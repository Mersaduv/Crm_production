<?php

use App\Models\Suspend;
use App\Models\PrSuspend;
use App\Models\Terminate;
use App\Models\PrRecontract;
use App\Models\PrTerminate;
use App\Models\Amend;
use App\Models\PrAmend;
use App\Models\Cancel;
use App\Models\CancelAmend;
use App\Models\PrCancel;
use App\Models\Customer;
use App\Models\Provincial;
use App\Models\Commission;
use App\Models\Marketer;
use App\Models\Package;
use App\Models\PrCancelAmend;
use App\Models\PrReactivate;
use App\Models\Reactivate;
use App\Models\Recontract;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

// Get User Permissions
function hasBranchePermission($user_id, $branch_id, $permission_id)
{
    $count = DB::table('user_permission')
        ->where([
            ['user_id', $user_id],
            ['branch_id', $branch_id],
            ['permission_id', $permission_id],
        ])
        ->count();

    return $count > 0;
}

function hasSectionPermission($user, $section, $permission)
{
    return $user->permissions->contains(function ($row) use ($section, $permission) {
        return
            $row->section == Str::headline($section) &&
            $row->permission == Str::headline($permission);
    });
}

function hasSectionPermissionForBranch($user, $section, $permission)
{
    return $user
        ->permissions
        ->filter(function ($row) use ($section, $permission) {
            return $row->section == Str::headline($section) &&
                $row->permission == Str::headline($permission);
        })->map(function ($row) {
            return $row->pivot->branch_id;
        })
        ->all();
}

function UserFullyQualifiedNameSpace()
{
    return \App\Models\User::class;
}

function CustomerFullyQualifiedNameSpace()
{
    return \App\Models\Customer::class;
}

function TerminateFullyQualifiedNameSpace()
{
    return \App\Models\Terminate::class;
}

function RecontractFullyQualifiedNameSpace()
{
    return \App\Models\Recontract::class;
}

function ReactivateFullyQualifiedNameSpace()
{
    return \App\Models\Reactivate::class;
}

function SuspendFullyQualifiedNameSpace()
{
    return \App\Models\Suspend::class;
}

function AmendmentFullyQualifiedNameSpace()
{
    return \App\Models\Amend::class;
}

function CancelAmendmentFullyQualifiedNameSpace()
{
    return \App\Models\CancelAmend::class;
}

function CancelFullyQualifiedNameSpace()
{
    return \App\Models\Cancel::class;
}


function ProvincialFullyQualifiedNameSpace()
{
    return \App\Models\Provincial::class;
}

function ProvincialTerminateFullyQualifiedNameSpace()
{
    return \App\Models\PrTerminate::class;
}

function ProvincialRecontractFullyQualifiedNameSpace()
{
    return \App\Models\PrRecontract::class;
}

function ProvincialSuspendFullyQualifiedNameSpace()
{
    return \App\Models\PrSuspend::class;
}

function ProvincialReactivateFullyQualifiedNameSpace()
{
    return \App\Models\PrReactivate::class;
}

function ProvincialAmendmentFullyQualifiedNameSpace()
{
    return \App\Models\PrAmend::class;
}

function ProvincialCancelAmendFullyQualifiedNameSpace()
{
    return \App\Models\PrCancelAmend::class;
}

function ProvincialCancelFullyQualifiedNameSpace()
{
    return \App\Models\PrCancel::class;
}

function CommissionFullyQualifiedNameSpace()
{
    return \App\Models\Commission::class;
}

function MarketerFullyQualifiedNameSpace()
{
    return \App\Models\Marketer::class;
}

function PackageFullyQualifiedNameSpace()
{
    return \App\Models\Package::class;
}

function ProvinceFullyQualifiedNameSpace()
{
    return \App\Models\Province::class;
}

function BranchFullyQualifiedNameSpace()
{
    return \App\Models\Branch::class;
}

function CategoryFullyQualifiedNameSpace()
{
    return \App\Models\Category::class;
}

function NocFullyQualifiedNameSpace()
{
    return \App\Models\NOC::class;
}

function ProvincialNocFullyQualifiedNameSpace()
{
    return \App\Models\PrNocInfo::class;
}

function PaymentFullyQualifiedNameSpace()
{
    return \App\Models\Payment::class;
}

function ProvincialPaymentFullyQualifiedNameSpace()
{
    return \App\Models\PrPayment::class;
}

function ProviderFullyQualifiedNameSpace()
{
    return \App\Models\Provider::class;
}

function hasAnyReadPermission($sections = [])
{
    $has = false;
    foreach ($sections as $section) {
        if (hasSectionPermission(auth()->user(), $section, 'read'))
            $has = true;
    }
    return $has;
}

function hasAnyTimeLinePermission($sections = [])
{
    $has = false;
    foreach ($sections as $section) {
        if (hasSectionPermission(auth()->user(), $section, 'time-line'))
            $has = true;
    }
    return $has;
}

