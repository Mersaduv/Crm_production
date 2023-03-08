<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CancelAmend;
use App\Models\Terminate;
use App\Models\Suspend;
use App\Models\Amend;
use App\Models\Cancel;
use DB;

class ChartController extends Controller
{
    public function customers()
    {

        // Total Customers

        $customers = Customer::whereNull('deleted_at',)->latest('customers.id');
        $months = Customer::whereNull('deleted_at',)->latest('customers.id');

        if (request('insStart') && request('insEnd')) {

            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->WhereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->WhereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->groupBy(DB::raw("Month(installation_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $months = $months
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->WhereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->WhereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->groupBy(DB::raw("Month(installation_date)"))
                ->select(DB::raw("Month(installation_date) as month"))
                ->pluck('month');
        } else {

            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereYear('customers_sales_info.installation_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(installation_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $months = $months
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereYear('customers_sales_info.installation_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(installation_date)"))
                ->select(DB::raw("Month(installation_date) as month"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        // Activation Data

        if (request('actStart') && request('actEnd')) {

            $activation = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->WhereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->WhereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->groupBy(DB::raw("Month(activation_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $activationMonths = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->WhereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->WhereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->groupBy(DB::raw("Month(activation_date)"))
                ->select(DB::raw("Month(activation_date) as month"))
                ->pluck('month');
        } else {

            $activation = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereYear('customers_noc_info.activation_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(activation_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $activationMonths = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereYear('customers_noc_info.activation_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(activation_date)"))
                ->select(DB::raw("Month(activation_date) as month"))
                ->pluck('month');
        }

        $activationDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($activationMonths as $index => $month) {
            $activationDatas[$month - 1] = $activation[$index];
        }

        // Cancel Data

        if (request('cancelStart') && request('cancelEnd')) {

            $cancel = Customer::join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->WhereDate('customers_cancel_info.cancel_date', '>=', request('cancelStart'))
                ->WhereDate('customers_cancel_info.cancel_date', '<=', request('cancelEnd'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $cancelMonths = Customer::join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->WhereDate('customers_cancel_info.cancel_date', '>=', request('cancelStart'))
                ->WhereDate('customers_cancel_info.cancel_date', '<=', request('cancelEnd'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->select(DB::raw("Month(cancel_date) as month"))
                ->pluck('month');
        } else {

            $cancel = Customer::join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->whereYear('customers_cancel_info.cancel_date', '=', date('Y'))
                ->whereNull('customers_cancel_info.rollback_date')
                ->whereNotNull('customers_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $cancelMonths = Customer::join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->whereYear('customers_cancel_info.cancel_date', '=', date('Y'))
                ->whereNull('customers_cancel_info.rollback_date')
                ->whereNotNull('customers_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->select(DB::raw("Month(cancel_date) as month"))
                ->pluck('month');
        }

        $cancelDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($cancelMonths as $index => $month) {
            $cancelDatas[$month - 1] = $cancel[$index];
        }

        // Suspend Data

        if (request('susStart') && request('susEnd')) {

            $suspend = Customer::join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->WhereDate('customers_suspend_info.suspend_date', '>=', request('susStart'))
                ->WhereDate('customers_suspend_info.suspend_date', '<=', request('susEnd'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $suspendMonths = Customer::join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->WhereDate('customers_suspend_info.suspend_date', '>=', request('susStart'))
                ->WhereDate('customers_suspend_info.suspend_date', '<=', request('susEnd'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->select(DB::raw("Month(suspend_date) as month"))
                ->pluck('month');
        } else {

            $suspend = Customer::join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->whereYear('customers_suspend_info.suspend_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $suspendMonths = Customer::join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->whereYear('customers_suspend_info.suspend_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->select(DB::raw("Month(suspend_date) as month"))
                ->pluck('month');
        }

        $suspendDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($suspendMonths as $index => $month) {
            $suspendDatas[$month - 1] = $suspend[$index];
        }

        // Terminate Data

        if (request('terStart') && request('terEnd')) {

            $terminates = Customer::join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->WhereDate('customers_terminate_info.termination_date', '>=', request('terStart'))
                ->WhereDate('customers_terminate_info.termination_date', '<=', request('terEnd'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(termination_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $terminatesMonths = Customer::join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->WhereDate('customers_terminate_info.termination_date', '>=', request('terStart'))
                ->WhereDate('customers_terminate_info.termination_date', '<=', request('terEnd'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(termination_date)"))
                ->select(DB::raw("Month(termination_date) as month"))
                ->pluck('month');
        } else {

            $terminates = Customer::join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereYear('customers_terminate_info.termination_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(termination_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $terminatesMonths = Customer::join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereYear('customers_terminate_info.termination_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(termination_date)"))
                ->select(DB::raw("Month(termination_date) as month"))
                ->pluck('month');
        }

        $terminatesDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($terminatesMonths as $index => $month) {
            $terminatesDatas[$month - 1] = $terminates[$index];
        }

        // Amendment Data

        if (request('amendStart') && request('amendEnd')) {

            $amendments = Customer::join('customer_amend_info', 'customers.id', '=', 'customer_amend_info.cu_id')
                ->WhereDate('customer_amend_info.amend_date', '>=', request('amendStart'))
                ->WhereDate('customer_amend_info.amend_date', '<=', request('amendEnd'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $amendmentsMonths = Customer::join('customer_amend_info', 'customers.id', '=', 'customer_amend_info.cu_id')
                ->WhereDate('customer_amend_info.amend_date', '>=', request('amendStart'))
                ->WhereDate('customer_amend_info.amend_date', '<=', request('amendEnd'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->select(DB::raw("Month(amend_date) as month"))
                ->pluck('month');
        } else {

            $amendments = Customer::join('customer_amend_info', 'customers.id', '=', 'customer_amend_info.cu_id')
                ->whereYear('customer_amend_info.amend_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(amend_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $amendmentsMonths = Customer::join('customer_amend_info', 'customers.id', '=', 'customer_amend_info.cu_id')
                ->whereYear('customer_amend_info.amend_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(amend_date)"))
                ->select(DB::raw("Month(amend_date) as month"))
                ->pluck('month');
        }

        $amendmentsDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($amendmentsMonths as $index => $month) {
            $amendmentsDatas[$month - 1] = $amendments[$index];
        }

        // Cancel Amendment Data
        if (request('cancelAmend') && request('cancelAmendEnd')) {

            $cancelAmendments = Customer::join('customers_amend_cancel', 'customers.id', '=', 'customers_amend_cancel.cu_id')
                ->WhereDate('customers_amend_cancel.cancel_date', '>=', request('cancelAmend'))
                ->WhereDate('customers_amend_cancel.cancel_date', '<=', request('cancelAmendEnd'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $cancelAmendmentsMonths = Customer::join('customers_amend_cancel', 'customers.id', '=', 'customers_amend_cancel.cu_id')
                ->WhereDate('customers_amend_cancel.cancel_date', '>=', request('cancelAmend'))
                ->WhereDate('customers_amend_cancel.cancel_date', '<=', request('cancelAmendEnd'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->select(DB::raw("Month(cancel_date) as month"))
                ->pluck('month');
        } else {

            $cancelAmendments = Customer::join('customers_amend_cancel', 'customers.id', '=', 'customers_amend_cancel.cu_id')
                ->whereYear('customers_amend_cancel.cancel_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $cancelAmendmentsMonths = Customer::join('customers_amend_cancel', 'customers.id', '=', 'customers_amend_cancel.cu_id')
                ->whereYear('customers_amend_cancel.cancel_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->select(DB::raw("Month(cancel_date) as month"))
                ->pluck('month');
        }

        $cancelAmendmentsDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($cancelAmendmentsMonths as $index => $month) {
            $cancelAmendmentsDatas[$month - 1] = $cancelAmendments[$index];
        }

        return view('dashboard.charts.customers', compact(['datas', 'activationDatas', 'cancelDatas', 'amendmentsDatas', 'suspendDatas', 'terminatesDatas', 'cancelAmendmentsDatas']));
    }

    // activated customers charts
    public function activated()
    {

        if (request('insStart') && request('insEnd')) {

            $customers = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->where('customers.active_status', '=', '1')
                ->groupBy(DB::raw("Month(customers_sales_info.installation_date)"))
                ->pluck('count');

            $months = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->select(DB::raw("Month(customers_sales_info.installation_date) as month"))
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->where('customers.active_status', '=', '1')
                ->groupBy(DB::raw("Month(customers_sales_info.installation_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->where('customers.active_status', '=', '1')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('count');

            $months    = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("Month(customers_noc_info.activation_date) as month"))
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->where('customers.active_status', '=', '1')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('month');
        } else {

            $customers = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereYear('customers_noc_info.activation_date', date('Y'))
                ->where('customers.active_status', '=', '1')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('count');

            $months = Customer::join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("Month(customers_noc_info.activation_date) as month"))
                ->whereYear('customers_noc_info.activation_date', date('Y'))
                ->where('customers.active_status', '=', '1')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.charts.activated', compact('datas'));
    }

    // termiantes customers charts
    public function terminates()
    {
        if (request('terStart') && request('terEnd')) {

            $customers = Terminate::select(DB::raw("count(*) as count"))
                ->WhereDate('termination_date', '>=', request('terStart'))
                ->WhereDate('termination_date', '<=', request('terEnd'))
                ->whereNotNull('noc_confirmation')
                ->where('status', '=', 'terminate')
                ->groupBy(DB::raw("Month(termination_date)"))
                ->pluck('count');

            $months = Terminate::select(DB::raw("Month(termination_date) as month"))
                ->WhereDate('termination_date', '>=', request('terStart'))
                ->WhereDate('termination_date', '<=', request('terEnd'))
                ->whereNotNull('noc_confirmation')
                ->where('status', '=', 'terminate')
                ->groupBy(DB::raw("Month(termination_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = Terminate::join('customers_noc_info', 'customers_terminate_info.cu_id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->where('customers_terminate_info.status', '=', 'terminate')
                ->whereNotNull('customers_terminate_info.noc_confirmation')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('count');

            $months    = Terminate::join('customers_noc_info', 'customers_terminate_info.cu_id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("Month(customers_noc_info.activation_date) as month"))
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->where('customers_terminate_info.status', '=', 'terminate')
                ->whereNotNull('customers_terminate_info.noc_confirmation')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('month');
        } else {

            $customers = Terminate::select(DB::raw("count(*) as count"))
                ->whereYear('termination_date', date('Y'))
                ->where('status', '=', 'terminate')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(termination_date)"))
                ->pluck('count');

            $months = Terminate::select(DB::raw("Month(termination_date) as month"))
                ->whereYear('termination_date', date('Y'))
                ->where('status', '=', 'terminate')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(termination_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.charts.terminates', compact('datas'));
    }

    // recontract customers charts
    public function recontract()
    {
        if (request('terStart') && request('terEnd')) {

            $customers = Terminate::select(DB::raw("count(*) as count"))
                ->WhereDate('termination_date', '>=', request('terStart'))
                ->WhereDate('termination_date', '<=', request('terEnd'))
                ->whereNotNull('recontract_date')
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(termination_date)"))
                ->pluck('count');

            $months = Terminate::select(DB::raw("Month(termination_date) as month"))
                ->WhereDate('termination_date', '>=', request('terStart'))
                ->WhereDate('termination_date', '<=', request('terEnd'))
                ->whereNotNull('recontract_date')
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(termination_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = Terminate::select(DB::raw("count(*) as count"))
                ->WhereDate('recontract_date', '>=', request('actStart'))
                ->WhereDate('recontract_date', '<=', request('actEnd'))
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(recontract_date)"))
                ->pluck('count');

            $months = Terminate::select(DB::raw("Month(recontract_date) as month"))
                ->WhereDate('recontract_date', '>=', request('actStart'))
                ->WhereDate('recontract_date', '<=', request('actEnd'))
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(recontract_date)"))
                ->pluck('month');
        } else {

            $customers = Terminate::select(DB::raw("count(*) as count"))
                ->whereYear('recontract_date', '=', date('Y'))
                ->whereNotNull('recontract_date')
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(recontract_date)"))
                ->pluck('count');

            $months = Terminate::select(DB::raw("Month(recontract_date) as month"))
                ->whereYear('recontract_date', '=', date('Y'))
                ->whereNotNull('recontract_date')
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(recontract_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.charts.recontract', compact('datas'));
    }

    // suspends customers charts
    public function suspends()
    {
        if (request('susStart') && request('susEnd')) {


            $customers = Suspend::select(DB::raw("count(*) as count"))
                ->WhereDate('suspend_date', '>=', request('susStart'))
                ->WhereDate('suspend_date', '<=', request('susEnd'))
                ->where('status', '=', 'suspend')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('count');

            $months = Suspend::select(DB::raw("Month(suspend_date) as month"))
                ->WhereDate('suspend_date', '>=', request('susStart'))
                ->WhereDate('suspend_date', '<=', request('susEnd'))
                ->where('status', '=', 'suspend')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = Suspend::join('customers_noc_info', 'customers_suspend_info.cu_id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->where('customers_suspend_info.status', '=', 'suspend')
                ->whereNotNull('customers_suspend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('count');

            $months    = Suspend::join('customers_noc_info', 'customers_suspend_info.cu_id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("Month(customers_noc_info.activation_date) as month"))
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->where('customers_suspend_info.status', '=', 'suspend')
                ->whereNotNull('customers_suspend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('month');
        } else {

            $customers = Suspend::select(DB::raw("count(*) as count"))
                ->whereYear('suspend_date', date('Y'))
                ->where('status', '=', 'suspend')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('count');

            $months = Suspend::select(DB::raw("Month(suspend_date) as month"))
                ->whereYear('suspend_date', date('Y'))
                ->where('status', '=', 'suspend')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.charts.suspends', compact('datas'));
    }

    // reactivate customers charts
    public function reactivate()
    {
        if (request('susStart') && request('susEnd')) {


            $customers = Suspend::select(DB::raw("count(*) as count"))
                ->WhereDate('suspend_date', '>=', request('susStart'))
                ->WhereDate('suspend_date', '<=', request('susEnd'))
                ->whereNotNull('reactivation_date')
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('count');

            $months = Suspend::select(DB::raw("Month(suspend_date) as month"))
                ->WhereDate('suspend_date', '>=', request('susStart'))
                ->WhereDate('suspend_date', '<=', request('susEnd'))
                ->whereNotNull('reactivation_date')
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = Suspend::select(DB::raw("count(*) as count"))
                ->whereDate('reactivation_date', '>=', request('actStart'))
                ->whereDate('reactivation_date', '<=', request('actEnd'))
                ->whereNotNull('reactivation_date')
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(reactivation_date)"))
                ->pluck('count');

            $months    = Suspend::select(DB::raw("Month(reactivation_date) as month"))
                ->whereDate('reactivation_date', '>=', request('actStart'))
                ->whereDate('reactivation_date', '<=', request('actEnd'))
                ->whereNotNull('reactivation_date')
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(reactivation_date)"))
                ->pluck('month');
        } else {

            $customers = Suspend::select(DB::raw("count(*) as count"))
                ->whereYear('reactivation_date', date('Y'))
                ->whereNotNull('reactivation_date')
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(reactivation_date)"))
                ->pluck('count');

            $months = Suspend::select(DB::raw("Month(reactivation_date) as month"))
                ->whereYear('reactivation_date', date('Y'))
                ->whereNotNull('reactivation_date')
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(reactivation_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.charts.reactivate', compact('datas'));
    }

    // amendments customers charts
    public function amendments()
    {
        if (request('amendStart') && request('amendEnd')) {

            $customers = Amend::select(DB::raw("count(*) as count"))
                ->whereDate('amend_date', '>=', request('amendStart'))
                ->whereDate('amend_date', '<=', request('amendEnd'))
                ->where('cancel_status', '=', '0')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->pluck('count');

            $months = Amend::select(DB::raw("Month(amend_date) as month"))
                ->whereDate('amend_date', '>=', request('amendStart'))
                ->whereDate('amend_date', '<=', request('amendEnd'))
                ->where('cancel_status', '=', '0')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = Amend::join('customers_noc_info', 'customer_amend_info.cu_id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->where('customer_amend_info.cancel_status', '=', '0')
                ->whereNotNull('customer_amend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('count');

            $months    = Amend::join('customers_noc_info', 'customer_amend_info.cu_id', '=', 'customers_noc_info.customer_id')
                ->select(DB::raw("Month(customers_noc_info.activation_date) as month"))
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->where('customer_amend_info.cancel_status', '=', '0')
                ->whereNotNull('customer_amend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(customers_noc_info.activation_date)"))
                ->pluck('month');
        } else {

            $customers = Amend::select(DB::raw("count(*) as count"))
                ->whereYear('amend_date', date('Y'))
                ->where('cancel_status', '=', '0')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->pluck('count');

            $months = Amend::select(DB::raw("Month(amend_date) as month"))
                ->whereYear('amend_date', date('Y'))
                ->where('cancel_status', '=', '0')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.charts.amendments', compact('datas'));
    }

    // return the cancel amendments charts data
    public function cancelAmendments()
    {
        if (request('cancel_date') && request('cancel_end')) {

            $customers = CancelAmend::select(DB::raw("count(*) as count"))
                ->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('count');

            $months = CancelAmend::select(DB::raw("Month(cancel_date) as month"))
                ->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('month');
        } else if (request('amendStart') && request('amendEnd')) {

            $customers = CancelAmend::join('customer_amend_info', 'customer_amend_info.id', '=', 'customers_amend_cancel.amend_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('customer_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('customer_amend_info.amend_date', '<=', request('amendEnd'))
                ->where('customer_amend_info.cancel_status', '=', '1')
                ->whereNotNull('customers_amend_cancel.noc_confirmation')
                ->groupBy(DB::raw("Month(customer_amend_info.amend_date)"))
                ->pluck('count');

            $months    = CancelAmend::join('customer_amend_info', 'customer_amend_info.id', '=', 'customers_amend_cancel.amend_id')
                ->select(DB::raw("Month(customer_amend_info.amend_date) as month"))
                ->whereDate('customer_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('customer_amend_info.amend_date', '<=', request('amendEnd'))
                ->where('customer_amend_info.cancel_status', '=', '1')
                ->whereNotNull('customers_amend_cancel.noc_confirmation')
                ->groupBy(DB::raw("Month(customer_amend_info.amend_date)"))
                ->pluck('month');
        } else {

            $customers = CancelAmend::select(DB::raw("count(*) as count"))
                ->whereYear('cancel_date', date('Y'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('count');

            $months = CancelAmend::select(DB::raw("Month(cancel_date) as month"))
                ->whereYear('cancel_date', date('Y'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.charts.cancelAmendments', compact('datas'));
    }

    // cancels customers charts
    public function cancels()
    {
        if (request('cancelStart') && request('cancelEnd')) {

            $customers = Cancel::select(DB::raw("count(*) as count"))
                ->whereDate('cancel_date', '>=', request('cancelStart'))
                ->whereDate('cancel_date', '<=', request('cancelEnd'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('count');

            $months = Cancel::select(DB::raw("Month(cancel_date) as month"))
                ->whereDate('cancel_date', '>=', request('cancelStart'))
                ->whereDate('cancel_date', '<=', request('cancelEnd'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('month');
        } else if (request('insStart') && request('insEnd')) {

            $customers = Cancel::join('customers_sales_info', 'customers_cancel_info.cu_id', '=', 'customers_sales_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->whereNull('customers_cancel_info.rollback_date')
                ->whereNotNull('customers_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(customers_sales_info.installation_date)"))
                ->pluck('count');

            $months = Cancel::join('customers_sales_info', 'customers_cancel_info.cu_id', '=', 'customers_sales_info.customer_id')
                ->select(DB::raw("Month(customers_sales_info.installation_date) as month"))
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->whereNull('customers_cancel_info.rollback_date')
                ->whereNotNull('customers_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(customers_sales_info.installation_date)"))
                ->pluck('month');
        } else {

            $customers = Cancel::select(DB::raw("count(*) as count"))
                ->whereYear('cancel_date', date('Y'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('count');

            $months = Cancel::select(DB::raw("Month(cancel_date) as month"))
                ->whereYear('cancel_date', date('Y'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }
        return view('dashboard.charts.cancels', compact('datas'));
    }

    // returning the device types reports statistics
    public function device()
    {

        if (request('device') == 'router') {
            $devices = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->select("customers_sales_info.router_type as device")
                ->groupBy(DB::raw("customers_sales_info.router_type"))
                ->pluck('device');

            $counts = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->select(DB::raw("count(customers_sales_info.router_type) as amount"))
                ->groupBy(DB::raw("customers_sales_info.router_type"))
                ->pluck('amount');
        } else {
            $devices = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->select("customers_sales_info.receiver_type as device")
                ->groupBy(DB::raw("customers_sales_info.receiver_type"))
                ->pluck('device');

            $counts = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->select(DB::raw("count(customers_sales_info.receiver_type) as amount"))
                ->groupBy(DB::raw("customers_sales_info.receiver_type"))
                ->pluck('amount');
        }

        return view('dashboard.charts.device', compact('devices', 'counts'));
    }

    // returning the branch types reports statistics
    public function branch()
    {
        $branches = Customer::join('branches', 'customers.branch_id', '=', 'branches.id')
            ->select("branches.name as branch")
            ->groupBy(DB::raw("branches.name"))
            ->pluck('branch');

        $counts = Customer::join('branches', 'customers.branch_id', '=', 'branches.id')
            ->select(DB::raw("count(branches.name) as amount"))
            ->groupBy(DB::raw("branches.name"))
            ->pluck('amount');

        return view('dashboard.charts.branch', compact('branches', 'counts'));
    }

    // returning the package types reports statistics
    public function package()
    {
        $packages = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
            ->join('packages', 'customers_sales_info.package_id', '=', 'packages.id')
            ->select("packages.name as package")
            ->groupBy(DB::raw("packages.name"))
            ->pluck('package');

        $counts = Customer::join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
            ->join('packages', 'customers_sales_info.package_id', '=', 'packages.id')
            ->select(DB::raw("count(packages.name) as amount"))
            ->groupBy(DB::raw("packages.name"))
            ->pluck('amount');

        return view('dashboard.charts.package', compact('packages', 'counts'));
    }
}
