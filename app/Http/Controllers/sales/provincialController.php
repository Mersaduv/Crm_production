<?php

namespace App\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provincial;
use App\Models\Branch;
use App\Models\Package;
use App\Models\Province;
use App\Models\PrAttachments;
use App\Models\PrTerminate;
use App\Models\PrSuspend;
use App\Models\PrReactivate;
use App\Models\PrRecontract;
use App\Models\PrAmend;
use App\Models\PrCancelAmend;
use App\Events\prCasheirEvent;
use App\Events\prProcessEvent;
use App\Events\prTerminateEvent;
use App\Events\prSalesSuspend;
use App\Events\prAmendmentEvent;
use App\Events\prActivatingEvent;
use App\Events\prContractionEvent;
use Illuminate\Validation\Rule;
use \Exception;
use DB;
use Auth;

class ProvincialController extends Controller
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

        if (request('status') || request('status') == '0') {
            $customers = $customers->where('active_status', '=', request('status'));
        }

        if (request('instDate') && !request('insEndDate')) {
            $customers = $customers->whereDate('installation_date', '=', request('instDate'));
        }

        if (request('instDate') && request('insEndDate')) {
            $customers = $customers->whereDate('installation_date', '>=', request('instDate'))
                ->whereDate('installation_date', '<=', request('insEndDate'));
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

        $provinces = Province::all();
        $customers = $customers
            ->where([
                ['terminate_status', '=', '0'],
                ['suspend_status', '=', '0'],
                ['cancel_status', '=', '0']
            ])
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial', 'read'))
            ->paginate(15);
        return view('sales.provincial.index', compact('customers', 'provinces'));
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
        return view('sales.provincial.create', compact('branches', 'provinces'));
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
            'customer_id' => 'required|unique:pr_customers,customer_id',
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
            'package_id' => 'required',
            'package_price' => 'required',
            'service' => 'required',
            'provider' => 'required',
            'installation_date' => 'required',
            // 'commission_id' => 'required',
            // 'marketer_id' => 'required',
            'commission_percent' => 'required',
        ], [
            'customer_id.required' => 'Customer ID is required',
            'customer_id.unique' => 'Customer ID must be unique',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Full Name Persian is required',
            'poc_persian.required' => 'Customer POC Persian is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'address.required' => 'Address is required',
            'package_id.required' => 'Package is required',
            'package_price.required' => 'Package Price is required',
            'branch_id.required' => 'Branch is required',
            'service.required' => 'Service Type is required',
            'province.required' => 'Province is required',
            'customerProvince.required' => 'Customer Province is required',
            'provider.required' => 'Provider is required',
            // 'commission_id.required' => 'Reseller is required',
            // 'marketer_id.required' => 'Reseller is required',
            'commission_percent.required' => 'Reseller Percent is required',
            'installation_date.required' => 'Installation Date is required',
        ]);

        $customer = new Provincial();

        $customer->user_id = Auth::user()->id;
        $customer->customer_id = $request->customer_id;
        $customer->full_name = $request->full_name;
        $customer->poc = $request->poc;
        $customer->full_name_persian = $request->full_name_persian;
        $customer->poc_persian = $request->poc_persian;
        $customer->phone1 = $request->phone1;
        $customer->phone2 = $request->phone2;
        $customer->branch_id = $request->branch_id;
        $customer->province = $request->province;
        $customer->customerProvince = $request->customerProvince;
        $customer->address = $request->address;
        $customer->package_id = $request->package_id;
        $customer->package_price = $request->package_price ? $request->package_price : '0';
        $customer->package_price_currency = $request->package_price_currency;
        $customer->service = $request->service;
        $customer->provider = $request->provider;
        $customer->installation_date = $request->installation_date;
        $customer->installation_cost = $request->installation_cost ? $request->installation_cost : '0';
        $customer->Installation_cost_currency = $request->Installation_cost_currency;
        $customer->public_ip = $request->public_ip;
        $customer->ip_price = $request->ip_price ? $request->ip_price : '0';
        $customer->ip_price_currency = $request->ip_price_currency;
        $customer->comment = $request->comment;
        $customer->commission_id = $request->commission_id;
        $customer->marketer_id = $request->marketer_id;
        $customer->commission_percent = $request->commission_percent ? $request->commission_percent : '0';
        $customer->commission_percent_currency = $request->commission_percent_currency;
        $customer->additional_charge = $request->additional_charge;
        $customer->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
        $customer->additional_currency = $request->additional_currency;
        $customer->demo_days = $request->demo_days ?? 0;

        try {
            DB::beginTransaction();

            $customer->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('provincial.index')->with('success', 'Operation Done.');
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
        return view('sales.provincial.show', compact('customer'));
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
        return view('sales.provincial.edit', compact(['customer', 'branches', 'provinces']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provincial $provincial)
    {
        $this->authorize('update', Provincial::class);
        $request->validate([
            'customer_id' => 'required|unique:pr_customers,customer_id,' . $provincial->id,
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
            'package_id' => 'required',
            'package_price' => 'required',
            'service' => 'required',
            'provider' => 'required',
            'installation_date' => 'required',
            // 'commission_id' => 'required',
            // 'marketer_id' => 'required',
            'commission_percent' => 'required',
        ], [
            'customer_id.required' => 'Customer ID is required',
            'customer_id.unique' => 'Customer ID must be unique',
            'full_name.required' => 'Customer Full Name is required',
            'poc.required' => 'Customer POC is required',
            'full_name_persian.required' => 'Customer Full Name Persian is required',
            'poc_persian.required' => 'Customer POC Persian is required',
            'phone1.required' => 'Customer Phone is required',
            'phone2.required' => 'Customer Phone is required',
            'address.required' => 'Address is required',
            'package_id.required' => 'Package is required',
            'package_price.required' => 'Package Price is required',
            'branch_id.required' => 'Branch is required',
            'service.required' => 'Service Type is required',
            'province.required' => 'Province is required',
            'customerProvince.required' => 'Customer Province is required',
            'provider.required' => 'Provider is required',
            // 'commission_id.required' => 'Reseller is required',
            // 'marketer_id.required' => 'Reseller is required',
            'commission_percent.required' => 'Reseller Percent is required',
            'installation_date.required' => 'Installation Date is required',
        ]);

        $provincial->user_id = Auth::user()->id;
        $provincial->customer_id = $request->customer_id;
        $provincial->full_name = $request->full_name;
        $provincial->poc = $request->poc;
        $provincial->full_name_persian = $request->full_name_persian;
        $provincial->poc_persian = $request->poc_persian;
        $provincial->phone1 = $request->phone1;
        $provincial->phone2 = $request->phone2;
        $provincial->branch_id = $request->branch_id;
        $provincial->province = $request->province;
        $provincial->customerProvince = $request->customerProvince;
        $provincial->address = $request->address;
        $provincial->package_id = $request->package_id;
        $provincial->package_price = $request->package_price ? $request->package_price : '0';
        $provincial->package_price_currency = $request->package_price_currency;
        $provincial->service = $request->service;
        $provincial->provider = $request->provider;
        $provincial->installation_date = $request->installation_date;
        $provincial->installation_cost = $request->installation_cost ? $request->installation_cost : '0';
        $provincial->Installation_cost_currency = $request->Installation_cost_currency;
        $provincial->public_ip = $request->public_ip;
        $provincial->ip_price = $request->ip_price ? $request->ip_price : '0';
        $provincial->ip_price_currency = $request->ip_price_currency;
        $provincial->comment = $request->comment;
        $provincial->commission_id = $request->commission_id;
        $provincial->marketer_id = $request->marketer_id;
        $provincial->commission_percent = $request->commission_percent ? $request->commission_percent : '0';
        $provincial->commission_percent_currency = $request->commission_percent_currency;
        $provincial->additional_charge = $request->additional_charge;
        $provincial->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
        $provincial->additional_currency = $request->additional_currency;
        $provincial->demo_days = $request->demo_days ?? 0;

        try {
            DB::beginTransaction();

            $provincial->save();

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
        $this->authorize('delete', Provincial::class);
        try {
            DB::beginTransaction();

            $customer = Provincial::find($id);
            $customer->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('provincial.index')->with('success', 'Operation Done.');
    }

    /**
     * Returing the trash customers
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('restore', Provincial::class);
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
            $customers = $customers->whereDate('deleted_at', '=', request('date'));
        }

        if ((request('start') && request('end')) && !request('date')) {
            $customers = $customers->whereDate('deleted_at', '>=', request('start'))
                ->whereDate('deleted_at', '<=', request('end'));
        }

        $provinces = Province::all();
        $customers = $customers
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial', 'read'))
            ->onlyTrashed()->paginate(15);
        return view('sales.provincial.trashed', compact('customers', 'provinces'));
    }

    /**
     * Restoring the trashed customer
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $this->authorize('restore', Provincial::class);
        try {
            DB::beginTransaction();

            Provincial::withTrashed()->find($id)->restore();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('provincial.index')->with('success', 'Operation Done.');
    }

    /**
     * Send to process the installation
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request, $id)
    {
        try {

            $customer = Provincial::find($id);
            $customer->process_status = '1';
            $customer->save();

            // Dispatch notification when new customer send for payment process.
            event(new prProcessEvent($customer));

            return redirect()->back()->with('success', 'Operation Done.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Operation Faild!');
        }
    }

    // return the attachment view
    public function prfiles($id)
    {
        $customer = Provincial::find($id);
        return view('sales.provincial.attachments', compact('customer'));
    }

    /**
     * Update the Provincial Contract file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pr_contract(Request $request, $id)
    {
        try {

            $destinationPath = 'public/uploads/pr/'; // upload path
            $document = new PrAttachments();

            $file = $request->file('file');
            $imageName = $file->getClientOriginalName();
            $file->move($destinationPath, $imageName);

            $document->file_name = $imageName;
            $document->customer_id = $id;
            $document->save();

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

            PrAttachments::where('file_name', $filename)->delete();
            $path = 'public/uploads/pr/' . $filename;
        } else {

            $sale = PrAttachments::find($id);
            $path = 'public/uploads/pr/' . $sale->file_name;
            $sale->delete();
        }

        if (file_exists($path)) {
            unlink($path);
        }
        return $path;
    }

    // terminate the customer
    public function prTerminate(Request $request, $id)
    {
        $this->authorize('create', PrTerminate::class);
        try {
            DB::beginTransaction();

            // check if the customer has pending terminate
            $terminate = PrTerminate::where('pr_cu_id', $id)->first();
            if ($terminate && ($terminate->sales_confirmation == "" || $terminate->finance_confirmation == "" || $terminate->noc_confirmation == "")) {
                DB::rollback();
                return redirect()->back()->with('error', 'Customer has already a pending terminate.');
            }

            $customer = Provincial::find($id);

            // check if the customer already in suspend process
            if ($customer->suspend_status == '1') {
                $suspend = PrSuspend::where('pr_cu_id', $id)->first();
                $suspend->status = 'terminate';
                $suspend->save();
            }

            $terminate = new PrTerminate();
            $terminate->status = 'terminate';
            $terminate->terminate_reason = $request->terminate_reason;
            $terminate->terminate_date   = $request->terminate_date;
            $terminate->user_id        = Auth::user()->id;
            $terminate->sales_confirmation = date('Y/m/d H:i:s');
            $terminate->pr_cu_id    = $id;
            $terminate->customer_id    = $customer->customer_id;
            $terminate->full_name = $customer->full_name;
            $terminate->branch_id = $customer->branch_id;
            $terminate->poc = $customer->poc;
            $terminate->phone1 = $customer->phone1;
            $terminate->phone2 = $customer->phone2;
            $terminate->province = $customer->province;
            $terminate->customerProvince = $customer->customerProvince;
            $terminate->address = $customer->address;
            $terminate->package_id = $customer->package_id;
            $terminate->package_price = $customer->package_price;
            $terminate->package_price_currency = $customer->package_price_currency;
            $terminate->service = $customer->service;
            $terminate->provider = $customer->provider;
            $terminate->public_ip = $customer->public_ip;
            $terminate->ip_price = $customer->ip_price;
            $terminate->ip_price_currency = $customer->ip_price_currency;
            $terminate->commission_id = $customer->commission_id;
            $terminate->marketer_id = $customer->marketer_id;
            $terminate->commission_percent = $customer->commission_percent;
            $terminate->commission_percent_currency = $customer->commission_percent_currency;
            $terminate->additional_charge = $customer->additional_charge;
            $terminate->additional_charge_price = $customer->additional_charge_price ? $request->additional_charge_price : '0';
            $terminate->additional_currency = $customer->additional_currency;
            $terminate->save();

            // Dispatch notification when customer terminates
            event(new prTerminateEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('pr.terminates')->with('success', 'Operation Done.');
    }

    // return the single terminate
    public function singleTerminate($id)
    {
        $this->authorize('view', PrTerminate::class);
        $customer = Provincial::find($id);
        $recontract = PrRecontract::where('pr_cu_id', $id)->first();
        return view('sales.provincial.terminates.show', compact('customer', 'recontract'));
    }

    // return the terminates
    public function prTerminates()
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
        $customers = $customers
            ->whereHas('terminate', function ($query) {
                $query->where('status', '=', 'terminate')
                    ->whereNotNull('sales_confirmation');
            })
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-terminate', 'read'))
            ->paginate(15);

        return view('sales.provincial.terminates.index', compact('customers', 'provinces'));
    }

    // Suspending the provincial customers
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
            $suspend = new PrSuspend();
            $suspend->status = 'suspend';
            $suspend->suspend_reason = $request->suspend_reason;
            $suspend->suspend_date   = $request->suspend_date;
            $suspend->user_id        = Auth::user()->id;
            $suspend->sales_confirmation = date('Y/m/d H:i:s');
            $suspend->pr_cu_id       = $id;
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
            event(new prSalesSuspend($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->route('pr.suspends')->with('success', 'Operation Done.');
    }

    // reactivate details
    public function reactivateDetails($id)
    {
        $this->authorize('view', PrReactivate::class);
        $customer = PrReactivate::find($id);
        return view('sales.provincial.reactivates.show', compact('customer'));
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

        return redirect()->route('pr.suspends')->with('success', 'Operation Done.');
    }

    // edit Terminate
    public function editTerminate(Request $request, $id)
    {
        $this->authorize('update', PrTerminate::class);
        try {
            DB::beginTransaction();

            $terminate = PrTerminate::find($id);
            $terminate->terminate_date = $request->terminate_date;
            $terminate->terminate_reason = $request->terminate_reason;
            $terminate->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done.');
    }

    // delete Terminate
    public function deleteTerminate(Request $request, $id)
    {
        $this->authorize('delete', PrTerminate::class);
        try {
            DB::beginTransaction();

            $terminate = PrTerminate::find($id);
            $customer = Provincial::find($terminate->pr_cu_id);

            $customer->cancel_status   = '0';
            $customer->suspend_status  = '0';
            $customer->active_status   = '1';
            $customer->process_status   = '1';
            $customer->terminate_status = '0';

            $customer->save();
            $terminate->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('pr.terminates')->with('success', 'Operation Done.');
    }

    public function singleSuspend($id)
    {
        $this->authorize('view', PrSuspend::class);
        $customer = Provincial::find($id);
        return view('sales.provincial.suspends.show', compact('customer'));
    }

    // Returing the suspends lists
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
                    ->whereNotNull('sales_confirmation');
            })
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-suspend', 'read'))
            ->distinct()
            ->paginate(15);

        return view('sales.provincial.suspends.index', compact('customers', 'provinces'));
    }

    // Return the recontract form to provincial
    public function recontract($id)
    {
        $this->authorize('create', PrRecontract::class);
        $customer = Provincial::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.provincial.terminates.contract', compact(['customer', 'branches', 'provinces']));
    }

    // Recontraction the provincial customer
    public function contraction(Request $request, $id)
    {
        $this->authorize('create', PrRecontract::class);
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
            'recontract_date' => 'required',
            // 'commission_id' => 'required',
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
            'recontract_date.required' => 'Recontraction Date is required',
            // 'commission_id.required' => 'Commission is required',
            'commission_percent.required' => 'Commission Percent is required',
        ]);

        try {
            DB::beginTransaction();

            $terminate = PrTerminate::where('pr_cu_id', $id)->first();

            if (empty($terminate->finance_confirmation) || empty($terminate->noc_confirmation)) {

                return redirect()->back()->with('error', 'Please wait for confirmation.');
            } else {

                $terminate->recontract_date = $request->recontract_date;
                $terminate->save();

                $customer = new PrRecontract();
                $customer->customer_id = $request->customer_id;
                $customer->full_name = $request->full_name;
                $customer->terminate_id = $terminate->id;
                $customer->poc = $request->poc;
                $customer->full_name_persian = $request->full_name_persian;
                $customer->poc_persian       = $request->poc_persian;
                $customer->phone1 = $request->phone1;
                $customer->phone2 = $request->phone2;
                $customer->branch_id = $request->branch_id;
                $customer->province = $request->province;
                $customer->customerProvince = $request->customerProvince;
                $customer->branch_id = $request->branch_id;
                $customer->address = $request->address;
                $customer->package_id = $request->package_id;
                $customer->package_price = $request->package_price;
                $customer->package_price_currency = $request->package_price_currency;
                $customer->service = $request->service;
                $customer->provider = $request->provider;
                $customer->installation_cost = $request->installation_cost;
                $customer->Installation_cost_currency = $request->Installation_cost_currency;
                $customer->public_ip = $request->public_ip;
                $customer->ip_price = $request->ip_price;
                $customer->ip_price_currency = $request->ip_price_currency;
                $customer->comment = $request->comment;
                $customer->commission_id = $request->commission_id;
                $customer->marketer_id = $request->marketer_id;
                $customer->commission_percent = $request->commission_percent;
                $customer->commission_percent_currency = $request->commission_percent_currency;
                $customer->additional_charge = $request->additional_charge;
                $customer->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
                $customer->additional_currency = $request->additional_currency;
                $customer->recontract_date = $request->recontract_date;
                $customer->user_id        = Auth::user()->id;
                $customer->sales_confirmation = date('Y/m/d H:i:s');
                $customer->pr_cu_id = $id;
                $customer->status = 'pending';
                $customer->save();

                // Dispatch notification when customer contraction happened.
                // event(new prContractionEvent($customer));

            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('pr.terminates')->with('success', 'Operation Done.');
    }

    // Return the suspend form to provincial
    public function recontractDetails($id)
    {
        $this->authorize('view', PrRecontract::class);
        $customer = PrRecontract::find($id);
        return view('sales.provincial.recontracts.show', compact('customer'));
    }

    // Return the suspend form to provincial
    public function suspendform($id)
    {
        $this->authorize('create', PrSuspend::class);
        $customer = Provincial::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.provincial.suspends.activate', compact(['customer', 'branches', 'provinces']));
    }

    // Reactivating the provincial customers
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
            // 'commission_id' => 'required',
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
            // 'commission_id.required' => 'Commission is required',
            'commission_percent.required' => 'Commission Percent is required',
            'reactive_date.required' => 'Recontraction Date is required',
        ]);


        try {
            DB::beginTransaction();

            $suspend = PrSuspend::where('pr_cu_id', $id)->first();
            if (empty($suspend->finance_confirmation) || empty($suspend->noc_confirmation)) {

                return redirect()->back()->with('error', 'Please wait for confirmation.');
            } else {

                $suspend->reactive_date = date('Y-m-d');
                $suspend->status = 'active';
                $suspend->save();

                $reactivate = new PrReactivate();
                $reactivate->user_id = Auth::user()->id;
                $reactivate->pr_cu_id = $id;
                $reactivate->suspend_id = $suspend->id;
                $reactivate->customer_id = $request->customer_id;
                $reactivate->commission_id = $request->commission_id;
                $reactivate->marketer_id = $request->marketer_id;
                $reactivate->commission_percent = $request->commission_percent;
                $reactivate->commission_percent_currency = $request->commission_percent_currency;
                $reactivate->full_name = $request->full_name;
                $reactivate->poc = $request->poc;
                $reactivate->full_name_persian = $request->full_name_persian;
                $reactivate->poc_persian = $request->poc_persian;
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
                $reactivate->sales_confirmation = date('Y/m/d H:i:s');
                $reactivate->save();

                // Dispatch notification when customer activate happened.
                // $customer = Provincial::find($id);
                // event(new prActivatingEvent($customer));

            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('pr.suspends')->with('success', 'Operation Done.');
    }

    // return the amedment form
    public function amendment($id)
    {
        $this->authorize('create', PrAmend::class);
        $customer = Provincial::find($id);
        $branches = Branch::all();
        $provinces = Province::all();
        return view('sales.provincial.amendments.amendment', compact(['customer', 'branches', 'provinces']));
    }

    // return the amedment form
    public function prEditAmendment($id)
    {
        $this->authorize('update', PrAmend::class);
        $customer = PrAmend::find($id);
        $provinces = Province::all();
        return view('sales.provincial.amendments.edit', compact(['customer', 'provinces']));
    }

    // delete amendment
    public function deleteAmendment($id)
    {
        $this->authorize('delete', PrAmend::class);
        try {
            DB::beginTransaction();

            $amed = PrAmend::find($id);
            $amed->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('pr.amendments')->with('success', 'Operation Done.');
    }

    // return the amedment form
    public function prUpdateAmendment(Request $request, $id)
    {
        $this->authorize('update', PrAmend::class);
        $request->validate([
            'customer_id' => 'required',
            'full_name' => 'required',
            'poc' => 'required',
            'full_name_persian' => 'required',
            'poc_persian' => 'required',
            'phone1' => 'required',
            'phone2' => 'required',
            'customerProvince' => 'required',
            'address' => 'required',
            'package' => 'required',
            'package_price' => 'required',
            'service' => 'required',
            'provider' => 'required',
            'amend_date' => 'required',
            'amend_comment' => 'required',
            // 'commission_id' => 'required',
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
            'service.required' => 'Service Type is required',
            'customerProvince.required' => 'Customer Province is required',
            'provider.required' => 'Provider is required',
            'amend_date.required' => 'Amendment Date is required',
            // 'commission_id.required' => 'Commission is required',
            'commission_percent.required' => 'Commission Percent is required',
            'amend_comment.required' => 'Amendment Comment is required',
        ]);

        $customer = PrAmend::find($id);
        $clone = [];

        $clone['customer_id'] = $customer->provincial->customer_id;
        $clone['full_name'] = $customer->provincial->full_name;
        $clone['poc'] = $customer->provincial->poc;
        $clone['full_name_persian'] = $customer->provincial->full_name_persian ? $customer->provincial->full_name : $customer->provincial->full_name;
        $clone['poc_persian'] = $customer->provincial->poc_persian ? $customer->provincial->poc_persian : $customer->provincial->poc;
        $clone['phone1'] = $customer->provincial->phone1;
        $clone['phone2'] = $customer->provincial->phone2;
        $clone['customerProvince'] = $customer->provincial->customerProvince;
        $clone['address'] = $customer->provincial->address;
        $clone['package_id'] = $customer->provincial->package_id;
        $clone['package_price'] = $customer->provincial->package_price;
        $clone['package_price_currency'] = $customer->provincial->package_price_currency;
        $clone['service'] = $customer->provincial->service;
        $clone['provider'] = $customer->provincial->provider;
        $clone['installation_cost'] = $customer->provincial->installation_cost;
        $clone['Installation_cost_currency'] = $customer->provincial->Installation_cost_currency;
        $clone['public_ip'] = $customer->provincial->public_ip;
        $clone['ip_price'] = $customer->provincial->ip_price;
        $clone['ip_price_currency'] = $customer->provincial->ip_price_currency;
        $clone['comment'] = $customer->provincial->comment;
        $clone['commission_id'] = $customer->provincial->commission_id;
        $clone['marketer_id'] = $customer->provincial->marketer_id;
        $clone['commission_percent'] = $customer->provincial->commission_percent;
        $clone['commission_percent_currency'] = $customer->provincial->commission_percent_currency;
        $clone['additional_charge'] = $customer->provincial->additional_charge;
        $clone['additional_charge_price'] = $customer->provincial->additional_charge_price ? $customer->provincial->additional_charge_price : '0';
        $clone['additional_currency'] = $customer->provincial->additional_currency;
        $clone['user_id'] = $customer->provincial->user_id;

        try {
            DB::beginTransaction();

            // check if the customer has pending amendment
            $amendment = PrAmend::where('pr_cu_id', $id)->first();
            if ($amendment && ($amendment->sales_confirmation == "" || $amendment->finance_confirmation == "" || $amendment->noc_confirmation == "")) {
                DB::rollback();
                return redirect()->back()->with('error', 'Customer has already a pending amendment.');
            }

            $customer->amend_date = $request->amend_date;
            $customer->amend_comment = $request->amend_comment;
            $customer->user_id = Auth::user()->id;
            $customer->sales_confirmation = date('Y/m/d H:i:s');
            $customer->customer_id = $request->customer_id;
            $customer->full_name = $request->full_name;
            $customer->poc = $request->poc;
            $customer->full_name_persian = $request->full_name_persian;
            $customer->poc_persian = $request->poc_persian;
            $customer->phone1 = $request->phone1;
            $customer->phone2 = $request->phone2;
            $customer->customerProvince = $request->customerProvince;
            $customer->address = $request->address;
            $customer->package_id = $request->package_id;
            $customer->package_price = $request->package_price;
            $customer->package_price_currency = $request->package_price_currency;
            $customer->service = $request->service;
            $customer->provider = $request->provider;
            $customer->installation_cost = $request->installation_cost;
            $customer->Installation_cost_currency = $request->Installation_cost_currency;
            $customer->public_ip = $request->public_ip;
            $customer->ip_price = $request->ip_price;
            $customer->ip_price_currency = $request->ip_price_currency;
            $customer->commission_id = $request->commission_id;
            $customer->marketer_id = $request->marketer_id;
            $customer->commission_percent = $request->commission_percent;
            $customer->commission_percent_currency = $request->commission_percent_currency;
            $customer->additional_charge = $request->additional_charge;
            $customer->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
            $customer->additional_currency = $request->additional_currency;
            $customer->clone = json_encode($clone);
            $customer->save();

            // Dispatch notification when amendation happened.
            event(new prAmendmentEvent($customer->provincial));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done.');
    }

    // amendmentation process for provincial
    public function amendmentation(Request $request, $id)
    {
        $this->authorize('create', PrAmend::class);
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
            'amend_date' => 'required',
            'amend_comment' => 'required',
            // 'commission_id' => 'required',
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
            'amend_date.required' => 'Amendment Date is required',
            // 'commission_id.required' => 'Commission is required',
            'commission_percent.required' => 'Commission Percent is required',
            'amend_comment.required' => 'Amendment Comment is required',
        ]);

        $customer = Provincial::find($id);
        $clone = [];

        $clone['customer_id'] = $customer->customer_id;
        $clone['full_name'] = $customer->full_name;
        $clone['poc'] = $customer->poc;
        $clone['full_name_persian'] = $customer->full_name_persian ? $customer->full_name_persian : $customer->full_name;
        $clone['poc_persian'] = $customer->poc_persian ? $customer->poc_persian : $customer->poc;
        $clone['phone1'] = $customer->phone1;
        $clone['phone2'] = $customer->phone2;
        $clone['branch_id'] = $customer->branch_id;
        $clone['province'] = $customer->province;
        $clone['customerProvince'] = $customer->customerProvince;
        $clone['address'] = $customer->address;
        $clone['package_id'] = $customer->package_id;
        $clone['package_price'] = $customer->package_price;
        $clone['package_price_currency'] = $customer->package_price_currency;
        $clone['service'] = $customer->service;
        $clone['provider'] = $customer->provider;
        $clone['public_ip'] = $customer->public_ip;
        $clone['ip_price'] = $customer->ip_price;
        $clone['ip_price_currency'] = $customer->ip_price_currency;
        $clone['comment'] = $customer->comment;
        $clone['commission_id'] = $customer->commission_id;
        $clone['marketer_id'] = $customer->marketer_id;
        $clone['commission_percent'] = $customer->commission_percent;
        $clone['commission_percent_currency'] = $customer->commission_percent_currency;
        $clone['additional_charge'] = $customer->additional_charge;
        $clone['additional_charge_price'] = $customer->additional_charge_price ? $customer->additional_charge_price : '0';
        $clone['additional_currency'] = $customer->additional_currency;
        $clone['user_id'] = $customer->user_id;

        try {
            DB::beginTransaction();

            $amed = new PrAmend();
            $amed->pr_cu_id = $id;
            $amed->amend_date = $request->amend_date;
            $amed->amend_comment = $request->amend_comment;
            $amed->user_id = Auth::user()->id;
            $amed->sales_confirmation = date('Y/m/d H:i:s');
            $amed->customer_id = $request->customer_id;
            $amed->full_name = $request->full_name;
            $amed->poc = $request->poc;
            $amed->full_name_persian = $request->full_name_persian;
            $amed->poc_persian = $request->poc_persian;
            $amed->phone1 = $request->phone1;
            $amed->phone2 = $request->phone2;
            $amed->province = $request->province;
            $amed->customerProvince = $request->customerProvince;
            $amed->address = $request->address;
            $amed->package_id = $request->package_id;
            $amed->package_price = $request->package_price;
            $amed->package_price_currency = $request->package_price_currency;
            $amed->service = $request->service;
            $amed->provider = $request->provider;
            $amed->public_ip = $request->public_ip;
            $amed->ip_price = $request->ip_price;
            $amed->ip_price_currency = $request->ip_price_currency;
            $amed->commission_id = $request->commission_id;
            $amed->marketer_id = $request->marketer_id;
            $amed->commission_percent = $request->commission_percent;
            $amed->commission_percent_currency = $request->commission_percent_currency;
            $amed->additional_charge = $request->additional_charge;
            $amed->additional_charge_price = $request->additional_charge_price ? $request->additional_charge_price : '0';
            $amed->additional_currency = $request->additional_currency;
            $amed->clone = json_encode($clone);
            $amed->save();

            // Dispatch notification when amendation happened.
            event(new prAmendmentEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('pr.amendments')->with('success', 'Operation Done.');
    }

    public function amend($id)
    {
        $this->authorize('view', PrAmend::class);
        $customer = PrAmend::find($id);
        return view('sales.provincial.amendments.show', compact('customer'));
    }

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
        $customers = $customers->where('cancel_status', '=', '0')
            ->whereNotNull('noc_confirmation')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-amendment', 'read'));
            })
            ->paginate(15);

        return view('sales.provincial.amendments.index', compact('customers', 'provinces'));
    }

    public function prprint($id)
    {
        $customer = Provincial::find($id);
        return view('sales.provincial.print', compact('customer'));
    }

    // return the attachments
    public function prattaches($id)
    {
        $customer = Provincial::find($id);
        return view('sales.provincial.portion.attachments', compact('customer'));
    }

    // update the customers when payment confirmed
    public function confirmed()
    {
        $customers = Provincial::where('payed_status', '=', '1')
            ->where('cashier_status', '=', '1')
            ->where('terminate_status', '=', '0')
            ->where('suspend_status', '=', '0')
            ->where('cancel_status', '=', '0')
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')->paginate('15');
        return view('sales.provincial.portion.customers', compact('customers'));
    }

    // update the suspend customers
    public function suspendEvent()
    {
        $customers = Provincial::orderBy('id', 'desc')
            ->whereNull('deleted_at')
            ->where('suspend_status', '=', '1')
            ->whereHas('suspend')
            ->paginate(15);
        return view('sales.provincial.suspends.portion', compact('customers'));
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
    public function cancelPrAmends()
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
            $query->whereNull('deleted_at');
        })->paginate(15);

        return view('sales.provincial.amendments.cancels.index', compact('customers'));
    }

    // return the single amendment
    public function cancelPrAmend($id)
    {
        $this->authorize('view', PrCancelAmend::class);
        $amend = PrCancelAmend::findorfail($id);
        return view('sales.provincial.amendments.cancels.show', compact('amend'));
    }

    public function printPrAmendment(Request $request)
    {
        $id = $request->id;
        $packages = Package::all();
        $customer = PrAmend::find($id);
        return view('sales.provincial.amendments.print', compact(['customer', 'packages']));
    }

    public function printPrSuspend(Request $request)
    {
        $id = $request->id;
        $customer = PrReactivate::find($id);
        return view('sales.provincial.reactivates.print', compact('customer'));
    }

    public function printPrTerminate(Request $request)
    {
        $id = $request->id;
        $customer = PrRecontract::find($id);
        return view('sales.provincial.recontracts.print', compact('customer'));
    }
}
