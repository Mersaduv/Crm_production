<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\RequestTerminate;
use App\Models\Sale;
use App\Models\NOC;
use App\Models\SalesAttachment;
use App\Models\Customer;
use App\Models\Provincial;
use App\Models\Suspend;
use App\Models\Reactivate;
use App\Models\Recontract;
use App\Models\PrSuspend;
use App\Models\PrReactivate;
use App\Models\PrRecontract;
use App\Models\Terminate;
use App\Models\PrTerminate;
use App\Models\Amend;
use App\Models\PrAmend;
use App\Models\Cancel;
use App\Models\PrCancel;
use App\Models\Commission;
use App\Models\SaleEquipments;
use App\Models\LeaseEquipments;
use App\Models\Equipments;
use App\Models\CancelAmend;
use App\Models\PrCancelAmend;
use App\Events\cancelAmendmentEvent;
use App\Events\cancelPrAmendment;
use App\Events\customerReactivateEvent;
use App\Events\customerContractionEvent;
use App\Events\prContractionEvent;
use App\Events\prActivatingEvent;
use App\Models\Branch;
use App\Models\Marketer;
use App\Models\Provider;
use App\Models\Province;
use \Exception;
use DB;
use Auth;

class SearchController extends Controller
{
    // Return the equipment types
    public function equipmentTypes(Request $request)
    {
        $output = "";
        $types = DB::connection('mysql2')->table('equipment_types')
            ->where('et_name', 'like', '%' . $request->search . '%')->get();

        if ($types->isNotEmpty()) {
            foreach ($types as $type) {
                $output .= '<li class="list-group-item"
                                id="' . $type->et_id . '">' . $type->et_name . '' . $type->et_model . '</li>';
            }
        } else {
            $output .= '<li class="list-group-item"
                            style="pointer-events:none">' . 'No results' . '</li>';
        }
        return $output;
    }

    // Return the packages types
    public function packagesType(Request $request)
    {
        $output = "";
        $types = Package::where('name', 'like', '%' . $request->search . '%')->get();

        if ($types->isNotEmpty()) {

            foreach ($types as $type) {

                $price = $type->price ? $type->price . ' ' . $type->price_currency : '*';
                $duration = $type->duration ? $type->duration . ' ' . $type->duration_unit : '*';

                $price_value = $type->price ? $type->price : '';
                $currency = $type->price ? $type->price_currency : '';

                if ($type->category->name == 'vip') {

                    $output .= '<li class="list-group-item"
                                    id="' . $type->id . '"
                                    price="' . $price_value . '"
                                    currency="' . $currency . '"
                                    content="' . $type->name . '">' . $type->name . '</li>';
                } else {

                    $output .= '<li class="list-group-item"
                                    id="' . $type->id . '"
                                    price="' . $price_value . '"
                                    currency="' . $currency . '"
                                    content="' . $type->name . '">' . $type->name . ' - ' . $price . ' - ' . $duration . '</li>';
                }
            }
        } else {
            $output .= '<li class="list-group-item"
                           style="pointer-events: none">' . 'No results' . '</li>';
        }

        return $output;
    }

    // Return the Commissions
    public function commissions(Request $request)
    {
        $output = "";
        $commissions = Commission::where('name', 'like', '%' . $request->search . '%')->get();

        if ($commissions->isNotEmpty()) {

            foreach ($commissions as $commission) {
                $output .= '<li class="list-group-item"
                                id="' . $commission->id . '">' . $commission->name . '</li>';
            }
        } else {
            $output .= '<li class="list-group-item"
                            style="pointer-events:none">' . 'No results' . '</li>';
        }

        return $output;
    }


    // Return the Marketers
    public function marketers(Request $request)
    {
        $output = "";
        $marketers = Marketer::where('name', 'like', '%' . $request->search . '%')->get();

        if ($marketers->isNotEmpty()) {

            foreach ($marketers as $marketer) {
                $output .= '<li class="list-group-item"
                                id="' . $marketer->id . '">' . $marketer->name . '</li>';
            }
        } else {
            $output .= '<li class="list-group-item"
                            style="pointer-events:none">' . 'No results' . '</li>';
        }

        return $output;
    }



    // Return the Providers
    public function providers(Request $request)
    {
        $output = "";
        $providers = Provider::where('name', 'like', '%' . $request->search . '%')->get();

        if ($providers->isNotEmpty()) {

            foreach ($providers as $provider) {
                $output .= '<li class="list-group-item"
                                id="' . $provider->id . '">' . $provider->name . '</li>';
            }
        } else {
            $output .= '<li class="list-group-item"
                            style="pointer-events:none">' . 'No results' . '</li>';
        }

        return $output;
    }

