<?php

use App\Models\Customer;
use App\Models\Province;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Suspend;
use App\Models\Cancel;
use App\Models\Amend;
use App\Models\PrAmend;
use App\Models\Terminate;
use App\Models\User;
use App\Models\Package;
use App\Models\Commission;
use App\Models\Marketer;
use App\Models\Permission;
use App\Models\Sale;
use App\Models\Provincial;
use App\Models\RequestTerminate;
use App\Models\PrTerminateRequest;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/*
	|--------------------------------------------------------------------------
	| Breadcrumb routes
	|--------------------------------------------------------------------------
	|
	| Here is routes for custom breadcrumbs used in project.
	| The breadcrumb packages is: diglactic/laravel-breadcrumbs
	|
	*/

// Breadcrumbs routes for Management Dashboard

// Home
Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});

// Home > Customers
Breadcrumbs::for('customers', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers', route('admin.customers'));
});

// Home > Customers > Customer Name
Breadcrumbs::for('customer', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('customers');
    $trail->push($customer->full_name, route('admin.customer', $customer));
});

// Home >  Cancels Customers
Breadcrumbs::for('dashboard.cancel', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Cancels', route('cancels.index'));
});

// Home >  Cancels Customers > Customer Name
Breadcrumbs::for('dashboard.cancel.show', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('dashboard.cancel');
    $trail->push($customer->full_name, route('cancels.show', $customer));
});

// Home >  Cancels Customers > Customer Name > Details
Breadcrumbs::for('dashboard.cancel.details', function (BreadcrumbTrail $trail, Cancel $cancel) {
    $trail->parent('dashboard.cancel.show', $cancel->customer);
    $trail->push("Cancel Details", route('cancel.details', $cancel));
});

// Home > Customers > Customer Name > Attachments
Breadcrumbs::for('attachments', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('customer', $customer);
    $trail->push("Attachments", route('admin.files', $customer));
});

// Home > Terminates
Breadcrumbs::for('terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Terminates', route('admin.customers.terminates'));
});

// Home > Terminates > name
Breadcrumbs::for('terminate', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('terminates');
    $trail->push($customer->full_name, route('admin.terminate', $customer));
});

// Home > Terminates > Terminate > Details
Breadcrumbs::for('terminate.details', function (BreadcrumbTrail $trail, Terminate $terminate) {
    $trail->parent('terminate', $terminate->customer);
    $trail->push("Terminate Details", route('admin.terminate.details', $terminate));
});

// Home > Suspends
Breadcrumbs::for('suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Suspends', route('admin.suspends'));
});

// Home > Suspends > Name
Breadcrumbs::for('suspend', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('suspends');
    $trail->push($customer->full_name, route('admin.singleSuspend', $customer));
});

// Home > Suspends > Name
Breadcrumbs::for('suspend.detail', function (BreadcrumbTrail $trail, Suspend $suspend) {
    $trail->parent('suspend', $suspend->customer);
    $trail->push("Suspend Details", route('admin.suspend.details', $suspend));
});

// Home > Amedments
Breadcrumbs::for('amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Amendments', route('admin.amedment'));
});

// Home > Amedments
Breadcrumbs::for('cancels.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Canceled Amendments', route('cancels.amendments.mr'));
});

// Home > Amedment
Breadcrumbs::for('manager.amed', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('amendments');
    $trail->push($customer->full_name, route('admin.amend', $customer));
});

// Home > Amedment
Breadcrumbs::for('manager.cancel.amed', function (BreadcrumbTrail $trail, Amend $amend) {
    $trail->parent('cancels.amendments');
    $trail->push($amend->full_name, route('cancel.amendment.mr', $amend));
});

// Home > Amedment > Details
Breadcrumbs::for('manager.amed.details', function (BreadcrumbTrail $trail, Amend $amend) {
    $trail->parent('manager.amed', $amend->customer);
    $trail->push("Amendment Details", route('admin.amendment.details', $amend));
});

// Home > Users
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Users', route('users'));
});

// Home > Trashed Users
Breadcrumbs::for('trashed', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Trashed', route('user.trashed'));
});

// Home > Add New User
Breadcrumbs::for('create-user', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Add New', route('users.create'));
});

// Home > Users > User Name
Breadcrumbs::for('user', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push($user->name);
    $trail->push("Permissions");
});

// Home > Users > User Name > Edit
Breadcrumbs::for('edit-user', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('users');
    $trail->push($user->name, route('users.edit', $user));
});


// Home > Users > User Name
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('index');
    $trail->push($user->name);
    $trail->push("Profile");
});

// Home > Packages
Breadcrumbs::for('packages', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Packages', route('packages.index'));
});


// Home > Add package
Breadcrumbs::for('packages.add', function (BreadcrumbTrail $trail) {
    $trail->parent('packages');
    $trail->push('Add Package', route('packages.create'));
});

// Home > Trashed Packages
Breadcrumbs::for('packages.trashed', function (BreadcrumbTrail $trail) {
    $trail->parent('packages');
    $trail->push('Trashed', route('packages.trashed'));
});

// Home > Packages > Packages Name > Edit
Breadcrumbs::for('packages.edit', function (BreadcrumbTrail $trail, Package $package) {
    $trail->parent('packages');
    $trail->push($package->name, route('packages.edit', $package));
});

// Home > Categories
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Categories', route('admin.categories'));
});

// Home > Requests
Breadcrumbs::for('requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Requests', route('getRequests'));
    $trail->push('Customers');
});

// Home > Requests > Request Status
Breadcrumbs::for('request', function (BreadcrumbTrail $trail, RequestTerminate $request) {
    $trail->parent('requests');
    $trail->push($request->status, route('getRequest', $request));
});

// Home > Timeline
Breadcrumbs::for('timeline', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Timeline");
    $trail->push("Customers", route('timeline.index'));
});