function headline($str)
{
    return Str::headline($str);
}

function suspends($role)
{
    $suspends =  Suspend::whereNull($role)->count();
    $reactives = Reactivate::whereNull($role)->count();
    $total = $suspends + $reactives;

    return  [
        'suspends' => $suspends,
        'reactives' => $reactives,
        'total' => $total
    ];
}

function terminates($role)
{

    $terminates = Terminate::whereNull($role)
        ->whereNull('noc_cancel')
        ->count();
    $recontracts = Recontract::whereNull($role)->whereNull('noc_cancel')->count();
    $total = $terminates + $recontracts;

    return [
        'terminates' => $terminates,
        'recontracts' => $recontracts,
        'total' => $total
    ];
}

function amends($role)
{
    $penddingAmend =  Amend::whereNull($role)->where('cancel_status', '0')->count();
    $canceledAmend = CancelAmend::whereNull($role)->count();
    $total = $penddingAmend + $canceledAmend;

    return  [
        'penddingAmend' => $penddingAmend,
        'canceledAmend' => $canceledAmend,
        'total' => $total
    ];
}

function cancels($role)
{
    return Cancel::whereNull($role)->count();
}

function requests($role)
{
    if ($role == 'finance') {
        return Customer::where('finance_status', '0')
            ->where('noc_status', '1')
            ->where('terminate_status', '0')
            ->where('suspend_status', '0')
            ->where('cancel_status', '0')
            ->whereNull('deleted_at')->count();
    } else if ($role == 'noc') {
        return Customer::where('active_status', '0')
            ->where('noc_status', '1')
            ->where('terminate_status', '0')
            ->where('suspend_status', '0')
            ->where('cancel_status', '0')
            ->whereNull('deleted_at')->count();
    }
}

// ************************** //

function PrSuspend($role)
{
    $suspends =  PrSuspend::whereNull($role)->count();
    $reactives = PrReactivate::whereNull($role)->count();
    $total = $suspends + $reactives;

    return  [
        'suspends' => $suspends,
        'reactives' => $reactives,
        'total' => $total
    ];
}


function PrTerminate($role)
{
    $terminates = PrTerminate::whereNull($role)->count();
    $recontracts = PrRecontract::whereNull($role)->count();
    $total = $terminates + $recontracts;

    return  [
        'terminates' => $terminates,
        'recontracts' => $recontracts,
        'total' => $total
    ];
}

function PrAmend($role)
{
    $penddingAmend =  PrAmend::whereNull($role)->where('cancel_status', '0')->count();
    $canceledAmend = PrCancelAmend::whereNull($role)->count();
    $total = $penddingAmend + $canceledAmend;

    return  [
        'penddingAmend' => $penddingAmend,
        'canceledAmend' => $canceledAmend,
        'total' => $total
    ];
}

function PrCancel($role)
{
    return PrCancelAmend::whereNull($role)->count();
}

function prRequests($role)
{
    if ($role == 'finance') {
        return Provincial::where('finance_status', '0')
            ->where('process_status', '1')
            ->where('terminate_status', '0')
            ->where('suspend_status', '0')
            ->where('cancel_status', '0')
            ->whereNull('deleted_at')->count();
    } else if ($role == 'noc') {
        return Provincial::where('active_status', '0')
            ->where('process_status', '1')
            ->where('terminate_status', '0')
            ->where('suspend_status', '0')
            ->where('cancel_status', '0')
            ->whereNull('deleted_at')->count();
    }
}

// province Function
function province($province)
{
    switch ($province) {
        case 'herat':
            return "Herat";
            break;
        case 'kabul':
            return "Kabul";
            break;
        case 'mazar':
            return "Mazar-e-Sharif";
            break;
        case 'badghis':
            return "Badghis";
            break;
        case 'jalal-abad':
            return "Jalal Abad";
            break;
        default:
            return $province;
    }
}

// lease type Function
function lease($lease)
{
    switch ($lease) {
        case 'full':
            return "Full Lease";
            break;
        case 'guarantee':
            return "Guarantee";
            break;
    }
}

// check status
function status($customer)
{
    $customer = Customer::where('customer_id', '=', $customer)->first();

    if ($customer->active_status == '1') {
        return ['status' => "Activated", "date" => $customer->noc->activation_date];
    }

    if ($customer->cancel_status == '1') {
        return ['status' => "Canceled", "date" => $customer->cancel->first()->cancel_date];
    }

    if ($customer->terminate_status == '1') {
        return ['status' => "Terminated", "date" => $customer->terminate->first()->termination_date];
    }

    if ($customer->suspend_status == '1') {
        return ['status' => "Suspended", "date" =>  $customer->suspend->first()->suspend_date];
    }

    if ($customer->noc_status == '1' && $customer->cancel_status == '0' && $customer->terminate_status == '0' && $customer->suspend_status == '0') {
        return ['status' => "Pending", "date" => 'NA'];
    }

    if ($customer->noc_status == '0' && $customer->cancel_status == '0' && $customer->terminate_status == '0' && $customer->suspend_status == '0') {
        return ['status' => "Not Proceed", "date" => 'NA'];
    }
}