    // Check mac address exist in sold equipments
    public function checkSellMac(Request $request)
    {

        $eq = SaleEquipments::join('equipments', 'equipments.eq_id', '=', 'equipment_sales.equipment_id')
            ->where('equipment_sales.customer_id', '=', $request->id)
            ->where('equipments.eq_key_value', '=', $request->data)
            ->first();

        if (!empty($eq)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    // Check mac address exist in leased equipments
    public function checkLeasedMac(Request $request)
    {

        $eq = LeaseEquipments::join('equipments', 'equipments.eq_id', '=', 'leased_equipments.equipment_id')
            ->where('leased_equipments.customer_id', '=', $request->id)
            ->where('equipments.eq_key_value', '=', $request->data)
            ->first();

        if (!empty($eq)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    // get Customer
    public function getCustomer(Request $request)
    {
        $output = "";
        $types = DB::table('customers')
            ->where('full_name', 'like', '%' . $request->search . '%')
            ->whereNull('deleted_at')
            ->where('active_status', '=', '1')->get();

        if ($types->isEmpty()) {

            $types = DB::table('pr_customers')
                ->where('full_name', 'like', '%' . $request->search . '%')
                ->whereNull('deleted_at')
                ->where('active_status', '=', '1')->get();
        }

        if ($types->isNotEmpty()) {
            foreach ($types as $type) {

                $output .= '<li class="list-group-item"
                                id="' . $type->id . '">' . $type->full_name . ' - ' . $type->customer_id . '</li>';
            }
        } else {

            $output .= '<li class="list-group-item"
                            style="pointer-events:none">' . 'No results' . '</li>';
        }
        return $output;
    }

    // get Customer
    public function getPrCustomer(Request $request)
    {
        $output = "";
        $types = DB::table('pr_customers')
            ->where('full_name', 'like', '%' . $request->search . '%')
            ->whereNull('deleted_at')
            ->where('active_status', '=', '1')->get();
        if ($types) {
            foreach ($types as $type) {
                $output .= '<option value="' . $type->full_name . ' - ' . $type->customer_id . '" id="' . $type->id . '">';
            }
            return $output;
        }
    }

    // return the attachment view to sales customers
    public function saleFiles(Request $request)
    {
        $sale = Sale::find($request->id);
        return view('sales.customers.images', compact('sale'));
    }

    // return the attachment view to sales provincial
    public function prFiles(Request $request)
    {
        $customer = Provincial::find($request->id);
        return view('sales.provincial.portion.images', compact('customer'));
    }

    // return the attachment view to noc customers
    public function nocFiles(Request $request)
    {
        $customer = Customer::find($request->id);
        return view('noc.customers.images', compact('customer'));
    }

    // return the attachment view to noc customers
    public function prNocFiles(Request $request)
    {
        $customer = Provincial::find($request->id);
        return view('noc.provincial.portion.images', compact('customer'));
    }

    // get requests
    public function requests()
    {
        $requests = RequestTerminate::latest('requests.created_at');
        if (request('customer_id')) {
            $requests = $requests->where('customer_id', '=', request('customer_id'));
        }

        if (request('date')) {
            $requests = $requests->whereDate('request_date', '=', request('date'));
        }

        if (request('sender')) {
            $requests = $requests->join('users', 'requests.user_id', '=', 'users.id')
                ->where('users.name', 'like', '%' . request('sender') . '%');
        }

        if (request('status')) {
            $requests = $requests->where('status', '=', request('status'));
        }

        $requests = $requests
            ->whereHas('customer', function ($query) {
                $query->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'customers', 'read'));
            })->paginate(15);

        if (Auth::user()->role == 'admin') {
            return view('dashboard.requests.index', compact('requests'));
        } else {
            return view('sales.requests.index', compact('requests'));
        }
    }

    // get request
    public function request($id)
    {
        $request = RequestTerminate::find($id);
        if (Auth::user()->role == 'admin') {
            return view('dashboard.requests.show', compact('request'));
        } else {
            return view('sales.requests.show', compact('request'));
        }
    }

    // update the request status
    public function updateRequest(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $req = RequestTerminate::find($id);
            $req->status = $request->status;
            $req->reject_reason = $request->reject_reason;
            $req->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }
        return redirect()->back()->with('success', 'Operation Done!');
    }

    // update the customer new requests on finance dashboard
    public function financeCustomersUpdate()
    {
        $customers = Customer::orderby('id', 'desc')
            ->where('noc_status', '=', '1')
            ->where('finance_status', '=', '1')
            ->paginate(15);
        return view('finance.customers.portion.list', compact('customers'));
    }

    //update customers status on sales dashboard
    public function customerStatus()
    {
        $customers = Customer::orderby('id', 'desc')
            ->where('terminate_status', '=', '1')
            ->where('suspend_status', '=', '1')
            ->paginate(15);
        return view('sales.customers.portion.list', compact('customers'));
    }

    // Update the list of new request in noc
    public function nocProcess()
    {
        $customers = Customer::orderby('id', 'desc')
            ->where('noc_status', '=', '1')
            ->where('active_status', '=', '0')->paginate(15);
        return view('noc.customers.portion.list', compact('customers'));
    }

    // Update the NOC Suspend list
    public function nocSuspend()
    {
        $customers = Customer::orderBy('id', 'desc')
            ->whereNull('deleted_at')
            ->whereHas('suspend')
            ->paginate(15);
        return view('noc.customers.suspends.portion', compact('customers'));
    }

    // Update the Suspend Suspend list
    public function salesSuspend()
    {
        $customers = Customer::orderBy('id', 'desc')
            ->whereNull('deleted_at')
            ->whereHas('suspend')
            ->paginate(15);
        return view('sales.customers.suspends.portion', compact('customers'));
    }

    // Update the finance Suspend list
    public function financeSuspend()
    {
        $customers = Customer::orderBy('id', 'desc')
            ->whereNull('deleted_at')
            ->whereHas('suspend')
            ->paginate(15);
        return view('finance.customers.suspends.portion', compact('customers'));
    }

    // update the noc terminate list
    public function nocTerminate()
    {
        $customers = Customer::orderBy('id', 'desc')
            ->where('terminate_status', '=', '1')
            ->whereNull('deleted_at')
            ->whereHas('terminate')
            ->paginate(15);
        return view('noc.customers.terminates.portion', compact('customers'));
    }

    // update the finance terminate list
    public function financeTerminate()
    {
        $customers = Customer::orderBy('id', 'desc')
            ->where('terminate_status', '=', '1')
            ->whereNull('deleted_at')
            ->whereHas('terminate')
            ->paginate(15);
        return view('finance.customers.terminates.portion', compact('customers'));
    }

    // update the noc amedment list
    public function nocAmed()
    {
        $customers = Amend::latest()
            ->where('cancel_status', '=', '0')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->paginate(15);

        return view('noc.customers.amendments.portion', compact('customers'));
    }

    // update the finance amedment list
    public function financeAmed()
    {
        $customers = Amend::latest()
            ->where('cancel_status', '=', '0')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->paginate(15);
        return view('finance.customers.amendments.portion', compact('customers'));
    }

    // Update the terminate requests in sales dash
    public function terminateRequests()
    {
        $requests = RequestTerminate::orderby('id', 'desc')->paginate(15);
        return view('sales.requests.portion.requests', compact('requests'));
    }

    // mark notifications
    public function markNotification(Request $request)
    {

        try {
            DB::beginTransaction();

            DB::table('notifications')->where('notifiable_id', '=', auth()->user()->id)
                ->delete($request->input('id'));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->noContent();
        }
        return response()->noContent();
    }

    // Check Customer Status
    public function status(Request $request)
    {
        $customer = Customer::findorfail($request->id);
        return $customer->terminate_status;
    }

    // Check Customer Status
    public function contactorsCheck(Request $request)
    {
        $customer = Provincial::findorfail($request->id);
        return $customer->terminate_status;
    }

    // confirm the cancel operation
    public function confirmCancel(Request $request)
    {

        $cancel = Cancel::findorfail($request->id);

        if (Auth::user()->role == 'sales') {

            $cancel->sales_confirmation = date('Y/m/d H:i:s');
        } else if (Auth::user()->role == 'finance') {

            $cancel->finance_confirmation = date('Y/m/d H:i:s');
        } else if (Auth::user()->role == 'noc') {

            $cancel->noc_confirmation = date('Y/m/d H:i:s');
        }

        $cancel->save();
        return response('success', 200);
    }

    // confirm the suspend customer
    public function confirmSuspend(Request $request)
    {
        try {

            $suspend = Suspend::findorfail($request->id);

            if (Auth::user()->role == 'sales') {

                $suspend->sales_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'finance') {

                $suspend->finance_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'noc') {

                $suspend->noc_confirmation = date('Y/m/d H:i:s');
                $suspend->status = 'suspend';

                $customer = Customer::find($suspend->cu_id);
                $customer->suspend_status   = '1';
                $customer->noc_status       = '0';
                $customer->active_status    = '0';
                $customer->terminate_status = '0';
                $customer->save();
            }

            $suspend->save();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed', 400);
        }

        return response('success', 200);
    }

    // confirm the reactivation
    public function confirmReactivate(Request $request)
    {
        try {

            $reactivate = Reactivate::findorfail($request->id);

            if (Auth::user()->role == 'sales') {

                $reactivate->sales_confirmation = date('Y/m/d H:i:s');
            }

            if (Auth::user()->role == 'finance') {

                $reactivate->finance_confirmation = date('Y/m/d H:i:s');
            }

            if (Auth::user()->role == 'noc') {

                $reactivate->noc_confirmation = date('Y/m/d H:i:s');
                $reactivate->status = 'confirm';

                $customer = Customer::find($reactivate->cu_id);
                $customer->suspend_status   = '0';
                $customer->noc_status       = '1';
                $customer->active_status    = '1';
                $customer->customer_id = $reactivate->customer_id;
                $customer->branch_id = $reactivate->branch_id;
                $customer->province = $reactivate->province;
                $customer->full_name = $reactivate->full_name;
                $customer->poc = $reactivate->poc;
                $customer->full_name_persian = $reactivate->full_name_persian;
                $customer->poc_persian = $reactivate->poc_persian;
                $customer->phone1 = $reactivate->phone1;
                $customer->phone2 = $reactivate->phone2;
                $customer->education = $reactivate->education;
                $customer->address = $reactivate->address;
                $customer->identity_num = $reactivate->identity;
                $customer->last_state = 'reactive';

                $sales = Sale::where('customer_id', $customer->id)->first();
                $sales->package_id = $reactivate->package_id;
                $sales->package_price = $reactivate->package_price ? $reactivate->package_price : '0';
                $sales->package_price_currency = $reactivate->package_price_currency;
                $sales->discount = $reactivate->discount;
                $sales->discount_currency = $reactivate->discount_currency;
                $sales->discount_period = $reactivate->discount_period;
                $sales->discount_period_currency = $reactivate->discount_period_currency;
                $sales->discount_reason = $reactivate->discount_reason;
                $sales->equi_type = $reactivate->equi_type;
                $sales->leased_type = $reactivate->leased_type;
                $sales->receiver_type = $reactivate->receiver_type;
                $sales->receiver_price = $reactivate->receiver_price;
                $sales->receiver_price_currency = $reactivate->receiver_price_currency;
                $sales->router_type = $reactivate->router_type;
                $sales->router_price = $reactivate->router_price;
                $sales->router_price_currency = $reactivate->router_price_currency;
                $sales->Installation_cost = $reactivate->Installation_cost;
                $sales->Installation_cost_currency = $reactivate->Installation_cost_currency;
                $sales->public_ip = $reactivate->public_ip;
                $sales->ip_price = $reactivate->ip_price;
                $sales->ip_price_currency = $reactivate->ip_price_currency;
                $sales->comment = $reactivate->comment;
                $sales->cable_price = $reactivate->cable_price;
                $sales->cable_price_currency = $reactivate->cable_price_currency;
                $sales->customer_id = $customer->id;
                $sales->commission_id = $reactivate->commission_id;
                $sales->marketer_id = $reactivate->marketer_id;
                $sales->commission_percent = $reactivate->commission_percent ? $reactivate->commission_percent : '0';
                $sales->commission_percent_currency = $reactivate->commission_percent_currency;
                $sales->additional_charge = $reactivate->additional_charge;
                $sales->additional_charge_price = $reactivate->additional_charge_price ? $reactivate->additional_charge_price : '0';
                $sales->additional_currency = $reactivate->additional_currency;

                // Dispatch Event On Activation
                event(new customerReactivateEvent($customer));

                $sales->save();
                $customer->save();
            }

            $reactivate->save();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed', $e);
        }

        return response('success', 200);
    }

    // confirm the reactivation
    public function confirmPrReactivate(Request $request)
    {
        try {

            $reactivate = PrReactivate::findorfail($request->id);

            if (Auth::user()->role == 'sales') {

                $reactivate->sales_confirmation = date('Y/m/d H:i:s');
            }

            if (Auth::user()->role == 'finance') {

                $reactivate->finance_confirmation = date('Y/m/d H:i:s');
            }

            if (Auth::user()->role == 'noc') {

                $reactivate->noc_confirmation = date('Y/m/d H:i:s');
                $reactivate->status = 'confirm';

                $customer = Provincial::find($reactivate->pr_cu_id);
                $customer->suspend_status = '0';
                $customer->process_status = '1';
                $customer->active_status  = '1';
                $customer->customer_id = $reactivate->customer_id;
                $customer->branch_id   = $reactivate->branch_id;
                $customer->commission_id = $reactivate->commission_id;
                $customer->marketer_id = $reactivate->marketer_id;
                $customer->commission_percent = $reactivate->commission_percent ? $reactivate->commission_percent : '0';
                $customer->commission_percent_currency = $reactivate->commission_percent_currency;
                $customer->full_name   = $reactivate->full_name;
                $customer->poc         = $reactivate->poc;
                $customer->full_name_persian   = $reactivate->full_name_persian;
                $customer->poc_persian         = $reactivate->poc_persian;
                $customer->province    = $reactivate->province;
                $customer->customerProvince = $reactivate->customerProvince;
                $customer->address = $reactivate->address;
                $customer->package_id = $reactivate->package_id;
                $customer->package_price = $reactivate->package_price ? $reactivate->package_price : '0';
                $customer->package_price_currency = $reactivate->package_price_currency;
                $customer->public_ip = $reactivate->public_ip;
                $customer->ip_price = $reactivate->ip_price;
                $customer->ip_price_currency = $reactivate->ip_price_currency;
                $customer->service = $reactivate->service;
                $customer->provider = $reactivate->provider;
                $customer->phone1 = $reactivate->phone1;
                $customer->phone2 = $reactivate->phone2;
                $customer->additional_charge = $reactivate->additional_charge;
                $customer->additional_charge_price = $reactivate->additional_charge_price ? $reactivate->additional_charge_price : '0';
                $customer->additional_currency = $reactivate->additional_currency;
                $customer->last_state = 'reactive';

                // event
                event(new prActivatingEvent($customer));
                $customer->save();
            }

            $reactivate->save();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed', $e);
        }

        return response('success', 200);
    }

    // confirm the recontraction
    public function confirmRecontract(Request $request)
    {
        try {

            $recontract = Recontract::findorfail($request->id);
            $terminate = Terminate::where('id', $recontract->terminate_id)->first();
            if (Auth::user()->role == 'finance') {

                $recontract->finance_confirmation = date('Y/m/d H:i:s');
            }

            if (Auth::user()->role == 'sales') {

                $recontract->sales_confirmation = date('Y/m/d H:i:s');
            }

            if (Auth::user()->role == 'noc') {


                $recontract->noc_confirmation = date('Y/m/d H:i:s');
                $recontract->status = 'confirm';

                $terminate->status = 'active';


                $customer = Customer::find($recontract->cu_id);
                $customer->suspend_status = '0';
                $customer->noc_status     = '0';
                $customer->active_status  = '0';
                $customer->terminate_status  = '0';
                $customer->finance_status  = '0';
                $customer->customer_id = $recontract->customer_id;
                $customer->branch_id = $recontract->branch_id;
                $customer->province = $recontract->province;
                $customer->full_name = $recontract->full_name;
                $customer->poc = $recontract->poc;
                $customer->full_name_persian = $recontract->full_name_persian;
                $customer->poc_persian = $recontract->poc_persian;
                $customer->phone1 = $recontract->phone1;
                $customer->phone2 = $recontract->phone2;
                $customer->education = $recontract->education;
                $customer->address = $recontract->address;
                $customer->identity_num = $recontract->identity;
                $customer->last_state = 'recontract';

                $sales = Sale::where('customer_id', $customer->id)->first();
                $sales->customer_id = $customer->id;
                $sales->package_id = $recontract->package_id;
                $sales->package_price = $recontract->package_price ? $recontract->package_price : '0';
                $sales->package_price_currency = $recontract->package_price_currency;
                $sales->discount = $recontract->discount;
                $sales->discount_currency = $recontract->discount_currency;
                $sales->discount_period = $recontract->discount_period;
                $sales->discount_period_currency = $recontract->discount_period_currency;
                $sales->discount_reason = $recontract->discount_reason;
                $sales->equi_type = $recontract->equi_type;
                $sales->leased_type = $recontract->leased_type;
                $sales->receiver_type = $recontract->receiver_type;
                $sales->receiver_price = $recontract->receiver_price;
                $sales->receiver_price_currency = $recontract->receiver_price_currency;
                $sales->router_type = $recontract->router_type;
                $sales->router_price = $recontract->router_price;
                $sales->router_price_currency = $recontract->router_price_currency;
                $sales->Installation_cost = $recontract->Installation_cost;
                $sales->Installation_cost_currency = $recontract->Installation_cost_currency;
                $sales->public_ip = $recontract->public_ip;
                $sales->ip_price = $recontract->ip_price;
                $sales->ip_price_currency = $recontract->ip_price_currency;
                $sales->comment = $recontract->comment;
                $sales->cable_price = $recontract->cable_price;
                $sales->cable_price_currency = $recontract->cable_price_currency;
                $sales->commission_id = $recontract->commission_id;
                $sales->marketer_id = $recontract->marketer_id;
                $sales->commission_percent = $recontract->commission_percent ? $recontract->commission_percent : '0';
                $sales->commission_percent_currency = $recontract->commission_percent_currency;
                $sales->additional_charge = $recontract->additional_charge;
                $sales->additional_charge_price = $recontract->additional_charge_price ? $recontract->additional_charge_price : '0';
                $sales->additional_currency = $recontract->additional_currency;
                $sales->installation_date = $recontract->recontract_date;

                // Dispatch Event On Activation
                event(new customerContractionEvent($customer));

                $sales->save();
                $customer->save();
                $terminate->save();
            }

            $recontract->save();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed');
        }

        return response('success', 200);
    }

    // confirm the recontraction of the provincial customer
    public function ConfirmPrRecontract(Request $request)
    {
        try {

            $recontract = PrRecontract::findorfail($request->id);
            $terminate = PrTerminate::where('id', $recontract->terminate_id)->first();
            if (Auth::user()->role == 'finance') {

                $recontract->finance_confirmation = date('Y/m/d H:i:s');
            }

            if (Auth::user()->role == 'sales') {

                $recontract->sales_confirmation = date('Y/m/d H:i:s');
            }

            if (Auth::user()->role == 'noc') {


                $recontract->noc_confirmation = date('Y/m/d H:i:s');
                $recontract->status = 'confirm';

                $terminate->status = 'active';

                $customer = Provincial::find($recontract->pr_cu_id);
                $customer->process_status = '0';
                $customer->active_status = '0';
                $customer->terminate_status = '0';
                $customer->finance_status = '0';
                $customer->customer_id = $recontract->customer_id;
                $customer->branch_id = $recontract->branch_id;
                $customer->commission_id = $recontract->commission_id;
                $customer->marketer_id = $recontract->marketer_id;
                $customer->commission_percent = $recontract->commission_percent;
                $customer->commission_percent_currency = $recontract->commission_percent_currency;
                $customer->full_name = $recontract->full_name;
                $customer->poc = $recontract->poc;
                $customer->full_name_persian = $recontract->full_name_persian;
                $customer->poc_persian = $recontract->poc_persian;
                $customer->province = $recontract->province;
                $customer->customerProvince = $recontract->customerProvince;
                $customer->address = $recontract->address;
                $customer->package_id = $recontract->package_id;
                $customer->package_price = $recontract->package_price;
                $customer->package_price_currency = $recontract->package_price_currency;
                $customer->installation_cost = $recontract->installation_cost;
                $customer->Installation_cost_currency = $recontract->Installation_cost_currency;
                $customer->public_ip = $recontract->public_ip;
                $customer->ip_price = $recontract->ip_price;
                $customer->ip_price_currency = $recontract->ip_price_currency;
                $customer->service = $recontract->service;
                $customer->provider = $recontract->provider;
                $customer->phone1 = $recontract->phone1;
                $customer->phone2 = $recontract->phone2;
                $customer->additional_charge = $recontract->additional_charge;
                $customer->additional_charge_price = $recontract->additional_charge_price ? $request->additional_charge_price : '0';
                $customer->additional_currency = $recontract->additional_currency;
                $customer->last_state = 'recontract';
                $customer->save();
                $terminate->save();
                // Dispatch notification when customer contraction happened.
                event(new prContractionEvent($customer));
            }

            $recontract->save();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed');
        }

        return response('success', 200);
    }

    // confirm the terminate customer
    public function confirmTerminate(Request $request)
    {

        try {

            $terminate = Terminate::findorfail($request->id);

            if (Auth::user()->role == 'sales') {

                $terminate->sales_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'finance') {

                $terminate->finance_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'noc') {

                $terminate->noc_confirmation = date('Y/m/d H:i:s');
                $terminate->status = 'terminate';

                $customer = Customer::find($terminate->cu_id);
                $customer->suspend_status   = '0';
                $customer->noc_status       = '0';
                $customer->active_status    = '0';
                $customer->terminate_status = '1';
                $customer->save();
            }

            $terminate->save();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed', 400);
        }

        return response('success', 200);
    }

    // confirm the amendment of customer
    public function confirmAmend(Request $request)
    {

        try {

            DB::beginTransaction();

            $amend = Amend::findorfail($request->id);
            $cu_id = $amend->cu_id;
            $customer = Customer::where('id', '=', $cu_id)->first();
            $sales = Sale::where('customer_id', $customer->id)->first();

            if (Auth::user()->role == 'sales') {

                $amend->sales_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'finance') {

                $amend->finance_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'noc') {

                $amend->noc_confirmation = date('Y/m/d H:i:s');
            }

            if (!empty($amend->noc_confirmation)) {
                $customer->customer_id = $amend->customer_id;
                $customer->full_name = $amend->full_name;
                $customer->poc = $amend->poc;
                $customer->full_name_persian = $amend->full_name_persian ? $amend->full_name_persian : $amend->full_name;
                $customer->poc_persian = $amend->poc_persian ? $amend->poc_persian : $amend->poc;
                $customer->phone1 = $amend->phone1;
                $customer->phone2 = $amend->phone2;
                $customer->education = $amend->education;
                $customer->address = $amend->address;
                $customer->identity_num = $amend->identity;
                $sales->package_id     = $amend->package_id;
                $sales->package_price = $amend->package_price ? $amend->package_price : '0';
                $sales->package_price_currency = $amend->package_price_currency;
                $sales->discount       = $amend->discount;
                $sales->discount_currency = $amend->discount_currency;
                $sales->equi_type      = $amend->equi_type;
                $sales->leased_type    = $amend->leased_type;
                $sales->receiver_type  = $amend->receiver_type;
                $sales->receiver_price = $amend->receiver_price;
                $sales->receiver_price_currency = $amend->receiver_price_currency;
                $sales->router_type    = $amend->router_type;
                $sales->router_price   = $amend->router_price;
                $sales->router_price_currency   = $amend->router_price_currency;
                $sales->Installation_cost = $amend->Installation_cost;
                $sales->Installation_cost_currency = $amend->Installation_cost_currency;
                $sales->public_ip   = $amend->public_ip;
                $sales->ip_price    = $amend->ip_price;
                $sales->ip_price_currency    = $amend->ip_price_currency;
                $sales->cable_price = $amend->cable_price;
                $sales->cable_price_currency = $amend->cable_price_currency;
                $sales->commission_id = $amend->commission_id;
                $sales->marketer_id = $amend->marketer_id;
                $sales->commission_percent = $amend->commission_percent ? $amend->commission_percent : '0';
                $sales->commission_percent_currency = $amend->commission_percent_currency;
                $sales->additional_charge = $amend->additional_charge;
                $sales->additional_charge_price = $amend->additional_charge_price ? $amend->additional_charge_price : '0';
                $sales->additional_currency = $amend->additional_currency;
                $customer->save();
                $sales->save();
            }

            $amend->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed', 400);
        }

        return response('success', 200);
    }

    // confirm the cancel amendment of customer
    public function confirmCancelAmend(Request $request)
    {

        try {

            DB::beginTransaction();
            $amend = CancelAmend::findorfail($request->id);

            if (Auth::user()->role == 'sales') {

                $amend->sales_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'finance') {

                $amend->finance_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'noc') {

                $amend->noc_confirmation = date('Y/m/d H:i:s');
            }

            $amend->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed', 400);
        }

        return response('success', 200);
    }

    // cancel the amendment
    public function cancelAmendment(Request $request, $id)
    {

        DB::beginTransaction();

        try {

            $amend = Amend::findorfail($id);
            $amend->cancel_status = '1';
            $cu_id = $amend->cu_id;

            // clone the data to cancel amendment
            $cancel = new CancelAmend();
            $cancel->amend_id = $id;
            $cancel->cu_id = $cu_id;
            $cancel->customer_id = $amend->customer_id;
            $cancel->full_name = $amend->full_name;
            $cancel->poc = $amend->poc;
            $cancel->phone1 = $amend->phone1;
            $cancel->phone2 = $amend->phone2;
            $cancel->education = $amend->education;
            $cancel->address = $amend->address;
            $cancel->identity = $amend->identity;
            $cancel->package_id     = $amend->package_id;
            $cancel->package_price = $amend->package_price ? $amend->package_price : '0';
            $cancel->package_price_currency = $amend->package_price_currency;
            $cancel->discount       = $amend->discount;
            $cancel->discount_currency = $amend->discount_currency;
            $cancel->discount_period = $amend->discount_period;
            $cancel->discount_period_currency = $amend->discount_period_currency;
            $cancel->discount_reason = $amend->discount_reason;
            $cancel->equi_type      = $amend->equi_type;
            $cancel->leased_type    = $amend->leased_type;
            $cancel->receiver_type  = $amend->receiver_type;
            $cancel->receiver_price = $amend->receiver_price;
            $cancel->receiver_price_currency = $amend->receiver_price_currency;
            $cancel->router_type    = $amend->router_type;
            $cancel->router_price   = $amend->router_price;
            $cancel->router_price_currency   = $amend->router_price_currency;
            $cancel->Installation_cost = $amend->Installation_cost;
            $cancel->Installation_cost_currency = $amend->Installation_cost_currency;
            $cancel->public_ip   = $amend->public_ip;
            $cancel->ip_price    = $amend->ip_price;
            $cancel->ip_price_currency    = $amend->ip_price_currency;
            $cancel->cable_price = $amend->cable_price;
            $cancel->cable_price_currency = $amend->cable_price_currency;
            $cancel->commission_id = $amend->commission_id;
            $cancel->marketer_id = $amend->marketer_id;
            $cancel->commission_percent = $amend->commission_percent ? $amend->commission_percent : '0';
            $cancel->commission_percent_currency = $amend->commission_percent_currency;
            $cancel->additional_charge = $amend->additional_charge;
            $cancel->additional_charge_price = $amend->additional_charge_price ? $amend->additional_charge_price : '0';
            $cancel->additional_currency = $amend->additional_currency;
            $cancel->cancel_date = $request->cancel_date;
            $cancel->cancel_reason = $request->cancel_reason;
            $cancel->user_id = Auth::user()->id;

            $cancel->save();
            $amend->save();

            // dispatch the event listener...
            $customer = CancelAmend::find($cancel->id);
            event(new cancelAmendmentEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        if (Auth::user()->role == 'finance') {

            return redirect()->route('finance.amedment')->with('success', 'Operation Done!');
        } else if (Auth::user()->role == 'noc') {

            return redirect()->route('noc.amedment')->with('success', 'Operation Done!');
        }
    }


    // cancel the provincial amendment
    public function cancelPrAmendment(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $amend = PrAmend::with(['provincial.provider', 'provincial.marketer'])->findorfail($id);
            $pr_cu_id = $amend->pr_cu_id;
            $amend->cancel_status = '1';

            $cancel = new PrCancelAmend();
            $cancel->customer_id = $amend->customer_id;
            $cancel->commission_id = $amend->commission_id;
            $cancel->marketer_id = $amend->provincial->marketer->id;
            $cancel->commission_percent = $amend->commission_percent;
            $cancel->commission_percent_currency = $amend->commission_percent_currency;
            $cancel->amend_id = $id;
            $cancel->pr_cu_id = $pr_cu_id;
            $cancel->full_name = $amend->full_name;
            $cancel->poc = $amend->poc;
            $cancel->province = $amend->province;
            $cancel->customerProvince = $amend->customerProvince;
            $cancel->address = $amend->address;
            $cancel->package_id = $amend->package_id;
            $cancel->package_price = $amend->package_price;
            $cancel->package_price_currency = $amend->package_price_currency;
            $cancel->public_ip = $amend->public_ip;
            $cancel->ip_price = $amend->ip_price;
            $cancel->ip_price_currency = $amend->ip_price_currency;
            $cancel->service = $amend->service;
            $cancel->provider_id = $amend->provincial->provider->id;
            $cancel->phone1 = $amend->phone1;
            $cancel->phone2 = $amend->phone2;
            $cancel->additional_charge = $amend->additional_charge;
            $cancel->additional_charge_price = $amend->additional_charge_price;
            $cancel->additional_currency = $amend->additional_currency;
            $cancel->cancel_date = $request->cancel_date;
            $cancel->cancel_reason = $request->cancel_reason;
            $cancel->user_id = Auth::user()->id;
            $cancel->save();

            $amend->save();

            // dispatch the event listener...
            $customer = PrCancelAmend::findorfail($cancel->id);
            event(new cancelPrAmendment($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        if (Auth::user()->role == 'finance') {

            return redirect()->route('pr.fin.amends')->with('success', 'Operation Done!');
        } else if (Auth::user()->role == 'noc') {

            return redirect()->route('pr.noc.amendments')->with('success', 'Operation Done!');
        }
    }

    // confirm the cancel operation
    public function prCancelConfirm(Request $request)
    {

        $cancel = PrCancel::findorfail($request->id);

        if (Auth::user()->role == 'sales') {

            $cancel->sales_confirmation = date('Y/m/d H:i:s');
        } else if (Auth::user()->role == 'finance') {

            $cancel->finance_confirmation = date('Y/m/d H:i:s');
        } else if (Auth::user()->role == 'noc') {

            $cancel->noc_confirmation = date('Y/m/d H:i:s');
        }

        $cancel->save();
        return response('success', 200);
    }

    // confirm the suspend customer
    public function prSuspendConfirm(Request $request)
    {
        try {

            $suspend = PrSuspend::findorfail($request->id);

            if (Auth::user()->role == 'sales') {

                $suspend->sales_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'finance') {

                $suspend->finance_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'noc') {

                $suspend->noc_confirmation = date('Y/m/d H:i:s');
                $suspend->status = 'suspend';

                $customer = Provincial::find($suspend->pr_cu_id);
                $customer->suspend_status   = '1';
                $customer->process_status   = '0';
                $customer->active_status    = '0';
                $customer->terminate_status = '0';
                $customer->cancel_status    = '0';
                $customer->save();
            }

            $suspend->save();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed', 400);
        }

        return response('success', 200);
    }

    // confirm the terminate customer
    public function prTerminateConfirm(Request $request)
    {
        $terminate = PrTerminate::findorfail($request->id);

        if (Auth::user()->role == 'sales') {

            $terminate->sales_confirmation = date('Y/m/d H:i:s');
        } else if (Auth::user()->role == 'finance') {

            $terminate->finance_confirmation = date('Y/m/d H:i:s');
        } else if (Auth::user()->role == 'noc') {

            $terminate->noc_confirmation = date('Y/m/d H:i:s');
            $terminate->status = 'terminate';

            $customer = Provincial::find($terminate->pr_cu_id);
            $customer->cancel_status   = '0';
            $customer->suspend_status  = '0';
            $customer->active_status   = '0';
            $customer->process_status   = '0';
            $customer->terminate_status = '1';
            $customer->save();
        }

        $terminate->save();
        return response('success', 200);
    }

    // confirm the cancel amendment of customer
    public function prAmendCancelConfirm(Request $request)
    {
        try {

            DB::beginTransaction();
            $amend = PrCancelAmend::findorfail($request->id);

            if (Auth::user()->role == 'sales') {

                $amend->sales_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'finance') {

                $amend->finance_confirmation = date('Y/m/d H:i:s');
            } else if (Auth::user()->role == 'noc') {

                $amend->noc_confirmation = date('Y/m/d H:i:s');
            }

            $amend->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response('failed', 400);
        }

        return response('success', 200);
    }

    // confirm the amendment of customer
    public function prAmendConfirm(Request $request)
    {
        $amend = PrAmend::with(['provincial.provider', 'provincial.marketer'])->findorfail($request->id);
        $id = $amend->pr_cu_id;

        if (Auth::user()->role == 'sales') {

            $amend->sales_confirmation = date('Y/m/d H:i:s');
        } else if (Auth::user()->role == 'finance') {

            $amend->finance_confirmation = date('Y/m/d H:i:s');
        } else if (Auth::user()->role == 'noc') {

            $amend->noc_confirmation = date('Y/m/d H:i:s');
            $customer = Provincial::findorfail($id);
            $customer->customer_id = $amend->customer_id;
            $customer->user_id = $amend->user_id;
            $customer->commission_id = $amend->commission_id;
            $customer->marketer_id = $amend->provincial->marketer->id;
            $customer->commission_percent = $amend->commission_percent;
            $customer->commission_percent_currency = $amend->commission_percent_currency;
            $customer->full_name = $amend->full_name;
            $customer->poc = $amend->poc;
            $customer->full_name_persian = $amend->full_name_persian ? $amend->full_name_persian : $amend->full_name;
            $customer->poc_persian = $amend->poc_persian ? $amend->poc_persian : $amend->poc;
            $customer->province = $amend->province;
            $customer->customerProvince = $amend->customerProvince;
            $customer->address = $amend->address;
            $customer->package_id = $amend->package_id;
            $customer->package_price = $amend->package_price;
            $customer->package_price_currency = $amend->package_price_currency;
            $customer->installation_cost = $amend->installation_cost;
            $customer->Installation_cost_currency = $amend->Installation_cost_currency;
            $customer->public_ip = $amend->public_ip;
            $customer->ip_price = $amend->ip_price;
            $customer->ip_price_currency = $amend->ip_price_currency;
            $customer->service = $amend->service;
            $customer->provider_id = $amend->provincial->provider->id;
            $customer->phone1 = $amend->phone1;
            $customer->phone2 = $amend->phone2;
            $customer->additional_charge = $amend->additional_charge;
            $customer->additional_charge_price = $amend->additional_charge_price;
            $customer->additional_currency = $amend->additional_currency;
            $customer->save();
        }

        $amend->save();
        return response('success', 200);
    }

    // filter amendment lists
    public function filterAmendment()
    {
        $customers = Amend::latest();
        $attr = request('attr');

        $confirmationColumn = '';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn = 'sales_confirmation';
                $renderedView = 'sales.customers.amendments.filter';
                break;
            case 'finance':
                $confirmationColumn = 'finance_confirmation';
                $renderedView = 'finance.customers.amendments.filter';
                break;
            case 'noc':
                $confirmationColumn = 'noc_confirmation';
                $renderedView = 'noc.customers.amendments.filter';
                break;
            case 'admin':
                $confirmationColumn = 'noc_confirmation';
                $renderedView = 'dashboard.customers.amendments.filter';
        }

        if ($attr == 'accepted') {
            $customers = $customers->whereNotNull($confirmationColumn);
        }

        if ($attr == 'pending') {
            $customers = $customers->whereNull($confirmationColumn);
        }

        $customers = $customers->where('cancel_status', '=', '0')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'amendment', 'read'));
            })->distinct()
            ->paginate(15);

        $total = $customers->total();

        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter cancel amendment lists
    public function filterCancelAmend()
    {
        $customers = CancelAmend::latest();
        $attr = request('attr');

        $confirmationColumn = '';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn = 'sales_confirmation';
                $renderedView = 'sales.customers.amendments.cancels.filter';
                break;
            case 'finance':
                $confirmationColumn = 'finance_confirmation';
                $renderedView = 'finance.customers.amendments.cancels.filter';
                break;
            case 'noc':
                $confirmationColumn = 'noc_confirmation';
                $renderedView = 'noc.customers.amendments.cancels.filter';
                break;
            case 'admin':
                $confirmationColumn = 'noc_confirmation';
                $renderedView = 'dashboard.customers.amendments.cancels.filter';
        }

        if ($attr == 'cancels') {
            $customers = $customers->whereNull($confirmationColumn);
        }

        $customers = $customers->whereHas('customer', function ($query) {
            $query->whereNull('deleted_at')
                ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'cancel-amendment', 'read'));
        })->paginate(15);

        $total = $customers->total();

        return view($renderedView, compact(['customers', 'total']))->render();
    }
    // public function filterCancelAmend()
    // {
    //     $customers = CancelAmend::latest();
    //     $attr = request('attr');

    //     if($attr == 'all'){
    //         $customers = $customers->whereNotNull('cancel_date');
    //     }

    //     if($attr == 'confirmed'){

    //         if(Auth::user()->role == 'admin'){
    //             $customers = $customers->whereNotNull('finance_confirmation')
    //                                    ->whereNotNull('noc_confirmation');
    //         }

    //         if(Auth::user()->role == 'sales'){
    //            $customers = $customers->whereNotNull('sales_confirmation');
    //         }

    //         if(Auth::user()->role == 'noc'){
    //             $customers = $customers->whereNotNull('noc_confirmation');
    //         }

    //         if(Auth::user()->role == 'finance'){
    //             $customers = $customers->whereNotNull('finance_confirmation');
    //         }

    //     }

    //     if($attr == 'not-confirm'){

    //         if(Auth::user()->role == 'sales'){
    //            $customers = $customers->whereNull('sales_confirmation');
    //         }

    //         if(Auth::user()->role == 'noc'){
    //             $customers = $customers->whereNull('noc_confirmation');
    //         }

    //         if(Auth::user()->role == 'admin'){
    //             $customers = $customers->where(function($query){
    //                 $query->whereNull('finance_confirmation')
    //                       ->orWhereNull('noc_confirmation')
    //                       ->orWhereNull('sales_confirmation');
    //             });
    //         }

    //         if(Auth::user()->role == 'finance'){
    //             $customers = $customers->whereNull('finance_confirmation');
    //         }

    //     }

    //     $customers = $customers ->whereHas('customer',function($query){
    //                                 $query->whereNull('deleted_at');
    //                             })->paginate(15);

    //     $total = $customers->total();

    //     if(Auth::user()->role == 'sales'){
    //         return view('sales.customers.amendments.cancels.filter',compact(['customers','total']))->render();
    //     }

    //     if(Auth::user()->role == 'noc'){
    //         return view('noc.customers.amendments.cancels.filter',compact(['customers','total']))->render();
    //     }

    //     if(Auth::user()->role == 'admin'){
    //         return view('dashboard.customers.amendments.cancels.filter',compact(['customers','total']))->render();
    //     }

    //     if(Auth::user()->role == 'finance'){
    //         return view('finance.customers.amendments.cancels.filter',compact(['customers','total']))->render();
    //     }

    // }

    // filter cancel amendment lists
    public function filterPrCancelAmend()
    {
        $customers = PrCancelAmend::latest();
        $attr = request('attr');

        if ($attr == 'cancels') {

            if (Auth::user()->role == 'admin') {
                $customers = $customers->whereNull('noc_confirmation');
            }

            if (Auth::user()->role == 'sales') {
                $customers = $customers->orWhereNull('sales_confirmation')->orWhereNull('noc_confirmation');
            }

            if (Auth::user()->role == 'noc') {
                $customers = $customers->whereNull('noc_confirmation');
            }

            if (Auth::user()->role == 'finance') {
                $customers = $customers->orWhereNull('finance_confirmation')->orWhereNull('noc_confirmation');
            }
        }

        $customers = $customers->whereHas('provincial', function ($query) {
            $query->whereNull('deleted_at')
                ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-cancel-amendment', 'read'));
        })->paginate(15);

        $total = $customers->total();

        if (Auth::user()->role == 'sales') {
            return view('sales.provincial.amendments.cancels.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'noc') {
            return view('noc.provincial.amendments.cancels.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'admin') {
            return view('dashboard.provincial.amendments.cancels.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'finance') {
            return view('finance.provincial.amendments.cancels.filter', compact(['customers', 'total']))->render();
        }
    }

    // filter provincial amendment lists
    public function filterPrAmendment()
    {
        $customers = PrAmend::latest();
        $attr = request('attr');

        if ($attr == 'accepted') {

            $customers = $customers->whereNotNull('noc_confirmation');
        }

        if ($attr == 'pending') {


            if (Auth::user()->role == 'finance') {
                $customers = $customers->whereNull('finance_confirmation');
            } else {
                $customers = $customers->whereNull('noc_confirmation');
            }
        }

        $customers = $customers->where('cancel_status', '=', '0')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at')
                    ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-amendment', 'read'));;
            })->distinct()
            ->paginate(15);

        $total = $customers->total();

        if (Auth::user()->role == 'sales') {
            return view('sales.provincial.amendments.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'noc') {
            return view('noc.provincial.amendments.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'admin') {
            return view('dashboard.provincial.amendments.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'finance') {
            return view('finance.provincial.amendments.filter', compact(['customers', 'total']))->render();
        }
    }

    // filter customers
    public function filterCustomer()
    {
        $customers = Customer::latest();
        $attr = request('attr');
        $user_role = Auth::user()->role;
        $renderedView = '';

        switch ($user_role) {
            case 'sales':
                $renderedView = 'sales.customers.portion.filter';
                break;
            case 'finance':
                $renderedView = 'finance.customers.portion.filter';
                break;
            case 'noc':
                $renderedView = 'noc.customers.portion.filter';
                break;
            case 'admin':
                $renderedView = 'dashboard.customers.portion.filter';
        }


        if ($attr == 'all') {
            if (in_array($user_role, ['sales', 'admin', 'noc'])) {
                $customers = $customers
                    ->WhereIn('active_status', ['0', '1']);;
            }
        }

        if ($attr == 'active') {
            if (in_array($user_role, ['sales', 'admin', 'noc'])) {
                $customers = $customers->where('active_status', '=', '1');
            } else {
                $customers = $customers->where('finance_status', '=', '1');
            }
        }

        if ($attr == 'not-active') {
            if (in_array($user_role, ['sales', 'admin', 'noc'])) {
                $customers = $customers->where('active_status', '=', '0');
            } else {
                $customers = $customers->where('finance_status', '=', '0');
            }
        }

        $customers = $customers
            ->where([
                ['terminate_status', '=', '0'],
                ['suspend_status', '=', '0'],
                ['cancel_status', '=', '0']
            ])
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'customers', 'read'))
            ->paginate(15);

        $total = $customers->total();

        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter provincial customers
    public function filterProvincial()
    {
        $customers = Provincial::latest();
        $attr = request('attr');

        if ($attr == 'all') {

            if (Auth::user()->role != 'finance') {
                $customers = $customers
                    ->WhereIn('active_status', ['0', '1']);
            }
        }

        if ($attr == 'active') {

            if (in_array(Auth::user()->role, ['sales', 'admin', 'noc'])) {
                $customers = $customers->where('active_status', '=', '1');
            } else {
                $customers = $customers->where('finance_status', '=', '1');
            }
        }

        if ($attr == 'not-active') {

            if (in_array(Auth::user()->role, ['sales', 'admin', 'noc'])) {
                $customers = $customers->where('active_status', '=', '0');
            } else {
                $customers = $customers->where('finance_status', '=', '0');
            }
        }

        $customers = $customers
            ->where([
                ['terminate_status', '=', '0'],
                ['suspend_status', '=', '0'],
                ['cancel_status', '=', '0']
            ])
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial', 'read'))
            ->paginate(15);

        $total = $customers->total();

        if (Auth::user()->role == 'sales') {
            return view('sales.provincial.portion.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'noc') {
            return view('noc.provincial.portion.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'admin') {
            return view('dashboard.provincial.portion.filter', compact(['customers', 'total']))->render();
        }

        if (Auth::user()->role == 'finance') {
            return view('finance.provincial.portion.filter', compact(['customers', 'total']))->render();
        }
    }

    // filter provincial terminate customers
    public function filterTerminate()
    {
        $customers = Customer::latest();
        $attr = request('attr');

        $confirmationColumn = 'customers_terminate_info';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn .= '.sales_confirmation';
                $renderedView = 'sales.customers.terminates.filter';
                break;
            case 'finance':
                $confirmationColumn .= '.finance_confirmation';
                $renderedView = 'finance.customers.terminates.filter';
                break;
            case 'noc':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'noc.customers.terminates.filter';
                break;
            case 'admin':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'dashboard.customers.terminates.filter';
        }

        if ($attr == 'terminate') {
            $customers = $customers
                ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereNotNull($confirmationColumn)
                ->select('customers.*', 'customers.customer_id');
        }

        if ($attr == 'pending') {
            $customers = $customers
                ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereNull($confirmationColumn)
                ->select('customers.*', 'customers.customer_id');
        }

        $customers = $customers->whereNull('deleted_at')
            ->whereHas('terminate', function ($query) {
                $query->where('status', '=', 'terminate');
            })
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'terminate', 'read'))
            ->paginate(15);

        $total = $customers->total();
        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter the recontract
    public function filterRecontract()
    {
        $customers = Recontract::latest();
        $attr = request('attr');

        $confirmationColumn = '';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn = 'sales_confirmation';
                $renderedView = 'sales.customers.recontracts.filter';
                break;
            case 'finance':
                $confirmationColumn = 'finance_confirmation';
                $renderedView = 'finance.customers.recontracts.filter';
                break;
            case 'noc':
                $confirmationColumn = 'noc_confirmation';
                $renderedView = 'noc.customers.recontracts.filter';
                break;
            case 'admin':
                $confirmationColumn = '.noc_confirmation';
                $renderedView = 'dashboard.customers.recontracts.filter';
        }

        if ($attr == 'recontract') {
            $customers = $customers->whereNull($confirmationColumn);
        }

        $customers = $customers
            ->whereIn('customers_recontract_info.branch_id', hasSectionPermissionForBranch(Auth::user(), 'recontract', 'read'))
            ->paginate(15);
        $total = $customers->total();

        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter provincial terminate customers
    public function filterPrTerminate()
    {
        $customers = Provincial::latest();
        $attr = request('attr');

        $confirmationColumn = 'pr_terminate_info';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn .= '.sales_confirmation';
                $renderedView = 'sales.provincial.terminates.filter';
                break;
            case 'finance':
                $confirmationColumn .= '.finance_confirmation';
                $renderedView = 'finance.provincial.terminates.filter';
                break;
            case 'noc':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'noc.provincial.terminates.filter';
                break;
            case 'admin':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'dashboard.provincial.terminates.filter';
        }

        if ($attr == 'terminate') {

            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereNotNull($confirmationColumn)
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if ($attr == 'pending') {

            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereNull($confirmationColumn)
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        $customers = $customers->whereNull('deleted_at')
            ->whereHas('terminate', function ($query) {
                $query->where('status', '=', 'terminate');
            })
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-terminate', 'read'))
            ->paginate(15);

        $total = $customers->total();
        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter provincial recontract terminate customers
    public function filterPrRecontract()
    {
        $customers = PrRecontract::latest();
        $attr = request('attr');

        $confirmationColumn = '';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn = 'sales_confirmation';
                $renderedView = 'sales.provincial.recontracts.filter';
                break;
            case 'finance':
                $confirmationColumn = 'finance_confirmation';
                $renderedView = 'finance.provincial.recontracts.filter';
                break;
            case 'noc':
                $confirmationColumn = 'noc_confirmation';
                $renderedView = 'noc.provincial.recontracts.filter';
                break;
            case 'admin':
                $confirmationColumn = '.noc_confirmation';
                $renderedView = 'dashboard.provincial.recontracts.filter';
        }


        if ($attr == 'recontract') {
            $customers = $customers->whereNull($confirmationColumn);
        }

        $customers = $customers
            ->whereIn('pr_recontract_info.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-recontract', 'read'))
            ->paginate(15);
        $total = $customers->total();

        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter suspends customers
    public function filterSuspend()
    {
        $customers = Customer::latest();
        $attr = request('attr');

        $confirmationColumn = 'customers_suspend_info';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn .= '.sales_confirmation';
                $renderedView = 'sales.customers.suspends.filter';
                break;
            case 'finance':
                $confirmationColumn .= '.finance_confirmation';
                $renderedView = 'finance.customers.suspends.filter';
                break;
            case 'noc':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'noc.customers.suspends.filter';
                break;
            case 'admin':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'dashboard.customers.suspends.filter';
        }

        $customers = $customers
            ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
            ->select('customers.*', 'customers.customer_id');

        if ($attr == 'suspends') {
            $customers = $customers->whereNotNull($confirmationColumn);
        }

        if ($attr == 'pendings') {
            $customers = $customers->whereNull($confirmationColumn);
        }


        $customers = $customers->whereNull('deleted_at')
            ->whereHas('suspend', function ($query) {
                $query->where('status', '=', 'suspend');
            })
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'suspend', 'read'))
            ->distinct()
            ->paginate(15);

        $total = $customers->total();


        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter the reactivated customers
    public function filterReactivate()
    {
        $customers = Reactivate::latest();
        $attr = request('attr');

        $firstConfirmationColumn = '';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $firstConfirmationColumn .= 'sales_confirmation';
                $renderedView = 'sales.customers.reactivates.filter';
                break;
            case 'finance':
                $firstConfirmationColumn .= 'finance_confirmation';
                $renderedView = 'finance.customers.reactivates.filter';
                break;
            case 'noc':
                $firstConfirmationColumn .= 'noc_confirmation';
                $renderedView = 'noc.customers.reactivates.filter';
                break;
            case 'admin':
                $firstConfirmationColumn .= 'noc_confirmation';
                $renderedView = 'dashboard.customers.reactivates.filter';
        }

        if ($attr == 'reactivations') {
            $customers = $customers->orWhereNull($firstConfirmationColumn);
        }

        $customers = $customers
            ->whereIn('customers_reactivate_info.branch_id', hasSectionPermissionForBranch(Auth::user(), 'reactivate', 'read'))
            ->paginate(15);
        $total = $customers->total();

        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter provincial suspends customers
    public function filterPrSuspend()
    {
        $customers = Provincial::latest();
        $attr = request('attr');


        $firstConfirmationColumn = 'pr_suspend_info';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $firstConfirmationColumn .= '.sales_confirmation';
                $renderedView = 'sales.provincial.suspends.filter';
                break;
            case 'finance':
                $firstConfirmationColumn .= '.finance_confirmation';
                $renderedView = 'finance.provincial.suspends.filter';
                break;
            case 'noc':
                $firstConfirmationColumn .= '.noc_confirmation';
                $renderedView = 'noc.provincial.suspends.filter';
                break;
            case 'admin':
                $firstConfirmationColumn .= '.noc_confirmation';
                $renderedView = 'dashboard.provincial.suspends.filter';
        }

        $customers = $customers
            ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id');

        if ($attr == 'suspend') {
            $customers = $customers->whereNotNull($firstConfirmationColumn);
        }

        if ($attr == 'pending') {
            $customers = $customers->WhereNull($firstConfirmationColumn);
        }

        $customers->select('pr_customers.*', 'pr_customers.customer_id');

        $customers = $customers->whereNull('deleted_at')
            ->whereHas('suspend', function ($query) {
                $query->where('status', '=', 'suspend');
            })
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-suspend', 'read'))
            ->distinct()
            ->paginate(15);

        $total = $customers->total();

        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter provincial reactivated customers
    public function filterPrReactivate()
    {
        $customers = PrReactivate::latest();
        $attr = request('attr');

        $firstConfirmationColumn = '';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $firstConfirmationColumn .= 'sales_confirmation';
                $renderedView = 'sales.provincial.reactivates.filter';
                break;
            case 'finance':
                $firstConfirmationColumn .= 'finance_confirmation';
                $renderedView = 'finance.provincial.reactivates.filter';
                break;
            case 'noc':
                $firstConfirmationColumn .= 'noc_confirmation';
                $renderedView = 'noc.provincial.reactivates.filter';
                break;
            case 'admin':
                $firstConfirmationColumn .= 'noc_confirmation';
                $renderedView = 'dashboard.provincial.reactivates.filter';
        }

        if ($attr == 'reactivate') {
            $customers = $customers->orWhereNull($firstConfirmationColumn);
        }

        $customers = $customers
            ->whereIn('pr_reactivate_info.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-reactivate', 'read'))
            ->paginate(15);

        $total = $customers->total();

        return view($renderedView, compact(['customers', 'total']))->render();
    }

    // filter cancel customers
    public function filterCancel()
    {
        $cancels = Customer::latest();
        $attr = request('attr');

        $confirmationColumn = 'customers_cancel_info';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn .= '.sales_confirmation';
                $renderedView = 'sales.customers.cancels.filter';
                break;
            case 'finance':
                $confirmationColumn .= '.finance_confirmation';
                $renderedView = 'finance.customers.cancels.filter';
                break;
            case 'noc':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'noc.customers.cancels.filter';
                break;
            case 'admin':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'dashboard.customers.cancels.filter';
        }

        $cancels = $cancels
            ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id');

        if ($attr == 'confirmed') {
            if (Auth::user()->role == 'admin') {
                $cancels = $cancels->where(function ($query) {
                    $query->whereNotNull('customers_cancel_info.finance_confirmation')
                        ->whereNotNull('customers_cancel_info.noc_confirmation')
                        ->whereNotNull('customers_cancel_info.sales_confirmation');
                })->select('customers.*', 'customers.customer_id');
            } else {
                $cancels = $cancels->whereNotNull($confirmationColumn);
            }
        }

        if ($attr == 'not-confirm') {

            if (Auth::user()->role == 'admin') {
                $cancels = $cancels->where(function ($query) {
                    $query->orWhereNull('customers_cancel_info.finance_confirmation')
                        ->orWhereNull('customers_cancel_info.noc_confirmation')
                        ->orWhereNull('customers_cancel_info.sales_confirmation');
                });
            } else {
                $cancels = $cancels->whereNull($confirmationColumn);
            }
        }

        $cancels = $cancels->select('customers.*', 'customers.customer_id');
        $cancels = $cancels->whereNull('deleted_at')
            ->where('cancel_status', '=', '1')
            ->whereHas('cancel')
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'cancel', 'read'))
            ->distinct()
            ->paginate(15);

        $total = $cancels->total();

        return view($renderedView, compact(['cancels', 'total']))->render();
    }

    // filter provincial cancel customers
    public function filterPrCancel()
    {
        $cancels = Provincial::latest();
        $attr = request('attr');

        $confirmationColumn = 'pr_cancel_info';
        $renderedView = '';

        switch (Auth::user()->role) {
            case 'sales':
                $confirmationColumn .= '.sales_confirmation';
                $renderedView = 'sales.provincial.cancels.filter';
                break;
            case 'finance':
                $confirmationColumn .= '.finance_confirmation';
                $renderedView = 'finance.provincial.cancels.filter';
                break;
            case 'noc':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'noc.provincial.cancels.filter';
                break;
            case 'admin':
                $confirmationColumn .= '.noc_confirmation';
                $renderedView = 'dashboard.provincial.cancels.filter';
        }

        $cancels = $cancels->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id');


        if ($attr == 'confirmed') {

            if (Auth::user()->role == 'admin') {
                $cancels = $cancels->whereNotNull('pr_cancel_info.finance_confirmation')
                    ->whereNotNull('pr_cancel_info.noc_confirmation')
                    ->whereNotNull('pr_cancel_info.sales_confirmation');
            } else {
                $cancels = $cancels->whereNotNull($confirmationColumn);
            }
        }

        if ($attr == 'not-confirm') {

            if (Auth::user()->role == 'admin') {
                $cancels = $cancels->where(function ($query) {
                    $query->orWhereNull('pr_cancel_info.finance_confirmation')
                        ->orWhereNull('pr_cancel_info.noc_confirmation')
                        ->orWhereNull('pr_cancel_info.sales_confirmation');
                });
            } else {

                $cancels = $cancels->whereNull($confirmationColumn);
            }
        }

        $cancels = $cancels->select('pr_customers.*', 'pr_customers.customer_id');
        $cancels = $cancels->whereNull('deleted_at')
            ->where('cancel_status', '=', '1')
            ->whereHas('prCancel')
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-cancel', 'read'))
            ->distinct()
            ->paginate(15);

        $total = $cancels->total();

        return view($renderedView, compact(['cancels', 'total']))->render();
    }

    public function branches()
    {
        $province = Province::where('name', 'like', '%' . request('province') . '%')->pluck('id')->first();
        $branches = Branch::where('province_id', '=', $province)->get();



        if (count($branches) > 0) {

            $output = '<option value="">Select Branch</option>';
            foreach ($branches as $branch) {
                $output .= '<option value="' . $branch->id . '">' . $branch->name . '</option>';
            }
            return $output;
        } else {

            $output = '<option value="">Select Branch</option>';
            return $output .= '<option value="">Not Found</option>';
        }
    }
}
