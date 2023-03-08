<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Provincial;
use App\Models\PrSuspend;
use App\Models\PrReactivate;
use App\Models\PrAmend;
use App\Models\PrTerminate;
use App\Models\PrRecontract;
use App\Models\PrCancel;
use App\Models\PrCancelAmend;
use Illuminate\Http\Request;
use \Exception;
use Auth;
use DB;

class ContractorTimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('timeLine', Provincial::class);
        $customers = Provincial::latest('pr_customers.created_at');

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('activate') && !request('activateEnd')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '=', request('activate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('activate') && request('activateEnd')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('activate'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('activateEnd'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('suspend') && !request('suspendEnd')) {
            $customers = $customers
                ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereDate('pr_suspend_info.suspend_date', '=', request('suspend'))
                ->whereNull('pr_suspend_info.reactive_date')
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('suspend') && request('suspendEnd')) {
            $customers = $customers
                ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereDate('pr_suspend_info.suspend_date', '>=', request('suspend'))
                ->whereDate('pr_suspend_info.suspend_date', '<=', request('suspendEnd'))
                ->whereNull('pr_suspend_info.reactive_date')
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('terminate') && !request('terminateEnd')) {
            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereDate('pr_terminate_info.terminate_date', '=', request('terminate'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('terminate') && request('terminateEnd')) {
            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereDate('pr_terminate_info.terminate_date', '>=', request('terminate'))
                ->whereDate('pr_terminate_info.terminate_date', '<=', request('terminateEnd'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('amend') && !request('amendEnd')) {
            $customers = $customers
                ->join('pr_amend_info', 'pr_customers.id', '=', 'pr_amend_info.pr_cu_id')
                ->whereDate('pr_amend_info.amend_date', '=', request('amend'))
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->where('pr_amend_info.cancel_status', '=', '0')
                ->groupBy('pr_amend_info.pr_cu_id')
                ->select('pr_customers.*');
        }

        if (request('amend') && request('amendEnd')) {
            $customers = $customers
                ->join('pr_amend_info', 'pr_customers.id', '=', 'pr_amend_info.pr_cu_id')
                ->whereDate('pr_amend_info.amend_date', '>=', request('amend'))
                ->whereDate('pr_amend_info.amend_date', '<=', request('amendEnd'))
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->where('pr_amend_info.cancel_status', '=', '0')
                ->groupBy('pr_amend_info.pr_cu_id')
                ->select('pr_customers.*');
        }

        if (request('cancel') && !request('cancelEnd')) {
            $customers = $customers
                ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->whereDate('pr_cancel_info.cancel_date', '=', request('cancel'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('cancel') && request('cancelEnd')) {
            $customers = $customers
                ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->whereDate('pr_cancel_info.cancel_date', '>=', request('cancel'))
                ->whereDate('pr_cancel_info.cancel_date', '<=', request('cancelEnd'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        $customers = $customers
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'Provincial', 'time-line'))
            ->whereNull('deleted_at')
            ->paginate('15');

        if (Auth::user()->role == 'sales') {

            return view('sales.provincial.timeline.index', compact('customers'));
        } else if (Auth::user()->role == 'noc') {

            return view('noc.provincial.timeline.index', compact('customers'));
        } else if (Auth::user()->role == 'admin') {

            return view('dashboard.provincial.timeline.index', compact('customers'));
        } else if (Auth::user()->role == 'finance') {

            return view('finance.provincial.timeline.index', compact('customers'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provincial  $provincial
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Provincial::findorfail($id);

        $timelineSQL = "SELECT
        event_date,
        GROUP_CONCAT(event_id) AS ids,
        GROUP_CONCAT(event_name) AS events
        FROM
        (
            SELECT
                DATE(installation_date) AS event_date,
                id AS event_id,
                'Installation' AS event_name
                FROM pr_customers
                WHERE id = $id
                UNION
            SELECT
                DATE(activation_date) AS event_date,
                id AS event_id,
                'Activate' AS event_name
                FROM pr_noc_info
                WHERE customer_id = $id
            UNION
            SELECT
                DATE(amend_date) AS event_date,
                id AS event_id,
                'Amendment' AS event_name
                FROM pr_amend_info
                WHERE pr_cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(suspend_date) AS event_date,
                id AS event_id,
                'Suspend' AS event_name
                FROM pr_suspend_info
                WHERE pr_cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(reactive_date) AS event_date,
                id AS event_id,
                'Reactivate' AS event_name
                FROM pr_reactivate_info
                WHERE pr_cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(terminate_date) AS event_date,
                id AS event_id,
                'Terminate' AS event_name
                FROM pr_terminate_info
                WHERE pr_cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(recontract_date) AS event_date,
                id AS event_id,
                'Recontract' AS event_name
                FROM pr_recontract_info
                WHERE pr_cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(cancel_date) AS event_date,
                id AS event_id,
                'Cancel' AS event_name
                FROM pr_cancel_info
                WHERE pr_cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(cancel_date) AS event_date,
                id AS event_id,
                'CancelAmendment' AS event_name
                FROM pr_amend_cancel
                WHERE pr_cu_id = $id AND noc_confirmation IS NOT NULL
        ) AS base_table
        GROUP BY event_date
        ORDER BY event_date";

        $timelineData = DB::select($timelineSQL);

        if (Auth::user()->role == 'sales') {

            return view('sales.provincial.timeline.show', compact(['timelineData', 'id', 'customer']));
        } else if (Auth::user()->role == 'noc') {

            return view('noc.provincial.timeline.show', compact(['timelineData', 'id', 'customer']));
        } else if (Auth::user()->role == 'admin') {

            return view('dashboard.provincial.timeline.show', compact(['timelineData', 'id', 'customer']));
        } else if (Auth::user()->role == 'finance') {

            return view('finance.provincial.timeline.show', compact(['timelineData', 'id', 'customer']));
        }
    }

    // Get timeline details
    public function details(Request $request)
    {
        $date = $request->date;
        $id = $request->id;
        $event_id = $request->event_id;

        switch ($request->event) {
            case ('Installation'):
                $customer = Provincial::where('id', $id)->whereDate('installation_date', $date)->first();
                return view('dashboard.provincial.timeline.installation', compact('customer'));
                break;

            case ('Activate'):
                $customer = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                    ->whereDate('pr_noc_info.activation_date', '=', $date)
                    ->where('pr_customers.id', '=', $id)
                    ->where('pr_noc_info.id', '=', $event_id)
                    ->select('pr_customers.*', 'pr_customers.customer_id')->first();
                return view('dashboard.provincial.timeline.activate', compact('customer'));
                break;

            case ('Amendment'):
                $customer = PrAmend::findorfail($event_id);
                return view('dashboard.provincial.timeline.amend', compact('customer'));
                break;

            case ('CancelAmendment'):
                $customer = PrCancelAmend::findorfail($event_id);
                return view('dashboard.provincial.timeline.cancelAmend', compact('customer'));
                break;

            case ('Suspend'):
                $customer = PrSuspend::findorfail($event_id);
                return view('dashboard.provincial.timeline.suspend', compact('customer'));
                break;
            case ('Reactivate'):
                $customer = PrReactivate::findorfail($event_id);
                return view('dashboard.provincial.timeline.reactivate', compact('customer'));
                break;

            case ('Terminate'):
                $customer = PrTerminate::findorfail($event_id);
                return view('dashboard.provincial.timeline.terminate', compact('customer'));
                break;

            case ('Recontract'):
                $customer = PrRecontract::findorfail($event_id);
                return view('dashboard.provincial.timeline.recontract', compact('customer'));
                break;

            case ('Cancel'):
                $customer = PrCancel::findorfail($event_id);
                return view('dashboard.provincial.timeline.cancel', compact('customer'));
                break;

            case ('Cancel RollBack'):
                $customer = PrCancel::findorfail($event_id);
                return view('dashboard.provincial.timeline.cancel', compact('customer'));
                break;
        }
    }
}
