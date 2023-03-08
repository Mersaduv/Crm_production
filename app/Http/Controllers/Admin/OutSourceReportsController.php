<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportProvincialActives;
use App\Exports\ExportProvincialAmendments;
use App\Exports\ExportProvincialBases;
use App\Exports\ExportProvincialCancelAmendments;
use App\Exports\ExportProvincialCancels;
use App\Exports\ExportProvincialPackages;
use App\Exports\ExportProvincialReactivates;
use App\Exports\ExportProvincialRecontracts;
use App\Exports\ExportProvincialResellers;
use App\Exports\ExportProvincialSuspends;
use App\Exports\ExportProvincialTerminated;
use App\Exports\ExportProvincialTotal;
use App\Http\Controllers\Controller;
use App\Models\Provincial;
use App\Models\PrAmend;
use App\Models\PrCancel;
use App\Models\PrSuspend;
use App\Models\PrReactivate;
use App\Models\PrTerminate;
use App\Models\PrRecontract;
use App\Models\PrCancelAmend;
use App\Models\Branch;
use App\Models\Province;
use Maatwebsite\Excel\Facades\Excel;

class OutSourceReportsController extends Controller
{
    // return the report page
    public function index()
    {
        $this->authorize('viewAny', Provincial::class);
        return view('dashboard.OutSourceReports.index');
    }

    // return the installation page reports
    public function installation()
    {
        $customers = Provincial::latest('pr_customers.created_at');
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('finance') || request('finance') == '0') {
            $customers = $customers->where('finance_status', '=', request('finance'));
            $isFilter = 'true';
        }

        if (request('process')) {
            $isFilter = 'true';
            switch (request('process')) {
                case 'activate':
                    $customers = $customers->whereHas('PrNocInfo')->where('active_status', '=', '1');
                    break;
                case 'cancel':
                    $customers = $customers->whereHas('prCancel', function ($query) {
                        $query->whereNotNull('noc_confirmation')->whereNull('rollback_date');
                    });
                    break;
                case 'suspend':
                    $customers = $customers->whereHas('suspend', function ($query) {
                        $query->whereNotNull('noc_confirmation')->whereNull('reactive_date');
                    });
                    break;
                case 'terminate':
                    $customers = $customers->whereHas('terminate', function ($query) {
                        $query->whereNotNull('noc_confirmation')->whereNull('recontract_date');
                    });
                    break;
                case 'amendment':
                    $customers = $customers->whereHas('amend', function ($query) {
                        $query->whereNotNull('noc_confirmation')->where('cancel_status', '=', '0');
                    });
                    break;
                default:
                    $customers = $customers->where('process_status', '=', '1')
                        ->where('active_status', '=', '0')
                        ->where('cancel_status', '=', '0')
                        ->where('suspend_status', '=', '0')
                        ->where('terminate_status', '=', '0');
                    break;
            }
        }

        if (request('insStart') && request('insEnd')) {
            $customers = $customers->whereDate('installation_date', '>=', request('insStart'))
                ->whereDate('installation_date', '<=', request('insEnd'));
            $isFilter = 'true';
        }

        if (request('actStart') && request('actEnd')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
            $isFilter = 'true';
        }

