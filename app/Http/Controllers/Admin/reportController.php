<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportActiveCustomer;
use App\Exports\ExportAmendments;
use App\Exports\ExportBases;
use App\Exports\ExportCancelAmendments;
use App\Exports\ExportCancels;
use App\Exports\ExportDevices;
use App\Exports\ExportPackages;
use App\Exports\ExportReactivates;
use App\Exports\ExportRecontracts;
use App\Exports\ExportSuspends;
use App\Exports\ExportTerminatedCustomers;
use App\Exports\ExportTotalCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Terminate;
use App\Models\Recontract;
use App\Models\Suspend;
use App\Models\Reactivate;
use App\Models\Amend;
use App\Models\Cancel;
use App\Models\CancelAmend;
use App\Models\Province;
use App\Models\Branch;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // return the report page
    public function index()
    {
        $this->authorize('viewAny', Customer::class);
        return view('dashboard.reports.index');
    }

    // return the installation page reports
    public function installation()
    {
        $customers = Customer::latest('customers.created_at');
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
                    $customers = $customers->where('active_status', '=', '1')->whereHas('noc');
                    break;
                case 'cancel':
                    $customers = $customers->whereHas('cancel', function ($query) {
                        $query->whereNotNull('noc_confirmation')->whereNull('rollback_date');
                    });
                    break;
                case 'suspend':
                    $customers = $customers->whereHas('suspend', function ($query) {
                        $query->whereNull('reactivation_date')->whereNotNull('noc_confirmation');
                    });
                    break;
                case 'terminate':
                    $customers = $customers->whereHas('terminate', function ($query) {
                        $query->whereNull('recontract_date')->whereNotNull('noc_confirmation');
                    });
                    break;
                case 'amendment':
                    $customers = $customers->whereHas('amend', function ($query) {
                        $query->where('cancel_status', '=', '0')->whereNotNull('noc_confirmation');
                    });
                    break;
                default:
                    $customers = $customers->where('noc_status', '=', '1')
                        ->where('active_status', '=', '0')
                        ->where('cancel_status', '=', '0')
                        ->where('suspend_status', '=', '0')
                        ->where('terminate_status', '=', '0');
                    break;
            }
        }

        if (request('insStart') && request('insEnd')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('actStart') && request('actEnd')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('cancelStart') && request('cancelEnd')) {
            $customers = $customers
                ->join('customers_cancel_info', 'customers.id', '=', 'customers_cancel_info.cu_id')
                ->whereDate('customers_cancel_info.cancel_date', '>=', request('cancelStart'))
                ->whereDate('customers_cancel_info.cancel_date', '<=', request('cancelEnd'))
                ->whereNotNull('customers_cancel_info.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('susStart') && request('susEnd')) {
            $customers = $customers
                ->join('customers_suspend_info', 'customers.id', '=', 'customers_suspend_info.cu_id')
                ->whereDate('customers_suspend_info.suspend_date', '>=', request('susStart'))
                ->whereDate('customers_suspend_info.suspend_date', '<=', request('susEnd'))
                ->whereNotNull('customers_suspend_info.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('terStart') && request('terEnd')) {
            $customers = $customers
                ->join('customers_terminate_info', 'customers.id', '=', 'customers_terminate_info.cu_id')
                ->whereDate('customers_terminate_info.termination_date', '>=', request('terStart'))
                ->whereDate('customers_terminate_info.termination_date', '<=', request('terEnd'))
                ->whereNotNull('customers_terminate_info.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('amendStart') && request('amendEnd')) {
            $customers = $customers
                ->join('customer_amend_info', 'customers.id', '=', 'customer_amend_info.cu_id')
                ->whereDate('customer_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('customer_amend_info.amend_date', '<=', request('amendEnd'))
                ->whereNotNull('customer_amend_info.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('cancelAmend') && request('cancelAmendEnd')) {
            $customers = $customers
                ->join('customers_amend_cancel', 'customers.id', '=', 'customers_amend_cancel.cu_id')
                ->whereDate('customers_amend_cancel.cancel_date', '>=', request('cancelAmend'))
                ->whereDate('customers_amend_cancel.cancel_date', '<=', request('cancelAmendEnd'))
                ->whereNotNull('customers_amend_cancel.noc_confirmation')
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('package_type')) {
            $customers = $customers->whereHas('sale', function ($query) {
                $query->whereHas('package', function ($query) {
                    $query->where('category_id', request('package_type'));
                });
            });
        }

        $customers = $customers->whereNull('deleted_at')
            ->paginate(request('per_page', 15))
            ->withQueryString();
        return view('dashboard.reports.installations', compact(['customers', 'isFilter']));
    }

    // Export the Total customers
    public function exportTotalCustomers(Request $request)
    {
        return Excel::download(new ExportTotalCustomer, 'total-customers-report.xlsx');
    }

    // return the customers page reports
    public function customers()
    {
        $customers = Customer::latest('customers.created_at');
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
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '=', request('ins'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('act')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '=', request('act'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('customers_noc_info', 'customers.id', '=', 'customers_noc_info.customer_id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('package_type')) {
            $customers = $customers->whereHas('sale', function ($query) {
                $query->whereHas('package', function ($query) {
                    $query->where('category_id', request('package_type'));
                });
            });
        }

        $customers = $customers
            ->whereNull('deleted_at')
            ->where('active_status', '=', '1')
            ->whereHas('noc')
            ->paginate(request('per_page', 15))
            ->withQueryString();
        return view('dashboard.reports.customers', compact(['customers', 'isFilter']));
    }

    // Export the Active customers
    public function exportActiveCustomers(Request $request)
    {
        return Excel::download(new ExportActiveCustomer, 'active-customers-report.xlsx');
    }

    // return the terminates page reports
    public function terminates()
    {
        $customers = Terminate::latest();
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
                ->join('customers', 'customers_terminate_info.cu_id', '=', 'customers.id')
                ->join('customers_noc_info', 'customers_noc_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_noc_info.activation_date', '=', request('activation'))
                ->select('customers_terminate_info.*', 'customers_terminate_info.customer_id');
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('activation')) {
            $customers = $customers
                ->join('customers', 'customers_terminate_info.cu_id', '=', 'customers.id')
                ->join('customers_noc_info', 'customers_noc_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customers_terminate_info.*', 'customers_terminate_info.customer_id');
            $isFilter = 'true';
        }

        if (request('terminate')) {
            $customers = $customers->whereDate('termination_date', '=', request('terminate'));
            $isFilter = 'true';
        }

        if ((request('terStart') && request('terEnd')) && !request('terminate')) {
            $customers = $customers->whereDate('termination_date', '>=', request('terStart'))
                ->whereDate('termination_date', '<=', request('terEnd'));
            $isFilter = 'true';
        }

        if (request('package_type')) {
            $customers = $customers->whereHas('customer', function ($query) {
                $query->whereHas('sale', function ($query) {
                    $query->whereHas('package', function ($query) {
                        $query->where('category_id', request('package_type'));
                    });
                });
            });
        }

        $customers = $customers->where('status', '=', 'terminate')
            ->whereNotNull('noc_confirmation')
            ->whereNull('recontract_date')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.terminates', compact(['customers', 'isFilter']));
    }

    // Export the Terminated customers
    public function exportTerminatedCustomers(Request $request)
    {
        return Excel::download(new ExportTerminatedCustomers, 'terminated-customers-report.xlsx');
    }

    // return the recontracted customers after termimation
    public function recontract()
    {
        $customers = Recontract::latest();
        $isFilter = 'false';

        if (request('id')) {
            $customers = $customers->where('customer_id', '=', request('id'));
            $isFilter = 'true';
        }

        if (request('name')) {
            $customers = $customers->where('full_name', 'like', '%' . request('name') . '%');
            $isFilter = 'true';
        }

        if (request('recontract')) {
            $customers = $customers->whereDate('recontract_date', '=', request('recontract'));
            $isFilter = 'true';
        }

        if ((request('recontractStart') && request('recontractEnd')) && !request('recontract')) {
            $customers = $customers->whereDate('recontract_date', '>=', request('recontractStart'))
                ->whereDate('recontract_date', '<=', request('recontractEnd'));
            $isFilter = 'true';
        }

        if (request('terminate')) {
            $customers = $customers->whereHas('terminate', function ($query) {
                $query->whereDate('termination_date', '=', request('terminate'));
            });
            $isFilter = 'true';
        }

        if ((request('terStart') && request('terEnd')) && !request('terminate')) {
            $customers = $customers->whereHas('terminate', function ($query) {
                $query->whereDate('termination_date', '>=', request('terStart'))
                    ->whereDate('termination_date', '<=', request('terEnd'));
            });
            $isFilter = 'true';
        }

        if (request('package_type')) {
            $customers = $customers->whereHas('customer', function ($query) {
                $query->whereHas('sale', function ($query) {
                    $query->whereHas('package', function ($query) {
                        $query->where('category_id', request('package_type'));
                    });
                });
            });
        }


        $customers = $customers->whereHas('customer', function ($query) {
            $query->whereNull('deleted_at');
        })->whereNotNull('noc_confirmation')
            ->where('status', '=', 'confirm')
            ->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.recontract', compact(['customers', 'isFilter']));
    }

    // Export the Recontracts customers
    public function exportRecontracts(Request $request)
    {
        return Excel::download(new ExportRecontracts, 'recontracts-report.xlsx');
    }

    // return the suspends page reports
    public function suspends()
    {
        $customers = Suspend::latest();
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
                ->join('customers', 'customers_suspend_info.cu_id', '=', 'customers.id')
                ->join('customers_noc_info', 'customers_noc_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_noc_info.activation_date', '=', request('act'))
                ->select('customers_suspend_info.*', 'customers_suspend_info.customer_id');
            $isFilter = 'true';
        }

        if ((request('suspendStart') && request('suspendEnd')) && !request('suspend')) {
            $customers = $customers->whereDate('suspend_date', '>=', request('suspendStart'))
                ->whereDate('suspend_date', '<=', request('suspendEnd'));
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('customers', 'customers_suspend_info.cu_id', '=', 'customers.id')
                ->join('customers_noc_info', 'customers_noc_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customers_suspend_info.*', 'customers_suspend_info.customer_id');
            $isFilter = 'true';
        }

        if (request('package_type')) {
            $customers = $customers->whereHas('customer', function ($query) {
                $query->whereHas('sale', function ($query) {
                    $query->whereHas('package', function ($query) {
                        $query->where('category_id', request('package_type'));
                    });
                });
            });
        }

        $customers = $customers->where('status', '=', 'suspend')
            ->whereNotNull('noc_confirmation')
            ->whereNull('reactivation_date')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.suspends', compact(['customers', 'isFilter']));
    }

    // Export the Suspends customers
    public function exportSuspends(Request $request)
    {
        return Excel::download(new ExportSuspends, 'suspends-report.xlsx');
    }

    // return the reactivate page reports
    public function reactivate()
    {
        $customers = Reactivate::latest();
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
            $customers = $customers->whereDate('reactivation_date', '=', request('act'));
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
            $customers = $customers->whereDate('reactivation_date', '>=', request('actStart'))
                ->whereDate('reactivation_date', '<=', request('actEnd'));
            $isFilter = 'true';
        }

        if (request('package_type')) {
            $customers = $customers->whereHas('customer', function ($query) {
                $query->whereHas('sale', function ($query) {
                    $query->whereHas('package', function ($query) {
                        $query->where('category_id', request('package_type'));
                    });
                });
            });
        }

        $customers = $customers->whereHas('customer', function ($query) {
            $query->whereNull('deleted_at');
        })->where('status', '=', 'confirm')
            ->whereNotNull("noc_confirmation")
            ->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.reactivate', compact(['customers', 'isFilter']));
    }

    // Export the reactivate customers
    public function exportReactivates(Request $request)
    {
        return Excel::download(new ExportReactivates, 'reactivates-report.xlsx');
    }

    // return the amendments page reports
    public function amendments()
    {
        $customers = Amend::latest();
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
                ->join('customers', 'customer_amend_info.cu_id', '=', 'customers.id')
                ->join('customers_noc_info', 'customers_noc_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_noc_info.activation_date', '=', request('act'))
                ->select('customer_amend_info.*', 'customer_amend_info.customer_id');
            $isFilter = 'true';
        }

        if ((request('amendStart') && request('amendEnd')) && !request('amend')) {
            $customers = $customers->whereDate('amend_date', '>=', request('amendStart'))
                ->whereDate('amend_date', '<=', request('amendEnd'));
            $isFilter = 'true';
        }

        if ((request('actStart') && request('actEnd')) && !request('act')) {
            $customers = $customers
                ->join('customers', 'customer_amend_info.cu_id', '=', 'customers.id')
                ->join('customers_noc_info', 'customers_noc_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_noc_info.activation_date', '>=', request('actStart'))
                ->whereDate('customers_noc_info.activation_date', '<=', request('actEnd'))
                ->select('customer_amend_info.*', 'customer_amend_info.customer_id');
            $isFilter = 'true';
        }

        if (request('package_type')) {
            $customers = $customers->whereHas('customer', function ($query) {
                $query->whereHas('sale', function ($query) {
                    $query->whereHas('package', function ($query) {
                        $query->where('category_id', request('package_type'));
                    });
                });
            });
        }


        $customers = $customers->whereHas('customer', function ($query) {
            $query->whereNull('deleted_at');
        })->where('cancel_status', '=', '0')
            ->whereNotNull('noc_confirmation')
            ->paginate(request('per_page', 15))
            ->withQueryString();
        return view('dashboard.reports.amendments', compact(['customers', 'isFilter']));
    }

    // Export the amendments customers
    public function exportAmendments(Request $request)
    {
        return Excel::download(new ExportAmendments, 'amendments-report.xlsx');
    }

    // return the cancel amendments to report page
    public function cancelAmendments()
    {
        $customers = CancelAmend::latest();
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
                ->join('customer_amend_info', 'customers_amend_cancel.amend_id', '=', 'customer_amend_info.id')
                ->whereDate('customer_amend_info.amend_date', '=', request('amend'))
                ->select('customers_amend_cancel.*');
            $isFilter = 'true';
        }

        if (request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '=', request('cancel'));
            $isFilter = 'true';
        }

        if ((request('amendStart') && request('amendEnd')) && !request('amend')) {
            $customers = $customers
                ->join('customer_amend_info', 'customers_amend_cancel.amend_id', '=', 'customer_amend_info.id')
                ->whereDate('customer_amend_info.amend_date', '>=', request('amendStart'))
                ->whereDate('customer_amend_info.amend_date', '<=', request('amendEnd'))
                ->select('customers_amend_cancel.*');
            $isFilter = 'true';
        }

        if ((request('cancel_date') && request('cancel_end')) && !request('cancel')) {
            $customers = $customers->whereDate('cancel_date', '>=', request('cancel_date'))
                ->whereDate('cancel_date', '<=', request('cancel_end'));
            $isFilter = 'true';
        }

        if (request('package_type')) {
            $customers = $customers->whereHas('customer', function ($query) {
                $query->whereHas('sale', function ($query) {
                    $query->whereHas('package', function ($query) {
                        $query->where('category_id', request('package_type'));
                    });
                });
            });
        }


        $customers = $customers->whereHas('customer', function ($query) {
            $query->whereNull('deleted_at');
        })->whereNotNull('noc_confirmation')
            ->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.cancelAmends', compact(['customers', 'isFilter']));
    }

    // Export the cancel amendments customers
    public function exportCancelAmendments(Request $request)
    {
        return Excel::download(new ExportCancelAmendments, 'cancel-amendments-report.xlsx');
    }


    // return the cancels page reports
    public function cancels()
    {
        $customers = Cancel::latest();
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
                ->join('customers', 'customers_cancel_info.cu_id', '=', 'customers.id')
                ->join('customers_sales_info', 'customers_sales_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_sales_info.installation_date', '=', request('ins'))
                ->select('customers_cancel_info.*', 'customers_cancel_info.customer_id');
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->join('customers', 'customers_cancel_info.cu_id', '=', 'customers.id')
                ->join('customers_sales_info', 'customers_sales_info.customer_id', '=', 'customers.id')
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->select('customers_cancel_info.*', 'customers_cancel_info.customer_id');

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

        if (request('package_type')) {
            $customers = $customers->whereHas('customer', function ($query) {
                $query->whereHas('sale', function ($query) {
                    $query->whereHas('package', function ($query) {
                        $query->where('category_id', request('package_type'));
                    });
                });
            });
        }


        $customers = $customers->whereNull('rollback_date')
            ->whereNotNull('noc_confirmation')
            ->whereHas('customer', function ($query) {
                $query->whereNull('deleted_at');
            })->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.cancels', compact(['customers', 'isFilter']));
    }

    // Export the cancels page  customers
    public function exportCancels(Request $request)
    {
        return Excel::download(new ExportCancels, 'cancels-report.xlsx');
    }


    // return the device type reports
    public function device()
    {

        $customers = Customer::latest('customers.created_at');
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
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '=', request('ins'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('receiver_type') && !request('router_type')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->where('customers_sales_info.receiver_type', 'like', '%' . request('receiver_type') . '%')
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (!request('receiver_type') && request('router_type')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->where('customers_sales_info.router_type', 'like', '%' . request('router_type') . '%')
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if (request('receiver_type') && request('router_type')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->where('customers_sales_info.receiver_type', 'like', '%' . request('receiver_type') . '%')
                ->where('customers_sales_info.router_type', 'like', '%' . request('router_type') . '%')
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        $customers = $customers
            ->whereNull('deleted_at')
            ->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.device', compact(['customers', 'isFilter']));
    }

    // Export the device type customers
    public function exportDevices(Request $request)
    {
        return Excel::download(new ExportDevices, 'devices-report.xlsx');
    }


    // return the customers via bases
    public function base()
    {
        $customers = Customer::latest('customers.created_at');
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
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '=', request('ins'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->select('customers.*', 'customers.customer_id');
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

        $branches  = Branch::all();
        $provinces = Province::all();
        $customers = $customers
            ->whereNull('deleted_at')
            ->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.base', compact(['customers', 'isFilter', 'branches', 'provinces']));
    }

    // Export the customers via bases
    public function exportBases(Request $request)
    {
        return Excel::download(new ExportBases, 'branchs-report.xlsx');
    }


    // return the packages
    public function package()
    {
        $customers = Customer::latest('customers.created_at');
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
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '=', request('ins'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        if ((request('insStart') && request('insEnd')) && !request('ins')) {
            $customers = $customers
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->whereDate('customers_sales_info.installation_date', '>=', request('insStart'))
                ->whereDate('customers_sales_info.installation_date', '<=', request('insEnd'))
                ->select('customers.*', 'customers.customer_id');
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
                ->join('customers_sales_info', 'customers.id', '=', 'customers_sales_info.customer_id')
                ->where('customers_sales_info.package_id', '=', request('package_id'))
                ->select('customers.*', 'customers.customer_id');
            $isFilter = 'true';
        }

        $customers = $customers
            ->whereHas('sale', function ($query) {
                $query->where('active_status', '=', '1')
                    ->orWhere('cancel_status', '=', '1')
                    ->orWhere('suspend_status', '=', '1')
                    ->orWhere('terminate_status', '=', '1');
            })
            ->whereNull('deleted_at')
            ->paginate(request('per_page', 15))
            ->withQueryString();

        return view('dashboard.reports.package', compact(['customers', 'isFilter']));
    }

    // Export the Packages customers
    public function exportPackages(Request $request)
    {
        return Excel::download(new ExportPackages, "packages-report.xlsx");
    }
}
