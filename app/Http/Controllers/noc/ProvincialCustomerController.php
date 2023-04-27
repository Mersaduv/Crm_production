<?php

namespace App\Http\Controllers\noc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provincial;
use App\Models\PrNocAttachments;
use App\Models\PrNocInfo;
use App\Models\Branch;
use App\Models\Province;
use App\Models\PrTerminate;
use App\Models\PrSuspend;
use App\Models\PrReactivate;
use App\Models\PrRecontract;
use App\Models\PrAmend;
use App\Models\PrCancelAmend;
use App\Events\prNocSuspend;
use App\Events\prNocActivatingEvent;
use App\Events\prNocProcessEvent;
use \Exception;
use DB;
use Auth;
use Mail;

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

        if (request('date')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '=', request('date'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if ((request('start') && request('end')) && !request('date')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('start'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('end'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        $provinces = Province::all();
        $customers = $customers->where('active_status', '=', '1')
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-installation', 'read'))
            ->paginate('15');
        return view('noc.provincial.index', compact('customers', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Provincial::class);
        $branches = Branch::all();
        $provinces = Province::all();
        $customer = Provincial::find(request('id'));
        return view('noc.provincial.create', compact(['customer', 'branches', 'provinces']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Provincial::class);
        $request->validate([
            'activation_date' => 'required',
            'additional_fee' => 'required',
            'additional_fee_price' => 'required',
        ], [
            'activation_date.required' => 'Activation Date is required',
            'additional_fee.required' => 'Additional Fee Reason is required',
            'additional_fee_price.required' => 'Additional Fee Price is required',
        ]);

        $noc = new PrNocInfo();
        $noc->customer_id = $request->customer_id;
        $noc->activation_date = $request->activation_date;
        $noc->latitiude = $request->latitiude;
        $noc->longitude = $request->longitude;
        $noc->additional_fee = $request->additional_fee;
        $noc->additional_fee_price = $request->additional_fee_price;
        $noc->additional_fee_currency = $request->additional_fee_currency;
        $noc->user_id = Auth::user()->id;

        try {
            DB::beginTransaction();

            $customer = Provincial::find($request->customer_id);
            $customer->active_status = '1';
            $customer->save();
            $noc->save();

            event(new prNocProcessEvent($customer));

            // if($customer->PrNocAttachments()->exists()){

            //     $customer ->active_status = '1';
            //     $customer->save();
            //     $noc->save();

            //     event(new prNocProcessEvent($customer));

            // }else{

            //     return redirect()->back()->with('error','Please Add Attachments');

            // }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('prCustomers.index')->with('success', 'Operation Done.');
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
        $customer = Provincial::find($id);
        return view('noc.provincial.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Provincial::class);
        $branches = Branch::all();
        $provinces = Province::all();
        $customer = Provincial::find($id);
        return view('noc.provincial.edit', compact(['customer', 'branches', 'provinces']));
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
        $this->authorize('update', Provincial::class);
        $request->validate([

            'activation_date' => 'required',
            'additional_fee' => 'required',
            'additional_fee_price' => 'required',
        ], [
            'activation_date.required' => 'Activation Date is required',
            'additional_fee.required' => 'Additional Fee Reason is required',
            'additional_fee_price.required' => 'Additional Fee Price is required',
        ]);

        $noc = PrNocInfo::find($id);
        $noc->customer_id = $request->customer_id;
        $noc->activation_date = $request->activation_date;
        $noc->latitiude = $request->latitiude;
        $noc->longitude = $request->longitude;
        $noc->additional_fee = $request->additional_fee;
        $noc->additional_fee_price = $request->additional_fee_price;
        $noc->additional_fee_currency = $request->additional_fee_currency;
        $noc->user_id = Auth::user()->id;

        try {
            DB::beginTransaction();

            $customer = Provincial::find($request->customer_id);
            $customer->active_status = '1';
            $customer->save();

            $noc->save();

            event(new prNocProcessEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done.');
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

    /**
     * Return the attachments to noc provincial view
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function files($id)
    {
        $customer = Provincial::find($id);
        return view('noc.provincial.attachments', compact('customer'));
    }

    /**
     * Update the attachments in noc provincial
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pr_files(Request $request, $id)
    {
        try {

            $destinationPath = 'public/uploads/pr/'; // upload path
            $document = new PrNocAttachments();

            $file = $request->file('file');
            $imageName = $file->getClientOriginalName();
            $file->move($destinationPath, $imageName);

            $document->file_name = $imageName;
            $document->customer_id = $id;
            $document->save();

            return response()->json(['success' => $imageName]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Upload Faild!');
        }
    }

    // remove the images in uploader
    public function prRemove(Request $request)
    {
        $filename =  $request->get('fileName');
        $id = $request->get('id');
        if ($filename) {

            PrNocAttachments::where('file_name', $filename)->delete();
            $path = 'public/uploads/pr/' . $filename;
        } else {

            $sale = PrNocAttachments::find($id);
            $path = 'public/uploads/pr/' . $sale->file_name;
            $sale->delete();
        }

        if (file_exists($path)) {
            unlink($path);
        }
        return $path;
    }

    // return the single terminate
    public function singleTerminate($id)
    {
        $this->authorize('view', PrTerminate::class);
        $customer = Provincial::find($id);
        return view('noc.provincial.terminates.show', compact('customer'));
    }

    // return the terminates provincial customers
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

        if (request('status') || request('status') == '0') {
            $customers = $customers->where('active_status', '=', request('status'));
        }

        if (request('actDate') && !request('actEndDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '=', request('actDate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('actDate') && request('actEndDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actDate'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEndDate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('terminate') && !request('terminateEnd')) {
            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereDate('pr_terminate_info.terminate_date', '=', request('terminate'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('terminate') && request('terminateEnd')) {
            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereDate('pr_terminate_info.terminate_date', '>=', request('terminate'))
                ->whereDate('pr_terminate_info.terminate_date', '<=', request('terminateEnd'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        $provinces = Province::all();
        $customers = $customers->whereNull('deleted_at')
            ->whereHas('terminate', function ($query) {
                $query->where('status', '=', 'terminate')
                    ->whereNotNull('noc_confirmation');
            })
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-terminate', 'read'))
            ->paginate(15);

        return view('noc.provincial.terminates.index', compact('customers', 'provinces'));
    }

    // return the requests to noc
    public function requests()
    {
        $this->authorize('viewAny', PrNocInfo::class);
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

        if (request('date')) {
            $customers = $customers->whereDate('installation_date', '=', request('date'));
        }

        if ((request('start') && request('end')) && !request('date')) {
            $customers = $customers->whereDate('installation_date', '>=', request('start'))
                ->whereDate('installation_date', '<=', request('end'));
        }

        $provinces = Province::all();
        $customers = $customers
            ->where([
                ['process_status', '=', '1'],
                ['suspend_status', '=', '0'],
                ['terminate_status', '=', '0'],
                ['cancel_status', '=', '0'],
                ['active_status', '=', '0']
            ])
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-installation', 'read'))
            ->paginate('15');
        return view('noc.provincial.requests', compact('customers', 'provinces'));
    }

    // return the single suspend
    public function singleSuspend($id)
    {
        $this->authorize('view', PrSuspend::class);
        $customer = Provincial::find($id);
        return view('noc.provincial.suspends.show', compact('customer'));
    }

    // return the suspends to noc
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

        if (request('status') || request('status') == '0') {
            $customers = $customers->where('active_status', '=', request('status'));
        }

        if (request('actDate') && !request('actEndDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '=', request('actDate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('actDate') && request('actEndDate')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actDate'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEndDate'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('suspend') && !request('suspendEnd')) {
            $customers = $customers
                ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereDate('pr_suspend_info.suspend_date', '=', request('suspend'))
                ->whereNull('pr_suspend_info.reactive_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('suspend') && request('suspendEnd')) {
            $customers = $customers
                ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereDate('pr_suspend_info.suspend_date', '>=', request('suspend'))
                ->whereDate('pr_suspend_info.suspend_date', '<=', request('suspendEnd'))
                ->whereNull('pr_suspend_info.reactive_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        $provinces = Province::all();
        $customers = $customers->whereNull('deleted_at')
            ->whereHas('suspend', function ($query) {
                $query->where('status', '=', 'suspend')
                    ->whereNotNull('noc_confirmation');
            })
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-suspend', 'read'))
            ->paginate(15);

        return view('noc.provincial.suspends.index', compact('customers', 'provinces'));
    }

    // reactivate details
    public function reactivateDetails($id)
    {
        $this->authorize('view', PrReactivate::class);
        $customer = PrReactivate::find($id);
        return view('noc.provincial.reactivates.show', compact('customer'));
    }

    // Return the suspend form to provincial
    public function recontractDetails($id)
    {
        $this->authorize('view', PrRecontract::class);
        $customer = PrRecontract::find($id);
        return view('noc.provincial.recontracts.show', compact('customer'));
    }

    // return the activate form
    public function activeform($id)
    {
        $this->authorize('create', PrReactivate::class);
        $customer = Provincial::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('noc.provincial.suspends.activate', compact(['customer', 'branches', 'provinces']));
    }

    public function activating(Request $request, $id)
    {
        $this->authorize('create', PrReactivate::class);
        $request->validate([
            'customer_id' => 'required',
            'branch_id' => 'required',
            'full_name' => 'required',
            'poc' => 'required',
            'full_name_persian' => 'required',
            'poc_persian' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'province' => 'required',
            'customerProvince' => 'required',
            'address' => 'required',
            'package' => 'required',
            'package_price' => 'required',
            'service' => 'required',
            'provider' => 'required',
            'reactive_date' => 'required',
            'commission_id' => 'required',
            'commission_percent' => 'required',
        ], [
            'customer_id.required' => 'Customer ID is required',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Persian Full Name is required',
            'poc_persian.required' => 'Customer Persian POC is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'address.required' => 'Address is required',
            'package.required' => 'Package is required',
            'package_price.required' => 'Package Price is required',
            'branch_id.required' => 'Branch is required',
            'service.required' => 'Service Type is required',
            'province.required' => 'Province is required',
            'customerProvince.required' => 'Customer Province is required',
            'provider.required' => 'Provider is required',
            'commission_id.required' => 'Commission is required',
            'commission_percent.required' => 'Commission Percent is required',
            'reactive_date.required' => 'Recontraction Date is required',
        ]);



        try {
            DB::beginTransaction();

            $suspend = PrSuspend::where('pr_cu_id', $id)->first();
            if (empty($suspend->sales_confirmation) || empty($suspend->finance_confirmation)) {

                return redirect()->back()->with('error', 'Please wait for confirmation.');
            } else {

                $suspend->reactive_date = date('Y-m-d');
                $suspend->save();

                $reactivate = new PrReactivate();
                $reactivate->user_id = Auth::user()->id;
                $reactivate->pr_cu_id = $id;
                $reactivate->suspend_id = $suspend->id;
                $reactivate->commission_id = $request->commission_id;
                $reactivate->marketer_id = $request->marketer_id;
                $reactivate->commission_percent = $request->commission_percent;
                $reactivate->commission_percent_currency = $request->commission_percent_currency;
                $reactivate->customer_id = $request->customer_id;
                $reactivate->full_name = $request->full_name;
                $reactivate->full_name_persian = $request->full_name_persian;
                $reactivate->poc_persian = $request->poc_persian;
                $reactivate->poc = $request->poc;
                $reactivate->phone1 = $request->phone1;
                $reactivate->phone2 = $request->phone2;
                $reactivate->branch_id = $request->branch_id;
                $reactivate->province = $request->province;
                $reactivate->customerProvince = $request->customerProvince;
                $reactivate->address = $request->address;
                $reactivate->package_id = $request->package_id;
                $reactivate->package_price = $request->package_price;
                $reactivate->package_price_currency = $request->package_price_currency;
                $reactivate->service = $request->service;
                $reactivate->provider = $request->provider;
                $reactivate->public_ip = $request->public_ip;
                $reactivate->ip_price = $request->ip_price;
                $reactivate->ip_price_currency = $request->ip_price_currency;
                $reactivate->comment = $request->comment;
                $reactivate->additional_charge = $request->additional_charge;
                $reactivate->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
                $reactivate->additional_currency = $request->additional_currency;
                $reactivate->reactive_date = $request->reactive_date;
                $reactivate->status = 'pending';
                $reactivate->save();

                // Dispatch notification when customer activate happened.
                // $customer = Provincial::find($id);
                // event(new prNocActivatingEvent($customer));

            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('pr.noc.suspends')->with('success', 'Operation Done.');
    }

    // suspending the suspends
    public function suspend(Request $request, $id)
    {
        $this->authorize('create', PrSuspend::class);
        try {
            DB::beginTransaction();

            // check if the customer has pending suspend
            $suspend = PrSuspend::where('pr_cu_id', $id)->first();
            if ($suspend && ($suspend->sales_confirmation == "" || $suspend->finance_confirmation == "" || $suspend->noc_confirmation == "")) {
                DB::rollback();
                return redirect()->back()->with('error', 'Customer has already a pending suspend.');
            }

            $customer = Provincial::find($id);
            $customer->suspend_status   = '1';
            $customer->process_status   = '0';
            $customer->active_status    = '0';
            $customer->terminate_status = '0';
            $customer->cancel_status    = '0';
            $customer->save();

            $suspend = new PrSuspend();
            $suspend->status = 'suspend';
            $suspend->suspend_reason = $request->suspend_reason;
            $suspend->suspend_date   = $request->suspend_date;
            $suspend->user_id        = Auth::user()->id;
            $suspend->noc_confirmation = date('Y/m/d H:i:s');
            $suspend->pr_cu_id    = $id;
            $suspend->customer_id    = $customer->customer_id;
            $suspend->full_name = $customer->full_name;
            $suspend->poc = $customer->poc;
            $suspend->phone1 = $customer->phone1;
            $suspend->phone2 = $customer->phone2;
            $suspend->province = $customer->province;
            $suspend->customerProvince = $customer->customerProvince;
            $suspend->branch_id = $customer->branch_id;
            $suspend->address = $customer->address;
            $suspend->package_id = $customer->package_id;
            $suspend->package_price = $customer->package_price;
            $suspend->package_price_currency = $customer->package_price_currency;
            $suspend->service = $customer->service;
            $suspend->provider = $customer->provider;
            $suspend->public_ip = $customer->public_ip;
            $suspend->ip_price = $customer->ip_price;
            $suspend->ip_price_currency = $customer->ip_price_currency;
            $suspend->commission_id = $customer->commission_id;
            $suspend->marketer_id = $customer->marketer_id;
            $suspend->commission_percent = $customer->commission_percent;
            $suspend->commission_percent_currency = $customer->commission_percent_currency;
            $suspend->additional_charge = $customer->additional_charge;
            $suspend->additional_charge_price = $customer->additional_charge_price ? $request->additional_charge_price : '0';
            $suspend->additional_currency = $customer->additional_currency;
            $suspend->save();

            // Dispatch notification when customer suspend.
            event(new prNocSuspend($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('pr.noc.suspends')->with('success', 'Operation Done.');
    }

    // edit suspend
    public function editSuspend(Request $request, $id)
    {
        $this->authorize('update', PrSuspend::class);
        try {
            DB::beginTransaction();

            $suspend = PrSuspend::find($id);
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

    // delete suspend
    public function deleteSuspend(Request $request, $id)
    {
        $this->authorize('delete', PrSuspend::class);
        try {
            DB::beginTransaction();

            $suspend = PrSuspend::find($id);
            $customer = Provincial::find($suspend->pr_cu_id);

            $customer->suspend_status   = '0';
            $customer->process_status   = '1';
            $customer->active_status    = '1';
            $customer->terminate_status = '0';
            $customer->cancel_status    = '0';

            $customer->save();
            $suspend->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('pr.noc.suspends')->with('success', 'Operation Done.');
    }

    // return the single amendments
    public function amend($id)
    {
        $this->authorize('view', PrSuspend::class);
        $customer = PrAmend::with(['provincial.provider', 'provincial.marketer'])->find($id);
        return view('noc.provincial.amendments.show', compact('customer'));
    }

    // return the amendments
    public function amendments()
    {
        $this->authorize('viewAny', PrSuspend::class);
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
        $customers = $customers->where('cancel_status', '=', '0')
            ->whereNotNull('noc_confirmation')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-amendment', 'read'));
            })->paginate(15);

        return view('noc.provincial.amendments.index', compact('customers', 'provinces'));
    }

    // return the attachments
    public function prfiles($id)
    {
        $customer = Provincial::find($id);
        return view('noc.provincial.portion.attachments', compact('customer'));
    }

    // update the lists when on new requests
    public function processEvent()
    {
        $customers = Provincial::where('process_status', '=', '1')
            ->whereNull('deleted_at')
            ->where('cancel_status', '=', '0')
            ->where('terminate_status', '=', '0')
            ->where('suspend_status', '=', '0')
            ->where('active_status', '=', '0')
            ->orderBy('id', 'desc')->paginate('15');
        return view('noc.provincial.portion.requests', compact('customers'));
    }

    // update the terminate lists
    public function terminateEvent()
    {
        $customers = Provincial::orderBy('id', 'desc')
            ->whereNull('deleted_at')
            ->where('terminate_status', '=', '1')
            ->whereHas('terminate')
            ->paginate(15);
        return view('noc.provincial.portion.terminates', compact('customers'));
    }

    // update the suspend customers
    public function suspendEvent()
    {
        $customers = Provincial::orderBy('id', 'desc')
            ->whereNull('deleted_at')
            ->where('suspend_status', '=', '1')
            ->whereHas('suspend')
            ->paginate(15);
        return view('noc.provincial.suspends.portion', compact('customers'));
    }

    // update the amendment customers
    public function amendmentEvent()
    {
        $customers = PrAmend::orderBy('id', 'desc')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })->paginate(15);

        return view('noc.provincial.amendments.portion', compact('customers'));
    }

    // update the cancels lists
    public function cancelEvent()
    {
        $cancels = Provincial::orderBy('id', 'desc')
            ->where('cancel_status', '=', '1')
            ->where('terminate_status', '=', '0')
            ->where('suspend_status', '=', '0')
            ->whereNull('deleted_at')
            ->whereHas('prCancel')->paginate('15');
        return view('sales.provincial.cancels.portion', compact('cancels'));
    }

    // return the provincial cancel amendments
    public function cancelsPrAmendments()
    {
        $this->authorize('viewAny', PrCancelAmend::class);
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
            $query->whereNull('deleted_at')
                ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-cancel-amendment', 'read'));
        })->paginate(15);

        return view('noc.provincial.amendments.cancels.index', compact('customers'));
    }

    // return the single amendment
    public function cancelPrAmendment($id)
    {
        $this->authorize('view', PrCancelAmend::class);
        $amend = PrCancelAmend::findorfail($id);
        return view('noc.provincial.amendments.cancels.show', compact('amend'));
    }
}
