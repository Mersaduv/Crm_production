<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provincial;
use App\Models\PrAmend;
use App\Models\PrPayment;
use App\Models\Province;
use App\Models\PrReactivate;
use App\Models\PrRecontract;
use App\Models\PrSuspend;
use App\Models\PrTerminate;
use Illuminate\Support\Facades\Auth;

class ProvincialCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Provincial::class);
        $customers = Provincial::latest('pr_customers.created_at');

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
        }

        if (request('StartInsDate')) {
            $customers = $customers->whereDate('installation_date', '=', request('StartInsDate'));
        }

        if ((request('instDate') && request('insEndDate')) && !request('StartInsDate')) {
            $customers = $customers->whereDate('installation_date', '>=', request('instDate'))
                ->whereDate('installation_date', '<=', request('insEndDate'));
        }

        if (request('StartActDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '=', request('StartActDate'));
        }

        if ((request('actDate') && request('actEndDate')) && !request('StartActDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actDate'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEndDate'));
        }

        if (request('activate') || request('activate') == '0') {
            $customers = $customers->where('active_status', '=', request('activate'));
        }

        if (request('finance') || request('finance') == '0') {
            $customers = $customers->where('finance_status', '=', request('finance'));
        }

        $provinces = Province::all();
        $customers = $customers
            ->where([
                ['terminate_status', '=', '0'],
                ['suspend_status', '=', '0'],
                ['cancel_status', '=', '0']
            ])
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial', 'read'))
            ->paginate(15);

        return view('dashboard.provincial.index', compact('customers', 'provinces'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Provincial::class);
        $customer = Provincial::withTrashed()->find($id);
        $payment  = PrPayment::where('customer_id', $id)->first();
        return view('dashboard.provincial.show', compact(['customer', 'payment']));
    }

    // return the single suspend
    public function singleSuspend($id)
    {
        $this->authorize('view', PrSuspend::class);
        $customer = Provincial::find($id);
        return view('dashboard.provincial.suspends.show', compact('customer'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function suspends()
    {
        $this->authorize('viewAny', PrSuspend::class);
        $customers = Provincial::latest();

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
        }

        if (request('StartActDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '=', request('StartActDate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if ((request('actDate') && request('actEndDate')) && !request('StartActDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actDate'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEndDate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('suspend')) {
            $customers = $customers
                ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereDate('pr_suspend_info.suspend_date', '=', request('suspend'))
                ->WhereNull('pr_suspend_info.reactive_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if ((request('suspendDate') && request('endSusDate')) && !request('suspend')) {
            $customers = $customers
                ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereDate('pr_suspend_info.suspend_date', '>=', request('suspendDate'))
                ->whereDate('pr_suspend_info.suspend_date', '<=', request('endSusDate'))
                ->WhereNull('pr_suspend_info.reactive_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('sales')) {

            if (request('sales') == 'true') {
                $customers = $customers
                    ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                    ->whereNotNull('pr_suspend_info.sales_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }

            if (request('sales') == 'false') {
                $customers = $customers
                    ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                    ->whereNull('pr_suspend_info.sales_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }
        }

        if (request('noc')) {

            if (request('noc') == 'true') {
                $customers = $customers
                    ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                    ->whereNotNull('pr_suspend_info.noc_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }

            if (request('noc') == 'false') {
                $customers = $customers
                    ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                    ->whereNull('pr_suspend_info.noc_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }
        }

        if (request('finance')) {

            if (request('finance') == 'true') {
                $customers = $customers
                    ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                    ->whereNotNull('pr_suspend_info.finance_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }

            if (request('finance') == 'false') {
                $customers = $customers
                    ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                    ->whereNull('pr_suspend_info.finance_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }
        }

        $provinces = Province::all();
        $customers = $customers->whereNull('deleted_at')
            ->whereHas('suspend', function ($query) {
                $query->where('status', '=', 'suspend')
                    ->whereNotNull('noc_confirmation');
            })
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-suspend', 'read'))
            ->paginate(15);

        return view('dashboard.provincial.suspends.index', compact('customers', 'provinces'));
    }

    // reactivate details
    public function reactivateDetails($id)
    {
        $this->authorize('view', PrReactivate::class);
        $customer = PrReactivate::find($id);
        return view('dashboard.provincial.reactivates.show', compact('customer'));
    }

    // Return the suspend form to provincial
    public function recontractDetails($id)
    {
        $this->authorize('view', PrRecontract::class);
        $customer = PrRecontract::find($id);
        return view('dashboard.provincial.recontracts.show', compact('customer'));
    }

    // return the single terminate
    public function singleTerminate($id)
    {
        $this->authorize('view', PrTerminate::class);
        $customer = Provincial::find($id);
        return view('dashboard.provincial.terminates.show', compact('customer'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function terminates()
    {
        $this->authorize('viewAny', PrTerminate::class);
        $customers = Provincial::latest();

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
        }

        if (request('StartActDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '=', request('StartActDate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if ((request('actDate') && request('actEndDate')) && !request('StartActDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actDate'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEndDate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('StartTerDate')) {
            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereDate('pr_terminate_info.terminate_date', '=', request('StartTerDate'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if ((request('terDate') && request('terEndDate')) && !request('StartTerDate')) {
            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereDate('pr_terminate_info.terminate_date', '>=', request('terDate'))
                ->whereDate('pr_terminate_info.terminate_date', '<=', request('terEndDate'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('noc')) {

            if (request('noc') == 'true') {
                $customers = $customers
                    ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                    ->whereNotNull('pr_terminate_info.noc_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }

            if (request('noc') == 'false') {
                $customers = $customers
                    ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                    ->whereNull('pr_terminate_info.noc_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }
        }

        if (request('finance')) {

            if (request('finance') == 'true') {
                $customers = $customers
                    ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                    ->whereNotNull('pr_terminate_info.finance_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }

            if (request('finance') == 'false') {
                $customers = $customers
                    ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                    ->whereNull('pr_terminate_info.finance_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }
        }

        $provinces = Province::all();
        $customers = $customers->whereNull('deleted_at')
            ->whereHas('terminate', function ($query) {
                $query->where('status', '=', 'terminate')
                    ->whereNotNull('noc_confirmation');
            })
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-terminate', 'read'))
            ->paginate(15);

        return view('dashboard.provincial.terminates.index', compact('customers', 'provinces'));
    }

    // return the single amendment
    public function amend($id)
    {
        $this->authorize('view', PrAmend::class);
        $customer = PrAmend::find($id);
        return view('dashboard.provincial.amendments.show', compact('customer'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function amendments()
    {
        $this->authorize('viewAny', PrAmend::class);
        $customers = PrAmend::latest();

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
        }

        if (request('activate')) {
            $customers = $customers
                ->join('pr_customers', 'pr_amend_info.pr_cu_id', '=', 'pr_customers.id')
                ->join('pr_noc_info', 'pr_noc_info.customer_id', '=', 'pr_customers.id')
                ->whereDate('pr_noc_info.activation_date', '=', request('activate'))
                ->select('pr_amend_info.*', 'pr_amend_info.customer_id');
        }

        if ((request('actDate') && request('actEndDate')) && !request('activate')) {
            $customers = $customers
                ->join('pr_customers', 'pr_amend_info.pr_cu_id', '=', 'pr_customers.id')
                ->join('pr_noc_info', 'pr_noc_info.customer_id', '=', 'pr_customers.id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actDate'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEndDate'))
                ->select('pr_amend_info.*', 'pr_amend_info.customer_id');
        }

        if (request('amendment')) {
            $customers = $customers->whereDate('amend_date', '=', request('amendment'));
        }

        if ((request('amendStart') && request('amendEnd')) && !request('amendment')) {
            $customers = $customers->whereDate('amend_date', '>=', request('amendStart'))
                ->whereDate('amend_date', '<=', request('amendEnd'));
        }

        if (request('noc')) {

            if (request('noc') == 'true') {
                $customers = $customers->whereNotNull('noc_confirmation');
            }

            if (request('noc') == 'false') {
                $customers = $customers->whereNull('noc_confirmation');
            }
        }

        if (request('finance')) {

            if (request('finance') == 'true') {
                $customers = $customers->whereNotNull('finance_confirmation');
            }

            if (request('finance') == 'false') {
                $customers = $customers->whereNull('finance_confirmation');
            }
        }

        $provinces = Province::all();
        $customers = $customers
            ->where('cancel_status', '=', '0')
            ->whereNotNull('noc_confirmation')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-amendment', 'read'));
            })->paginate(15);


        return view('dashboard.provincial.amendments.index', compact('customers', 'provinces'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashes()
    {
        $customers = Provincial::latest('pr_customers.created_at');

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
        }

        if (request('date')) {
            $customers = $customers->whereDate('deleted_at', '=', request('date'));
        }

        if ((request('start') && request('end')) && !request('date')) {
            $customers = $customers->whereDate('deleted_at', '>=', request('start'))
                ->whereDate('deleted_at', '<=', request('end'));
        }

        $provinces = Province::all();
        $customers = $customers->onlyTrashed()->paginate(15);
        return view('dashboard.provincial.trashed', compact('customers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function files($id)
    {
        $customer = Provincial::find($id);
        return view('dashboard.provincial.attachments', compact('customer'));
    }
}