// Home > Timeline > Customer Name
Breadcrumbs::for('timeline.show', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('timeline');
    $trail->push($customer->full_name, route('timeline.show', $customer));
});

// Home > Timeline
Breadcrumbs::for('contractors', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Provincials");
    $trail->push("Timeline", route('contractorsTimeline.index'));
});

// Home > Timeline > Customer Name
Breadcrumbs::for('contractors.show', function (BreadcrumbTrail $trail, Provincial $customer) {
    $trail->parent('contractors');
    $trail->push($customer->full_name, route('contractorsTimeline.show', $customer));
});

// Home > Resellers
Breadcrumbs::for('resellers', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Resellers", route('commission.index'));
});

// Home > Resellers
Breadcrumbs::for('resellers.edit', function (BreadcrumbTrail $trail, Commission $com) {
    $trail->parent('resellers');
    $trail->push($com->name, route('commission.edit', $com));
});

// Home > Resellers
Breadcrumbs::for('resellers.add', function (BreadcrumbTrail $trail) {
    $trail->parent('resellers');
    $trail->push("Add New", route('commission.create'));
});

// Home > Resellers
Breadcrumbs::for('resellers.trashed', function (BreadcrumbTrail $trail) {
    $trail->parent('resellers');
    $trail->push("Trashed", route('commission.create'));
});



// Home > Field Officer
Breadcrumbs::for('marketers', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Field Officers", route('marketers.index'));
});

// Home > Field Officer > name
Breadcrumbs::for('marketers.edit', function (BreadcrumbTrail $trail, Marketer $marketer) {
    $trail->parent('marketers');
    $trail->push($marketer->name, route('marketers.edit', $marketer));
});

// Home > Field Officer > Add New
Breadcrumbs::for('marketers.add', function (BreadcrumbTrail $trail) {
    $trail->parent('marketers');
    $trail->push("Add New", route('marketers.create'));
});

// Home > Field Officer > Trashed
Breadcrumbs::for('marketers.trashed', function (BreadcrumbTrail $trail) {
    $trail->parent('marketers');
    $trail->push("Trashed", route('marketers.trashed'));
});


// Home > Reports > Customers
Breadcrumbs::for('reports.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Reports", route('reports.index'));
    $trail->push("Customers");
});

// Home > Reports > OutSource Reports
Breadcrumbs::for('outsource.reports.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Reports", route('outsource.reports.index'));
    $trail->push("Provincial");
});

// Home > Reports > Total Customers
Breadcrumbs::for('reports.installation', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Total Customers", route('reports.installation'));
});

// Home > Reports > OutSource Total Customers
Breadcrumbs::for('outsource.reports.installation', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Total Customers", route('outsource.reports.installation'));
});

// Home > Reports > Customers > Actived Customers
Breadcrumbs::for('reports.customers', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Actived Customers", route('reports.customers'));
});

// Home > Reports > OutSource Customers
Breadcrumbs::for('outsource.reports.customers', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Customers", route('outsource.reports.customers'));
});

// Home > Reports > Customers > Terminations
Breadcrumbs::for('reports.terminations', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Terminations", route('reports.terminates'));
});

// Home > Reports > Customers > Recontractions
Breadcrumbs::for('reports.recontract', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Recontractions", route('reports.recontract'));
});

// Home > Reports > OutSource Terminations
Breadcrumbs::for('outsource.reports.terminations', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Terminations", route('outsource.reports.terminates'));
});

// Home > Reports > OutSource Recontraction
Breadcrumbs::for('outsource.reports.recontract', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Recontraction", route('outsource.reports.recontract'));
});

// Home > Reports > Customers >  Amendments
Breadcrumbs::for('reports.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Amendments", route('reports.amendments'));
});

// Home > Reports > Customers >  Cancel Amendments
Breadcrumbs::for('reports.cancel.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Cancels Amendments", route('reports.cancel.amendments'));
});

// Home > Reports > OutSource Amendments
Breadcrumbs::for('outsource.reports.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Amendments", route('outsource.reports.amendments'));
});

// Home > Reports > OutSource Amendments
Breadcrumbs::for('outsource.reports.cancelAmendments', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Cancels Amendments", route('outsource.reports.cancelAmendments'));
});

// Home > Reports > Customers > Suspends
Breadcrumbs::for('reports.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Suspends", route('reports.suspends'));
});

// Home > Reports > Customers >  Reactivate
Breadcrumbs::for('reports.reactivate', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Reactivate", route('reports.reactivate'));
});

// Home > Reports > Customers >  Device types
Breadcrumbs::for('reports.device', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Device Type", route('reports.device'));
});

// Home > Reports > Customers > Branch types
Breadcrumbs::for('reports.base', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Branch Reports", route('reports.base'));
});

// Home > Reports > Customers > Package types
Breadcrumbs::for('reports.package', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Package Reports", route('reports.package'));
});

// Home > Reports > OutSource Suspends
Breadcrumbs::for('outsource.reports.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Suspends", route('outsource.reports.suspends'));
});

// Home > Reports > OutSource Reactivate
Breadcrumbs::for('outsource.reports.reactivate', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Reactivates", route('outsource.reports.reactivate'));
});

// Home > Reports > Customers > Cancels
Breadcrumbs::for('reports.cancels', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Cancels", route('reports.cancels'));
});

// Home > Reports > OutSource Cancels
Breadcrumbs::for('outsource.reports.cancels', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Cancels", route('outsource.reports.cancels'));
});

// Home > Reports > OutSource Branches
Breadcrumbs::for('outsource.reports.base', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Branch Reports", route('outsource.reports.base'));
});

// Home > Reports > OutSource Packages
Breadcrumbs::for('outsource.reports.package', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Package Reports", route('outsource.reports.package'));
});

// Home > Reports > OutSource Resellers
Breadcrumbs::for('outsource.reports.resellers', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Resellers Reports", route('outsource.reports.resellers'));
});

