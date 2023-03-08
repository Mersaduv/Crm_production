<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Category;
use App\Models\Amend;
use App\Models\CancelAmend;
use App\Models\NOC;
use App\Models\PrCancelAmend;
use App\Models\Reactivate;
use App\Models\Recontract;
use App\Models\PrTerminateRequest;
use App\Models\Suspend;
use App\Models\Terminate;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // return the customers to management dashboard
    public function customers()
    {
        $this->authorize('viewAny', Customer::class);

        $customers = Customer::latest('customers.created_at');

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('ins')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '=', request('ins'))
                ->select('customers.*', 'customers.customer_id');
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('act')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '=', request('act'))
                ->select('customers.*', 'customers.customer_id');
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('activate') || request('activate') == '0') {
            $customers = $customers->where('active_status', '=', request('activate'));
        }

        if (request('finance') || request('finance') == '0') {
            $customers = $customers->where('finance_status', '=', request('finance'));
        }

        $customers = $customers
            ->where([
                ['terminate_status', '=', '0'],
                ['suspend_status', '=', '0'],
                ['cancel_status', '=', '0']
            ])
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'customers', 'read'))
            ->paginate(15);

        return view('dashboard.customers.index', compact('customers'));
    }

    // return the customer to management dashboard
    public function customer($id)
    {
        $this->authorize('view', Customer::class);
        $customer = Customer::find($id);
        return view('dashboard.customers.show', compact('customer'));
    }

    // return the packages to management dashboard
    public function packages()
    {
        $packages = Package::latest();

        if (request('id')) {
            $packages = $packages->where('category_id', '=', request('id'));
        }

        if (request('name')) {
            $packages = $packages->where('name', 'like', '%' . request('name') . '%');
        }

        if (request('price')) {
            $packages = $packages->where('price', '=', request('price'));
        }

        if (request('duration')) {
            $packages = $packages->where('duration', '=', request('duration'));
        }

        $categories = Category::all();
        $packages = $packages->paginate(15);
        return view('dashboard.packages.index', compact(['packages', 'categories']));
    }

    // return the package to dashboard
    public function package($id)
    {
        $package = Package::find($id);
        return view('dashboard.packages.show', compact('package'));
    }

    // return the categories to dashboard
    public function categories()
    {
        $categories = Category::latest();

        if (request('name')) {
            $categories = $categories->where('name', 'like', '%' . request('name') . '%');
        }

        $categories = $categories->paginate(15);
        return view('dashboard.categories.index', compact('categories'));
    }

    // return the terminate
    public function terminate($id)
    {
        $this->authorize('view', Terminate::class);
        $customer = Customer::find($id);
        return view('dashboard.customers.terminates.show', compact('customer'));
    }

    // return the terminates customers
    public function terminates()
    {
        $this->authorize('viewAny', Terminate::class);
        $customers = Customer::latest();

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('terminate')) {
            $customers = $customers
                ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereDate('customers_terminate_info.termination_date', '=', request('terminate'))
                ->whereNull('customers_terminate_info.recontract_date')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('act')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '=', request('act'))
                ->select('customers.*', 'customers.customer_id');
        }

        if ((request('terStart') && request('terEnd')) && !request('terminate')) {
            $customers = $customers
                ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereDate('customers_terminate_info.termination_date', '>=', request('terStart'))
                ->whereDate('customers_terminate_info.termination_date', '<=', request('terEnd'))
                ->whereNull('customers_terminate_info.recontract_date')
                ->select('customers.*', 'customers.customer_id');
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('noc')) {

            if (request('noc') == 'true') {
                $customers = $customers
                    ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                    ->whereNotNull('customers_terminate_info.noc_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }

            if (request('noc') == 'false') {
                $customers = $customers
                    ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                    ->whereNull('customers_terminate_info.noc_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }
        }

        if (request('finance')) {

            if (request('finance') == 'true') {
                $customers = $customers
                    ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                    ->whereNotNull('customers_terminate_info.finance_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }

            if (request('finance') == 'false') {
                $customers = $customers
                    ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                    ->whereNull('customers_terminate_info.finance_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }
        }

        $customers = $customers->whereNull('deleted_at')
            ->whereHas('terminate', function ($query) {
                $query->where('status', '=', 'terminate')
                    ->whereNotNull('noc_confirmation');
            })
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'terminate', 'read'))
            ->distinct()
            ->paginate(15);

        return view('dashboard.customers.terminates.index', compact('customers'));
    }

    // return the recontract details
    public function recontractDetails($id)
    {
        $this->authorize('view', Recontract::class);
        $customer = Recontract::find($id);
        return view('dashboard.customers.recontracts.show', compact('customer'));
    }

    // return the single suspend
    public function singleSuspend($id)
    {
        $this->authorize('view', Suspend::class);
        $customer = Customer::find($id);
        return view('dashboard.customers.suspends.show', compact('customer'));
    }

    // return the suspended customers
    public function suspends()
    {

        $this->authorize('viewAny', Suspend::class);
        $customers = Customer::latest();

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('suspend')) {
            $customers = $customers
                ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->whereDate('customers_suspend_info.suspend_date', '=', request('suspend'))
                ->WhereNull('customers_suspend_info.reactivation_date')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('act')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '=', request('act'))
                ->select('customers.*', 'customers.customer_id');
        }

        if ((request('suspendStart') && request('suspendEnd')) && !request('suspend')) {
            $customers = $customers
                ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->whereDate('customers_suspend_info.suspend_date', '>=', request('suspendStart'))
                ->whereDate('customers_suspend_info.suspend_date', '<=', request('suspendEnd'))
                ->WhereNull('customers_suspend_info.reactivation_date')
                ->select('customers.*', 'customers.customer_id');
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('noc')) {

            if (request('noc') == 'true') {
                $customers = $customers
                    ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                    ->whereNotNull('customers_suspend_info.noc_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }

            if (request('noc') == 'false') {
                $customers = $customers
                    ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                    ->whereNull('customers_suspend_info.noc_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }
        }

        if (request('sales')) {

            if (request('sales') == 'true') {
                $customers = $customers
                    ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                    ->whereNotNull('customers_suspend_info.sales_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }

            if (request('sales') == 'false') {
                $customers = $customers
                    ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                    ->whereNull('customers_suspend_info.sales_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }
        }

        if (request('finance')) {

            if (request('finance') == 'true') {
                $customers = $customers
                    ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                    ->whereNotNull('customers_suspend_info.finance_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }

            if (request('finance') == 'false') {
                $customers = $customers
                    ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                    ->whereNull('customers_suspend_info.finance_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }
        }

        $customers = $customers->whereNull('deleted_at')
            ->whereHas('suspend', function ($query) {
                $query->where('status', '=', 'suspend')
                    ->whereNotNull('noc_confirmation');
            })
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'suspend', 'read'))
            ->distinct()
            ->paginate(15);
        return view('dashboard.customers.suspends.index', compact('customers'));
    }

    /**
     * Display a listing of the reactivates
     *
     * @return \Illuminate\Http\Response
     */
    public function reactivates()
    {
        $customers = Reactivate::latest()->where('status', '=', 'pending')->paginate(15);
        return view('dashboard.customers.reactivates.index', compact('customers'));
    }

    /**
     * Display a reactivate details
     *
     * @return \Illuminate\Http\Response
     */
    public function reactivateDetails($id)
    {
        $this->authorize('view', Reactivate::class);
        $customer = Reactivate::find($id);
        return view('dashboard.customers.reactivates.show', compact('customer'));
    }

    // return the single amend
    public function amend($id)
    {
        $this->authorize('view', Amend::class);
        $customer = Amend::find($id);
        return view('dashboard.customers.amendments.show', compact('customer'));
    }

    // return the amendments
    public function amedmentList()
    {

        $this->authorize('viewAny', Amend::class);
        $customers = Amend::latest();

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('amend')) {
            $customers = $customers->whereDate('amend_date', '=', request('amend'));
        }

        if (request('act')) {
            $customers = $customers
                ->join('customers', 'customer_amend_info.cu_id', '=', 'customers.id')
                ->join('customers_noc_info', 'customers_noc_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_noc_info.activation_date', '=', request('act'))
                ->select('customer_amend_info.*', 'customer_amend_info.customer_id');
        }

        if ((request('amendStart') && request('amendEnd')) && !request('amend')) {
            $customers = $customers->whereDate('amend_date', '>=', request('amendStart'))
                ->whereDate('amend_date', '<=', request('amendEnd'));
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('customers', 'customer_amend_info.cu_id', '=', 'customers.id')
                ->join('customers_noc_info', 'customers_noc_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customer_amend_info.*', 'customer_amend_info.customer_id');
        }

        if (request('finance') || request('finance') == '0') {
            $request = request('finance');

            if ($request == '1') {
                $customers = $customers->whereNotNull('finance_confirmation');
            }

            if ($request == '0') {
                $customers = $customers->whereNull('finance_confirmation');
            }
        }

        if (request('noc') || request('noc') == '0') {

            $request = request('noc');

            if ($request == '1') {
                $customers = $customers->whereNotNull('noc_confirmation');
            }

            if ($request == '0') {
                $customers = $customers->whereNull('noc_confirmation');
            }
        }

        $customers = $customers->where('cancel_status', '=', '0')
            ->whereNotNull('noc_confirmation')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'amendment', 'read'));
            })
            ->paginate(15);

        return view('dashboard.customers.amendments.index', compact('customers'));
    }

    // return the amendments
    public function cancelsAmendments()
    {

        $customers = CancelAmend::latest();

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('amend')) {
            $customers = $customers
                ->join('customer_amend_info', 'customers_amend_cancel.amend_id', '=', 'customer_amend_info.id')
                ->whereDate('customer_amend_info.amend_date', '=', request('amend'))
                ->select('customers_amend_cancel.*');
        }

        if (request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '=', request('cancel'));
        }

        if ((request('amendStart') && request('amendEnd')) && !request('amend')) {
            $customers = $customers
                ->join('customer_amend_info', 'customers_amend_cancel.amend_id', '=', 'customer_amend_info.id')
                ->whereDate('customer_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('customer_amend_info.amend_date', '<=', request('amendEnd'))
                ->select('customers_amend_cancel.*');
        }

        if (request('cancel_date') && request('cancel_end') && !request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'));
        }

        $customers = $customers->whereHas('customer', function ($query) {
            $query->whereNull('deleted_at');
        })->paginate(15);

        return view('dashboard.customers.amendments.cancels.index', compact('customers'));
    }

    // return the single amendment
    public function cancelAmendment($id)
    {
        $amend = CancelAmend::findorfail($id);
        return view('dashboard.customers.amendments.cancels.show', compact('amend'));
    }

    // return the provincial cancels of amendments
    public function cancelsPrAmendments()
    {
        $customers = PrCancelAmend::latest();

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('amend')) {
            $customers = $customers
                ->join('pr_amend_info', 'pr_amend_cancel.amend_id', '=', 'pr_amend_info.id')
                ->whereDate('pr_amend_info.amend_date', '=', request('amend'))
                ->select('pr_amend_cancel.*');
        }

        if (request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '=', request('cancel'));
        }

        if ((request('amendStart') && request('amendEnd')) && !request('amend')) {
            $customers = $customers
                ->join('pr_amend_info', 'pr_amend_cancel.amend_id', '=', 'pr_amend_info.id')
                ->whereDate('pr_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('pr_amend_info.amend_date', '<=', request('amendEnd'))
                ->select('pr_amend_cancel.*');
        }

        if ((request('cancel_date') && request('cancel_end')) && !request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'));
        }

        $customers = $customers->whereHas('provincial', function ($query) {
            $query->whereNull('deleted_at');
        })->paginate(15);

        return view('dashboard.provincial.amendments.cancels.index', compact('customers'));
    }

    // return the single amendment
    public function cancelPrAmendment($id)
    {
        $amend = PrCancelAmend::findorfail($id);
        return view('dashboard.provincial.amendments.cancels.show', compact('amend'));
    }

    // return customers to show on map
    public function map()
    {
        // $customers = Customer::with(['noc' => function ($query) {
        //     $query->whereNotNull('latitiude')
        //         ->whereNotNull('longitude');
        // }])
        //     ->whereNull('deleted_at')
        //     ->where('active_status', '=', '1')
        //     ->get()
        //     ->toArray();

        // $customers  =  $customers
        //     ->map(function ($customer) {
        //         return [
        //             "full_name" => $customer->full_name,
        //             'latitiude' => $customer->noc->latitiude,
        //             'longitude' => $customer->noc->longitude,
        //         ];
        //     })
        //     ->toArray();

        $customers = Customer::latest('customers.created_at');
        $customers = $customers
            ->whereNull('deleted_at')
            ->where('active_status', '=', '1')
            ->whereHas(
                'noc',
                function ($query) {
                    $query->whereNotNull('latitiude')
                        ->whereNotNull('longitude');
                }
            )
            ->get()
            ->map(function ($customer) {
                return [
                    "full_name" => $customer->full_name,
                    'latitiude' => $customer->noc->latitiude,
                    'longitude' => $customer->noc->longitude,
                ];
            })
            ->toArray();


        // dd($customers);
        return view('dashboard.customers.map', compact('customers'));
    }

    // return the customer attachments to manager
    public function attachments($id)
    {
        $customer = Customer::find($id);
        return view('dashboard.customers.attachments', compact('customer'));
    }

    // return the pr requests
    public function prRequests()
    {
        $requests = PrTerminateRequest::latest('pr_requests.created_at');
        if (request('customer_id')) {
            $requests = $requests->where('customer_id', '=', request('customer_id'));
        }

        if (request('date')) {
            $requests = $requests->whereDate('request_date', '=', request('date'));
        }

        if (request('start') && request('end')) {
            $requests = $requests->whereDate('request_date', '>=', request('start'))
                ->whereDate('request_date', '<=', request('date'));
        }

        if (request('sender')) {
            $value = request('sender');
            $requests = $requests->whereHas('user', function ($q) use ($value) {
                $q->where('role', $value);
            });
        }

        if (request('status')) {
            $requests = $requests->where('status', '=', request('status'));
        }

        $requests = $requests->whereNull('deleted_at')->paginate(15);

        return view('dashboard.prRequests.index', compact('requests'));
    }

    // return the individual pr requests
    public function prRequest($id)
    {
        $request = PrTerminateRequest::find($id);
        return view('dashboard.prRequests.show', compact('request'));
    }
}
