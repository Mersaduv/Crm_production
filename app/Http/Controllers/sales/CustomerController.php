<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Province;
use App\Models\Cancel;
use App\Models\Sale;
use App\Models\Suspend;
use App\Models\Reactivate;
use App\Models\Recontract;
use App\Models\Terminate;
use App\Models\Commission;
use App\Models\Amend;
use App\Models\CancelAmend;
use App\Events\paymentEvent;
use App\Events\processEvent;
use App\Events\terminateEvent;
use App\Events\suspendEvent;
use App\Events\amendmentEvent;
use App\Models\SalesAttachment;
use App\Events\customerReactivateEvent;
use App\Events\customerContractionEvent;
use Illuminate\Validation\Rule;
use \Exception;
use DB;
use Auth;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        return view('sales.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Customer::class);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.customers.create', compact('branches', 'provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Customer::class);
        $request->validate([
            'customer_id' => 'required|unique:customers,customer_id',
            'branch_id' => 'required',
            'full_name' => 'required',
            'poc' => 'required',
            'full_name_persian' => 'required',
            'poc_persian' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'education' => 'required',
            'province' => 'required',
            'identity_num' => 'required',
            'address' => 'required',
            'package_id' => 'required',
            'equi_type' => 'required',
            'cable_price' => 'required',
            'installation_date' => 'required',
            'package_price' => 'required'
        ], [
            'customer_id.required' => 'Customer ID is required',
            'customer_id.unique' => 'Customer ID already exists',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Full Name Persian is required',
            'poc_persian.required' => 'Customer POC Persian is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'education.required' => 'Education is required',
            'identity_num.required' => 'Identity Number is required',
            'address.required' => 'Address is required',
            'package_id.required' => 'Package is required',
            'equi_type.required' => 'Equipment Type is required',
            'cable_price.required' => 'Cable Price is required',
            'branch_id.required' => 'Branch is required',
            'province.required' => 'Province is required',
            'installation_date.required' => 'Installation Date is required',
            'package_price.required' => 'Package Price is required'
        ]);

        $customer = new Customer();
        $sales = new Sale();

        $customer->customer_id = $request->customer_id;
        $customer->full_name = $request->full_name;
        $customer->poc = $request->poc;
        $customer->full_name_persian = $request->full_name_persian;
        $customer->poc_persian = $request->poc_persian;
        $customer->phone1 = $request->phone1;
        $customer->phone2 = $request->phone2;
        $customer->education = $request->education;
        $customer->address = $request->address;
        $customer->identity_num = $request->identity_num;
        $customer->branch_id = $request->branch_id;
        $customer->province = $request->province;

        $sales->package_id = $request->package_id;
        $sales->package_price = $request->package_price ? $request->package_price : '0';
        $sales->package_price_currency = $request->package_price_currency;
        $sales->discount = $request->discount ? $request->discount : '0';
        $sales->discount_currency = $request->discount_currency;
        $sales->discount_period = $request->discount_period ? $request->discount_period : '0';
        $sales->discount_period_currency = $request->discount_period_currency;
        $sales->discount_reason = $request->discount_reason;
        $sales->equi_type = $request->equi_type;
        $sales->leased_type = $request->leased_type;
        $sales->router_type = $request->router_type;
        $sales->router_price = $request->router_price ? $request->router_price : '0';
        $sales->router_price_currency = $request->router_price_currency;
        $sales->Installation_cost = $request->Installation_cost ? $request->Installation_cost : '';
        $sales->Installation_cost_currency = $request->Installation_cost_currency;
        $sales->installation_date = $request->installation_date;
        $sales->public_ip = $request->public_ip;
        $sales->ip_price = $request->ip_price ? $request->ip_price : '0';
        $sales->ip_price_currency = $request->ip_price_currency;
        $sales->additional_charge = $request->additional_charge;
        $sales->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
        $sales->additional_currency = $request->additional_currency;
        $sales->comment = $request->comment;
        $sales->user_id = Auth::user()->id;
        $sales->cable_price = $request->cable_price ? $request->cable_price : '0';
        $sales->cable_price_currency = $request->cable_price_currency;
        $sales->commission_id = $request->commission_id;
        $sales->marketer_id = $request->marketer_id;
        $sales->commission_percent = $request->commission_percent ? $request->commission_percent : '0';
        $sales->commission_percent_currency = $request->commission_percent_currency;
        $sales->receiver_type = $request->receiver_type;
        $sales->receiver_price = $request->receiver_price ? $request->receiver_price : '0';
        $sales->receiver_price_currency = $request->receiver_price_currency;

        try {
            DB::beginTransaction();

            $customer->save();
            $sales->customer_id = $customer->id;
            $sales->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('customers.index')->with('success', 'Operation Done.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Customer::class);
        $customer = Customer::find($id);
        return view('sales.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Customer::class);
        $customer = Customer::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.customers.edit', compact(['customer', 'branches', 'provinces']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', Customer::class);
        $request->validate([
            'customer_id' => 'required|unique:customers,customer_id,' . $customer->id,
            'branch_id' => 'required',
            'full_name' => 'required',
            'poc' => 'required',
            'full_name_persian' => 'required',
            'poc_persian' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'education' => 'required',
            'province' => 'required',
            'identity_num' => 'required',
            'address' => 'required',
            'package_id' => 'required',
            'equi_type' => 'required',
            'cable_price' => 'required',
            'installation_date' => 'required',
            'package_price' => 'required'
        ], [
            'customer_id.required' => 'Customer ID is required',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Full Name Persian is required',
            'poc_persian.required' => 'Customer POC Persian is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'education.required' => 'Education is required',
            'identity_num.required' => 'Identity Number is required',
            'address.required' => 'Address is required',
            'package_id.required' => 'Package is required',
            'equi_type.required' => 'Equipment Type is required',
            'cable_price.required' => 'Cable Price is required',
            'branch_id.required' => 'Branch is required',
            'province.required' => 'Province is required',
            'installation_date.required' => 'Installation Date is required',
            'package_price.required' => 'Package Price is required'
        ]);

        // $customer = Customer::find($id);

        $customer->customer_id = $request->customer_id;
        $customer->full_name = $request->full_name;
        $customer->poc = $request->poc;
        $customer->full_name_persian = $request->full_name_persian;
        $customer->poc_persian = $request->poc_persian;
        $customer->phone1 = $request->phone1;
        $customer->phone2 = $request->phone2;
        $customer->education = $request->education;
        $customer->address = $request->address;
        $customer->identity_num = $request->identity_num;
        $customer->branch_id = $request->branch_id;
        $customer->province = $request->province;

        try {
            DB::beginTransaction();

            $customer->save();

            $sales = Sale::where('customer_id', $customer->id)->first();
            $sales->package_id = $request->package_id;
            $sales->package_price = $request->package_price ? $request->package_price : '0';
            $sales->package_price_currency = $request->package_price_currency;
            $sales->discount = $request->discount ? $request->discount : '0';
            $sales->discount_currency = $request->discount_currency;
            $sales->discount_period = $request->discount_period ? $request->discount_period : '0';
            $sales->discount_period_currency = $request->discount_period_currency;
            $sales->discount_reason = $request->discount_reason;
            $sales->equi_type = $request->equi_type;
            $sales->leased_type = $request->leased_type;
            $sales->router_type = $request->router_type;
            $sales->router_price = $request->router_price ? $request->router_price : '0';
            $sales->router_price_currency = $request->router_price_currency;
            $sales->Installation_cost = $request->Installation_cost ? $request->Installation_cost : '0';
            $sales->Installation_cost_currency = $request->Installation_cost_currency;
            $sales->installation_date = $request->installation_date;
            $sales->public_ip = $request->public_ip;
            $sales->ip_price = $request->ip_price ? $request->ip_price : '0';
            $sales->ip_price_currency = $request->ip_price_currency;
            $sales->comment = $request->comment;
            $sales->user_id = Auth::user()->id;
            $sales->cable_price = $request->cable_price ? $request->cable_price : '0';
            $sales->cable_price_currency = $request->cable_price_currency;
            $sales->customer_id = $customer->id;
            $sales->additional_charge = $request->additional_charge;
            $sales->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
            $sales->additional_currency = $request->additional_currency;
            $sales->commission_id = $request->commission_id;
            $sales->marketer_id = $request->marketer_id;
            $sales->commission_percent = $request->commission_percent ? $request->commission_percent : '0';
            $sales->commission_percent_currency = $request->commission_percent_currency;
            $sales->receiver_type = $request->receiver_type;
            $sales->receiver_price = $request->receiver_price ? $request->receiver_price : '0';
            $sales->receiver_price_currency = $request->receiver_price_currency;
            $sales->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('customers.index')->with('success', 'Operation Done.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Customer::class);
        try {
            DB::beginTransaction();

            $customer = Customer::find($id);
            $customer->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('customers.index')->with('success', 'Operation Done.');
    }

    // Return the trash customers
    public function trashed()
    {
        $this->authorize('restore', Customer::class);
        $customers = Customer::onlyTrashed()->orderby('id', 'desc')->paginate(15);
        return view('sales.customers.trashed', compact('customers'));
    }

    // restore back the customers from trash
    public function restore($id)
    {
        $this->authorize('restore', Customer::class);
        try {
            DB::beginTransaction();

            Customer::withTrashed()->find($id)->restore();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('customers.index')->with('success', 'Operation Done.');
    }

    // return the single terminate
    public function singleTerminate($id)
    {
        $this->authorize('view', Terminate::class);
        $customer = Customer::find($id);
        $recontract = Recontract::where('cu_id', $id)->first();
        return view('sales.customers.terminates.show', compact('customer', 'recontract'));
    }

    /**
     * Display a listing of the terminated customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function terminated()
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
                    ->whereNotNull('sales_confirmation');
            })
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'terminate', 'read'))
            ->distinct()
            ->paginate(15);

        return view('sales.customers.terminates.index', compact('customers'));
    }

    // return the single suspend
    public function suspendSingle($id)
    {
        $this->authorize('view', Suspend::class);
        $customer = Customer::find($id);
        return view('sales.customers.suspends.show', compact('customer'));
    }

    // return the suspends list
    public function suspendedLists()
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

        $customers = $customers->whereNull('deleted_at')
            ->whereHas('suspend', function ($query) {
                $query->where('status', '=', 'suspend')
                    ->whereNotNull('sales_confirmation');
            })->distinct()
            ->paginate(15);

        return view('sales.customers.suspends.index', compact('customers'));
    }

    /**
     * return the reactivates lists
     *
     * @return \Illuminate\Http\Response
     */
    public function reactivates()
    {
        $this->authorize('viewAny', Reactivate::class);
        $customers = Reactivate::latest()
            ->whereIn('customers_reactivate_info.branch_id', hasSectionPermissionForBranch(Auth::user(), 'reactivate', 'read'))
            ->where('status', '=', 'pending')
            ->paginate(15);
        return view('sales.customers.reactivates.index', compact('customers'));
    }

    /**
     * return the reactivate details
     *
     * @return \Illuminate\Http\Response
     */
    public function reactivateDetails($id)
    {
        $this->authorize('view', Reactivate::class);
        $customer = Reactivate::find($id);
        return view('sales.customers.reactivates.show', compact('customer'));
    }

    // return the recontraction form
    public function contractForm($id)
    {
        $this->authorize('create', Recontract::class);
        $customer = Customer::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.customers.terminates.contract', compact(['customer', 'branches', 'provinces']));
    }

    // recontract the customer
    public function recontraction(Request $request, $id)
    {
        $this->authorize('create', Recontract::class);
        $request->validate([
            'customer_id' => 'required',
            'branch_id' => 'required',
            'full_name' => 'required',
            'poc' => 'required',
            'full_name_persian' => 'required',
            'poc_persian' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'education' => 'required',
            'province' => 'required',
            'identity_num' => 'required',
            'address' => 'required',
            'package' => 'required',
            'equi_type' => 'required',
            'cable_price' => 'required',
            'receiver_type' => 'required',
            'recontract_date' => 'required',
        ], [
            'customer_id.required' => 'Customer ID is required',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Persian Full Name is required',
            'poc_persian.required' => 'Customer Persian POC is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'education.required' => 'Education is required',
            'identity_num.required' => 'Identity Number is required',
            'address.required' => 'Address is required',
            'package.required' => 'Package is required',
            'equi_type.required' => 'Equipment Type is required',
            'cable_price.required' => 'Cable Price is required',
            'receiver_type.required' => 'Receiver Type is required',
            'branch_id.required' => 'Branch is required',
            'province.required' => 'Province is required',
            'recontract_date.required' => 'Installation Date is required',
        ]);

        try {
            DB::beginTransaction();

            $terminate = Terminate::where('cu_id', $id)->first();

            if (empty($terminate->finance_confirmation) || empty($terminate->noc_confirmation)) {

                return redirect()->back()->with('error', 'Please Wait for confirmation.');
            } else {

                $terminate->recontract_date = $request->recontract_date;
                $terminate->save();

                $recontract = new Recontract();
                $recontract->cu_id = $id;
                $recontract->terminate_id = $terminate->id;
                $recontract->customer_id = $request->customer_id;
                $recontract->branch_id   = $request->branch_id;
                $recontract->full_name   = $request->full_name;
                $recontract->poc         = $request->poc;
                $recontract->full_name_persian   = $request->full_name_persian;
                $recontract->poc_persian         = $request->poc_persian;
                $recontract->phone1      = $request->phone1;
                $recontract->phone2      = $request->phone2;
                $recontract->education   = $request->education;
                $recontract->province    = $request->province;
                $recontract->address     = $request->address;
                $recontract->identity    = $request->identity_num;
                $recontract->package_id       = $request->package_id;
                $recontract->package_price    = $request->package_price ? $request->package_price : '0';
                $recontract->package_price_currency = $request->package_price_currency;
                $recontract->discount          = $request->discount;
                $recontract->discount_currency = $request->discount_currency;
                $recontract->discount_period   = $request->discount_period;
                $recontract->discount_period_currency = $request->discount_period_currency;
                $recontract->discount_reason = $request->discount_reason;
                $recontract->equi_type       = $request->equi_type;
                $recontract->leased_type     = $request->leased_type;
                $recontract->receiver_type   = $request->receiver_type;
                $recontract->receiver_price  = $request->receiver_price;
                $recontract->receiver_price_currency = $request->receiver_price_currency;
                $recontract->router_type    = $request->router_type;
                $recontract->router_price   = $request->router_price;
                $recontract->router_price_currency   = $request->router_price_currency;
                $recontract->Installation_cost = $request->Installation_cost;
                $recontract->Installation_cost_currency = $request->Installation_cost_currency;
                $recontract->public_ip   = $request->public_ip;
                $recontract->ip_price    = $request->ip_price;
                $recontract->ip_price_currency    = $request->ip_price_currency;
                $recontract->comment     = $request->comment;
                $recontract->user_id     = Auth::user()->id;
                $recontract->cable_price = $request->cable_price;
                $recontract->cable_price_currency = $request->cable_price_currency;
                $recontract->commission_id = $request->commission_id;
                $recontract->marketer_id = $request->marketer_id;
                $recontract->commission_percent = $request->commission_percent ? $request->commission_percent : '0';
                $recontract->commission_percent_currency = $request->commission_percent_currency;
                $recontract->additional_charge = $request->additional_charge;
                $recontract->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
                $recontract->additional_currency = $request->additional_currency;
                $recontract->recontract_date = $request->recontract_date;
                $recontract->sales_confirmation = date('Y/m/d H:i:s');
                $recontract->save();

                // event(new customerContractionEvent($customer));
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done.');
    }

    // return the recontract details
    public function recontractDetails($id)
    {
        $this->authorize('view', Recontract::class);
        $customer = Recontract::find($id);
        return view('sales.customers.recontracts.show', compact('customer'));
    }

    /**
     * Update the Sales Contract file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sales_contract(Request $request, $id)
    {
        try {

            $destinationPath = 'public/uploads/sales/'; // upload path
            $document = new SalesAttachment();

            $file = $request->file('file');
            $imageName = $file->getClientOriginalName();
            $file->move($destinationPath, $imageName);

            $document->file_name = $imageName;
            $document->sales_id = $id;
            $document->save();

            $sale = Sale::where('customer_id', $id)->first();
            $customer = Customer::where('id', $sale->customer_id)->first();

            if ($customer->active_status == '1') {
                \Mail::to(['installation@ariyabod.af', 'finance@ariyabod.af', 'support@ariyabod.af'])
                    ->cc(['baratian@ariyabod.af', 'ceo@ariyabod.af', 'soroosh@ariyabod.af'])
                    ->send(new \App\Mail\CustomerAttachmentsUpdateMail($customer));
            }

            return response()->json($imageName);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Upload Faild!');
        }
    }

    // remove the images in uploader
    public function removeFile(Request $request)
    {
        $filename =  $request->get('fileName');
        $id = $request->get('id');
        if ($filename) {

            SalesAttachment::where('file_name', $filename)->delete();
            $path = 'public/uploads/sales/' . $filename;
        } else {

            $sale = SalesAttachment::find($id);
            $path = 'public/uploads/sales/' . $sale->file_name;
            $sale->delete();
        }

        if (file_exists($path)) {
            unlink($path);
        }
        return $path;
    }

    /**
     * Return the print view
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printContract(Request $request)
    {
        $id = $request->id;
        $packages = Package::all();
        $customer = Customer::find($id);
        return view('sales.customers.print', compact(['customer', 'packages']));
    }

    /**
     * Return the print view of amendment
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printAmendment(Request $request)
    {
        $id = $request->id;
        $packages = Package::all();
        $customer = Amend::find($id);
        return view('sales.customers.amendments.print', compact(['customer', 'packages']));
    }

    /**
     * Return the print view of suspend
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printSuspend(Request $request)
    {
        $id = $request->id;
        $packages = Package::all();
        $customer = Reactivate::find($id);
        return view('sales.customers.reactivates.print', compact(['customer', 'packages']));
    }

    /**
     * Return the print view of terminate
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printTerminate(Request $request)
    {
        $id = $request->id;
        $packages = Package::all();
        $customer = Recontract::find($id);
        return view('sales.customers.recontracts.print', compact(['customer', 'packages']));
    }

    /**
     * To Check Sales send to Cashier
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendCashier(Request $request, $id)
    {
        $this->authorize('update', Customer::class);
        try {

            $customer = Customer::find($id);
            $customer->cashier_status = 1;
            $customer->save();

            // fire the event for notification when customer sent for payment
            //event(new paymentEvent());

            return redirect()->back()->with('success', 'Operation Done.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Operation Faild!');
        }
    }

    /**
     * To Check Sales send to finance and installation
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendProcess(Request $request, $id)
    {
        $this->authorize('update', Customer::class);
        try {

            $customer = Customer::find($id);
            $customer->noc_status = 1;
            $customer->save();

            event(new processEvent($customer));

            return redirect()->back()->with('success', 'Operation Done.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Operation Faild!');
        }
    }

    // terminate the customer
    public function terminate(Request $request, $id)
    {
        $this->authorize('create', Terminate::class);
        try {
            DB::beginTransaction();

            // check if the terminate is already in none confirmed terminate
            $terminate = Terminate::where('cu_id', $id)->first();
            if ($terminate && ($terminate->noc_confirmation == "" || $terminate->finance_confirmation == "" || $terminate->sales_confirmation == "")) {
                DB::rollback();
                return redirect()->back()->with('error', 'Customer has already a pending terminate');
            }

            $customer = Customer::find($id);

            // check if customer is already in suspend process
            if ($customer->suspend_status == '1') {
                $suspend = Suspend::where('cu_id', $id)->first();
                $suspend->status = 'terminate';
                $suspend->save();
            }

            $terminate = new Terminate();
            $terminate->cu_id = $id;
            $terminate->status = 'terminate';
            $terminate->customer_id = $customer->customer_id;
            $terminate->branch_id = $customer->branch_id;
            $terminate->province = $customer->province;
            $terminate->full_name   = $customer->full_name;
            $terminate->poc    = $customer->poc;
            $terminate->phone1 = $customer->phone1;
            $terminate->phone2 = $customer->phone2;
            $terminate->education = $customer->education;
            $terminate->identity  = $customer->identity_num;
            $terminate->address   = $customer->address;
            $terminate->package_id = $customer->sale->package_id;
            $terminate->package_price = $customer->sale->package_price;
            $terminate->package_price_currency = $customer->sale->package_price_currency;
            $terminate->commission_id = $customer->sale->commission_id;
            $terminate->marketer_id = $customer->sale->marketer_id;
            $terminate->commission_percent = $customer->sale->commission_percent ? $customer->sale->commission_percent : '0';
            $terminate->commission_percent_currency = $customer->sale->commission_percent_currency;
            $terminate->discount = $customer->sale->discount;
            $terminate->discount_currency = $customer->sale->discount_currency;
            $terminate->discount_period =   $customer->sale->discount_period;
            $terminate->discount_period_currency = $customer->sale->discount_period_currency;
            $terminate->discount_reason = $customer->sale->discount_reason;
            $terminate->equi_type       = $customer->sale->equi_type;
            $terminate->leased_type    = $customer->sale->leased_type;
            $terminate->receiver_type  = $customer->sale->receiver_type;
            $terminate->receiver_price = $customer->sale->receiver_price;
            $terminate->receiver_price_currency = $customer->sale->receiver_price_currency;
            $terminate->router_type = $customer->sale->router_type;
            $terminate->router_price = $customer->sale->router_price;
            $terminate->router_price_currency = $customer->sale->router_price_currency;
            $terminate->cable_price = $customer->sale->cable_price;
            $terminate->cable_price_currency = $customer->sale->cable_price_currency;
            $terminate->Installation_cost = $customer->sale->Installation_cost;
            $terminate->Installation_cost_currency = $customer->sale->Installation_cost_currency;
            $terminate->public_ip = $customer->sale->public_ip;
            $terminate->ip_price = $customer->sale->ip_price;
            $terminate->ip_price_currency = $customer->sale->ip_price_currency;
            $terminate->additional_charge = $customer->sale->additional_charge;
            $terminate->additional_charge_price = $customer->sale->additional_charge_price;
            $terminate->additional_currency = $customer->sale->additional_currency;
            $terminate->user_id        = Auth::user()->id;
            $terminate->terminate_reason = $request->terminate_reason;
            $terminate->termination_date = $request->terminate_date;
            $terminate->sales_confirmation = date('Y/m/d H:i:s');
            $terminate->save();

            // terminate event dispatch
            // event(new terminateEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('customers.terminated.list')->with('success', 'Operation Done.');
    }

    // suspend the customer
    public function suspend(Request $request, $id)
    {
        $this->authorize('create', Suspend::class);
        try {
            DB::beginTransaction();

            // check if the suspend is already in none confirmed suspend
            $suspend = Suspend::where('cu_id', $id)->first();
            if ($suspend && ($suspend->noc_confirmation == "" || $suspend->finance_confirmation == "" || $suspend->sales_confirmation == "")) {
                DB::rollback();
                return redirect()->back()->with('error', 'Customer has already a pending suspend');
            }

            $customer = Customer::find($id);
            $suspend = new Suspend();
            $suspend->cu_id = $id;
            $suspend->status = 'suspend';
            $suspend->branch_id = $customer->branch_id;
            $suspend->province = $customer->province;
            $suspend->customer_id = $customer->customer_id;
            $suspend->full_name   = $customer->full_name;
            $suspend->poc = $customer->poc;
            $suspend->phone1 = $customer->phone1;
            $suspend->phone2 = $customer->phone2;
            $suspend->education = $customer->education;
            $suspend->identity  = $customer->identity_num;
            $suspend->address   = $customer->address;
            $suspend->package_id = $customer->sale->package_id;
            $suspend->package_price = $customer->sale->package_price;
            $suspend->package_price_currency = $customer->sale->package_price_currency;
            $suspend->commission_id = $customer->sale->commission_id;
            $suspend->marketer_id = $customer->sale->marketer_id;
            $suspend->commission_percent = $customer->sale->commission_percent ? $customer->sale->commission_percent : '0';
            $suspend->commission_percent_currency = $customer->sale->commission_percent_currency;
            $suspend->discount = $customer->sale->discount;
            $suspend->discount_currency = $customer->sale->discount_currency;
            $suspend->discount_period = $customer->sale->discount_period;
            $suspend->discount_period_currency = $customer->sale->discount_period_currency;
            $suspend->discount_reason = $customer->sale->discount_reason;
            $suspend->equi_type = $customer->sale->equi_type;
            $suspend->leased_type = $customer->sale->leased_type;
            $suspend->receiver_type = $customer->sale->receiver_type;
            $suspend->receiver_price = $customer->sale->receiver_price;
            $suspend->receiver_price_currency = $customer->sale->receiver_price_currency;
            $suspend->router_type = $customer->sale->router_type;
            $suspend->router_price = $customer->sale->router_price;
            $suspend->router_price_currency = $customer->sale->router_price_currency;
            $suspend->cable_price = $customer->sale->cable_price;
            $suspend->cable_price_currency = $customer->sale->cable_price_currency;
            $suspend->public_ip = $customer->sale->public_ip;
            $suspend->ip_price = $customer->sale->ip_price;
            $suspend->ip_price_currency = $customer->sale->ip_price_currency;
            $suspend->additional_charge = $customer->sale->additional_charge;
            $suspend->additional_currency = $customer->sale->additional_currency;
            $suspend->additional_charge_price = $customer->sale->additional_charge_price;
            $suspend->user_id        = Auth::user()->id;
            $suspend->suspend_reason = $request->suspend_reason;
            $suspend->suspend_date = $request->suspend_date;
            $suspend->sales_confirmation = date('Y/m/d H:i:s');
            $suspend->save();

            event(new suspendEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('customers.suspend.list')->with('success', 'Operation Done.');
    }

    // Edit the suspend before confirmation
    public function suspendEdit(Request $request, $id)
    {
        $this->authorize('update', Suspend::class);
        try {
            DB::beginTransaction();

            $suspend = Suspend::find($id);
            $suspend->suspend_date = $request->suspend_date;
            $suspend->suspend_reason = $request->suspend_reason;
            $suspend->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done.');
    }

    // Delete suspend
    public function suspendDelete(Request $request, $id)
    {
        $this->authorize('delete', Suspend::class);
        try {
            DB::beginTransaction();

            $suspend = Suspend::find($id);
            $customer = Customer::find($suspend->cu_id);

            $customer->noc_status = '1';
            $customer->suspend_status = '0';
            $customer->active_status = '1';

            $customer->save();
            $suspend->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('customers.suspend.list')->with('success', 'Operation Done.');
    }

    // Edit the terminate before confirmation
    public function terminateEdit(Request $request, $id)
    {
        $this->authorize('update', Terminate::class);
        try {
            DB::beginTransaction();

            $terminate = Terminate::find($id);
            $terminate->termination_date = $request->termination_date;
            $terminate->terminate_reason = $request->terminate_reason;
            $terminate->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done.');
    }

    // delete the termination
    public function terminateDelete(Request $request, $id)
    {
        $this->authorize('delete', Terminate::class);
        try {
            DB::beginTransaction();

            $terminate = Terminate::find($id);
            $customer = Customer::find($terminate->cu_id);

            $customer->noc_status = '1';
            $customer->terminate_status = '0';
            $customer->active_status = '1';

            $customer->save();
            $terminate->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('customers.terminated.list')->with('success', 'Operation Done.');
    }

    // Return the activation form to sales
    public function activateForm($id)
    {
        $this->authorize('create', Reactivate::class);
        $customer = Customer::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.customers.suspends.activate', compact(['customer', 'branches', 'provinces']));
    }

    // Activate the suspended customer
    public function activate(Request $request, $id)
    {
        $this->authorize('create', Reactivate::class);
        $request->validate([
            'customer_id' => 'required',
            'branch_id' => 'required',
            'full_name' => 'required',
            'poc' => 'required',
            'full_name_persian' => 'required',
            'poc_persian' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'education' => 'required',
            'province' => 'required',
            'identity_num' => 'required',
            'address' => 'required',
            'package' => 'required',
            'equi_type' => 'required',
            'cable_price' => 'required',
            'receiver_type' => 'required',
            'reactivation_date' => 'required',
        ], [
            'customer_id.required' => 'Customer ID is required',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Persian Full Name is required',
            'poc_persian.required' => 'Customer Persian POC is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'education.required' => 'Education is required',
            'identity_num.required' => 'Identity Number is required',
            'address.required' => 'Address is required',
            'package.required' => 'Package is required',
            'equi_type.required' => 'Equipment Type is required',
            'cable_price.required' => 'Cable Price is required',
            'receiver_type.required' => 'Receiver Type is required',
            'branch_id.required' => 'Branch is required',
            'province.required' => 'Province is required',
            'reactivation_date.required' => 'Re-Activation Date is required',
        ]);

        try {
            DB::beginTransaction();

            $suspend = Suspend::orderby('id', 'desc')->where('cu_id', $id)->first();
            if (empty($suspend->finance_confirmation) || empty($suspend->noc_confirmation)) {

                return redirect()->back()->with('error', 'Please wait for confirmation.');
            } else {

                $suspend->reactivation_date = $request->reactivation_date;
                $suspend->status = 'active';
                $suspend->save();

                $reactivate = new Reactivate();
                $reactivate->cu_id = $id;
                $reactivate->customer_id = $request->customer_id;
                $reactivate->suspend_id = $suspend->id;
                $reactivate->full_name = $request->full_name;
                $reactivate->poc = $request->poc;
                $reactivate->full_name_persian = $request->full_name_persian;
                $reactivate->poc_persian = $request->poc_persian;
                $reactivate->phone1 = $request->phone1;
                $reactivate->phone2 = $request->phone2;
                $reactivate->education = $request->education;
                $reactivate->identity = $request->identity_num;
                $reactivate->address = $request->address;
                $reactivate->package_id = $request->package_id;
                $reactivate->package_price = $request->package_price ? $request->package_price : '0';
                $reactivate->package_price_currency = $request->package_price_currency;
                $reactivate->discount = $request->discount;
                $reactivate->discount_currency = $request->discount_currency;
                $reactivate->discount_period = $request->discount_period;
                $reactivate->discount_period_currency = $request->discount_period_currency;
                $reactivate->discount_reason = $request->discount_reason;
                $reactivate->commission_id = $request->commission_id;
                $reactivate->marketer_id = $request->marketer_id;
                $reactivate->commission_percent = $request->commission_percent ? $request->commission_percent : '0';
                $reactivate->commission_percent_currency = $request->commission_percent_currency;
                $reactivate->equi_type = $request->equi_type;
                $reactivate->leased_type = $request->leased_type;
                $reactivate->receiver_type = $request->receiver_type;
                $reactivate->receiver_price = $request->receiver_price;
                $reactivate->receiver_price_currency = $request->receiver_price_currency;
                $reactivate->router_type = $request->router_type;
                $reactivate->router_price = $request->router_price;
                $reactivate->router_price_currency = $request->router_price_currency;
                $reactivate->cable_price = $request->cable_price;
                $reactivate->cable_price_currency = $request->cable_price_currency;
                $reactivate->Installation_cost = $request->Installation_cost;
                $reactivate->Installation_cost_currency = $request->Installation_cost_currency;
                $reactivate->public_ip = $request->public_ip;
                $reactivate->ip_price = $request->ip_price;
                $reactivate->ip_price_currency = $request->ip_price_currency;
                $reactivate->additional_charge = $request->additional_charge;
                $reactivate->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
                $reactivate->additional_currency = $request->additional_currency;
                $reactivate->user_id = Auth::user()->id;
                $reactivate->reactivation_date = $request->reactivation_date;
                $reactivate->comment = $request->comment;
                $reactivate->status = 'pending';
                $reactivate->sales_confirmation = date('Y/m/d H:i:s');
                $reactivate->province = $request->province;
                $reactivate->branch_id = $request->branch_id;
                $reactivate->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done.');
    }

    // return the amedment form
    public function amedment($id)
    {
        $this->authorize('create', Amend::class);
        $customer = Customer::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.customers.amendments.amendment', compact(['customer', 'branches', 'provinces']));
    }

    // return the amedment edit form
    public function editAmendment($id)
    {
        $this->authorize('update', Amend::class);
        $customer = Amend::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.customers.amendments.edit', compact(['customer', 'branches', 'provinces']));
    }

    // return the single amendment
    public function amend($id)
    {
        $this->authorize('view', Amend::class);
        $customer = Amend::find($id);
        return view('sales.customers.amendments.show', compact('customer'));
    }
    // return the amedments lists
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

        $customers = $customers->where('customer_amend_info.cancel_status', '=', '0')
            ->whereNotNull('sales_confirmation')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'amendment', 'read'));
            })->paginate(15);

        return view('sales.customers.amendments.index', compact('customers'));
    }

    // update the amendment
    public function updateAmendment(Request $request, $id)
    {
        $this->authorize('update', Amend::class);
        $request->validate([
            'customer_id' => 'required',
            'full_name' => 'required',
            'poc' => 'required',
            'full_name_persian' => 'required',
            'poc_persian' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'education' => 'required',
            'identity_num' => 'required',
            'address' => 'required',
            'package_id' => 'required',
            'equi_type' => 'required',
            'cable_price' => 'required',
            'receiver_type' => 'required',
            'amedment_date' => 'required',
        ], [
            'customer_id.required' => 'Customer ID is required',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Full Name is required',
            'poc_persian.required' => 'Customer POC is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'education.required' => 'Education is required',
            'identity_num.required' => 'Identity Number is required',
            'address.required' => 'Address is required',
            'package_id.required' => 'Package is required',
            'equi_type.required' => 'Equipment Type is required',
            'cable_price.required' => 'Cable Price is required',
            'receiver_type.required' => 'Receiver Type is required',
            'amedment_date.required' => 'Amedment Date is required',
        ]);

        $amed = Amend::find($id);
        $clone = [];

        try {
            DB::beginTransaction();

            $amed->cu_id = $id;
            $amed->customer_id = $request->customer_id;
            $amed->full_name   = $request->full_name;
            $amed->poc         = $request->poc;
            $amed->full_name_persian  = $request->full_name_persian;
            $amed->poc_persian        = $request->poc_persian;
            $amed->phone1      = $request->phone1;
            $amed->phone2      = $request->phone2;
            $amed->education   = $request->education;
            $amed->identity    = $request->identity_num;
            $amed->address     = $request->address;
            $amed->package_id  = $request->package_id;
            $amed->package_price = $request->package_price ? $request->package_price : '0';
            $amed->package_price_currency = $request->package_price_currency;
            $amed->commission_id = $request->commission_id;
            $amed->marketer_id = $request->marketer_id;
            $amed->commission_percent = $request->commission_percent ? $request->commission_percent : '0';
            $amed->commission_percent_currency = $request->commission_percent_currency;
            $amed->discount          = $request->discount;
            $amed->discount_currency = $request->discount_currency;
            $amed->discount_period = $request->discount_period;
            $amed->discount_period_currency = $request->discount_period_currency;
            $amed->discount_reason = $request->discount_reason;
            $amed->equi_type         = $request->equi_type;
            $amed->leased_type       = $request->leased_type;
            $amed->receiver_type     = $request->receiver_type;
            $amed->receiver_price    = $request->receiver_price;
            $amed->receiver_price_currency = $request->receiver_price_currency;
            $amed->router_type       = $request->router_type;
            $amed->router_price      = $request->router_price;
            $amed->router_price_currency = $request->router_price_currency;
            $amed->cable_price       = $request->cable_price;
            $amed->cable_price_currency = $request->cable_price_currency;
            $amed->Installation_cost = $request->Installation_cost;
            $amed->Installation_cost_currency = $request->Installation_cost_currency;
            $amed->public_ip         = $request->public_ip;
            $amed->ip_price          = $request->ip_price;
            $amed->ip_price_currency = $request->ip_price_currency;
            $amed->additional_charge = $request->additional_charge;
            $amed->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
            $amed->additional_currency = $request->additional_currency;
            $amed->user_id          = Auth::user()->id;
            $amed->amend_date       = $request->amedment_date;
            $amed->amedment_comment = $request->amedment_comment;
            $amed->sales_confirmation = date('Y/m/d H:i:s');

            $clone['customer_id'] = $amed->customer->customer_id;
            $clone['full_name']   = $amed->customer->full_name;
            $clone['poc']         = $amed->customer->poc;
            $clone['full_name_persian']   = $amed->customer->full_name_persian ? $amed->customer->full_name_persian : $amed->customer->full_name;
            $clone['poc_persian']         = $amed->customer->poc_persian ? $amed->customer->poc_persian : $amed->customer->poc;
            $clone['phone1']      = $amed->customer->phone1;
            $clone['phone2']      = $amed->customer->phone2;
            $clone['education']   = $amed->customer->education;
            $clone['address']     = $amed->customer->address;
            $clone['identity_num'] = $amed->customer->identity_num;
            $clone['package_id']  = $amed->customer->sale->package_id;
            $clone['package_price'] = $amed->customer->sale->package_price ? $amed->customer->sale->package_price : '0';
            $clone['package_price_currency'] = $amed->customer->sale->package_price_currency;
            $clone['discount'] = $amed->customer->sale->discount;
            $clone['discount_currency'] = $amed->customer->sale->discount_currency;
            $clone['discount_period'] = $amed->customer->sale->discount_period;
            $clone['discount_period_currency'] = $amed->customer->sale->discount_period;
            $clone['discount_reason'] = $amed->customer->sale->discount_reason;
            $clone['equi_type'] = $amed->customer->sale->equi_type;
            $clone['leased_type'] = $amed->customer->sale->leased_type;
            $clone['receiver_type'] = $amed->customer->sale->receiver_type;
            $clone['receiver_price'] = $amed->customer->sale->receiver_price;
            $clone['receiver_price_currency'] = $amed->customer->sale->receiver_price_currency;
            $clone['router_type'] = $amed->customer->sale->router_type;
            $clone['router_price'] = $amed->customer->sale->router_price;
            $clone['router_price_currency'] = $amed->customer->sale->router_price_currency;
            $clone['Installation_cost'] = $amed->customer->sale->Installation_cost;
            $clone['Installation_cost_currency'] = $amed->customer->sale->Installation_cost_currency;
            $clone['public_ip'] = $amed->customer->sale->public_ip;
            $clone['ip_price'] = $amed->customer->sale->ip_price;
            $clone['ip_price_currency'] = $amed->customer->sale->ip_price_currency;
            $clone['comment'] = $amed->customer->sale->comment;
            $clone['user_id'] = $amed->customer->sale->user_id;
            $clone['cable_price'] = $amed->customer->sale->cable_price;
            $clone['cable_price_currency'] = $amed->customer->sale->cable_price_currency;
            $clone['commission_id'] = $amed->customer->sale->commission_id;
            $clone['marketer_id'] = $amed->customer->sale->marketer_id;
            $clone['commission_percent'] = $amed->customer->sale->commission_percent ? $amed->customer->sale->commission_percent : '0';
            $clone['commission_percent_currency'] = $amed->customer->sale->commission_percent_currency;
            $clone['additional_charge'] = $amed->customer->sale->additional_charge;
            $clone['additional_charge_price'] = $amed->customer->sale->additional_charge_price ? $amed->customer->sale->additional_charge_price : '0';
            $clone['additional_currency'] = $amed->customer->sale->additional_currency;
            $amed->clone = json_encode($clone);
            $amed->save();

            // Dispatch event by customer amendments
            event(new amendmentEvent($amed->customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('customer.ameds')->with('success', 'Operation Done.');
    }

    // Delete amendment before update
    public function deleteAmendment(Request $request, $id)
    {
        $this->authorize('delete', Amend::class);

        try {
            DB::beginTransaction();

            $amed = Amend::find($id);
            $amed->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('customer.ameds')->with('success', 'Operation Done.');
    }

    // executing the amedmentation
    public function amedmentation(Request $request, $id)
    {
        $this->authorize('create', Amend::class);
        $request->validate([
            'customer_id' => 'required',
            'full_name' => 'required',
            'poc' => 'required',
            'full_name_persian' => 'required',
            'poc_persian' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'education' => 'required',
            'identity_num' => 'required',
            'address' => 'required',
            'package_id' => 'required',
            'equi_type' => 'required',
            'cable_price' => 'required',
            'receiver_type' => 'required',
            'amedment_date' => 'required',
        ], [
            'customer_id.required' => 'Customer ID is required',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Persian Full Name is required',
            'poc_persian.required' => 'Customer Persian POC is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'education.required' => 'Education is required',
            'identity_num.required' => 'Identity Number is required',
            'address.required' => 'Address is required',
            'package_id.required' => 'Package is required',
            'equi_type.required' => 'Equipment Type is required',
            'cable_price.required' => 'Cable Price is required',
            'receiver_type.required' => 'Receiver Type is required',
            'amedment_date.required' => 'Amedment Date is required',
        ]);

        $customer = Customer::find($id);
        $clone = [];

        try {
            DB::beginTransaction();

            // check if the customer a pending amendment
            $amendment = Amend::where('cu_id', $id)->first();
            if ($amendment && ($amendment->sales_confirmation == "" || $amendment->finance_confirmation == "" || $amendment->noc_confirmation == "")) {
                DB::rollback();
                return redirect()->back()->with('error', 'Customer has already a pending amendment.');
            }

            $discount = $request->previous_discount == $request->discount ? 0 : $request->discount;
            $discount_period = $request->previous_discount_period == $request->discount_period ? 0 : $request->discount_period;
            $discount_reason = $request->previous_discount_reason == $request->discount_reason ? '' : $request->discount_reason;
            $receiver_price = $request->previous_receiver_price == $request->receiver_price ? 0 : $request->receiver_price;
            $router_price = $request->previous_router_price == $request->router_price ? 0 : $request->router_price;
            $cable_price = $request->previous_cable_price == $request->cable_price ? 0 : $request->cable_price;
            $Installation_cost = $request->previous_Installation_cost == $request->Installation_cost ? 0 : $request->Installation_cost;
            $additional_charge_price = $request->previous_additional_charge_price == $request->additional_charge_price ? 0 : $request->additional_charge_price;

            $amed = new Amend();
            $amed->cu_id = $id;
            $amed->customer_id = $request->customer_id;
            $amed->full_name   = $request->full_name;
            $amed->poc         = $request->poc;
            $amed->full_name_persian = $request->full_name_persian;
            $amed->poc_persian       = $request->full_name_persian;
            $amed->phone1      = $request->phone1;
            $amed->phone2      = $request->phone2;
            $amed->education   = $request->education;
            $amed->identity    = $request->identity_num;
            $amed->address     = $request->address;
            $amed->package_id  = $request->package_id;
            $amed->package_price = $request->package_price ? $request->package_price : '0';
            $amed->package_price_currency = $request->package_price_currency;
            $amed->commission_id = $request->commission_id;
            $amed->marketer_id = $request->marketer_id;
            $amed->commission_percent = $request->commission_percent ? $request->commission_percent : '0';
            $amed->commission_percent_currency = $request->commission_percent_currency;
            $amed->discount          = $discount;
            $amed->discount_currency = $request->discount_currency;
            $amed->discount_period = $discount_period;
            $amed->discount_period_currency = $request->discount_period_currency;
            $amed->discount_reason = $discount_reason;
            $amed->equi_type         = $request->equi_type;
            $amed->leased_type       = $request->leased_type;
            $amed->receiver_type     = $request->receiver_type;
            $amed->receiver_price    = $receiver_price;
            $amed->receiver_price_currency = $request->receiver_price_currency;
            $amed->router_type       = $request->router_type;
            $amed->router_price      = $router_price;
            $amed->router_price_currency = $request->router_price_currency;
            $amed->cable_price       = $cable_price;
            $amed->cable_price_currency = $request->cable_price_currency;
            $amed->Installation_cost = $Installation_cost;
            $amed->Installation_cost_currency = $request->Installation_cost_currency;
            $amed->public_ip         = $request->public_ip;
            $amed->ip_price          = $request->ip_price;
            $amed->ip_price_currency = $request->ip_price_currency;
            $amed->additional_charge = $request->additional_charge;
            $amed->additional_charge_price = $additional_charge_price;
            $amed->additional_currency = $request->additional_currency;
            $amed->user_id          = Auth::user()->id;
            $amed->amend_date       = $request->amedment_date;
            $amed->amedment_comment = $request->amedment_comment;
            $amed->sales_confirmation = date('Y/m/d H:i:s');
            $clone['customer_id'] = $customer->customer_id;
            $clone['full_name']   = $customer->full_name;
            $clone['poc']         = $customer->poc;
            $clone['full_name_persian']  = $customer->full_name_persian ? $customer->full_name_persian : $customer->full_name;
            $clone['poc_persian']        = $customer->poc_persian ? $customer->poc_persian : $customer->poc;
            $clone['phone1']      = $customer->phone1;
            $clone['phone2']      = $customer->phone2;
            $clone['education']   = $customer->education;
            $clone['address']     = $customer->address;
            $clone['identity_num'] = $customer->identity_num;
            $clone['branch_id']   = $customer->branch_id;
            $clone['province']    = $customer->province;
            $clone['package_id']  = $customer->sale->package_id;
            $clone['package_price'] = $customer->sale->package_price ? $customer->sale->package_price : '0';
            $clone['package_price_currency'] = $customer->sale->package_price_currency;
            $clone['discount'] = $customer->sale->discount;
            $clone['discount_currency'] = $customer->sale->discount_currency;
            $clone['discount_period'] = $customer->sale->discount_period;
            $clone['discount_period_currency'] = $customer->sale->discount_period;
            $clone['discount_reason'] = $customer->sale->discount_reason;
            $clone['equi_type'] = $customer->sale->equi_type;
            $clone['leased_type'] = $customer->sale->leased_type;
            $clone['receiver_type'] = $customer->sale->receiver_type;
            $clone['receiver_price'] = $customer->sale->receiver_price;
            $clone['receiver_price_currency'] = $customer->sale->receiver_price_currency;
            $clone['router_type'] = $customer->sale->router_type;
            $clone['router_price'] = $customer->sale->router_price;
            $clone['router_price_currency'] = $customer->sale->router_price_currency;
            $clone['Installation_cost'] = $customer->sale->Installation_cost;
            $clone['Installation_cost_currency'] = $customer->sale->Installation_cost_currency;
            $clone['public_ip'] = $customer->sale->public_ip;
            $clone['ip_price'] = $customer->sale->ip_price;
            $clone['ip_price_currency'] = $customer->sale->ip_price_currency;
            $clone['comment'] = $customer->sale->comment;
            $clone['user_id'] = $customer->sale->user_id;
            $clone['cable_price'] = $customer->sale->cable_price;
            $clone['cable_price_currency'] = $customer->sale->cable_price_currency;
            $clone['commission_id'] = $customer->sale->commission_id;
            $clone['marketer_id'] = $customer->sale->marketer_id;
            $clone['commission_percent'] = $customer->sale->commission_percent ? $customer->sale->commission_percent : '0';
            $clone['commission_percent_currency'] = $customer->sale->commission_percent_currency;
            $clone['additional_charge'] = $customer->sale->additional_charge;
            $clone['additional_charge_price'] = $customer->sale->additional_charge_price ? $customer->sale->additional_charge_price : '0';
            $clone['additional_currency'] = $customer->sale->additional_currency;
            $amed->clone = json_encode($clone);
            $amed->save();

            // Dispatch event by customer amendments
            event(new amendmentEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('customer.ameds')->with('success', 'Operation Done.');
    }

    // return the attachments
    public function customerAttachments($id)
    {
        $customer = Customer::find($id);
        return view('sales.customers.portion.attachments', compact('customer'));
    }

    // return the attachment view
    public function fileview($id)
    {
        $sale = Sale::find($id);
        return view('sales.customers.attachments', compact('sale'));
    }

    // return the commissions
    public function resellers()
    {
        $this->authorize('viewAny', Commission::class);
        $commissions = Commission::latest('commissions.id');

        if (request('phone')) {
            $commissions = $commissions->where('phone', 'like', '%' . request('phone') . '%');
        }

        if (request('name')) {
            $commissions = $commissions->where('name', 'like', '%' . request('name') . '%');
        }

        $commissions = $commissions->whereNull('deleted_at')
            ->paginate(15);

        return view('sales.commission.index', compact('commissions'));
    }

    // listing the cancel customers
    public function cancelsEvent()
    {
        $this->authorize('viewAny', CancelAmend::class);
        $cancels = Customer::orderBy('id', 'desc')
            ->where('cancel_status', '=', '1')
            ->where('terminate_status', '=', '0')
            ->where('suspend_status', '=', '0')
            ->whereNull('deleted_at')
            ->whereHas('cancel')
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'cancel-amendment', 'read'))
            ->paginate('15');
        return view('sales.customers.cancels.portion', compact('cancels'));
    }

    // return the canceled amendments
    public function cancelAmends()
    {
        $this->authorize('viewAny', CancelAmend::class);
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

        if ((request('cancel_date') && request('cancel_end')) && !request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'));
        }

        $customers = $customers->whereHas('customer', function ($query) {
            $query->whereNull('deleted_at')
                ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'cancel-amendment', 'read'));
        })->paginate(15);
        return view('sales.customers.amendments.cancels.index', compact('customers'));
    }

    // return the single cancel amendment
    public function cancelAmend($id)
    {
        $this->authorize('view', CancelAmend::class);
        $amend = CancelAmend::findorfail($id);
        return view('sales.customers.amendments.cancels.show', compact('amend'));
    }
}