// Home > Reports > Customers > Total Customers
Breadcrumbs::for('charts.customers', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Total Customers", route('charts.customers'));
});

// Home > Reports > Customers >  Device Types
Breadcrumbs::for('charts.device', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Device Types Reports", route('charts.device'));
});

// Home > Reports > Customers >  Branch Types
Breadcrumbs::for('charts.branch', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Branch Types Reports", route('charts.branch'));
});

// Home > Reports > Customers > Package Types
Breadcrumbs::for('charts.package', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Package Types Reports", route('charts.package'));
});

Breadcrumbs::for('outsource.charts.customers', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Total Customers", route('outsource.charts.customers'));
});

Breadcrumbs::for('outsource.charts.resellers', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Resellers", route('outsource.charts.resellers'));
});

Breadcrumbs::for('outsource.charts.package', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Package Types", route('outsource.charts.package'));
});

Breadcrumbs::for('outsource.charts.branch', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Branch Types", route('outsource.charts.branch'));
});

// Home > Reports > Customers > Activated Customers
Breadcrumbs::for('charts.activated', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Activated Customers", route('charts.activated'));
});

Breadcrumbs::for('outsource.charts.activated', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Activated Customers", route('outsource.charts.activated'));
});

// Home > Reports > Customers > Terminates Customers
Breadcrumbs::for('charts.terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Terminates Customers", route('charts.terminates'));
});

// Home > Reports > Customers > Recontract Customers
Breadcrumbs::for('charts.recontract', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Recontracted Customers", route('charts.recontract'));
});

// Home > Reports > outsource terminates Customers
Breadcrumbs::for('outsource.charts.terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Terminates Customers", route('outsource.charts.terminates'));
});

// Home > Reports > outsource Recontract Customers
Breadcrumbs::for('outsource.charts.recontract', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Recontract Customers", route('outsource.charts.recontract'));
});

// Home > Reports > Customers > Suspends Customers
Breadcrumbs::for('charts.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Suspends Customers", route('charts.suspends'));
});

// Home > Reports > Customers > Reactivate Customers
Breadcrumbs::for('charts.reactivate', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Reactivate Customers", route('charts.reactivate'));
});

Breadcrumbs::for('outsource.charts.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Suspends Customers", route('outsource.charts.suspends'));
});

Breadcrumbs::for('outsource.charts.reactivate', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Reactivate Customers", route('outsource.charts.reactivate'));
});

// Home > Reports > Customers > Amendments Customers
Breadcrumbs::for('charts.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Amendments Customers", route('charts.amendments'));
});

// Home > Reports > Customers >  Amendments Customers
Breadcrumbs::for('charts.cancels.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Cancels Amendments", route('charts.cancels.amendments'));
});

Breadcrumbs::for('outsource.charts.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Amendments Customers", route('outsource.charts.amendments'));
});

Breadcrumbs::for('outsource.charts.cancelAmendments', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Cancels Amendments", route('outsource.charts.cancelAmendments'));
});

// Home > Reports > Customers > Cancels Customers
Breadcrumbs::for('charts.cancels', function (BreadcrumbTrail $trail) {
    $trail->parent('reports.index');
    $trail->push("Cancels Customers", route('charts.cancels'));
});

Breadcrumbs::for('outsource.charts.cancels', function (BreadcrumbTrail $trail) {
    $trail->parent('outsource.reports.index');
    $trail->push("Cancels Customers", route('outsource.charts.cancels'));
});

Breadcrumbs::for('province.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Provinces", route('province.index'));
});

Breadcrumbs::for('province.create', function (BreadcrumbTrail $trail) {
    $trail->parent('province.index');
    $trail->push("Add New", route('province.create'));
});

Breadcrumbs::for('province.edit', function (BreadcrumbTrail $trail, Province $province) {
    $trail->parent('province.index');
    $trail->push($province->name, route('province.edit', $province));
});

Breadcrumbs::for('province.trashed', function (BreadcrumbTrail $trail) {
    $trail->parent('province.index');
    $trail->push("Trashed", route('province.trashed'));
});


Breadcrumbs::for('branch.index', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Branches", route('branch.index'));
});

Breadcrumbs::for('branch.create', function (BreadcrumbTrail $trail) {
    $trail->parent('branch.index');
    $trail->push("Add New", route('branch.create'));
});

Breadcrumbs::for('branch.edit', function (BreadcrumbTrail $trail, Branch $branch) {
    $trail->parent('branch.index');
    $trail->push($branch->name, route('branch.edit', $branch));
});

Breadcrumbs::for('branch.trashed', function (BreadcrumbTrail $trail) {
    $trail->parent('branch.index');
    $trail->push("Trashed", route('branch.trashed'));
});

// -------------------------------------------------------------------------------//
// -------------------------------------------------------------------------------//

// Breadcrumbs routes for Sales Dashboard

// Home > Sales Customers
Breadcrumbs::for('salesCustomers', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers', route('customers.index'));
});

// Home > Sales Customers > Customer Name
Breadcrumbs::for('salesCustomer', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('salesCustomers');
    $trail->push($customer->full_name, route('customers.show', $customer));
});

// Home > Sales >Terminated Customers
Breadcrumbs::for('salesTerminates', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Terminates', route('customers.terminated.list'));
});

// Home > Sales >Terminated Customers > Customer
Breadcrumbs::for('singleTerminate', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('salesTerminates');
    $trail->push($customer->full_name, route('singleTerminate', $customer));
});

// Home > Sales >Terminated Customers > Customer
Breadcrumbs::for('sales.terminate.details', function (BreadcrumbTrail $trail, Terminate $terminate) {
    $trail->parent('singleTerminate', $terminate->customer);
    $trail->push("Terminate Details", route('terminate.details', $terminate));
});

// Home > Sales > Suspended Customers
Breadcrumbs::for('salesSuspends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Suspends', route('customers.suspend.list'));
});

