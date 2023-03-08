<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provincial;
use App\Models\PrAmend;
use App\Models\PrCancel;
use App\Models\PrSuspend;
use App\Models\PrTerminate;
use App\Models\PrCancelAmend;
use DB;

class OutSourceChartsController extends Controller
{
    public function customers()
    {

        // Total Customers

        $customers = Provincial::whereNull('deleted_at',)->latest('pr_customers.id');
        $months = Provincial::whereNull('deleted_at',)->latest('pr_customers.id');

        if (request('insStart') && request('insEnd')) {

            $customers = $customers
                ->WhereDate('installation_date', '>=', request('insStart'))
                ->WhereDate('installation_date', '<=', request('insEnd'))
                ->groupBy(DB::raw("Month(installation_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $months = $months
                ->WhereDate('installation_date', '>=', request('insStart'))
                ->WhereDate('installation_date', '<=', request('insEnd'))
                ->groupBy(DB::raw("Month(installation_date)"))
                ->select(DB::raw("Month(installation_date) as month"))
                ->pluck('month');
        } else {

            $customers = $customers
                ->whereYear('installation_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(installation_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $months = $months
                ->whereYear('installation_date', '=', date('Y'))
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

            $activation = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->WhereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->WhereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $activationMonths = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->WhereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->WhereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->select(DB::raw("Month(pr_noc_info.activation_date) as month"))
                ->pluck('month');
        } else {

            $activation = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereYear('pr_noc_info.activation_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $activationMonths = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereYear('pr_noc_info.activation_date', '=', date('Y'))
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->select(DB::raw("Month(pr_noc_info.activation_date) as month"))
                ->pluck('month');
        }

        $activationDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($activationMonths as $index => $month) {
            $activationDatas[$month - 1] = $activation[$index];
        }

        // Cancel Data

        if (request('cancelStart') && request('cancelEnd')) {

            $cancel = Provincial::join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->WhereDate('pr_cancel_info.cancel_date', '>=', request('cancelStart'))
                ->WhereDate('pr_cancel_info.cancel_date', '<=', request('cancelEnd'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_cancel_info.cancel_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $cancelMonths = Provincial::join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->WhereDate('pr_cancel_info.cancel_date', '>=', request('cancelStart'))
                ->WhereDate('pr_cancel_info.cancel_date', '<=', request('cancelEnd'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_cancel_info.cancel_date)"))
                ->select(DB::raw("Month(pr_cancel_info.cancel_date) as month"))
                ->pluck('month');
        } else {

            $cancel = Provincial::join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->whereYear('pr_cancel_info.cancel_date', '=', date('Y'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_cancel_info.cancel_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $cancelMonths = Provincial::join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->whereYear('pr_cancel_info.cancel_date', '=', date('Y'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_cancel_info.cancel_date)"))
                ->select(DB::raw("Month(pr_cancel_info.cancel_date) as month"))
                ->pluck('month');
        }

        $cancelDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($cancelMonths as $index => $month) {
            $cancelDatas[$month - 1] = $cancel[$index];
        }

        // Suspend Data

        if (request('susStart') && request('susEnd')) {

            $suspend = Provincial::join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->WhereDate('pr_suspend_info.suspend_date', '>=', request('susStart'))
                ->WhereDate('pr_suspend_info.suspend_date', '<=', request('susEnd'))
                ->whereNull('pr_suspend_info.reactive_date')
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_suspend_info.suspend_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $suspendMonths = Provincial::join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->WhereDate('pr_suspend_info.suspend_date', '>=', request('susStart'))
                ->WhereDate('pr_suspend_info.suspend_date', '<=', request('susEnd'))
                ->whereNull('pr_suspend_info.reactive_date')
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_suspend_info.suspend_date)"))
                ->select(DB::raw("Month(pr_suspend_info.suspend_date) as month"))
                ->pluck('month');
        } else {

            $suspend = Provincial::join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereYear('pr_suspend_info.suspend_date', '=', date('Y'))
                ->whereNull('pr_suspend_info.reactive_date')
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_suspend_info.suspend_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $suspendMonths = Provincial::join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereYear('pr_suspend_info.suspend_date', '=', date('Y'))
                ->whereNull('pr_suspend_info.reactive_date')
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_suspend_info.suspend_date)"))
                ->select(DB::raw("Month(pr_suspend_info.suspend_date) as month"))
                ->pluck('month');
        }

        $suspendDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($suspendMonths as $index => $month) {
            $suspendDatas[$month - 1] = $suspend[$index];
        }

        // Terminate Data

        if (request('terStart') && request('terEnd')) {

            $terminates = Provincial::join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->WhereDate('pr_terminate_info.terminate_date', '>=', request('terStart'))
                ->WhereDate('pr_terminate_info.terminate_date', '<=', request('terEnd'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_terminate_info.terminate_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $terminatesMonths = Provincial::join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->WhereDate('pr_terminate_info.terminate_date', '>=', request('terStart'))
                ->WhereDate('pr_terminate_info.terminate_date', '<=', request('terEnd'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_terminate_info.terminate_date)"))
                ->select(DB::raw("Month(pr_terminate_info.terminate_date) as month"))
                ->pluck('month');
        } else {

            $terminates = Provincial::join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereYear('pr_terminate_info.terminate_date', '=', date('Y'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_terminate_info.terminate_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $terminatesMonths = Provincial::join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereYear('pr_terminate_info.terminate_date', '=', date('Y'))
                ->whereNull('pr_terminate_info.recontract_date')
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_terminate_info.terminate_date)"))
                ->select(DB::raw("Month(pr_terminate_info.terminate_date) as month"))
                ->pluck('month');
        }

        $terminatesDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($terminatesMonths as $index => $month) {
            $terminatesDatas[$month - 1] = $terminates[$index];
        }

        // Amendment Data

        if (request('amendStart') && request('amendEnd')) {

            $amendments = Provincial::join('pr_amend_info', 'pr_customers.id', '=', 'pr_amend_info.pr_cu_id')
                ->WhereDate('pr_amend_info.amend_date', '>=', request('amendStart'))
                ->WhereDate('pr_amend_info.amend_date', '<=', request('amendEnd'))
                ->where('pr_amend_info.cancel_status', '=', '0')
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_info.amend_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $amendmentsMonths = Provincial::join('pr_amend_info', 'pr_customers.id', '=', 'pr_amend_info.pr_cu_id')
                ->WhereDate('pr_amend_info.amend_date', '>=', request('amendStart'))
                ->WhereDate('pr_amend_info.amend_date', '<=', request('amendEnd'))
                ->where('pr_amend_info.cancel_status', '=', '0')
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_info.amend_date)"))
                ->select(DB::raw("Month(pr_amend_info.amend_date) as month"))
                ->pluck('month');
        } else {

            $amendments = Provincial::join('pr_amend_info', 'pr_customers.id', '=', 'pr_amend_info.pr_cu_id')
                ->whereYear('pr_amend_info.amend_date', '=', date('Y'))
                ->where('pr_amend_info.cancel_status', '=', '0')
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_info.amend_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $amendmentsMonths = Provincial::join('pr_amend_info', 'pr_customers.id', '=', 'pr_amend_info.pr_cu_id')
                ->whereYear('pr_amend_info.amend_date', '=', date('Y'))
                ->where('pr_amend_info.cancel_status', '=', '0')
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_info.amend_date)"))
                ->select(DB::raw("Month(pr_amend_info.amend_date) as month"))
                ->pluck('month');
        }

        $amendmentsDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($amendmentsMonths as $index => $month) {
            $amendmentsDatas[$month - 1] = $amendments[$index];
        }

        // Cancel Amendment Data
        if (request('cancelAmend') && request('cancelAmendEnd')) {

            $cancelAmendments = Provincial::join('pr_amend_cancel', 'pr_customers.id', '=', 'pr_amend_cancel.pr_cu_id')
                ->WhereDate('pr_amend_cancel.cancel_date', '>=', request('cancelAmend'))
                ->WhereDate('pr_amend_cancel.cancel_date', '<=', request('cancelAmendEnd'))
                ->whereNotNull('pr_amend_cancel.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_cancel.cancel_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $cancelAmendmentsMonths = Provincial::join('pr_amend_cancel', 'pr_customers.id', '=', 'pr_amend_cancel.pr_cu_id')
                ->WhereDate('pr_amend_cancel.cancel_date', '>=', request('cancelAmend'))
                ->WhereDate('pr_amend_cancel.cancel_date', '<=', request('cancelAmendEnd'))
                ->whereNotNull('pr_amend_cancel.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_cancel.cancel_date)"))
                ->select(DB::raw("Month(pr_amend_cancel.cancel_date) as month"))
                ->pluck('month');
        } else {

            $cancelAmendments = Provincial::join('pr_amend_cancel', 'pr_customers.id', '=', 'pr_amend_cancel.pr_cu_id')
                ->whereYear('pr_amend_cancel.cancel_date', '=', date('Y'))
                ->whereNotNull('pr_amend_cancel.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_cancel.cancel_date)"))
                ->select(DB::raw("count(*) as count"))
                ->pluck('count');

            $cancelAmendmentsMonths = Provincial::join('pr_amend_cancel', 'pr_customers.id', '=', 'pr_amend_cancel.pr_cu_id')
                ->whereYear('pr_amend_cancel.cancel_date', '=', date('Y'))
                ->whereNotNull('pr_amend_cancel.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_cancel.cancel_date)"))
                ->select(DB::raw("Month(pr_amend_cancel.cancel_date) as month"))
                ->pluck('month');
        }

        $cancelAmendmentsDatas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($cancelAmendmentsMonths as $index => $month) {
            $cancelAmendmentsDatas[$month - 1] = $cancelAmendments[$index];
        }

        return view('dashboard.OutSourceCharts.customers', compact(['datas', 'activationDatas', 'cancelDatas', 'amendmentsDatas', 'suspendDatas', 'terminatesDatas', 'cancelAmendmentsDatas']));
    }

    // activated customers charts
    public function activated()
    {

        if (request('insStart') && request('insEnd')) {

            $customers = Provincial::select(DB::raw("count(*) as count"))
                ->whereDate('installation_date', '>=', request('insStart'))
                ->whereDate('installation_date', '<=', request('insEnd'))
                ->where('active_status', '=', '1')
                ->groupBy(DB::raw("Month(installation_date)"))
                ->pluck('count');

            $months = Provincial::select(DB::raw("Month(installation_date) as month"))
                ->whereDate('installation_date', '>=', request('insStart'))
                ->whereDate('installation_date', '<=', request('insEnd'))
                ->where('active_status', '=', '1')
                ->groupBy(DB::raw("Month(installation_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->where('active_status', '=', '1')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('count');

            $months    = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("Month(pr_noc_info.activation_date) as month"))
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->where('active_status', '=', '1')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('month');
        } else {

            $customers = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereYear('pr_noc_info.activation_date', date('Y'))
                ->where('active_status', '=', '1')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('count');

            $months = Provincial::join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("Month(pr_noc_info.activation_date) as month"))
                ->whereYear('pr_noc_info.activation_date', date('Y'))
                ->where('active_status', '=', '1')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.OutSourceCharts.activated', compact('datas'));
    }

    // termiantes customers charts
    public function terminates()
    {
        if (request('terStart') && request('terEnd')) {

            $customers = PrTerminate::select(DB::raw("count(*) as count"))
                ->WhereDate('terminate_date', '>=', request('terStart'))
                ->WhereDate('terminate_date', '<=', request('terEnd'))
                ->where('status', '=', 'terminate')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(terminate_date)"))
                ->pluck('count');

            $months = PrTerminate::select(DB::raw("Month(terminate_date) as month"))
                ->WhereDate('terminate_date', '>=', request('terStart'))
                ->WhereDate('terminate_date', '<=', request('terEnd'))
                ->where('status', '=', 'terminate')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(terminate_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = PrTerminate::join('pr_noc_info', 'pr_terminate_info.pr_cu_id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->where('pr_terminate_info.status', '=', 'terminate')
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('count');

            $months    = PrTerminate::join('pr_noc_info', 'pr_terminate_info.pr_cu_id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("Month(pr_noc_info.activation_date) as month"))
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->where('pr_terminate_info.status', '=', 'terminate')
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('month');
        } else {

            $customers = PrTerminate::select(DB::raw("count(*) as count"))
                ->whereYear('terminate_date', date('Y'))
                ->where('status', '=', 'terminate')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(terminate_date)"))
                ->pluck('count');

            $months = PrTerminate::select(DB::raw("Month(terminate_date) as month"))
                ->whereYear('terminate_date', date('Y'))
                ->where('status', '=', 'terminate')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(terminate_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.OutSourceCharts.terminates', compact('datas'));
    }

    // recontract customers charts
    public function recontract()
    {
        if (request('terStart') && request('terEnd')) {

            $customers = PrTerminate::select(DB::raw("count(*) as count"))
                ->WhereDate('terminate_date', '>=', request('terStart'))
                ->WhereDate('terminate_date', '<=', request('terEnd'))
                ->whereNotNull('recontract_date')
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(terminate_date)"))
                ->pluck('count');

            $months = PrTerminate::select(DB::raw("Month(terminate_date) as month"))
                ->WhereDate('terminate_date', '>=', request('terStart'))
                ->WhereDate('terminate_date', '<=', request('terEnd'))
                ->whereNotNull('recontract_date')
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(terminate_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = PrTerminate::select(DB::raw("count(*) as count"))
                ->whereDate('recontract_date', '>=', request('actStart'))
                ->whereDate('recontract_date', '<=', request('actEnd'))
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(recontract_date)"))
                ->pluck('count');

            $months    = PrTerminate::select(DB::raw("Month(recontract_date) as month"))
                ->whereDate('recontract_date', '>=', request('actStart'))
                ->whereDate('recontract_date', '<=', request('actEnd'))
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(recontract_date)"))
                ->pluck('month');
        } else {

            $customers = PrTerminate::select(DB::raw("count(*) as count"))
                ->whereYear('recontract_date', date('Y'))
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(recontract_date)"))
                ->pluck('count');

            $months = PrTerminate::select(DB::raw("Month(recontract_date) as month"))
                ->whereYear('recontract_date', date('Y'))
                ->whereHas('recontract', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(recontract_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.OutSourceCharts.recontract', compact('datas'));
    }

    // suspends customers charts
    public function suspends()
    {
        if (request('susStart') && request('susEnd')) {


            $customers = PrSuspend::select(DB::raw("count(*) as count"))
                ->WhereDate('suspend_date', '>=', request('susStart'))
                ->WhereDate('suspend_date', '<=', request('susEnd'))
                ->where('status', '=', 'suspend')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('count');

            $months = PrSuspend::select(DB::raw("Month(suspend_date) as month"))
                ->WhereDate('suspend_date', '>=', request('susStart'))
                ->WhereDate('suspend_date', '<=', request('susEnd'))
                ->where('status', '=', 'suspend')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = PrSuspend::join('pr_noc_info', 'pr_suspend_info.pr_cu_id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->where('pr_suspend_info.status', '=', 'suspend')
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('count');

            $months    = PrSuspend::join('pr_noc_info', 'pr_suspend_info.pr_cu_id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("Month(pr_noc_info.activation_date) as month"))
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->where('pr_suspend_info.status', '=', 'suspend')
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('month');
        } else {

            $customers = PrSuspend::select(DB::raw("count(*) as count"))
                ->whereYear('suspend_date', date('Y'))
                ->where('status', '=', 'suspend')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('count');

            $months = PrSuspend::select(DB::raw("Month(suspend_date) as month"))
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

        return view('dashboard.OutSourceCharts.suspends', compact('datas'));
    }

    // reactivate customers charts
    public function reactivate()
    {
        if (request('susStart') && request('susEnd')) {


            $customers = PrSuspend::select(DB::raw("count(*) as count"))
                ->WhereDate('suspend_date', '>=', request('susStart'))
                ->WhereDate('suspend_date', '<=', request('susEnd'))
                ->whereNotNull('reactive_date')
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('count');

            $months = PrSuspend::select(DB::raw("Month(suspend_date) as month"))
                ->WhereDate('suspend_date', '>=', request('susStart'))
                ->WhereDate('suspend_date', '<=', request('susEnd'))
                ->whereNotNull('reactive_date')
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(suspend_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = PrSuspend::select(DB::raw("count(*) as count"))
                ->whereDate('reactive_date', '>=', request('actStart'))
                ->whereDate('reactive_date', '<=', request('actEnd'))
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })->groupBy(DB::raw("Month(reactive_date)"))
                ->pluck('count');

            $months    = PrSuspend::select(DB::raw("Month(reactive_date) as month"))
                ->whereDate('reactive_date', '>=', request('actStart'))
                ->whereDate('reactive_date', '<=', request('actEnd'))
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(reactive_date)"))
                ->pluck('month');
        } else {

            $customers = PrSuspend::select(DB::raw("count(*) as count"))
                ->whereYear('reactive_date', date('Y'))
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(reactive_date)"))
                ->pluck('count');

            $months = PrSuspend::select(DB::raw("Month(reactive_date) as month"))
                ->whereYear('reactive_date', date('Y'))
                ->whereHas('reactivate', function ($query) {
                    $query->whereNotNull('noc_confirmation');
                })
                ->groupBy(DB::raw("Month(reactive_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }

        return view('dashboard.OutSourceCharts.reactivate', compact('datas'));
    }

    // amendments customers charts
    public function amendments()
    {
        if (request('amendStart') && request('amendEnd')) {

            $customers = PrAmend::select(DB::raw("count(*) as count"))
                ->whereDate('amend_date', '>=', request('amendStart'))
                ->whereDate('amend_date', '<=', request('amendEnd'))
                ->where('cancel_status', '=', '0')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->pluck('count');

            $months = PrAmend::select(DB::raw("Month(amend_date) as month"))
                ->whereDate('amend_date', '>=', request('amendStart'))
                ->whereDate('amend_date', '<=', request('amendEnd'))
                ->where('cancel_status', '=', '0')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->pluck('month');
        } else if (request('actStart') && request('actEnd')) {

            $customers = PrAmend::join('pr_noc_info', 'pr_amend_info.pr_cu_id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->where('pr_amend_info.cancel_status', '=', '0')
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('count');

            $months    = PrAmend::join('pr_noc_info', 'pr_amend_info.pr_cu_id', '=', 'pr_noc_info.customer_id')
                ->select(DB::raw("Month(pr_noc_info.activation_date) as month"))
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->where('pr_amend_info.cancel_status', '=', '0')
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_noc_info.activation_date)"))
                ->pluck('month');
        } else {

            $customers = PrAmend::select(DB::raw("count(*) as count"))
                ->whereYear('amend_date', date('Y'))
                ->where('cancel_status', '=', '0')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(amend_date)"))
                ->pluck('count');

            $months = PrAmend::select(DB::raw("Month(amend_date) as month"))
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

        return view('dashboard.OutSourceCharts.amendments', compact('datas'));
    }

    // cancels amendments charts
    public function cancelAmendments()
    {
        if (request('amendStart') && request('amendEnd')) {

            $customers = PrCancelAmend::join('pr_amend_info', 'pr_amend_cancel.customer_id', '=', 'pr_amend_info.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('pr_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('pr_amend_info.amend_date', '<=', request('amendEnd'))
                ->whereNotNull('pr_amend_cancel.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_info.amend_date)"))
                ->pluck('count');

            $months = PrCancelAmend::join('pr_amend_info', 'pr_amend_cancel.customer_id', '=', 'pr_amend_info.customer_id')
                ->select(DB::raw("Month(pr_amend_info.amend_date) as month"))
                ->whereDate('pr_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('pr_amend_info.amend_date', '<=', request('amendEnd'))
                ->whereNotNull('pr_amend_cancel.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_amend_info.amend_date)"))
                ->pluck('month');
        } else if (request('cancel_date') && request('cancel_end')) {

            $customers = PrCancelAmend::select(DB::raw("count(*) as count"))
                ->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('count');

            $months    = PrCancelAmend::select(DB::raw("Month(cancel_date) as month"))
                ->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('month');
        } else {

            $customers = PrCancelAmend::select(DB::raw("count(*) as count"))
                ->whereYear('cancel_date', date('Y'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('count');

            $months = PrCancelAmend::select(DB::raw("Month(cancel_date) as month"))
                ->whereYear('cancel_date', date('Y'))
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('month');
        }

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $customers[$index];
        }
        return view('dashboard.OutSourceCharts.cancelAmendments', compact('datas'));
    }

    // cancels customers charts
    public function cancels()
    {
        if (request('cancelStart') && request('cancelEnd')) {

            $customers = PrCancel::select(DB::raw("count(*) as count"))
                ->whereDate('cancel_date', '>=', request('cancelStart'))
                ->whereDate('cancel_date', '<=', request('cancelEnd'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('count');

            $months = PrCancel::select(DB::raw("Month(cancel_date) as month"))
                ->whereDate('cancel_date', '>=', request('cancelStart'))
                ->whereDate('cancel_date', '<=', request('cancelEnd'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('month');
        } else if (request('insStart') && request('insEnd')) {

            $customers = PrCancel::join('pr_customers', 'pr_cancel_info.customer_id', '=', 'pr_customers.customer_id')
                ->select(DB::raw("count(*) as count"))
                ->whereDate('pr_customers.installation_date', '>=', request('insStart'))
                ->whereDate('pr_customers.installation_date', '<=', request('insEnd'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_customers.installation_date)"))
                ->pluck('count');

            $months = PrCancel::join('pr_customers', 'pr_cancel_info.customer_id', '=', 'pr_customers.customer_id')
                ->select(DB::raw("Month(pr_customers.installation_date) as month"))
                ->whereDate('pr_customers.installation_date', '>=', request('insStart'))
                ->whereDate('pr_customers.installation_date', '<=', request('insEnd'))
                ->whereNull('pr_cancel_info.rollback_date')
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->groupBy(DB::raw("Month(pr_customers.installation_date)"))
                ->pluck('month');
        } else {

            $customers = PrCancel::select(DB::raw("count(*) as count"))
                ->whereYear('cancel_date', date('Y'))
                ->whereNull('rollback_date')
                ->whereNotNull('noc_confirmation')
                ->groupBy(DB::raw("Month(cancel_date)"))
                ->pluck('count');

            $months = PrCancel::select(DB::raw("Month(cancel_date) as month"))
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
        return view('dashboard.OutSourceCharts.cancels', compact('datas'));
    }


    public function resellers()
    {
        $commissions = Provincial::join('commissions', 'pr_customers.commission_id', '=', 'commissions.id')
            ->select("commissions.name as branch")
            ->groupBy(DB::raw("commissions.name"))
            ->pluck('branch');

        $counts = Provincial::join('commissions', 'pr_customers.commission_id', '=', 'commissions.id')
            ->select(DB::raw("count(commissions.name) as amount"))
            ->groupBy(DB::raw("commissions.name"))
            ->pluck('amount');

        return view('dashboard.OutSourceCharts.resellers', compact('commissions', 'counts'));
    }

    public function branch()
    {
        $branches = Provincial::join('branches', 'pr_customers.branch_id', '=', 'branches.id')
            ->select("branches.name as branch")
            ->groupBy(DB::raw("branches.name"))
            ->pluck('branch');

        $counts = Provincial::join('branches', 'pr_customers.branch_id', '=', 'branches.id')
            ->select(DB::raw("count(branches.name) as amount"))
            ->groupBy(DB::raw("branches.name"))
            ->pluck('amount');

        return view('dashboard.OutSourceCharts.branch', compact('branches', 'counts'));
    }

    public function package()
    {
        $packages = Provincial::join('packages', 'pr_customers.package_id', '=', 'packages.id')
            ->select("packages.name as package")
            ->groupBy(DB::raw("packages.name"))
            ->pluck('package');

        $counts = Provincial::join('packages', 'pr_customers.package_id', '=', 'packages.id')
            ->select(DB::raw("count(packages.name) as amount"))
            ->groupBy(DB::raw("packages.name"))
            ->pluck('amount');

        return view('dashboard.OutSourceCharts.package', compact('packages', 'counts'));
    }
}