        if (request('cancelStart') && request('cancelEnd')) {
            $customers = $customers
                ->join('pr_cancel_info', 'pr_customers.id', '=', 'pr_cancel_info.pr_cu_id')
                ->whereDate('pr_cancel_info.cancel_date', '>=', request('cancelStart'))
                ->whereDate('pr_cancel_info.cancel_date', '<=', request('cancelEnd'))
                ->whereNotNull('pr_cancel_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
            $isFilter = 'true';
        }

        if (request('susStart') && request('susEnd')) {
            $customers = $customers
                ->join('pr_suspend_info', 'pr_customers.id', '=', 'pr_suspend_info.pr_cu_id')
                ->whereDate('pr_suspend_info.suspend_date', '>=', request('susStart'))
                ->whereDate('pr_suspend_info.suspend_date', '<=', request('susEnd'))
                ->whereNotNull('pr_suspend_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
            $isFilter = 'true';
        }

        if (request('terStart') && request('terEnd')) {
            $customers = $customers
                ->join('pr_terminate_info', 'pr_customers.id', '=', 'pr_terminate_info.pr_cu_id')
                ->whereDate('pr_terminate_info.termination_date', '>=', request('terStart'))
                ->whereDate('pr_terminate_info.termination_date', '<=', request('terEnd'))
                ->whereNotNull('pr_terminate_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
            $isFilter = 'true';
        }

        if (request('amendStart') && request('amendEnd')) {
            $customers = $customers
                ->join('pr_amend_info', 'pr_customers.id', '=', 'pr_amend_info.pr_cu_id')
                ->whereDate('pr_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('pr_amend_info.amend_date', '<=', request('amendEnd'))
                ->whereNotNull('pr_amend_info.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
            $isFilter = 'true';
        }

        if (request('cancelAmend') && request('cancelAmendEnd')) {
            $customers = $customers
                ->join('pr_amend_cancel', 'pr_customers.id', '=', 'pr_amend_cancel.pr_cu_id')
                ->whereDate('pr_amend_cancel.cancel_date', '>=', request('cancelAmend'))
                ->whereDate('pr_amend_cancel.cancel_date', '<=', request('cancelAmendEnd'))
                ->whereNotNull('pr_amend_cancel.noc_confirmation')
                ->select('pr_customers.*', 'pr_customers.customer_id');
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();
        $customers = $customers->whereNull('deleted_at')
            ->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.installations', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the Total customers
    public function exportTotalCustomers()
    {
        return Excel::download(new ExportProvincialTotal, 'total-provincial-customers-report.xlsx');
    }

    // return the customers page reports
    public function customers()
    {
        $customers = Provincial::latest('pr_customers.created_at');
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('ins')) {
            $customers = $customers
                ->whereDate('installation_date', '=', request('ins'));
            $isFilter = 'true';
        }

        if (request('act')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '=', request('act'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
            $isFilter = 'true';
        }

        if (request('insStart') && request('insEnd')) {
            $customers = $customers
                ->whereDate('installation_date', '>=', request('insStart'))
                ->whereDate('installation_date', '<=', request('insEnd'));
            $isFilter = 'true';
        }

        if (request('actStart') && request('actEnd')) {
            $customers = $customers
                ->join('pr_noc_info', 'pr_customers.id', '=', 'pr_noc_info.customer_id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->select('pr_customers.*', 'pr_customers.customer_id');
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers
            ->where('active_status', '=', '1')
            ->whereNull('deleted_at')
            ->whereHas('PrNocInfo')
            ->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.customers', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the Active customers
    public function exportActiveCustomers()
    {
        return Excel::download(new ExportProvincialActives, 'provincial-active-customers-report.xlsx');
    }

    // return the terminates page reports
    public function terminates()
    {
        $customers = PrTerminate::latest();
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('activation')) {
            $customers = $customers
                ->join('pr_customers', 'pr_terminate_info.pr_cu_id', '=', 'pr_customers.id')
                ->join('pr_noc_info', 'pr_noc_info.customer_id', '=', 'pr_customers.id')
                ->whereDate('pr_noc_info.activation_date', '=', request('activation'))
                ->select('pr_terminate_info.*', 'pr_terminate_info.customer_id');
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('activation')) {
            $customers = $customers
                ->join('pr_customers', 'pr_terminate_info.pr_cu_id', '=', 'pr_customers.id')
                ->join('pr_noc_info', 'pr_noc_info.customer_id', '=', 'pr_customers.id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->select('pr_terminate_info.*', 'pr_terminate_info.customer_id');
            $isFilter = 'true';
        }

        if (request('terminate')) {
            $customers = $customers->whereDate('terminate_date', '=', request('terminate'));
            $isFilter = 'true';
        }

        if ((request('terStart') && request('terEnd')) && !request('terminate')) {
            $customers = $customers->whereDate('terminate_date', '>=', request('terStart'))
                ->whereDate('terminate_date', '<=', request('terEnd'));
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers->where('status', '=', 'terminate')
            ->whereNotNull('noc_confirmation')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.terminates', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the Terminated customers
    public function exportTerminatedCustomers()
    {
        return Excel::download(new ExportProvincialTerminated, 'provincial-terminated-report.xlsx');
    }


    // return the recontract page reports
    public function recontract()
    {
        $customers = PrRecontract::latest();
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('activation')) {
            $customers = $customers->whereDate('recontract_date', '=', request('activation'));
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('activation')) {
            $customers = $customers->whereDate('recontract_date', '>=', request('actStart'))
                ->whereDate('recontract_date', '<=', request('actEnd'));
            $isFilter = 'true';
        }

        if (request('terminate')) {
            $customers = $customers->whereHas('terminate', function ($query) {
                $query->whereDate('terminate_date', '=', request('terminate'));
            });
            $isFilter = 'true';
        }

        if ((request('terStart') && request('terEnd')) && !request('terminate')) {
            $customers = $customers->whereHas('terminate', function ($query) {
                $query->whereDate('terminate_date', '>=', request('terStart'))
                    ->whereDate('terminate_date', '<=', request('terEnd'));
            });
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereNotNull('noc_confirmation')
            ->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.recontract', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the Recontracts customers
    public function exportRecontracts()
    {
        return Excel::download(new ExportProvincialRecontracts, 'provincial-recontracts-report.xlsx');
    }

    // return the suspends page reports
    public function suspends()
    {
        $customers = PrSuspend::latest();
        $isFilter = 'false';

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('suspend')) {
            $customers = $customers->whereDate('suspend_date', '=', request('suspend'));
            $isFilter = 'true';
        }

        if (request('act')) {
            $customers = $customers
                ->join('pr_customers', 'pr_suspend_info.pr_cu_id', '=', 'pr_customers.id')
                ->join('pr_noc_info', 'pr_noc_info.customer_id', '=', 'pr_customers.id')
                ->whereDate('pr_noc_info.activation_date', '=', request('act'))
                ->select('pr_suspend_info.*', 'pr_suspend_info.customer_id');
            $isFilter = 'true';
        }

        if ((request('suspendStart') && request('suspendEnd')) && !request('suspend')) {
            $customers = $customers->whereDate('suspend_date', '>=', request('suspendStart'))
                ->whereDate('suspend_date', '<=', request('suspendEnd'));
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('pr_customers', 'pr_suspend_info.pr_cu_id', '=', 'pr_customers.id')
                ->join('pr_noc_info', 'pr_noc_info.customer_id', '=', 'pr_customers.id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->select('pr_suspend_info.*', 'pr_suspend_info.customer_id');
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers
            ->where('status', '=', 'suspend')
            ->whereNotNull('noc_confirmation')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.suspends', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the Suspends customers
    public function exportSuspends()
    {
        return Excel::download(new ExportProvincialSuspends, 'provincial-suspends-report.xlsx');
    }

    // return the reactivate page reports
    public function reactivate()
    {
        $customers = PrReactivate::latest();
        $isFilter = 'false';

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('suspend')) {
            $customers = $customers->whereHas('suspend', function ($query) {
                $query->whereDate('suspend_date', '=', request('suspend'));
            });
            $isFilter = 'true';
        }

        if (request('act')) {
            $customers = $customers->whereDate('reactive_date', '=', request('act'));
            $isFilter = 'true';
        }

        if ((request('suspendStart') && request('suspendEnd')) && !request('suspend')) {
            $customers = $customers->whereHas('suspend', function ($query) {
                $query->whereDate('suspend_date', '>=', request('suspendStart'))
                    ->whereDate('suspend_date', '<=', request('suspendEnd'));
            });
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers->whereDate('reactive_date', '>=', request('actStart'))
                ->whereDate('reactive_date', '<=', request('actEnd'));
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereNotNull('noc_confirmation')
            ->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.reactivate', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the reactivate customers
    public function exportReactivates()
    {
        return Excel::download(new ExportProvincialReactivates, 'provincial-reactivates-report.xlsx');
    }


    // return the amendments page reports
    public function amendments()
    {
        $customers = PrAmend::latest();
        $isFilter = 'false';

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('amend')) {
            $customers = $customers->whereDate('amend_date', '=', request('amend'));
            $isFilter = 'true';
        }

        if (request('act')) {
            $customers = $customers
                ->join('pr_customers', 'pr_amend_info.pr_cu_id', '=', 'pr_customers.id')
                ->join('pr_noc_info', 'pr_noc_info.customer_id', '=', 'pr_customers.id')
                ->whereDate('pr_noc_info.activation_date', '=', request('act'))
                ->select('pr_amend_info.*', 'pr_amend_info.customer_id');
            $isFilter = 'true';
        }

        if ((request('amendStart') && request('amendEnd')) && !request('amend')) {
            $customers = $customers->whereDate('amend_date', '>=', request('amendStart'))
                ->whereDate('amend_date', '<=', request('amendEnd'));
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('pr_customers', 'pr_amend_info.pr_cu_id', '=', 'pr_customers.id')
                ->join('pr_noc_info', 'pr_noc_info.customer_id', '=', 'pr_customers.id')
                ->whereDate('pr_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('pr_noc_info.activation_date', '<=', request('actEnd'))
                ->select('pr_amend_info.*', 'pr_amend_info.customer_id');
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->where('pr_amend_info.cancel_status', '=', '0')
            ->whereNotNull('noc_confirmation')
            ->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.amendments', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the amendments customers
    public function exportAmendments()
    {
        return Excel::download(new ExportProvincialAmendments, 'provincial-amendments-report.xlsx');
    }

    // return the cancel amendments
    public function cancelAmendments()
    {
        $customers = PrCancelAmend::latest();
        $isFilter = 'false';

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('amend')) {
            $customers = $customers
                ->join('pr_amend_info', 'pr_amend_cancel.amend_id', '=', 'pr_amend_info.id')
                ->whereDate('pr_amend_info.amend_date', '=', request('amend'))
                ->select('pr_amend_cancel.*');
            $isFilter = 'true';
        }

        if ((request('amendStart') && request('amendEnd')) && !request('amend')) {
            $customers = $customers
                ->join('pr_amend_info', 'pr_amend_cancel.amend_id', '=', 'pr_amend_info.id')
                ->whereDate('pr_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('pr_amend_info.amend_date', '<=', request('amendEnd'))
                ->select('pr_amend_cancel.*');
            $isFilter = 'true';
        }

        if (request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '=', request('cancel'));
            $isFilter = 'true';
        }

        if ((request('cancel_date') && request('cancel_end')) && !request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'));
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->whereNotNull('pr_amend_cancel.noc_confirmation')
            ->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.cancelAmendments', compact(['customers', 'isFilter', 'provinces']));
    }


    // Export the cancel amendments customers
    public function exportCancelAmendments()
    {
        return Excel::download(new ExportProvincialCancelAmendments, 'provincial-cancel-amendments-report.xlsx');
    }


    // return the cancels page reports
    public function cancels()
    {
        $customers = PrCancel::latest();
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('ins')) {
            $customers = $customers
                ->join('pr_customers', 'pr_cancel_info.pr_cu_id', '=', 'pr_customers.id')
                ->whereDate('pr_customers.installation_date', '=', request('ins'))
                ->select('pr_cancel_info.*', 'pr_cancel_info.customer_id');
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->join('pr_customers', 'pr_cancel_info.pr_cu_id', '=', 'pr_customers.id')
                ->whereDate('installation_date', '>=', request('insStart'))
                ->whereDate('installation_date', '<=', request('insEnd'))
                ->select('pr_cancel_info.*', 'pr_cancel_info.customer_id');
            $isFilter = 'true';
        }

        if (request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '=', request('cancel'));
            $isFilter = 'true';
        }

        if ((request('cancel_date') && request('endDate')) && !request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('endDate'));
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers
            ->whereNull('rollback_date')
            ->whereNotNull('pr_cancel_info.noc_confirmation')
            ->whereHas('provincial', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->paginate(request('per_page', 15));
        return view('dashboard.OutSourceReports.cancels', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the cancels page  customers
    public function exportCancels()
    {
        return Excel::download(new ExportProvincialCancels, 'provincial-cancels-report.xlsx');
    }

    // reuturn the base reports of provincial customers
    public function base()
    {
        $customers = Provincial::latest('pr_customers.created_at');
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('ins')) {
            $customers = $customers
                ->whereDate('installation_date', '=', request('ins'));
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->whereDate('installation_date', '>=', request('insStart'))
                ->whereDate('installation_date', '<=', request('insEnd'));
            $isFilter = 'true';
        }

        if (request('branch_id')) {
            $customers = $customers->where('branch_id', '=', request('branch_id'));
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();
        $branches  = Branch::all();
        $customers = $customers
            ->whereNull('deleted_at')
            ->paginate(request('per_page', 15));

        return view('dashboard.OutSourceReports.base', compact(['customers', 'isFilter', 'branches', 'provinces']));
    }

    // Export the customers via bases
    public function exportBases()
    {
        return Excel::download(new ExportProvincialBases, 'provincial-branchs-report.xlsx');
    }

    // reuturn the package reports of provincial customers
    public function package()
    {
        $customers = Provincial::latest('pr_customers.created_at');
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('ins')) {
            $customers = $customers
                ->whereDate('installation_date', '=', request('ins'));
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->whereDate('installation_date', '>=', request('insStart'))
                ->whereDate('installation_date', '<=', request('insEnd'));
            $isFilter = 'true';
        }

        if (request('process')) {
            $isFilter = 'true';
            switch (request('process')) {
                case 'activate':
                    $customers = $customers->where('active_status', '=', '1');
                    break;
                case 'cancel':
                    $customers = $customers->where('cancel_status', '=', '1');
                    break;
                case 'suspend':
                    $customers = $customers->where('suspend_status', '=', '1');
                    break;
                case 'terminate':
                    $customers = $customers->where('terminate_status', '=', '1');
                    break;
            }
        }

        if (request('package_id')) {
            $customers = $customers
                ->where('package_id', '=', request('package_id'));
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        $provinces = Province::all();

        $customers = $customers
            ->where(function ($query) {
                $query->where('active_status', '=', '1')
                    ->orWhere('cancel_status', '=', '1')
                    ->orWhere('suspend_status', '=', '1')
                    ->orWhere('terminate_status', '=', '1');
            })
            ->whereNull('deleted_at')
            ->paginate(request('per_page', 15));

        return view('dashboard.OutSourceReports.package', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the Packages customers
    public function exportPackages()
    {
        return Excel::download(new ExportProvincialPackages, "provincial-packages-report.xlsx");
    }

    // reuturn the resellers reports of provincial customers
    public function resellers()
    {
        $customers = Provincial::latest('pr_customers.created_at');
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('ins')) {
            $customers = $customers
                ->whereDate('installation_date', '=', request('ins'));
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->whereDate('installation_date', '>=', request('insStart'))
                ->whereDate('installation_date', '<=', request('insEnd'));
            $isFilter = 'true';
        }

        if (request('province')) {
            $customers = $customers->where('province', 'like', '%' . request('province') . '%');
            $isFilter = 'true';
        }

        if (request('commission_id')) {
            $customers = $customers->where('commission_id', '=', request('commission_id'));
            $isFilter = 'true';
        }

        $provinces = Province::all();
        $customers = $customers
            ->whereNull('deleted_at')
            ->paginate(request('per_page', 15));

        return view('dashboard.OutSourceReports.resellers', compact(['customers', 'isFilter', 'provinces']));
    }

    // Export the Packages customers
    public function exportResellers()
    {
        return Excel::download(new ExportProvincialResellers, "provincial-resellers-report.xlsx");
    }
}
