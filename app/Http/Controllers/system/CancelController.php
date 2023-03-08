<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cancel;
use App\Events\CancelEvent;
use App\Models\Customer;
// use \Exception;
use DB;
use Auth;

class CancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Cancel::class);
        $cancels = Customer::with(['cancel' => function ($q) {
            $q->orderBy('id', 'desc');
        }]);
        if (request('id')) {
            $cancels = $cancels->where('customer_id', '=', request('id'));
        }

        if (request('name')) {
            $cancels = $cancels->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('cancel_date') && !request('endDate')) {
            $cancels = $cancels
                ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->whereDate('customers_cancel_info.cancel_date', '=', request('cancel_date'))
                ->whereNull('customers_cancel_info.rollback_date')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('cancel_date') && request('endDate')) {
            $cancels = $cancels
                ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->whereDate('customers_cancel_info.cancel_date', '>=', request('cancel_date'))
                ->whereDate('customers_cancel_info.cancel_date', '<=', request('endDate'))
                ->whereNull('customers_cancel_info.rollback_date')
                ->select('customers.*', 'customers.customer_id');
        }

        if (request('sales')) {

            if (request('sales') == 'true') {
                $cancels = $cancels
                    ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                    ->whereNotNull('customers_cancel_info.sales_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }

            if (request('sales') == 'false') {
                $cancels = $cancels
                    ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                    ->whereNull('customers_cancel_info.sales_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }
        }

        if (request('finance')) {

            if (request('finance') == 'true') {
                $cancels = $cancels
                    ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                    ->whereNotNull('customers_cancel_info.finance_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }

            if (request('finance') == 'false') {
                $cancels = $cancels
                    ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                    ->whereNull('customers_cancel_info.finance_confirmation')
                    ->select('customers.*', 'customers.customer_id');
            }
        }

        $cancels = $cancels->where('cancel_status', '=', '1')
            ->where('terminate_status', '=', '0')
            ->where('suspend_status', '=', '0')
            ->whereNull('deleted_at')
            ->whereHas('cancel')
            ->whereIn('customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'cancel', 'read'))
            ->paginate('15');

        if (Auth::user()->role == 'sales') {

            return view('sales.customers.cancels.index', compact('cancels'));
        } else if (Auth::user()->role == 'noc') {

            return view('noc.customers.cancels.index', compact('cancels'));
        } else if (Auth::user()->role == 'admin') {

            return view('dashboard.customers.cancels.index', compact('cancels'));
        } else if (Auth::user()->role == 'finance') {

            return view('finance.customers.cancels.index', compact('cancels'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Cancel::class);
        try {
            DB::beginTransaction();

            $request->validate([
                'cancel_date' => 'required',
                'cancel_reason' => 'required',
            ], [
                'cancel_date.required' => 'Cancel Date is required',
                'cancel_reason.required' => 'Cancel Reason is required',
            ]);

            $customer = Customer::find($request->customer_id);
            $customer->cancel_status = '1';
            $customer->noc_status = '0';
            $customer->save();

            $cancel = new Cancel();
            $cancel->cu_id = $customer->id;
            $cancel->customer_id = $customer->customer_id;
            $cancel->full_name = $customer->full_name;
            $cancel->poc = $customer->poc;
            $cancel->phone1 = $customer->phone1;
            $cancel->phone2 = $customer->phone2;
            $cancel->education = $customer->education;
            $cancel->identity = $customer->identity_num;
            $cancel->address = $customer->address;
            $cancel->package_id = $customer->sale->package_id;
            $cancel->package_price = $customer->sale->package_price;
            $cancel->package_price_currency = $customer->sale->package_price_currency;
            $cancel->commission_id = $customer->sale->commission_id;
            $cancel->marketer_id = $customer->sale->marketer_id;
            $cancel->commission_percent = $customer->sale->commission_percent
                ? $customer->sale->commission_percent : '0';
            $cancel->commission_percent_currency = $customer->sale->commission_percent_currency;
            $cancel->discount = $customer->sale->discount;
            $cancel->discount_currency = $customer->sale->discount_currency;
            $cancel->discount_period = $customer->sale->discount_period;
            $cancel->discount_period_currency = $customer->sale->discount_period_currency;
            $cancel->discount_reason = $customer->sale->discount_reason;
            $cancel->equi_type = $customer->sale->equi_type;
            $cancel->leased_type = $customer->sale->leased_type;
            $cancel->receiver_type = $customer->sale->receiver_type;
            $cancel->receiver_price = $customer->sale->receiver_price;
            $cancel->receiver_price_currency = $customer->sale->receiver_price_currency;
            $cancel->router_type = $customer->sale->router_type;
            $cancel->router_price = $customer->sale->router_price;
            $cancel->router_price_currency = $customer->sale->router_price_currency;
            $cancel->cable_price = $customer->cable_price;
            $cancel->cable_price_currency = $customer->cable_price_currency;
            $cancel->Installation_cost = $customer->Installation_cost;
            $cancel->Installation_cost_currency = $customer->Installation_cost_currency;
            $cancel->public_ip = $customer->public_ip;
            $cancel->ip_price = $customer->ip_price;
            $cancel->ip_price_currency = $customer->ip_price_currency;
            $cancel->additional_charge = $customer->additional_charge;
            $cancel->additional_charge_price = $customer->additional_charge_price ? $request->additional_charge_price : '0';
            $cancel->additional_currency = $customer->additional_currency;
            $cancel->user_id        = Auth::user()->id;
            $cancel->cancel_date = $request->cancel_date;
            $cancel->cancel_reason = $request->cancel_reason;
            $cancel->noc_confirmation = date('Y/m/d H:i:s');
            $cancel->save();

            // Dispatch event when cancel the customer process
            event(new CancelEvent($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->back()->with('success', 'Operation Done.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Cancel::class);
        $customer = Customer::find($id);

        if (Auth::user()->role == 'sales') {

            return view('sales.customers.cancels.show', compact('customer'));
        } else if (Auth::user()->role == 'noc') {

            return view('noc.customers.cancels.show', compact('customer'));
        } else if (Auth::user()->role == 'admin') {

            return view('dashboard.customers.cancels.show', compact('customer'));
        } else if (Auth::user()->role == 'finance') {

            return view('finance.customers.cancels.show', compact('customer'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->authorize('update', Cancel::class);
        try {
            DB::beginTransaction();

            $request->validate([
                'rollback_date' => 'required',
            ], [
                'rollback_date.required' => 'Rollback Date is required'
            ]);

            $cancel = Cancel::find($id);

            if (empty($cancel->finance_confirmation)) {

                return redirect()->back()->with('error', 'Please wait for confirmation.');
            }

            if (empty($cancel->sales_confirmation)) {

                return redirect()->back()->with('error', 'Please wait for confirmation.');
            }

            $cancel->rollback_date = $request->rollback_date;
            $cancel->user_id = Auth::user()->id;
            $cancel->save();

            $customer = Customer::find($request->customer_id);
            $customer->noc_status = '1';
            $customer->cancel_status = '0';
            $customer->save();

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
}