// Home > Sales > Suspended Customers > Customer
Breadcrumbs::for('salesSuspend', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('salesSuspends');
    $trail->push($customer->full_name, route('suspends.suspend', $customer));
});

// Home > Sales > Suspended Customers > Customer
Breadcrumbs::for('sales.suspend.details', function (BreadcrumbTrail $trail, Suspend $suspend) {
    $trail->parent('salesSuspend', $suspend->customer);
    $trail->push("Suspend Details", route('suspend.details', $suspend));
});

// Home > Sales > Cancels Customers
Breadcrumbs::for('sales.cancel', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Cancels', route('cancels.index'));
});

// Home > Sales > Cancels Customers > Cancel name
Breadcrumbs::for('sales.cancel.show', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('sales.cancel');
    $trail->push($customer->full_name, route('cancels.show', $customer));
});

// Home > Sales > Cancels Customers > Cancel name
Breadcrumbs::for('sales.cancel.detail', function (BreadcrumbTrail $trail, Cancel $cancel) {
    $trail->parent('sales.cancel.show', $cancel->customer);
    $trail->push("Cancel Details", route('cancel.details', $cancel));
});

// Home > Suspends > Customer Name > Activate
Breadcrumbs::for('salesCustomerActivate', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('salesSuspends');
    $trail->push($customer->full_name);
    $trail->push('Activate', route('customer.activate.form', $customer));
});

// Home > Sales Trashed Customers
Breadcrumbs::for('salesTrashed', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Trashed Customers', route('customers.trashed'));
});

// Home > Add New Customer
Breadcrumbs::for('salesAddCustomer', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Add Customer', route('customers.create'));
});

// Home > Customer Name > Attachments
Breadcrumbs::for('salesAttachments', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('salesCustomers');
    $trail->push($customer->full_name, route('customers.show', $customer));
    $trail->push('Attachments');
});

// Home > Customer Name > Edit
Breadcrumbs::for('salesCustomerEdit', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('salesCustomer', $customer);
    $trail->push('Edit', route('customers.edit', $customer));
});

// Home > Customer Name > Amedment
Breadcrumbs::for('salesCustomerAmedment', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('salesCustomer', $customer);
    $trail->push('Amedment', route('customer.amedment', $customer));
});

// Home > Customer Name > Contract Form
Breadcrumbs::for('salesCustomerContract', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('salesCustomer', $customer);
    $trail->push('Re-Contract', route('customer.contractForm', $customer));
});

// Home > Categories
Breadcrumbs::for('salesCategories', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Categories', route('categories.index'));
});

// Home > Categories
Breadcrumbs::for('salesCategoryEdit', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('salesCategories');
    $trail->push($category->name, route('categories.edit', $category));
});

// Home > Trashed Categories
Breadcrumbs::for('salesTrashedCategories', function (BreadcrumbTrail $trail) {
    $trail->parent('salesCategories');
    $trail->push('Trashed', route('categories.trashed'));
});

// Home > Add Category
Breadcrumbs::for('salesAddCategory', function (BreadcrumbTrail $trail) {
    $trail->parent('salesCategories');
    $trail->push('Add New', route('categories.create'));
});

// Home > Requests
Breadcrumbs::for('salesRequests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Requests', route('getRequests'));
});

// Home > Requests > Request Status
Breadcrumbs::for('salesRequest', function (BreadcrumbTrail $trail, RequestTerminate $request) {
    $trail->parent('salesRequests');
    $trail->push($request->status, route('getRequest', $request->id));
});

// Home > Amendments
Breadcrumbs::for('sales.customers.amends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Customers");
    $trail->push("Amendments", route('customer.ameds'));
});

// Home > Cancel Amendments
Breadcrumbs::for('sales.customers.cancels.amends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Canceled Amendments", route('customers.ameds.cancels'));
});

// Home > Amendments > Name
Breadcrumbs::for('sales.customers.amend', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('sales.customers.amends');
    $trail->push($customer->full_name, route('amedment.amend', $customer));
});

// Home > Canceled Amendments > Name
Breadcrumbs::for('sales.customers.cancel.amend', function (BreadcrumbTrail $trail, Amend $amend) {
    $trail->parent('sales.customers.cancels.amends');
    $trail->push($amend->full_name, route('customers.amed.cancel', $amend));
});

// Home > Amendments > Name > Details
Breadcrumbs::for('sales.amend.details', function (BreadcrumbTrail $trail, Amend $amend) {
    $trail->parent('sales.customers.amend', $amend->customer);
    $trail->push("Amendment Details", route('amedment.amend', $amend));
});

// Home > Packages
Breadcrumbs::for('sales.packages', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Packages", route('customers.packages'));
});

// Home > Packages
Breadcrumbs::for('sales.package', function (BreadcrumbTrail $trail, Package $package) {
    $trail->parent('sales.packages');
    $trail->push($package->name, route('customers.package', $package));
});

// Home > Resellers
Breadcrumbs::for('sales.resellers', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Resellers", route('sales.resellers'));
});

// -------------------------------------------------------------------------------//
// -------------------------------------------------------------------------------//

// Breadcrumbs routes for Finance Dashboard

// Home > Customers
Breadcrumbs::for('finance', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers', route('finance.index'));
});

// Home > Customers > Customer Name
Breadcrumbs::for('finance.show', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('finance');
    $trail->push($customer->full_name, route('finance.show', $customer));
});

// Home > Customers > Customer Name > Attachements
Breadcrumbs::for('finance.attachments', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('finance.show', $customer);
    $trail->push('Attachments', route('finance.files', $customer));
});

// Home > Terminates
Breadcrumbs::for('finance.terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Terminates', route('finance.terminated'));
});

// Home > Terminate
Breadcrumbs::for('finance.terminate', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('finance.terminates');
    $trail->push($customer->full_name, route('finance.terminate', $customer));
});