// check status
function prStatus($customer)
{
    $customer = Provincial::where('customer_id', '=', $customer)->first();

    if ($customer->active_status == '1') {
        return ['status' => "Activated", "date" => $customer->PrNocInfo->activation_date];
    }

    if ($customer->cancel_status == '1') {
        return ['status' => "Canceled", "date" => $customer->prCancel->first()->cancel_date];
    }

    if ($customer->terminate_status == '1') {
        return ['status' => "Terminated", "date" => $customer->terminate->first()->terminate_date];
    }

    if ($customer->suspend_status == '1') {
        return ['status' => "Suspended", "date" => $customer->suspend->first()->suspend_date];
    }

    if ($customer->process_status == '1' && $customer->cancel_status == '0' && $customer->terminate_status == '0' && $customer->suspend_status == '0') {
        return ['status' => "Pending", "date" => "NA"];
    }

    if ($customer->process_status == '0' && $customer->cancel_status == '0' && $customer->terminate_status == '0' && $customer->suspend_status == '0') {
        return ['status' => "Not Proceed", "date" => "NA"];
    }
}

// Getting the Package
function package($id)
{
    $package = Package::find($id);
    if ($package) {
        return $package->name;
    } else {
        return "NA";
    }
}

// Getting the Reseller
function reseller($id)
{
    $reseller = Commission::find($id);
    return $reseller->name;
}

// Getting the Reseller
function marketer($id)
{
    $marketer = Marketer::find($id);
    return $marketer->name;
}

// Getting the User
function user($id)
{
    $user = User::find($id);
    return $user->name;
}

// Checking the debt status
function debt($id, $requests)
{
    $customer = Customer::findorfail($id);
    $status = '0';
    $currency = 'true';

    $package_price = $customer->sale->package_price;
    $package_price_currency = $customer->sale->package_price_currency;

    $receiver_price = $customer->sale->receiver_price;
    $receiver_price_currency = $customer->sale->receiver_price_currency;

    $router_price = $customer->sale->router_price;
    $router_price_currency = $customer->sale->router_price_currency;

    $cable_price = $customer->sale->cable_price;
    $cable_price_currency = $customer->sale->cable_price_currency;

    $Installation_cost = $customer->sale->Installation_cost;
    $Installation_cost_currency = $customer->sale->Installation_cost_currency;

    $ip_price = $customer->sale->ip_price;
    $ip_price_currency = $customer->sale->ip_price_currency;

    // Checking the payment with the form requests
    if ($package_price > $requests['package_price']) {
        $status = '1';
    }

    if ($package_price_currency != $requests['package_price_currency']) {
        $currency = 'false';
    }

    if ($receiver_price > $requests['receiver_price']) {
        $status = '1';
    }

    if ($receiver_price_currency != $requests['receiver_price_currency']) {
        $currency = 'false';
    }

    if ($router_price > $requests['router_price']) {
        $status = '1';
    }

    if ($router_price_currency != $requests['router_price_currency']) {
        $currency = 'false';
    }

    if ($cable_price > $requests['cable_price']) {
        $status = '1';
    }

    if ($cable_price_currency != $requests['cable_price_currency']) {
        $currency = 'false';
    }

    if ($Installation_cost > $requests['Installation_cost']) {
        $status = '1';
    }

    if ($Installation_cost_currency != $requests['Installation_cost_currency']) {
        $currency = 'false';
    }

    if ($ip_price > $requests['ip_price']) {
        $status = '1';
    }

    if ($ip_price_currency != $requests['ip_price_currency']) {
        $currency = 'false';
    }

    return ['status' => $status, 'currency' => $currency];
}


// Checking the debt status
function pr_debt($id, $requests)
{
    $customer = Provincial::findorfail($id);
    $status = '0';
    $currency = 'true';

    $package_price = $customer->package_price;
    $package_price_currency = $customer->package_price_currency;

    $Installation_cost = $customer->installation_cost;
    $Installation_cost_currency = $customer->Installation_cost_currency;

    $ip_price = $customer->ip_price;
    $ip_price_currency = $customer->ip_price_currency;

    // Checking the payment with the form requests
    if ($package_price > $requests['package_price']) {
        $status = '1';
    }

    if ($package_price_currency != $requests['package_price_currency']) {
        $currency = 'false';
    }

    if ($Installation_cost > $requests['installation_cost']) {
        $status = '1';
    }

    if ($Installation_cost_currency != $requests['Installation_cost_currency']) {
        $currency = 'false';
    }

    if ($ip_price > $requests['ip_price']) {
        $status = '1';
    }

    if ($ip_price_currency != $requests['ip_price_currency']) {
        $currency = 'false';
    }

    return ['status' => $status, 'currency' => $currency];
}
