<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrCancel;
use App\Models\Provincial;
use App\Models\Province;
use App\Events\prSalesCancel;
use App\Events\prNocCancel;
use \Exception;
use DB;
use Auth;

class ProvinceCancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', PrCancel::class);
        $cancels = Provincial::latest('pr_customers.created_at');

        if (request('name')) {
            $cancels = $cancels->where('full_name', 'like', '%' . request('name') . '%');
        }

        if (request('id')) {
            $cancels = $cancels->where('customer_id', '=', request('id'));
        }

        if (request('province')) {
            $cancels = $cancels->where('province', '=', request('province'));
        }

        if (request('date')) {
            $cancels = $cancels
                ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->whereDate('pr_cancel_info.cancel_date', '=', request('date'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if ((request('start') && request('end')) && !request('date')) {
            $cancels = $cancels
                ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->whereDate('pr_cancel_info.cancel_date', '>=', request('start'))
                ->whereDate('pr_cancel_info.cancel_date', '<=', request('end'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->select('pr_customers.*', 'pr_customers.customer_id');
        }

        if (request('sales')) {

            if (request('sales') == 'true') {
                $cancels = $cancels
                    ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                    ->whereNotNull('pr_cancel_info.sales_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }

            if (request('sales') == 'false') {
                $cancels = $cancels
                    ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                    ->whereNull('pr_cancel_info.sales_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }
        }

        if (request('finance')) {

            if (request('finance') == 'true') {
                $cancels = $cancels
                    ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                    ->whereNotNull('pr_cancel_info.finance_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }

            if (request('finance') == 'false') {
                $cancels = $cancels
                    ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                    ->whereNull('pr_cancel_info.finance_confirmation')
                    ->select('pr_customers.*', 'pr_customers.customer_id');
            }
        }

        $provinces = Province::all();
        $cancels = $cancels->where('cancel_status', '=', '1')
            ->where('terminate_status', '=', '0')
            ->where('suspend_status', '=', '0')
            ->whereNull('deleted_at')
            ->whereHas('prCancel')
            ->whereIn('pr_customers.branch_id', hasSectionPermissionForBranch(Auth::user(), 'provincial-cancel', 'read'))
            ->paginate('15');

        if (Auth::user()->role == 'sales') {
            return view('sales.provincial.cancels.index', compact('cancels', 'provinces'));
        } else if (Auth::user()->role == 'noc') {
            return view('noc.provincial.cancels.index', compact('cancels', 'provinces'));
        } else if (Auth::user()->role == 'admin') {
            return view('dashboard.provincial.cancels.index', compact('cancels', 'provinces'));
        } else if (Auth::user()->role == 'finance') {
            return view('finance.provincial.cancels.index', compact('cancels', 'provinces'));
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
        try {
            DB::beginTransaction();

            $request->validate([
                'cancel_date' => 'required',
                'cancel_reason' => 'required',
            ], [
                'cancel_date.required' => 'Cancel Date is required',
                'cancel_reason.required' => 'Cancel Reason is required',
            ]);

            $customer = Provincial::find($request->customer_id);
            $customer->cancel_status = '1';
            $customer->save();

            $cancel = new PrCancel();
            $cancel->cancel_date = $request->cancel_date;
            $cancel->cancel_reason = $request->cancel_reason;
            $cancel->user_id = Auth::user()->id;
            $cancel->noc_confirmation = date('Y/m/d H:i:s');
            $cancel->pr_cu_id    = $request->customer_id;
            $cancel->customer_id    = $customer->customer_id;
            $cancel->full_name = $customer->full_name;
            $cancel->poc = $customer->poc;
            $cancel->phone1 = $customer->phone1;
            $cancel->phone2 = $customer->phone2;
            $cancel->province = $customer->province;
            $cancel->customerProvince = $customer->customerProvince;
            $cancel->address = $customer->address;
            $cancel->package_id = $customer->package_id;
            $cancel->package_price = $customer->package_price;
            $cancel->package_price_currency = $customer->package_price_currency;
            $cancel->service = $customer->service;
            $cancel->provider = $customer->provider;
            $cancel->installation_date = $customer->installation_date;
            $cancel->installation_cost = $customer->installation_cost;
            $cancel->Installation_cost_currency = $customer->Installation_cost_currency;
            $cancel->public_ip = $customer->public_ip;
            $cancel->ip_price = $customer->ip_price;
            $cancel->ip_price_currency = $customer->ip_price_currency;
            $cancel->commission_id = $customer->commission_id;
            $cancel->marketer_id = $customer->marketer_id;
            $cancel->commission_percent = $customer->commission_percent;
            $cancel->commission_percent_currency = $customer->commission_percent_currency;
            $cancel->save();

            // Dispatch notification when installation canceled.
            event(new prNocCancel($customer));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Operation Faild!');
        }

        return redirect()->route('prCancels.index')->with('success', 'Operation Done.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', PrCancel::class);
        $customer = Provincial::find($id);

        if (Auth::user()->role == 'sales') {
            return view('sales.provincial.cancels.show', compact('customer'));
        } else if (Auth::user()->role == 'noc') {
            return view('noc.provincial.cancels.show', compact('customer'));
        } else if (Auth::user()->role == 'admin') {
            return view('dashboard.provincial.cancels.show', compact('customer'));
        } else if (Auth::user()->role == 'finance') {
            return view('finance.provincial.cancels.show', compact('customer'));
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
        try {
            DB::beginTransaction();

            $request->validate([
                'rollback_date' => 'required',
            ], [
                'rollback_date.required' => 'Rollback Date is required'
            ]);

            $cancel = PrCancel::find($id);

            if (empty($cancel->sales_confirmation) && empty($cancel->finance_confirmation)) {

                return redirect()->back()->with('error', 'Please wait for confirmation.');
            } else {
                $cancel->rollback_date = $request->rollback_date;
                $cancel->user_id = Auth::user()->id;
                $cancel->save();

                $customer = Provincial::find($request->customer_id);
                $customer->cancel_status = '0';
                $customer->process_status = '1';
                $customer->save();
            }


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