// Home > Terminates > Terminate > Details
Breadcrumbs::for('finance.terminate.details', function (BreadcrumbTrail $trail, Terminate $terminate) {
    $trail->parent('finance.terminate', $terminate->customer);
    $trail->push("Terminate Details", route('finance.terminate.details', $terminate));
});

// Home > Suspends
Breadcrumbs::for('finance.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Suspends', route('finance.suspends'));
});

// Home > Suspends > Suspend
Breadcrumbs::for('finance.suspend', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('finance.suspends');
    $trail->push($customer->full_name, route('singleSuspend', $customer));
});

// Home > Suspends > Suspend > Details
Breadcrumbs::for('finance.suspend.detail', function (BreadcrumbTrail $trail, Suspend $suspend) {
    $trail->parent('finance.suspend', $suspend->customer);
    $trail->push("Suspend Details", route('finance.suspend.details', $suspend));
});

// Home > Suspends > Customer Name > Activate
Breadcrumbs::for('finance.activate', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('finance.suspends');
    $trail->push($customer->full_name);
    $trail->push('Activate', route('finance.activate', $customer));
});

// Home > Requests
Breadcrumbs::for('finance.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Requests', route('finance.requests'));
});

// Home > Amedments
Breadcrumbs::for('finance.amedments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Amedments', route('finance.amedment'));
});

// Home > Canceled Amedments
Breadcrumbs::for('finance.cancels.amedments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Canceled Amedments', route('finance.cancels.amedments'));
});

// Home > Amedments > Name
Breadcrumbs::for('finance.amedments.amend', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('finance.amedments');
    $trail->push($customer->full_name, route('finance.amends.amend', $customer));
});

// Home > Canceled Amedments > Name
Breadcrumbs::for('finance.cancel.amend', function (BreadcrumbTrail $trail, Amend $amend) {
    $trail->parent('finance.cancels.amedments');
    $trail->push($amend->full_name, route('finance.cancel.amedment', $amend));
});

// Home > Amedments > Name > Details
Breadcrumbs::for('finance.amend.details', function (BreadcrumbTrail $trail, Amend $amend) {
    $trail->parent('finance.amedments.amend', $amend->customer);
    $trail->push("Amendment Details", route('finance.amendment.details', $amend));
});

// Home > Terminate Requests
Breadcrumbs::for('finance.terminate.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Request');
    $trail->push('Customers');
    $trail->push('Terminate Requests', route('requests.index'));
});

// Home > Terminate Requests > Request Status
Breadcrumbs::for('finance.ter.req', function (BreadcrumbTrail $trail, RequestTerminate $request) {
    $trail->parent('finance.terminate.requests');
    $trail->push($request->status, route('requests.show', $request));
});

// Home > Terminate Requests > Edit
Breadcrumbs::for('finance.ter.edit', function (BreadcrumbTrail $trail, RequestTerminate $request) {
    $trail->parent('finance.terminate.requests');
    $trail->push($request->status, route('requests.edit', $request));
});

// Home > Terminate Requests > Add New
Breadcrumbs::for('finance.ter.create', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Request');
    $trail->push("Add Request", route('requests.create'));
});

// -------------------------------------------------------------------------------//
// -------------------------------------------------------------------------------//

// Breadcrumbs routes for NOC Dashboard


// Home > Customers
Breadcrumbs::for('noc', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers', route('installation.index'));
});

// Home > Customers > Customer Name
Breadcrumbs::for('noc.show', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc');
    $trail->push($customer->full_name, route('installation.show', $customer));
});

// Home > Customers > Customer Name
Breadcrumbs::for('noc.process.update', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc.show', $customer);
    $trail->push('Process', route('installation.edit', $customer));
});

// Home > Customers > Customer Name > Attachments
Breadcrumbs::for('noc.attachments', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc.show', $customer);
    $trail->push('Attachments', route('noc.attachment', $customer));
});

// Home > Terminates
Breadcrumbs::for('noc.terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Terminates', route('installation.terminates'));
});

// Home > Terminate
Breadcrumbs::for('noc.terminate', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc.terminates');
    $trail->push($customer->full_name, route('noc.terminate', $customer));
});

// Home > Terminates > Terminate > Details
Breadcrumbs::for('noc.terminate.details', function (BreadcrumbTrail $trail, Terminate $terminate) {
    $trail->parent('noc.terminate', $terminate->customer);
    $trail->push("Terminate Details", route('noc.terminate.details', $terminate));
});

// Home > NOC > Cancels Customers
Breadcrumbs::for('noc.cancel', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Cancels', route('cancels.index'));
});

// Home > NOC > Cancels Customers > Customer Name
Breadcrumbs::for('noc.cancel.show', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc.cancel');
    $trail->push($customer->full_name, route('cancels.show', $customer));
});

// Home > NOC > Cancels Customers > Customer Name > Details
Breadcrumbs::for('noc.cancel.details', function (BreadcrumbTrail $trail, Cancel $cancel) {
    $trail->parent('noc.cancel.show', $cancel->customer);
    $trail->push("Cancel Details", route('cancel.details', $cancel));
});

// Home > Suspends
Breadcrumbs::for('noc.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Suspends', route('noc.suspends'));
});

// Home > Suspends > Name
Breadcrumbs::for('noc.suspend', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc.suspends');
    $trail->push($customer->full_name, route('noc.singleSuspend', $customer));
});

// Home > Suspends > Suspend > Suspend Detail
Breadcrumbs::for('noc.suspend.detail', function (BreadcrumbTrail $trail, Suspend $suspend) {
    $trail->parent('noc.suspend', $suspend->customer);
    $trail->push("Suspend Detail", route('noc.suspend.details', $suspend));
});

// Home > Suspends > Customer Name > Activate
Breadcrumbs::for('noc.activate', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc.suspends');
    $trail->push($customer->full_name);
    $trail->push('Activate', route('noc.activateForm', $customer));
});

