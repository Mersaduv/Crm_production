<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <!--<a href="index.html" class="logo"><i class="mdi mdi-assistant"></i> Zoter</a>-->
            <a href="{{ route('dashboard') }}" class="logo">
                <img src="{{ asset('/public/assets/images/logo.png') }}" alt="" class="logo-large"
                    style="filter: invert(1)">
            </a>
        </div>
    </div>

    <div class="sidebar-inner niceScrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span> Dashboard</span>
                    </a>
                </li>

                <!-- ========== Manager ========== -->


                @if (auth()->user()->role == 'admin')

                @can('viewAny', UserFullyQualifiedNameSpace())
                <li>
                    <a href="{{ route('users') }}" class="waves-effect">
                        <i class="mdi mdi-account-settings-variant"></i>
                        <span> Users </span>
                    </a>
                </li>
                @endcan

                @if (hasAnyReadPermission(['customers','terminate','suspend','amendment','cancel']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i>
                        <span> Customers </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',CustomerFullyQualifiedNameSpace())
                        <li><a href="{{ route('admin.customers') }}">Customers</a></li>
                        @endcan
                        <li><a href="{{ route('admin.map') }}">Map</a></li>
                        @can('viewAny',TerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('admin.customers.terminates') }}">
                                Terminates
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',SuspendFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('admin.suspends') }}">
                                Suspends
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',AmendmentFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('admin.amedment') }}">Amendments</a>
                        </li>
                        @endcan
                        @can('viewAny',CancelFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('cancels.index') }}">
                                Cancels
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if(
                hasAnyReadPermission(
                [
                'provincial',
                'provincial-terminate',
                'provincial-suspend',
                'provincial-amendment',
                'provincial-cancel'
                ])
                )
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i>
                        <span> Provincial </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('admin.provincial') }}">
                                Customers
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialTerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('admin.terminates') }}">
                                Terminates
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialSuspendFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('admin.pr.suspends') }}">
                                Suspends
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialAmendmentFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('admin.amends') }}">
                                Amendments
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialCancelFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('prCancels.index') }}">
                                Cancels
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @can('viewAny', CommissionFullyQualifiedNameSpace())
                <li>
                    <a href="{{ route('commission.index') }}" class="waves-effect">
                        <i class="mdi mdi-account-convert"></i>
                        <span> Resellers </span>
                    </a>
                </li>
                @endcan

                @can('viewAny', MarketerFullyQualifiedNameSpace())
                <li>
                    <a href="{{ route('marketers.index') }}" class="waves-effect">
                        <i class="mdi mdi-account-convert"></i>
                        <span> Field Officers </span>
                    </a>
                </li>
                @endcan

                @if(
                hasAnyTimeLinePermission(
                [
                'customers',
                'provincial'
                ])
                )
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-chart-line"></i>
                        <span> Timeline </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('timeLine',CustomerFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('timeline.index') }}">
                                Customers
                            </a>
                        </li>
                        @endcan
                        @can('timeLine',ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('contractorsTimeline.index') }}">
                                Provincials
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @can('viewAny',PackageFullyQualifiedNameSpace())
                <li>
                    <a href="{{ route('packages.index') }}" class="waves-effect">
                        <i class="mdi mdi-briefcase"></i>
                        <span> Packages </span>
                    </a>
                </li>
                @endcan

                @if (hasSectionPermission(auth()->user(),'province','read') ||
                hasSectionPermission(auth()->user(),'branch','read'))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-animation"></i>
                        <span> Branches </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',ProvinceFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('province.index') }}">Provinces</a>
                        </li>
                        @endcan
                        @can('viewAny',BranchFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('branch.index') }}">Branches</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @can('viewAny',CategoryFullyQualifiedNameSpace())
                <li>
                    <a href="{{ route('categories.index') }}" class="waves-effect">
                        <i class="mdi mdi-animation"></i>
                        <span> Categories </span>
                    </a>
                </li>
                @endcan

                @if (hasAnyReadPermission(['terminate','provincial-terminate']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-send"></i>
                        <span> Requests </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',TerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('getRequests') }}" class="waves-effect">
                                <span>Customer Terminate </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialTerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('man.pr.requests') }}" class="waves-effect">
                                <span>Provincial Terminate </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (hasAnyReadPermission(['customers','provincial']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="fas fa-file-signature"></i>
                        <span> Reports </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',CustomerFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('reports.index') }}" class="waves-effect">
                                <span>Customers</span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('outsource.reports.index') }}" class="waves-effect">
                                <span>Provincial</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                <li>
                    <a href="{{ route('permissions.index') }}">
                        <i class="mdi mdi-lock"></i>
                        <span> Permissions </span>
                    </a>
                </li>

                @endif
                <!-- ========== Sales ========== -->
                @if (auth()->user()->role == 'sales')

                @if (hasAnyReadPermission(['customers','terminate','suspend','amendment','cancel']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i>
                        <span> Customers</span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',CustomerFullyQualifiedNameSpace())
                        <li><a href="{{ route('customers.index') }}">Customers</a></li>
                        @endcan
                        @can('viewAny',TerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('customers.terminated.list') }}">
                                Terminates
                                <span class="badge badge-info">
                                    {{ terminates('sales_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',SuspendFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('customers.suspend.list') }}">
                                Suspends
                                <span class="badge badge-info">
                                    {{ suspends('sales_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',AmendmentFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('customer.ameds') }}">
                                Amendments
                                <span class="badge badge-info">
                                    {{ amends('sales_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',CancelFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('cancels.index') }}">
                                Cancels
                                <span class="badge badge-info">
                                    {{ cancels('sales_confirmation') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if(
                hasAnyReadPermission(
                [
                'provincial',
                'provincial-terminate',
                'provincial-suspend',
                'provincial-amendment',
                'provincial-cancel'
                ])
                )
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i>
                        <span> Provincials </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('provincial.index') }}">
                                Customers
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialTerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.terminates') }}">
                                Terminates
                                <span class="badge badge-info">
                                    {{ PrTerminate('sales_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialSuspendFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.suspends') }}">
                                Suspends
                                <span class="badge badge-info">
                                    {{ PrSuspend('sales_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialAmendmentFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.amendments') }}">
                                Amendments
                                <span class="badge badge-info">
                                    {{ PrAmend('sales_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialCancelFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('prCancels.index') }}">
                                Cancels
                                <span class="badge badge-info">
                                    {{ PrCancel('sales_confirmation') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (hasSectionPermission(auth()->user(),'customers','time-line') ||
                hasSectionPermission(auth()->user(),'provincial','time-line'))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-chart-line"></i>
                        <span> Timeline </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('timeLine',CustomerFullyQualifiedNameSpace())
                        <li><a href="{{ route('timeline.index') }}">Customers</a></li>
                        @endcan
                        @can('timeLine', ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('contractorsTimeline.index') }}">
                                Provincials
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @can('viewAny',PackageFullyQualifiedNameSpace())
                <li>
                    <a href="{{ route('customers.packages') }}" class="waves-effect">
                        <i class="mdi mdi-briefcase"></i>
                        <span> Packages </span>
                    </a>
                </li>
                @endcan

                @if (hasAnyReadPermission(['terminate','provincial-terminate']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-send"></i>
                        <span> Requests </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',TerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('getRequests') }}" class="waves-effect">
                                <span>Customers Terminate</span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialTerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('PrRequests.index') }}" class="waves-effect">
                                <span>Provincials Terminate</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @endif


                <!-- ========== NOC ========== -->
                @if (auth()->user()->role == 'noc')

                @if (hasAnyReadPermission(['installation','terminate','suspend','amendment','cancel']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i>
                        <span> Customers </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',NocFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('installation.index') }}">Customers</a>
                        </li>
                        @endcan
                        @can('viewAny',TerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('installation.terminates') }}">
                                Terminates
                                <span class="badge badge-info">
                                    {{ terminates('noc_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',SuspendFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('noc.suspends') }}">
                                Suspends
                                <span class="badge badge-info">
                                    {{ suspends('noc_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',AmendmentFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('noc.amedment') }}">
                                Amendments
                                <span class="badge badge-info">
                                    {{ amends('noc_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',CancelFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('cancels.index') }}">
                                Cancels
                                <span class="badge badge-info">
                                    {{ cancels('noc_confirmation') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',NocFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('noc.requests') }}">
                                Requests
                                <span class="badge badge-info">
                                    {{ requests('noc') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if(
                hasAnyReadPermission(
                [
                'provincial-installation',
                'provincial-terminate',
                'provincial-suspend',
                'provincial-amendment',
                'provincial-cancel'
                ])
                )
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i>
                        <span> Provincials </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',ProvincialNocFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('prCustomers.index') }}">
                                Customers
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialTerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.noc.terminates') }}">
                                Terminates
                                <span class="badge badge-info">
                                    {{ PrTerminate('noc_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialSuspendFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.noc.suspends') }}">
                                Suspends
                                <span class="badge badge-info">
                                    {{ PrSuspend('noc_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialAmendmentFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.noc.amendments') }}">
                                Amendments
                                <span class="badge badge-info">
                                    {{ PrAmend('noc_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialCancelFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('prCancels.index') }}">
                                Cancels
                                <span class="badge badge-info">
                                    {{ PrCancel('noc_confirmation') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialNocFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.noc.requests') }}">
                                Requests
                                <span class="badge badge-info">
                                    {{ prRequests('noc') }}
                                </span>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li>
                @endif

                @if (hasSectionPermission(auth()->user(),'customers','time-line') ||
                hasSectionPermission(auth()->user(),'provincial','time-line'))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-chart-line"></i>
                        <span> Timeline </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('timeLine',CustomerFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('timeline.index') }}">Customers</a>
                        </li>
                        @endcan
                        @can('timeLine', ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('contractorsTimeline.index') }}">
                                Provincials
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (hasAnyReadPermission(['terminate','provincial-terminate']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-send"></i>
                        <span> Requests </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',TerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('NocRequests.index') }}">
                                Customers Terminate
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialTerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('prRequests.index') }}">
                                Provincials Terminate
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @endif

                <!-- ========== Finance ========== -->
                @if (auth()->user()->role == 'finance')

                @if (hasAnyReadPermission(['customers','terminate','suspend','amendment','cancel']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i>
                        <span> Customers </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',CustomerFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('finance.index') }}">Customers</a>
                        </li>
                        @endcan
                        @can('viewAny',TerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('finance.terminated') }}">
                                Terminates
                                <span class="badge badge-info">
                                    {{ terminates('finance_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',SuspendFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('finance.suspends') }}">
                                Suspends
                                <span class="badge badge-info">
                                    {{ suspends('finance_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',AmendmentFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('finance.amedment') }}">
                                Amendments
                                <span class="badge badge-info">
                                    {{ amends('finance_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',CancelFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('cancels.index') }}">
                                Cancels
                                <span class="badge badge-info">
                                    {{ cancels('finance_confirmation') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',CustomerFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('finance.requests') }}">
                                Requests
                                <span class="badge badge-info">
                                    {{ requests('finance') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if(
                hasAnyReadPermission(
                [
                'provincial',
                'provincial-terminate',
                'provincial-suspend',
                'provincial-amendment',
                'provincial-cancel'
                ])
                )
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-account-multiple-plus"></i>
                        <span> Provincials </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('prc.index') }}">
                                Customers
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialTerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.fin.terminates') }}">
                                Terminates
                                <span class="badge badge-info">
                                    {{ PrTerminate('finance_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialSuspendFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.fin.suspends') }}">
                                Suspends
                                <span class="badge badge-info">
                                    {{ PrSuspend('finance_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialAmendmentFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.fin.amends') }}">
                                Amendments
                                <span class="badge badge-info">
                                    {{ PrAmend('finance_confirmation')['total'] }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialCancelFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('prCancels.index') }}">
                                Cancels
                                <span class="badge badge-info">
                                    {{ PrCancel('finance_confirmation') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('pr.fin.requests') }}">
                                Requests
                                <span class="badge badge-info">
                                    {{ prRequests('finance') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (hasSectionPermission(auth()->user(),'customers','time-line') ||
                hasSectionPermission(auth()->user(),'provincial','time-line'))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-chart-line"></i>
                        <span> Timeline </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('timeLine',CustomerFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('timeline.index') }}">Customers</a>
                        </li>
                        @endcan
                        @can('timeLine', ProvincialFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('contractorsTimeline.index') }}">
                                Provincials
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (hasAnyReadPermission(['terminate','provincial-terminate']))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect">
                        <i class="mdi mdi-send"></i>
                        <span> Requests </span>
                        <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                    </a>
                    <ul class="list-unstyled">
                        @can('viewAny',TerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('requests.index') }}">
                                Customers Terminate
                            </a>
                        </li>
                        @endcan
                        @can('viewAny',ProvincialTerminateFullyQualifiedNameSpace())
                        <li>
                            <a href="{{ route('trRequests.index') }}">
                                Provincials Terminate
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @endif

            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->