<?php

namespace App\Http\Controllers\noc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Package;
use App\Models\NOC;
use App\Models\Sale;
use App\Models\Branch;
use App\Models\Province;
use App\Models\Suspend;
use App\Models\Reactivate;
use App\Models\Recontract;
use App\Models\Terminate;
use App\Models\Amend;
use App\Models\CancelAmend;
use App\Models\NocAttachment;
use App\Events\nocSuspendEvent;
use App\Events\nocActivateEvent;
use App\Events\nocProcessEvent;
use \Exception;
use DB;
use Auth;
use Mail;

class InstallationController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->authorize('viewAny', NOC::class);
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

        $customers = $customers
            ->where('active_status', '=', '1')
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'installation', 'read'))
            ->paginate(15);
        return view('noc.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', NOC::class);
        $customer = Customer::find($request->id);
        return view('noc.customers.create', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', NOC::class);
        $request->validate([
            'installer' => 'required',
            'activation_date' => 'required',
            'additional_fee' => 'required',
            'additional_fee_price' => 'required',
            'latitiude' => 'required',
            'longitude' => 'required',
        ], [
            'installer.required' => 'Installer name is required',
            'activation_date.required' => 'Activation date is required',
            'additional_fee.required' => 'Additional fee reason is required',
            'additional_fee_price.required' => 'Additional fee price is required',
            'latitiude.required' => 'Additional fee price is required',
            'longitude.required' => 'Additional fee price is required',
        ]);

        $noc = new NOC();
        $noc->installer = $request->installer;
        $noc->activation_date = $request->activation_date;
        $noc->cable_length = $request->cable_length;
        $noc->reciever_mac = $request->reciever_mac;
        $noc->latitiude = $request->latitiude;
        $noc->longitude = $request->longitude;
        $noc->additional_fee = $request->additional_fee;
        $noc->additional_fee_price = $request->additional_fee_price;
        $noc->additional_fee_currency = $request->additional_fee_currency;
        $noc->user_id = Auth::user()->id;
        $noc->customer_id = $request->customer_id;

        try {
            DB::beginTransaction();

            $customer = Customer::find($request->customer_id);
            $customer->active_status = '1';

            $sale = Sale::where('customer_id', $request->customer_id)->first();
            $sale->receiver_type = $request->receiver_type;

            // if($customer->NocAttachment()->exists()){

            //     $customer->save();
            //     $sale->save();
            //     $noc->save();

            //     event(new nocProcessEvent($customer));

            // }else{

            //     return redirect()->back()->with('error','Please add the attachments');

            // }

            $customer->save();
            $sale->save();
            $noc->save();

            event(new nocProcessEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', NOC::class);
        $customer = Customer::find($id);
        return view('noc.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', NOC::class);
        $customer = Customer::find($id);
        return view('noc.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', NOC::class);
        $request->validate([
            'installer' => 'required',
            'activation_date' => 'required',
            'additional_fee' => 'required',
            'additional_fee_price' => 'required',
            'latitiude' => 'required',
            'longitude' => 'required',
        ], [
            'installer.required' => 'Installer name is required',
            'activation_date.required' => 'Activation date is required',
            'additional_fee.required' => 'Additional fee reason is required',
            'additional_fee_price.required' => 'Additional fee price is required',
            'latitiude.required' => 'Additional fee price is required',
            'longitude.required' => 'Additional fee price is required',
        ]);

        $noc = NOC::find($request->noc_id);
        $noc->installer = $request->installer;
        $noc->activation_date = $request->activation_date;
        $noc->cable_length = $request->cable_length;
        $noc->reciever_mac = $request->reciever_mac;
        $noc->latitiude = $request->latitiude;
        $noc->longitude = $request->longitude;
        $noc->additional_fee = $request->additional_fee;
        $noc->additional_fee_price = $request->additional_fee_price;
        $noc->additional_fee_currency = $request->additional_fee_currency;
        $noc->user_id = Auth::user()->id;
        $noc->customer_id = $request->customer_id;

        try {
            DB::beginTransaction();

            $sale = Sale::find($request->sale_id);
            $sale->receiver_type = $request->receiver_type;
            $sale->save();
            $noc->save();

            $customer = Customer::find($request->customer_id);

            event(new nocProcessEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('installation.index')->with('success', 'Operation Done.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //return the single terminate
    public function terminate($id)
    {
        $this->authorize('view', Terminate::class);
        $customer = Customer::find($id);
        return view('noc.customers.terminates.show', compact('customer'));
    }

    // returning the terminated customers to noc
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

        $customers = $customers->whereNull('deleted_at')
            ->whereHas('terminate', function ($query) {
                $query->where('status', '=', 'terminate')
                    ->whereNotNull('noc_confirmation');
            })
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'terminate', 'read'))
            ->distinct()
            ->paginate(15);

        return view('noc.customers.terminates.index', compact('customers'));
    }

    // return the recontract details
    public function recontractDetails($id)
    {
        $this->authorize('view', Recontract::class);
        $customer = Recontract::find($id);
        return view('noc.customers.recontracts.show', compact('customer'));
    }

    // return the single suspend
    public function singleSuspend($id)
    {
        $this->authorize('view', Suspend::class);
        $customer = Customer::find($id);
        return view('noc.customers.suspends.show', compact('customer'));
    }

    // returning the suspended customers to noc
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

        $customers = $customers->whereNull('deleted_at')
            ->whereHas('suspend', function ($query) {
                $query->where('status', '=', 'suspend')
                    ->whereNotNull('noc_confirmation');
            })
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'suspend', 'read'))
            ->distinct()
            ->paginate(15);

        return view('noc.customers.suspends.index', compact('customers'));
    }

    /**
     * Display a listing of the reactivates
     *
     * @return \Illuminate\Http\Response
     */
    public function reactivates()
    {
        $this->authorize('viewAny', Reactivate::class);
        $customers = Reactivate::latest()
            ->where('status', '=', 'pending')
            ->whereIn('customers_reactivate_info.branch_id', hasSectionPermissionForBranch(Auth::user(), 'reactivate', 'read'))
            ->paginate(15);
        return view('noc.customers.reactivates.index', compact('customers'));
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
        return view('noc.customers.reactivates.show', compact('customer'));
    }

    /**
     * Display a listing of the new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests()
    {

        $this->authorize('viewAny', NOC::class);
        $customers = Customer::latest();
        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $customers = $customers->where('full_name', '=', request('name'));
        }

        if (request('package_id')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->join('packages', 'customers_sales_info.package_id', '=', 'packages.id')
                ->where('packages.id', '=', request('package_id'))
                ->select('customers.customer_id', 'customers.*');
        }

        $customers = $customers->where('noc_status', '=', '1')
            ->where('active_status', '=', '0')
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'installation', 'read'))
            ->paginate(15);
        return view('noc.customers.requests', compact('customers'));
    }


    //Upload installation contract file
    public function installation_contract(Request $request, $id)
    {
        try {

            $destinationPath = 'public/uploads/noc/'; // upload path
            $document = new NocAttachment();

            $file = $request->file('file');
            $imageName = $file->getClientOriginalName();
            $file->move($destinationPath, $imageName);

            $document->file = $imageName;
            $document->customer_id = $id;
            $document->save();

            return response()->json(['success' => $imageName]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Upload Faild!');
        }
    }

    // remove the images in uploader
    public function nocRemove(Request $request)
    {
        $filename =  $request->get('fileName');
        $id = $request->get('id');
        if ($filename) {

            NocAttachment::where('file', $filename)->delete();
            $path = 'public/uploads/noc/' . $filename;
        } else {

            $sale = NocAttachment::find($id);
            $path = 'public/uploads/noc/' . $sale->file;
            $sale->delete();
        }

        if (file_exists($path)) {
            unlink($path);
        }
        return $path;
    }


    /**
     * Activation form to noc
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activateForm($id)
    {
        $this->authorize('create', Reactivate::class);
        $customer = Customer::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('noc.customers.suspends.activate', compact(['customer', 'branches', 'provinces']));
    }

    /**
     * Reactivating the customers by NOC Department
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reactivate(Request $request, $id)
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
            if (empty($suspend->sales_confirmation) || empty($suspend->finance_confirmation)) {

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
            $customer->suspend_status   = '1';
            $customer->noc_status       = '0';
            $customer->active_status    = '0';
            $customer->terminate_status = '0';
            $customer->save();

            $suspend = new Suspend();
            $suspend->cu_id = $id;
            $suspend->status = 'suspend';
            $suspend->customer_id = $customer->customer_id;
            $suspend->full_name = $customer->full_name;
            $suspend->poc = $customer->poc;
            $suspend->phone1 = $customer->phone1;
            $suspend->phone2 = $customer->phone2;
            $suspend->education = $customer->education;
            $suspend->identity = $customer->identity_num;
            $suspend->address = $customer->address;
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
            $suspend->additional_charge_price = $customer->sale->additional_charge_price;
            $suspend->additional_currency = $customer->sale->additional_currency;
            $suspend->user_id        = Auth::user()->id;
            $suspend->suspend_reason = $request->suspend_reason;
            $suspend->suspend_date = $request->suspend_date;
            $suspend->noc_confirmation = date('Y/m/d H:i:s');
            $suspend->save();

            event(new nocSuspendEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('noc.suspends')->with('success', 'Operation Done.');
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

        return redirect()->route('noc.suspends')->with('success', 'Operation Done.');
    }

    // return the single amend
    public function amend($id)
    {
        $this->authorize('view', Amend::class);
        $customer = Amend::find($id);
        return view('noc.customers.amendments.show', compact('customer'));
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
            })->paginate(15);

        return view('noc.customers.amendments.index', compact('customers'));
    }

    // return the attachment files
    public function attachments($id)
    {
        $customer = Customer::find($id);
        return view('noc.customers.attachments', compact('customer'));
    }

    public function customerAttachments($id)
    {
        $customer = Customer::find($id);
        return view('noc.customers.portion.attachments', compact('customer'));
    }

    // remove noc attachments
    public function removefile(Request $request)
    {
        $filename =  $request->get('fileName');
        $id = $request->get('id');
        if ($filename) {

            NocAttachment::where('file', $filename)->delete();
            $path = 'public/uploads/noc/' . $filename;
        } else {

            $sale = NocAttachment::find($id);
            $path = 'public/uploads/noc/' . $sale->file;
            $sale->delete();
        }

        if (file_exists($path)) {
            unlink($path);
        }
        return $path;
    }

    // return the amendments
    public function cancelsAmendments()
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

        return view('noc.customers.amendments.cancels.index', compact('customers'));
    }

    // return the single amendment
    public function cancelAmendment($id)
    {
        $this->authorize('view', CancelAmend::class);
        $amend = CancelAmend::findorfail($id);
        return view('noc.customers.amendments.cancels.show', compact('amend'));
    }
}