// Home > Requests
Breadcrumbs::for('noc.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Requests', route('noc.requests'));
});

// Home >  Cancels Customers
Breadcrumbs::for('finance.cancel', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Cancels', route('cancels.index'));
});

// Home >  Cancels Customers > Customer Name
Breadcrumbs::for('finance.cancel.show', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('finance.cancel');
    $trail->push($customer->full_name, route('cancels.show', $customer));
});

// Home >  Cancels Customers > Customer Name > Details
Breadcrumbs::for('finance.cancel.details', function (BreadcrumbTrail $trail, Cancel $cancel) {
    $trail->parent('finance.cancel.show', $cancel->customer);
    $trail->push("Cancel Details", route('cancel.details', $cancel));
});

// Home > Requests > Process
Breadcrumbs::for('noc.process', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc.requests');
    $trail->push($customer->full_name . " - " . $customer->customer_id, route('installation.create', $customer));
});

// Home > Amedments
Breadcrumbs::for('noc.amedments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Customers');
    $trail->push('Amedments', route('noc.amedment'));
});

// Home > Canceled Amedments
Breadcrumbs::for('noc.cancels.amedments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Canceled Amedments', route('noc.cancels.amedments'));
});

// Home > Amedments
Breadcrumbs::for('noc.amedment', function (BreadcrumbTrail $trail, Customer $customer) {
    $trail->parent('noc.amedments');
    $trail->push($customer->full_name, route('noc.amedment.amend', $customer));
});

// Home > Canceled Amedments > name
Breadcrumbs::for('noc.cancel.amedment', function (BreadcrumbTrail $trail, Amend $amend) {
    $trail->parent('noc.cancels.amedments');
    $trail->push($amend->full_name, route('noc.amedment.amend', $amend));
});

// Home > Amedments
Breadcrumbs::for('noc.amedment.details', function (BreadcrumbTrail $trail, Amend $amend) {
    $trail->parent('noc.amedment', $amend->customer);
    $trail->push("Amendment Details", route('noc.amendment.details', $amend));
});

// Home > Terminate Requests
Breadcrumbs::for('noc.terminate.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Terminate Requests', route('NocRequests.index'));
});

// Home > Terminate Requests > Request Status
Breadcrumbs::for('noc.ter.req', function (BreadcrumbTrail $trail, RequestTerminate $request) {
    $trail->parent('noc.terminate.requests');
    $trail->push($request->status, route('NocRequests.show', $request));
});

// Home > Terminate Requests > Edit
Breadcrumbs::for('noc.ter.edit', function (BreadcrumbTrail $trail, RequestTerminate $request) {
    $trail->parent('noc.terminate.requests');
    $trail->push($request->status, route('NocRequests.edit', $request));
});

// Home > Terminate Requests > Add New
Breadcrumbs::for('noc.ter.create', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Add Request", route('NocRequests.create'));
});


// *********************Provincial Customers************************** //
// ***************************Dashboard******************************* //

// Home > Provincial
Breadcrumbs::for('provincial', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Outsourcing', route('admin.provincial'));
});

// Home > Provincial > Provincial Name
Breadcrumbs::for('provincial.name', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('provincial');
    $trail->push($pro->full_name, route('admin.provincial', $pro));
});

// Home > Provincial > Provincial Name > Attachments
Breadcrumbs::for('provincial.attachments', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('provincial.name', $pro);
    $trail->push('Attachments', route('admin.pr.show', $pro));
});

// Home > Terminates
Breadcrumbs::for('manager.pr.terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Terminates', route('admin.terminates'));
});

// Home > Suspends
Breadcrumbs::for('manager.pr.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Suspends', route('admin.pr.suspends'));
});

// Home > Suspends > Name
Breadcrumbs::for('manager.pr.suspend', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('manager.pr.suspends');
    $trail->push($pro->full_name, route('admin.pr.suspend', $pro));
});

// Home > Amendments
Breadcrumbs::for('manager.pr.amends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Amendments', route('admin.amends'));
});

// Home > Amendments > Name
Breadcrumbs::for('manager.pr.amend', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('manager.pr.amends');
    $trail->push($pro->full_name, route('admin.amend', $pro));
});

// Home > Canceled Amendments
Breadcrumbs::for('manager.pr.cancels.amend', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push("Canceled Amendments", route('cancels.prAmendments.mr'));
});

// Home > Canceled Amendments > Name
Breadcrumbs::for('manager.pr.cancel.amend', function (BreadcrumbTrail $trail, PrAmend $amend) {
    $trail->parent('manager.pr.cancels.amend');
    $trail->push($amend->full_name, route('cancel.PrAmendment.mr', $amend->id));
});

// Home > Cancels
Breadcrumbs::for('manager.pr.cancels', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Cancels', route('prCancels.index'));
});

// Home > Cancels
Breadcrumbs::for('manager.pr.cancel', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('manager.pr.cancels');
    $trail->push($pro->full_name, route('prCancels.show', $pro));
});

// Home > Trashes
Breadcrumbs::for('manager.pr.trash', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Trashes', route('admin.pr.tr'));
});

// Home > Requests
Breadcrumbs::for('manager.pr.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Requests', route('man.pr.requests'));
    $trail->push('Provincials');
});

// Home > Requests > Request
Breadcrumbs::for('manager.pr.request', function (BreadcrumbTrail $trail, PrTerminateRequest $tr) {
    $trail->parent('manager.pr.requests');
    $trail->push('Request', route('man.pr.request', $tr));
});

// ***************************Sales******************************* //

// Home > Provincial
Breadcrumbs::for('sales.provincial', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial', route('provincial.index'));
    $trail->push('Customers');
});

// Home > Provincial > Provincial Name
Breadcrumbs::for('sales.provincial.name', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.provincial');
    $trail->push($pro->full_name, route('provincial.show', $pro));
});

