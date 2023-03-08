<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Suspend;
use App\Models\Reactivate;
use App\Models\Terminate;
use App\Models\Recontract;
use App\Models\Amend;
use App\Models\Cancel;
use App\Models\CancelAmend;
use \Exception;
use Auth;
use DB;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('timeLine', Customer::class);
        $customers = Customer::latest('customers.created_at');

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('activate') && !request('activateEnd')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '=', request('activate'))
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('activate') && request('activateEnd')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('activate'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('activateEnd'))
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('suspend') && !request('suspendEnd')) {
            $customers = $customers
                ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->whereDate('customers_suspend_info.suspend_date', '=', request('suspend'))
                ->WhereNull('customers_suspend_info.reactivation_date')
                ->whereNotNull('customers_suspend_info.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('suspend') && request('suspendEnd')) {
            $customers = $customers
                ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->whereDate('customers_suspend_info.suspend_date', '>=', request('suspend'))
                ->whereDate('customers_suspend_info.suspend_date', '<=', request('suspendEnd'))
                ->WhereNull('customers_suspend_info.reactivation_date')
                ->whereNotNull('customers_suspend_info.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('terminate') && !request('terminateEnd')) {
            $customers = $customers
                ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereDate('customers_terminate_info.termination_date', '=', request('terminate'))
                ->whereNull('customers_terminate_info.recontract_date')
                ->whereNotNull('customers_terminate_info.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('terminate') && request('terminateEnd')) {
            $customers = $customers
                ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereDate('customers_terminate_info.termination_date', '>=', request('terminate'))
                ->whereDate('customers_terminate_info.termination_date', '<=', request('terminateEnd'))
                ->whereNull('customers_terminate_info.recontract_date')
                ->whereNotNull('customers_terminate_info.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('amend') && !request('amendEnd')) {
            $customers = $customers
                ->join('customer_amend_info', 'customers.id', '=', 'customer_amend_info.cu_id')
                ->whereDate('customer_amend_info.amend_date', '=', request('amend'))
                ->whereNotNull('customer_amend_info.noc_confirmation')
                ->where('customer_amend_info.cancel_status', '=', '0')
                ->groupBy('customer_amend_info.cu_id')
                ->select('customers.*');
        }

        if (request('amend') && request('amendEnd')) {
            $customers = $customers
                ->join('customer_amend_info', 'customers.id', '=', 'customer_amend_info.cu_id')
                ->whereDate('customer_amend_info.amend_date', '>=', request('amend'))
                ->whereDate('customer_amend_info.amend_date', '<=', request('amendEnd'))
                ->whereNotNull('customer_amend_info.noc_confirmation')
                ->where('customer_amend_info.cancel_status', '=', '0')
                ->groupBy('customer_amend_info.cu_id')
                ->select('customers.*');
        }

        if (request('cancel') && !request('cancelEnd')) {
            $customers = $customers
                ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->whereDate('customers_cancel_info.cancel_date', '=', request('cancel'))
                ->whereNotNull('customers_cancel_info.noc_confirmation')
                ->whereNull('customers_cancel_info.rollback_date')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('cancel') && request('cancelEnd')) {
            $customers = $customers
                ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->whereDate('customers_cancel_info.cancel_date', '>=', request('cancel'))
                ->whereDate('customers_cancel_info.cancel_date', '<=', request('cancelEnd'))
                ->whereNotNull('customers_cancel_info.noc_confirmation')
                ->whereNull('customers_cancel_info.rollback_date')
                ->select('customers.*', 'customers.customer_id');
        }

        $customers = $customers
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'customers', 'time-line'))
            ->whereNull('deleted_at')
            ->paginate('15');

        if (Auth::user()->role == 'sales') {

            return view('sales.customers.timeline.index', compact('customers'));
        } else if (Auth::user()->role == 'noc') {

            return view('noc.customers.timeline.index', compact('customers'));
        } else if (Auth::user()->role == 'admin') {

            return view('dashboard.customers.timeline.index', compact('customers'));
        } else if (Auth::user()->role == 'finance') {

            return view('finance.customers.timeline.index', compact('customers'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findorfail($id);

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
                FROM customers_sales_info
                WHERE customer_id = $id
            UNION
            SELECT
                DATE(activation_date) AS event_date,
                id AS event_id,
                'Activate' AS event_name
                FROM customers_noc_info
                WHERE customer_id = $id
            UNION
            SELECT
                DATE(amend_date) AS event_date,
                id AS event_id,
                'Amendment' AS event_name
                FROM customer_amend_info
                WHERE cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(cancel_date) AS event_date,
                id AS event_id,
                'CancelAmendment' AS event_name
                FROM customers_amend_cancel
                WHERE cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(suspend_date) AS event_date,
                id AS event_id,
                'Suspend' AS event_name
                FROM customers_suspend_info
                WHERE cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(reactivation_date) AS event_date,
                id AS event_id,
                'Reactivate' AS event_name
                FROM customers_reactivate_info
                WHERE cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(termination_date) AS event_date,
                id AS event_id,
                'Terminate' AS event_name
                FROM customers_terminate_info
                WHERE cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(recontract_date) AS event_date,
                id AS event_id,
                'Recontract' AS event_name
                FROM customers_recontract_info
                WHERE cu_id = $id AND noc_confirmation IS NOT NULL
            UNION
            SELECT
                DATE(cancel_date) AS event_date,
                id AS event_id,
                'Cancel' AS event_name
                FROM customers_cancel_info
                WHERE cu_id = $id AND noc_confirmation IS NOT NULL
        ) AS base_table
        GROUP BY event_date
        ORDER BY event_date";

        $timelineData = DB::select($timelineSQL);

        if (Auth::user()->role == 'sales') {

            return view('sales.customers.timeline.show', compact(['timelineData', 'id', 'customer']));
        } else if (Auth::user()->role == 'noc') {

            return view('noc.customers.timeline.show', compact(['timelineData', 'id', 'customer']));
        } else if (Auth::user()->role == 'admin') {

            return view('dashboard.customers.timeline.show', compact(['timelineData', 'id', 'customer']));
        } else if (Auth::user()->role == 'finance') {

            return view('finance.customers.timeline.show', compact(['timelineData', 'id', 'customer']));
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
                $customer = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                    ->whereDate('customers_sales_info.installation_date', '=', $date)
                    ->where('customers.id', '=', $id)
                    ->where('customers_sales_info.id', '=', $event_id)
                    ->select('customers.*', 'customers.customer_id')->first();
                return view('dashboard.customers.timeline.installation', compact('customer'));
                break;

            case ('Activate'):
                $customer = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                    ->whereDate('customers_noc_info.activation_date', '=', $date)
                    ->where('customers.id', '=', $id)
                    ->where('customers_noc_info.id', '=', $event_id)
                    ->select('customers.*', 'customers.customer_id')->first();
                return view('dashboard.customers.timeline.activate', compact('customer'));
                break;

            case ('Amendment'):
                $customer = Amend::findorfail($event_id);
                return view('dashboard.customers.timeline.amend', compact('customer'));
                break;

            case ('CancelAmendment'):
                $customer = CancelAmend::findorfail($event_id);
                return view('dashboard.customers.timeline.cancelAmend', compact('customer'));
                break;

            case ('Suspend'):
                $customer = Suspend::findorfail($event_id);
                return view('dashboard.customers.timeline.suspend', compact('customer'));
                break;
            case ('Reactivate'):
                $customer = Reactivate::findorfail($event_id);
                return view('dashboard.customers.timeline.reactivate', compact('customer'));
                break;

            case ('Terminate'):
                $customer = Terminate::findorfail($event_id);
                return view('dashboard.customers.timeline.terminate', compact('customer'));
                break;

            case ('Recontract'):
                $customer = Recontract::findorfail($event_id);
                return view('dashboard.customers.timeline.recontract', compact('customer'));
                break;

            case ('Cancel'):
                $customer = Cancel::findorfail($event_id);
                return view('dashboard.customers.timeline.cancel', compact('customer'));
                break;

            case ('Cancel RollBack'):
                $customer = Cancel::findorfail($event_id);
                return view('dashboard.customers.timeline.cancel', compact('customer'));
                break;
        }
    }
}