// Home > Suspends > Provincial Name > Reactive
Breadcrumbs::for('sales.provincial.edit', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.provincial');
    $trail->push($pro->full_name);
    $trail->push('Edt', route('provincial.show', $pro));
});

// Home > Provincial > Provincial Name > Attachments
Breadcrumbs::for('sales.provincial.attachments', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.provincial.name', $pro);
    $trail->push('Attachments', route('pr.files', $pro));
});

// Home > Terminates
Breadcrumbs::for('sales.terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Terminates', route('pr.terminates'));
});

// Home > Terminates > name
Breadcrumbs::for('sales.pr.terminate', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.terminates');
    $trail->push($pro->full_name, route('pr.sales.terminate', $pro));
});

// Home > Terminates > Provincial Name > Recontract
Breadcrumbs::for('sales.provincial.recontract', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.terminates');
    $trail->push($pro->full_name);
    $trail->push('Recontract', route('pr.recontract', $pro));
});

// Home > Suspends
Breadcrumbs::for('sales.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Suspends', route('pr.suspends'));
});

// Home > Suspends > Name
Breadcrumbs::for('sales.pr.suspend', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.suspends');
    $trail->push($pro->full_name, route('pr.suspend', $pro));
});

// Home > Suspends > Provincial Name > Reactive
Breadcrumbs::for('sales.provincial.reactive', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.suspends');
    $trail->push($pro->full_name);
    $trail->push('Reactive', route('pr.suspendform', $pro));
});

// Home > Amendment
Breadcrumbs::for('sales.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Amendments', route('pr.amendments'));
});

// Home > Amendment > Name
Breadcrumbs::for('sales.pr.amend', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.amendments');
    $trail->push($pro->full_name, route('pr.amend', $pro));
});

// Home > Amendment > Name
Breadcrumbs::for('sales.pr.amendment', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.pr.amend', $pro);
    $trail->push('Amendment', route('pr.amendment', $pro));
});

// Home > Cancel Amendment
Breadcrumbs::for('sales.cancels.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Cancels Amendments', route('customers.PrAmends.cancels'));
});

// Home > Cancel Amendment
Breadcrumbs::for('sales.cancel.amendment', function (BreadcrumbTrail $trail, PrAmend $amend) {
    $trail->parent('sales.cancels.amendments');
    $trail->push($amend->full_name, route('customers.Pramend.cancel', $amend));
});

// Home > Cancels
Breadcrumbs::for('sales.cancels', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Cancels', route('prCancels.index'));
});

// Home > Cancels > Name
Breadcrumbs::for('sales.pr.cancel', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('sales.cancels');
    $trail->push($pro->full_name, route('prCancels.show', $pro));
});

// Home > Add New
Breadcrumbs::for('sales.provincial.add', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Add New', route('provincial.create'));
});

// Home > Trasher
Breadcrumbs::for('sales.trashes', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Trashes', route('provincial.trashed'));
});

// Home > Requests
Breadcrumbs::for('sales.pr.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Requests', route('PrRequests.index'));
});

// Home > Requests > Request
Breadcrumbs::for('sales.pr.request', function (BreadcrumbTrail $trail, PrTerminateRequest $tr) {
    $trail->parent('sales.pr.requests');
    $trail->push('Request', route('PrRequests.show', $tr));
});

// ***************************Finance******************************* //

// Home > Provincial
Breadcrumbs::for('finance.provincial', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial', route('prc.index'));
});

// Home > Provincial > Name
Breadcrumbs::for('finance.pr.name', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('finance.provincial');
    $trail->push($pro->full_name, route('prc.show', $pro));
});

// Home > Suspends > Name > Reactive
Breadcrumbs::for('finance.pr.attachments', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('finance.pr.name', $pro);
    $trail->push('Attachments', route('pr.finance.files', $pro));
});

// Home > Terminates
Breadcrumbs::for('finance.pr.terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Terminates', route('pr.fin.terminates'));
});

// Home > Terminates > name
Breadcrumbs::for('finance.pr.terminate', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('finance.pr.terminates');
    $trail->push($pro->full_name, route('pr.fin.terminate', $pro));
});

// Home > Suspends
Breadcrumbs::for('finance.pr.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Suspends', route('pr.fin.suspends'));
});

// Home > Suspends > name
Breadcrumbs::for('finance.pr.suspend', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('finance.pr.suspends');
    $trail->push($pro->full_name, route('pr.fin.suspend', $pro));
});

// Home > Suspends > Name > Reactive
Breadcrumbs::for('finance.pr.activate', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('finance.pr.suspends');
    $trail->push($pro->full_name);
    $trail->push('Reactive', route('pr.fin.activate', $pro));
});

// Home > Amendments
Breadcrumbs::for('finance.pr.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Amendments', route('pr.fin.amends'));
});

// Home > Canceled Amendments
Breadcrumbs::for('finance.pr.cancels.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Canceled Amendments', route('finance.cancels.PrAmedments'));
});

// Home > Amendments > Name
Breadcrumbs::for('finance.pr.amend', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('finance.pr.amendments');
    $trail->push($pro->full_name, route('pr.fin.amend', $pro));
});

// Home > Amendments > Name
Breadcrumbs::for('finance.pr.cancel.amend', function (BreadcrumbTrail $trail, PrAmend $amend) {
    $trail->parent('finance.pr.cancels.amendments');
    $trail->push($amend->full_name, route('finance.cancel.PrAmedment', $amend));
});

// Home > Cancels
Breadcrumbs::for('finance.pr.cancels', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Cancels', route('prCancels.index'));
});

// Home > Cancels > Name
Breadcrumbs::for('finance.pr.cancel', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('finance.pr.cancels');
    $trail->push($pro->full_name, route('prCancels.show', $pro));
});

// Home > Requests
Breadcrumbs::for('finance.pr.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincial');
    $trail->push('Requests', route('pr.fin.requests'));
});

// Home > Terminate Requests
Breadcrumbs::for('tr.finance.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Requests');
    $trail->push('Provincials');
    $trail->push('Terminate Requests', route('trRequests.index'));
});

// Home > Requests > Request
Breadcrumbs::for('tr.fiance.request', function (BreadcrumbTrail $trail, PrTerminateRequest $tr) {
    $trail->parent('tr.finance.requests');
    $trail->push(' Request', route('trRequests.show', $tr));
});

// Home > Requests > Edit
Breadcrumbs::for('tr.finance.edit', function (BreadcrumbTrail $trail, PrTerminateRequest $tr) {
    $trail->parent('tr.finance.requests');
    $trail->push('Edit Request', route('trRequests.edit', $tr));
});

// Home > Requests > Add New
Breadcrumbs::for('tr.finance.add', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Add New', route('trRequests.create'));
});

// ***************************NOC******************************* //

// Home > Provincial
Breadcrumbs::for('noc.provincial', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincials');
    $trail->push('Customers', route('prCustomers.index'));
});

// Home > Provincial > Name
Breadcrumbs::for('noc.provincial.name', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('noc.provincial');
    $trail->push($pro->full_name, route('prCustomers.show', $pro));
});

// Home > Provincial > Name > Process
Breadcrumbs::for('noc.provincial.process', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('noc.provincial.name', $pro);
    $trail->push('Process', route('prCustomers.create'));
});

// Home > Provincial > Name > Attachments
Breadcrumbs::for('noc.provincial.attachments', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('noc.provincial.name', $pro);
    $trail->push('Attachments', route('pr.noc.files', $pro));
});

// Home > Terminates
Breadcrumbs::for('noc.pr.terminates', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincials');
    $trail->push('Terminates', route('pr.noc.terminates'));
});

// Home > Terminates
Breadcrumbs::for('noc.pr.terminate', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('noc.pr.terminates');
    $trail->push($pro->full_name, route('pr.noc.terminate', $pro));
});

// Home > Suspends
Breadcrumbs::for('noc.pr.suspends', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincials');
    $trail->push('Suspends', route('pr.noc.suspends'));
});

// Home > Suspends > name
Breadcrumbs::for('noc.pr.suspend', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('noc.pr.suspends');
    $trail->push($pro->full_name, route('pr.noc.suspend', $pro));
});

// Home > Suspends > Activate
Breadcrumbs::for('noc.pr.activateform', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('noc.pr.suspend', $pro);
    $trail->push('Activate', route('pr.noc.active', $pro));
});

// Home > Amendments
Breadcrumbs::for('noc.pr.amendments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincials');
    $trail->push('Amendments', route('pr.noc.amendments'));
});

// Home > Amendments > name
Breadcrumbs::for('noc.pr.amend', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('noc.pr.amendments');
    $trail->push($pro->full_name, route('pr.noc.amend', $pro));
});

// Home > cancels Amendments
Breadcrumbs::for('noc.pr.cancelsamendments', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincials');
    $trail->push('Canceled Amendments', route('noc.cancels.PrAmedments'));
});

// Home > cancels Amendments > name
Breadcrumbs::for('noc.pr.cancel.amend', function (BreadcrumbTrail $trail, PrAmend $pro) {
    $trail->parent('noc.pr.cancelsamendments');
    $trail->push($pro->full_name, route('noc.cancel.PrAmend', $pro));
});

// Home > Cancels
Breadcrumbs::for('noc.pr.cancels', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincials');
    $trail->push('Cancels', route('prCancels.index'));
});

// Home > Cancels > Name
Breadcrumbs::for('noc.pr.cancel', function (BreadcrumbTrail $trail, Provincial $pro) {
    $trail->parent('noc.pr.cancels');
    $trail->push($pro->full_name, route('prCancels.show', $pro));
});

// Home > Requests
Breadcrumbs::for('noc.pr.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Provincials');
    $trail->push('Requests', route('pr.noc.requests'));
});

// Home > Terminate Requests
Breadcrumbs::for('tr.noc.requests', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Requests', route('prRequests.index'));
});

// Home > Requests > Request
Breadcrumbs::for('tr.noc.request', function (BreadcrumbTrail $trail, PrTerminateRequest $tr) {
    $trail->parent('tr.noc.requests');
    $trail->push('Request', route('prRequests.show', $tr));
});

// Home > Requests > Edit
Breadcrumbs::for('tr.noc.edit', function (BreadcrumbTrail $trail, PrTerminateRequest $tr) {
    $trail->parent('tr.noc.requests');
    $trail->push('Edit Request', route('prRequests.edit', $tr));
});

// Home > Requests > Add New
Breadcrumbs::for('tr.noc.add', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Add New', route('prRequests.create'));
});


// Permissions

// Home > Permissions
Breadcrumbs::for('permissions', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Permissions', route('permissions.index'));
});

// Home > Permissions  > Trashed
Breadcrumbs::for('trashed-permissions', function (BreadcrumbTrail $trail) {
    $trail->parent('permissions', route('permissions.index'));
    $trail->push('Trashed');
});

// Home > Permissions > Add New User
Breadcrumbs::for('create-permission', function (BreadcrumbTrail $trail) {
    $trail->parent('permissions', route('permissions.index'));
    $trail->push('Add New');
});

// Home > Permissions > Section > Permission
Breadcrumbs::for('show-permissions', function (BreadcrumbTrail $trail, Permission $permission) {
    $trail->parent('permissions', route('permissions.index'));
    $trail->push($permission->section);
    $trail->push($permission->permission);
});

// Home > Permissions > Section > permission
Breadcrumbs::for('edit-permission', function (BreadcrumbTrail $trail, Permission $permission) {
    $trail->parent('permissions', route('permissions.index'));
    $trail->push($permission->section);
    $trail->push($permission->permission);
});
