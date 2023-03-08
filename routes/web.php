<?php

use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route(Auth::check() ? 'dashboard' : 'login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', 'homeController@index')->name('dashboard');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/users/{id}/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/users/{id}/profile', [UserController::class, 'updateProfile'])->name('users.update-profile');

    Route::post('/equipmentTypes', 'system\SearchController@equipmentTypes')->name('equipmentTypes');
    Route::post('/packagesType', 'system\SearchController@packagesType')->name('packagesType');
    Route::post('/commissions/search', 'system\SearchController@commissions')->name('commission.search');
    Route::post('/marketers/search', 'system\SearchController@marketers')->name('marketers.search');
    Route::post('/checkSellMac', 'system\SearchController@checkSellMac')->name('checkSellMac');
    Route::post('/checkLeasedMac', 'system\SearchController@checkLeasedMac')->name('checkLeasedMac');
    Route::post('/getCustomer', 'system\SearchController@getCustomer')->name('getCustomer');
    Route::post('/getPrCustomer', 'system\SearchController@getPrCustomer')->name('getPrCustomer');
    Route::get('/getRequests', 'system\SearchController@requests')->name('getRequests');
    Route::put('/updateRequest/{id}', 'system\SearchController@updateRequest')->name('updateRequest');
    Route::get('/getRequest/{id}', 'system\SearchController@request')->name('getRequest');
    Route::post('/saleFiles', 'system\SearchController@saleFiles')->name('saleFiles');
    Route::post('/prFiles', 'system\SearchController@prFiles')->name('prFiles');
    Route::post('/nocFiles', 'system\SearchController@nocFiles')->name('nocFiles');
    Route::post('/prNocFiles', 'system\SearchController@prNocFiles')->name('prNocFiles');
    Route::resource('/cancels', 'system\CancelController');
    Route::resource('/prCancels', 'system\ProvinceCancelController');
    Route::post('/mark-as-read', 'system\SearchController@markNotification')->name('markNotification');
    Route::resource('/timeline', 'system\TimelineController');
    Route::post('timeline/params', 'system\TimelineController@details')->name('timeline.details');
    Route::resource('/contractorsTimeline', 'system\ContractorTimelineController');
    Route::post('/contractors/params', 'system\ContractorTimelineController@details')->name('contractors.details');
    Route::post('/cancel/confirm', 'system\SearchController@confirmCancel')->name('cancel.confirm');
    Route::post('/suspend/confirm', 'system\SearchController@confirmSuspend')->name('suspend.confirm');
    Route::post('/terminate/confirm', 'system\SearchController@confirmTerminate')->name('terminate.confirm');
    Route::post('/amend/confirm', 'system\SearchController@confirmAmend')->name('amend.confirm');
    Route::post('/cancel/amend.confirm', 'system\SearchController@confirmCancelAmend')->name('cancel.amend.confirm');
    Route::post('/prCancel/confirm', 'system\SearchController@prCancelConfirm')->name('prCancel.confirm');
    Route::post('/prSuspend/confirm', 'system\SearchController@prSuspendConfirm')->name('prSuspend.confirm');
    Route::post('/prAmend/confirm', 'system\SearchController@prAmendConfirm')->name('prAmend.confirm');
    Route::post('/prAmend/cancel/confirm', 'system\SearchController@prAmendCancelConfirm')->name('prAmend.cancel.confirm');
    Route::post('/prTerminate/confirm', 'system\SearchController@prTerminateConfirm')->name('prTerminate.confirm');
    Route::get('/filter-amendment', 'system\SearchController@filterAmendment');
    Route::get('/filter-prAmendment', 'system\SearchController@filterPrAmendment');
    Route::get('/filter-customer', 'system\SearchController@filterCustomer');
    Route::get('/filter-provincial', 'system\SearchController@filterProvincial');
    Route::get('/filter-terminate', 'system\SearchController@filterTerminate');
    Route::get('/filter-suspend', 'system\SearchController@filterSuspend');
    Route::get('/filter-reactivate', 'system\SearchController@filterReactivate');
    Route::get('/filter-recontract', 'system\SearchController@filterRecontract');
    Route::get('/filter-cancel', 'system\SearchController@filterCancel');
    Route::get('/filter-pr-terminate', 'system\SearchController@filterPrTerminate');
    Route::get('/filter-pr-suspend', 'system\SearchController@filterPrSuspend');
    Route::get('/filter-pr-reactivate', 'system\SearchController@filterPrReactivate');
    Route::get('/filter-pr-cancel', 'system\SearchController@filterPrCancel');
    Route::get('/filter-amend-cancel', 'system\SearchController@filterCancelAmend');
    Route::get('/filter-pr-amend-cancel', 'system\SearchController@filterPrCancelAmend');
    Route::put('/cancel/amend/{id}', 'system\SearchController@cancelAmendment')->name('cancel.amendment');
    Route::put('/cancel/pr/amend/{id}', 'system\SearchController@cancelPrAmendment')->name('cancel.pr.amendment');
    Route::get('/check/branch', 'system\SearchController@branches');
    Route::post('/reactivate/confirm', 'system\SearchController@confirmReactivate')->name('confirm.reactivate');
    Route::post('/recontract/confirm', 'system\SearchController@confirmRecontract')->name('confirm.recontract');
    Route::post('/prreactivate/confirm', 'system\SearchController@confirmPrReactivate')->name('confirm.PrReactivate');
    Route::get('/filter-prrecontract', 'system\SearchController@filterPrRecontract');
    Route::post('/prrecontract-confirm', 'system\SearchController@ConfirmPrRecontract')->name('confirm.prrecontract');


    //Group middleware for sales
    Route::group(['middleware' => ['sales']], function () {

        Route::resource('/customers', 'sales\CustomerController');
        Route::get('/lists/packages', 'sales\PackageController@index')->name('customers.packages');
        Route::get('/lists/package/{id}', 'sales\PackageController@show')->name('customers.package');
        Route::get('/customer/trashed', 'sales\CustomerController@trashed')->name('customers.trashed');
        Route::put('/customer/trash/{id}', 'sales\CustomerController@restore')->name('customer.restore');
        Route::put('/customer/terminate/{id}', 'sales\CustomerController@terminate')->name('customer.terminate');
        Route::get('/customer/terminate/list', 'sales\CustomerController@terminated')->name('customers.terminated.list');
        Route::get('/sales/singleTerminate/{id}', 'sales\CustomerController@singleTerminate')->name('singleTerminate');
        Route::get('/customer/contractForm/{id}', 'sales\CustomerController@contractForm')->name('customer.contractForm');
        Route::put('/customer/recontraction/{id}', 'sales\CustomerController@recontraction')->name('customer.recontraction');
        Route::put('/sales_contract/{id}', 'sales\CustomerController@sales_contract')->name('sales_contract');
        Route::put('/sendCashier/{id}', 'sales\CustomerController@sendCashier')->name('sendCashier');
        Route::put('/sendProcess/{id}', 'sales\CustomerController@sendProcess')->name('sendProcess');
        Route::get('/printContract', 'sales\CustomerController@printContract')->name('printContract');
        Route::get('/printAmendment', 'sales\CustomerController@printAmendment')->name('printAmendment');
        Route::get('/printSuspend', 'sales\CustomerController@printSuspend')->name('printSuspend');
        Route::get('/printTerminate', 'sales\CustomerController@printTerminate')->name('printTerminate');
        Route::put('/customer/suspend/{id}', 'sales\CustomerController@suspend')->name('customer.suspend');
        Route::get('/customer/suspend/list', 'sales\CustomerController@suspendedLists')->name('customers.suspend.list');
        Route::get('/customer/suspends/single/{id}', 'sales\CustomerController@suspendSingle')->name('suspends.suspend');
        Route::put('/customer/reactivate/{id}', 'sales\CustomerController@activate')->name('customer.activate');
        Route::get('/customer/activateForm/{id}', 'sales\CustomerController@activateForm')->name('customer.activate.form');
        Route::get('customer/amedmentList', 'sales\CustomerController@amedmentList')->name('customer.ameds');
        Route::get('customer/cancels/amends', 'sales\CustomerController@cancelAmends')->name('customers.ameds.cancels');
        Route::get('customer/cancels/amend/{id}', 'sales\CustomerController@cancelAmend')->name('customers.amed.cancel');
        Route::get('/customer/amedment/{id}', 'sales\CustomerController@amedment')->name('customer.amedment');
        Route::put('/customer/amedmentation/{id}', 'sales\CustomerController@amedmentation')->name('customer.amedmentation');
        Route::post('/sales/files/remove', 'sales\CustomerController@removeFile')->name('file.remove');
        Route::get('/sales/attachments/{id}', 'sales\CustomerController@fileview')->name('fileview');
        Route::get('/update/customers/status', 'system\SearchController@customerStatus');
        Route::get('/request/terminate/customer', 'system\SearchController@terminateRequests');
        Route::get('/sales/customers/amend/{id}', 'sales\CustomerController@amend')->name('amedment.amend');
        Route::get('/sales/customer/attachments/{id}', 'sales\CustomerController@customerAttachments')->name('customer.attachment.common');
        Route::get('/sales/resellers', 'sales\CustomerController@resellers')->name('sales.resellers');
        Route::post('/check/status', 'system\SearchController@status')->name('customer.status');
        Route::post('/Contractors/status', 'system\SearchController@contactorsCheck')->name('contactors.status');
        Route::get('customer/cancels/PrAmends', 'sales\ProvincialController@cancelPrAmends')->name('customers.PrAmends.cancels');
        Route::get('customer/cancels/PrAmend/{id}', 'sales\ProvincialController@cancelPrAmend')->name('customers.Pramend.cancel');
        Route::put('customer/suspend/edit/{id}', 'sales\CustomerController@suspendEdit')->name('suspend.edit');
        Route::delete('customer/suspend/delete/{id}', 'sales\CustomerController@suspendDelete')->name('suspend.delete');
        Route::put('customer/terminate/edit/{id}', 'sales\CustomerController@terminateEdit')->name('terminate.edit');
        Route::delete('customer/terminate/delete/{id}', 'sales\CustomerController@terminateDelete')->name('terminate.delete');

        Route::get('/customer/amedment/edit/{id}', 'sales\CustomerController@editAmendment')->name('customer.amedment.edit');
        Route::put('/customer/amedment/update/{id}', 'sales\CustomerController@updateAmendment')->name('customer.amedment.updateAmendment');
        Route::delete('/customer/amedment/delete/{id}', 'sales\CustomerController@deleteAmendment')->name('customer.amedment.delete');
        Route::get('/suspends/reactivates/list', 'sales\CustomerController@reactivates')->name('suspends.reactivates.lists');
        Route::get('/suspends/reactivate/show/{id}', 'sales\CustomerController@reactivateDetails')->name('suspends.reactivates.show');
        Route::get('/terminate/recontract/show/{id}', 'sales\CustomerController@recontractDetails')->name('terminate.recontract.show');

        // provincial customers
        Route::resource('/provincial', 'sales\ProvincialController');
        Route::get('/provincials/trashed', 'sales\ProvincialController@trashed')->name('provincial.trashed');
        Route::put('/provincials/trashed/{id}', 'sales\ProvincialController@restore')->name('provincial.restore');
        Route::put('/provincials/cashier/{id}', 'sales\ProvincialController@cashier')->name('pr_cashier');
        Route::put('/provincials/process/{id}', 'sales\ProvincialController@process')->name('pr_process');
        Route::get('/pr/attachments/{id}', 'sales\ProvincialController@prfiles')->name('pr.files');
        Route::put('/pr/files/{id}', 'sales\ProvincialController@pr_contract')->name('pr_contract');
        Route::post('/pr/files/remove', 'sales\ProvincialController@removeFile')->name('pr.sales.remove');
        Route::put('/pr/terminate/{id}', 'sales\ProvincialController@prTerminate')->name('pr.terminate');
        Route::get('/pr/sales/terminates', 'sales\ProvincialController@prTerminates')->name('pr.terminates');
        Route::get('/pr/sales/singleTerminate/{id}', 'sales\ProvincialController@singleTerminate')->name('pr.sales.terminate');
        Route::put('/pr/suspend/{id}', 'sales\ProvincialController@suspend')->name('pr.suspend.process');
        Route::get('/pr/suspends', 'sales\ProvincialController@suspends')->name('pr.suspends');
        Route::get('/pr/singleSuspend/{id}', 'sales\ProvincialController@singleSuspend')->name('pr.suspend');
        Route::get('/pr/recontract/form/{id}', 'sales\ProvincialController@recontract')->name('pr.recontract');
        Route::put('/pr/contraction/{id}', 'sales\ProvincialController@contraction')->name('pr.contraction');
        Route::get('/pr/suspend/form/{id}', 'sales\ProvincialController@suspendform')->name('pr.suspendform');
        Route::put('/pr/activating/{id}', 'sales\ProvincialController@activating')->name('pr.activating');
        Route::get('/pr/amendment/{id}', 'sales\ProvincialController@amendment')->name('pr.amendment');
        Route::put('/pr/amendmentation/{id}', 'sales\ProvincialController@amendmentation')->name('pr.amendmentation');
        Route::get('/pr/amendments', 'sales\ProvincialController@amendments')->name('pr.amendments');
        Route::get('/pr/amend/{id}', 'sales\ProvincialController@amend')->name('pr.amend');
        Route::get('/pr/payment/confirm', 'sales\ProvincialController@confirmed');
        Route::get('/pr/sales/suspendEvent', 'sales\ProvincialController@suspendEvent');
        Route::get('/pr/sales/cancelEvent', 'sales\ProvincialController@cancelEvent');
        Route::resource('/PrRequests', 'sales\ProvincialRequestController');
        Route::get('/pr/tr/requests', 'sales\ProvincialRequestController@requestEvent');
        Route::get('/sales/suspend/event', 'system\SearchController@salesSuspend');
        Route::get('/sales/cancels/customers', 'sales\CustomerController@cancelsEvent');
        Route::get('/pr/sales/files/{id}', 'sales\ProvincialController@prattaches')->name('pr.sales.attachments');
        Route::get('/pr/sales/print/{id}', 'sales\ProvincialController@prprint')->name('pr.sales.print');
        Route::put('/pr/sales/suspend/edit/{id}', 'sales\ProvincialController@editSuspend')->name('pr.suspend.edit');
        Route::delete('/pr/sales/suspend/delete/{id}', 'sales\ProvincialController@deleteSuspend')->name('pr.suspend.delete');
        Route::put('/pr/sales/terminate/edit/{id}', 'sales\ProvincialController@editTerminate')->name('pr.terminate.edit');
        Route::delete('/pr/sales/terminate/delete/{id}', 'sales\ProvincialController@deleteTerminate')->name('pr.terminate.delete');

        Route::get('/pr/sales/printAmendment', 'sales\ProvincialController@printPrAmendment')->name('printPrAmendment');
        Route::get('/pr/sales/printSuspend', 'sales\ProvincialController@printPrSuspend')->name('printPrSuspend');
        Route::get('/pr/sales/printTerminate', 'sales\ProvincialController@printPrTerminate')->name('printPrTerminate');

        Route::get('/pr/amedment/edit/{id}', 'sales\ProvincialController@prEditAmendment')->name('pr.amedment.edit');
        Route::put('/pr/amedment/update/{id}', 'sales\ProvincialController@prUpdateAmendment')->name('pr.amedment.updateAmendment');
        Route::delete('/pr/amedment/delete/{id}', 'sales\ProvincialController@deleteAmendment')->name('pr.amedment.delete');
        Route::get('/pr/reactivate/{id}', 'sales\ProvincialController@reactivateDetails')->name('pr.reactivate.details');
        Route::get('/pr/recontract/{id}', 'sales\ProvincialController@recontractDetails')->name('pr.recontract.details');
    });

    //Group middleware for noc
    Route::group(['middleware' => ['noc']], function () {
        Route::resource('/installation', 'noc\InstallationController');
        Route::get('/installation/customers/terminates', 'noc\InstallationController@terminates')->name('installation.terminates');
        Route::get('/noc/customers/terminate/{id}', 'noc\InstallationController@terminate')->name('noc.terminate');
        Route::get('/requests/noc', 'noc\InstallationController@requests')->name('noc.requests');
        Route::put('/installation_contract/{id}', 'noc\InstallationController@installation_contract')->name('installation_contract');
        Route::get('/installation/customers/suspends', 'noc\InstallationController@suspends')->name('noc.suspends');
        Route::get('/noc/singleSuspend/{id}', 'noc\InstallationController@singleSuspend')->name('noc.singleSuspend');
        Route::get('/noc/activate/{id}', 'noc\InstallationController@activateForm')->name('noc.activateForm');
        Route::put('/noc/reactivate/{id}', 'noc\InstallationController@reactivate')->name('noc.reactivate');
        Route::put('/noc/suspend/{id}', 'noc\InstallationController@suspend')->name('noc.suspend');
        Route::resource('NocRequests', 'noc\RequestController');
        Route::get('/noc/amedment/list', 'noc\InstallationController@amedmentList')->name('noc.amedment');
        Route::get('/noc/cancels/amendments', 'noc\InstallationController@cancelsAmendments')->name('noc.cancels.amedments');
        Route::get('/noc/customers/amend/{id}', 'noc\InstallationController@amend')->name('noc.amedment.amend');
        Route::get('/noc/cancel/amend/{id}', 'noc\InstallationController@cancelAmendment')->name('noc.cancel.amend');
        Route::post('/noc/files/remove', 'noc\InstallationController@nocRemove')->name('noc.remove');
        Route::get('/noc/attachments/{id}', 'noc\InstallationController@attachments')->name('noc.attachment');
        Route::post('/noc/files/remove', 'noc\InstallationController@removefile')->name('noc.remove');
        Route::get('/update/customer/process', 'system\SearchController@nocProcess');
        Route::get('/suspend/noc/customer', 'system\SearchController@nocSuspend');
        Route::get('/terminate/noc/customer', 'system\SearchController@nocTerminate');
        Route::get('/amed/noc/customer', 'system\SearchController@nocAmed');
        Route::get('/noc/customer/attachment/{id}', 'noc\InstallationController@customerAttachments')->name('noc.customer.attachment');
        Route::get('/noc/cancels/PrAmendments', 'noc\ProvincialCustomerController@cancelsPrAmendments')->name('noc.cancels.PrAmedments');
        Route::get('/noc/cancel/PrAmend/{id}', 'noc\ProvincialCustomerController@cancelPrAmendment')->name('noc.cancel.PrAmend');
        Route::put('noc/suspend/edit/{id}', 'noc\InstallationController@suspendEdit')->name('noc.suspend.edit');
        Route::delete('noc/suspend/delete/{id}', 'noc\InstallationController@suspendDelete')->name('noc.suspend.delete');

        Route::get('/noc/reactivates/list', 'noc\InstallationController@reactivates')->name('noc.reactivates.lists');
        Route::get('/noc/reactivate/show/{id}', 'noc\InstallationController@reactivateDetails')->name('noc.reactivates.show');
        Route::get('/noc/recontract/show/{id}', 'noc\InstallationController@recontractDetails')->name('noc.recontract.show');

        // provincial customers
        Route::resource('/prCustomers', 'noc\ProvincialCustomerController');
        Route::get('/prCustomer/files/{id}', 'noc\ProvincialCustomerController@files')->name('pr.noc.files');
        Route::put('/pr/noc/files/{id}', 'noc\ProvincialCustomerController@pr_files')->name('pr.noc.contract');
        Route::post('/pr/remove/files', 'noc\ProvincialCustomerController@prRemove')->name('pr.remove');
        Route::get('/pr/noc/terminates', 'noc\ProvincialCustomerController@terminates')->name('pr.noc.terminates');
        Route::get('/pr/noc/terminate/{id}', 'noc\ProvincialCustomerController@singleTerminate')->name('pr.noc.terminate');
        Route::get('/pr/noc/requests', 'noc\ProvincialCustomerController@requests')->name('pr.noc.requests');
        Route::get('/pr/noc/suspends', 'noc\ProvincialCustomerController@suspends')->name('pr.noc.suspends');
        Route::get('/pr/noc/suspend/{id}', 'noc\ProvincialCustomerController@singleSuspend')->name('pr.noc.suspend');
        Route::get('/pr/noc/active/{id}', 'noc\ProvincialCustomerController@activeform')->name('pr.noc.active');
        Route::put('/pr/noc/activating/{id}', 'noc\ProvincialCustomerController@activating')->name('pr.noc.activiating');
        Route::put('/pr/noc/suspend/{id}', 'noc\ProvincialCustomerController@suspend')->name('pr.noc.suspend.process');
        Route::get('/pr/noc/amendments', 'noc\ProvincialCustomerController@amendments')->name('pr.noc.amendments');
        Route::get('/pr/noc/amend/{id}', 'noc\ProvincialCustomerController@amend')->name('pr.noc.amend');
        Route::resource('/prRequests', 'noc\ProvincialRequestController');
        Route::get('/pr/noc/process', 'noc\ProvincialCustomerController@processEvent');
        Route::get('/pr/noc/terminate', 'noc\ProvincialCustomerController@terminateEvent');
        Route::get('/pr/noc/suspendEvent', 'noc\ProvincialCustomerController@suspendEvent');
        Route::get('/pr/noc/amendmentEvent', 'noc\ProvincialCustomerController@amendmentEvent');
        Route::get('/pr/noc/cancelEvent', 'noc\ProvincialCustomerController@cancelEvent');
        Route::get('/pr/noc/files/{id}', 'noc\ProvincialCustomerController@prfiles')->name('pr.noc.attachments');
        Route::put('/pr/noc/suspend/edit/{id}', 'noc\ProvincialCustomerController@editSuspend')->name('pr.noc.suspend.edit');
        Route::delete('/pr/noc/suspend/delete/{id}', 'noc\ProvincialCustomerController@deleteSuspend')->name('pr.noc.suspend.delete');
        Route::get('/pr/noc/reactivate/{id}', 'noc\ProvincialCustomerController@reactivateDetails')->name('pr.noc.reactivate.details');
        Route::get('/pr/noc/recontract/{id}', 'noc\ProvincialCustomerController@recontractDetails')->name('pr.noc.recontract.details');
    });

    //Group middleware for finance
    Route::group(['middleware' => ['finance']], function () {
        Route::resource('/finance', 'finance\FinanceController');
        Route::get('/terminates/finance', 'finance\FinanceController@terminated')->name('finance.terminated');
        Route::get('/finance/terminate/{id}', 'finance\FinanceController@terminate')->name('finance.terminate');
        Route::get('/requests/finance', 'finance\FinanceController@requests')->name('finance.requests');
        Route::get('/finance/customers/suspends', 'finance\FinanceController@suspends')->name('finance.suspends');
        Route::get('/finance/singleSuspend/{id}', 'finance\FinanceController@singleSuspend')->name('singleSuspend');
        Route::get('/finance/activate/{id}', 'finance\FinanceController@activateForm')->name('finance.activate');
        Route::put('/finance/reactive/{id}', 'finance\FinanceController@reactivate')->name('finance.reactivate');
        Route::put('/finance/suspend/{id}', 'finance\FinanceController@suspend')->name('finance.suspend');
        Route::resource('/requests', 'finance\RequestController');
        Route::get('/finance/amedment/list', 'finance\FinanceController@amedmentList')->name('finance.amedment');
        Route::get('/finance/cancels/amendments', 'finance\FinanceController@cancelsAmendments')->name('finance.cancels.amedments');
        Route::get('/finance/customers/amend/{id}', 'finance\FinanceController@amend')->name('finance.amends.amend');
        Route::get('/finance/cancels/amend/{id}', 'finance\FinanceController@cancelAmendment')->name('finance.cancel.amedment');
        Route::get('/finance/attachments/{id}', 'finance\FinanceController@attachments')->name('finance.files');
        Route::get('/update/customers/new', 'system\SearchController@financeCustomersUpdate');
        Route::get('/suspend/finance/customer', 'system\SearchController@financeSuspend');
        Route::get('/terminate/finance/customer', 'system\SearchController@financeTerminate');
        Route::get('/amed/finance/customer', 'system\SearchController@financeAmed');
        Route::get('/finance/cancels/customers', 'finance\FinanceController@cancelsEvent');
        Route::get('/finance/cancels/prAmendments', 'finance\ProvincialCustomerController@cancelsPrAmendments')->name('finance.cancels.PrAmedments');
        Route::get('/finance/cancels/prAmend/{id}', 'finance\ProvincialCustomerController@cancelPrAmendment')->name('finance.cancel.PrAmedment');
        Route::put('finance/suspend/edit/{id}', 'finance\FinanceController@suspendEdit')->name('finance.suspend.edit');
        Route::delete('finance/suspend/delete/{id}', 'finance\FinanceController@suspendDelete')->name('finance.suspend.delete');

        Route::get('/finance/reactivates/list', 'finance\FinanceController@reactivates')->name('finance.reactivates.lists');
        Route::get('/finance/reactivate/show/{id}', 'finance\FinanceController@reactivateDetails')->name('finance.reactivates.show');
        Route::get('/finance/recontract/show/{id}', 'finance\FinanceController@recontractDetails')->name('finance.recontract.show');

        //Provincial customers
        Route::resource('/prc', 'finance\ProvincialCustomerController');
        Route::get('/pr/finance/files/{id}', 'finance\ProvincialCustomerController@files')->name('pr.finance.files');
        Route::get('/pr/terminates', 'finance\ProvincialCustomerController@terminates')->name('pr.fin.terminates');
        Route::get('/pr/terminate/{id}', 'finance\ProvincialCustomerController@singleTerminate')->name('pr.fin.terminate');
        Route::get('/pr/requests', 'finance\ProvincialCustomerController@requests')->name('pr.fin.requests');
        Route::get('/pr/fin/suspends', 'finance\ProvincialCustomerController@suspends')->name('pr.fin.suspends');
        Route::get('/pr/fin/suspend/{id}', 'finance\ProvincialCustomerController@singleSuspend')->name('pr.fin.suspend');
        Route::get('/pr/fin/activate/{id}', 'finance\ProvincialCustomerController@activate')->name('pr.fin.activate');
        Route::put('/pr/fin/activating/{id}', 'finance\ProvincialCustomerController@activating')->name('pr.fin.activating');
        Route::put('/pr/fin/suspend/{id}', 'finance\ProvincialCustomerController@suspend')->name('pr.fin.suspend.process');
        Route::get('/pr/fin/amendments', 'finance\ProvincialCustomerController@amendments')->name('pr.fin.amends');
        Route::get('/pr/fin/amend/{id}', 'finance\ProvincialCustomerController@amend')->name('pr.fin.amend');
        Route::resource('/trRequests', 'finance\ProvincialRequestController');
        Route::get('/pr/fin/payment', 'finance\ProvincialCustomerController@payment');
        Route::get('/pr/fin/terminate', 'finance\ProvincialCustomerController@terminateEvent');
        Route::get('/pr/finance/suspendEvent', 'finance\ProvincialCustomerController@suspendEvent');
        Route::get('/pr/finance/amendEvent', 'finance\ProvincialCustomerController@amendEvent');
        Route::get('/pr/finance/cancelEvent', 'finance\ProvincialCustomerController@cancelEvent');
        Route::put('/pr/finance/suspend/edit/{id}', 'finance\ProvincialCustomerController@editSuspend')->name('pr.finance.suspend.edit');
        Route::delete('/pr/finance/suspend/delete/{id}', 'finance\ProvincialCustomerController@deleteSuspend')->name('pr.finance.suspend.delete');
        Route::get('/pr/finance/reactivate/{id}', 'finance\ProvincialCustomerController@reactivateDetails')->name('pr.finance.reactivate.details');
        Route::get('/pr/finance/recontract/{id}', 'finance\ProvincialCustomerController@recontractDetails')->name('pr.finance.recontract.details');
    });

    //Group middleware for manager
    Route::group(['middleware' => ['admin']], function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::get('/users/show/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::put('/user/permission/{id}', [UserController::class, 'setAccess'])->name('users.setAccess');

        Route::get('/categories/trashed', 'Admin\PackageCategoryController@trashed')->name('categories.trashed');
        Route::put('/categories/restore/{id}', 'Admin\PackageCategoryController@restore')->name('categories.restore');
        Route::resource('/categories', 'Admin\PackageCategoryController');

        Route::get('/package/trashed', 'Admin\PackageController@trashed')->name('packages.trashed');
        Route::put('/package/restore/{id}', 'Admin\PackageController@restore')->name('packages.restore');
        Route::resource('/packages', 'Admin\PackageController');

        Route::get('/admin/customers', 'Admin\AdminController@customers')->name('admin.customers');
        Route::get('/admin/customer/{id}', 'Admin\AdminController@customer')->name('admin.customer');
        Route::get('/admin/packages', 'Admin\AdminController@packages')->name('admin.packages');
        Route::get('/admin/package/{id}', 'Admin\AdminController@package')->name('admin.package');
        Route::get('/admin/cates', 'Admin\AdminController@categories')->name('admin.categories');
        Route::get('/user/trashed', [UserController::class, 'trashed'])->name('user.trashed');
        Route::put('/user/trashed/{id}', [UserController::class, 'restore'])->name('user.restore');
        Route::get('/admin/customers/terminates', 'Admin\AdminController@terminates')->name('admin.customers.terminates');
        Route::get('/admin/terminate/{id}', 'Admin\AdminController@terminate')->name('customers.terminate');
        Route::get('/admin/customers/suspends', 'Admin\AdminController@suspends')->name('admin.suspends');
        Route::get('/admin/singleSuspend/{id}', 'Admin\AdminController@singleSuspend')->name('admin.singleSuspend');
        Route::get('/admin/amedment/list', 'Admin\AdminController@amedmentList')->name('admin.amedment');
        Route::get('/admin/customers/amend/{id}', 'Admin\AdminController@amend')->name('customers.amend');
        Route::get('/admin/customers/map', 'Admin\AdminController@map')->name('admin.map');
        Route::get('/admin/attachments/{id}', 'Admin\AdminController@attachments')->name('admin.files');
        Route::get('/admin/provincials', 'Admin\ProvincialCustomerController@index')->name('admin.provincial');
        Route::get('admin/pr/sus', 'Admin\ProvincialCustomerController@suspends')->name('admin.pr.suspends');
        Route::get('admin/pr/sus/{id}', 'Admin\ProvincialCustomerController@singleSuspend')->name('admin.pr.suspend');
        Route::get('/admin/pr/ter', 'Admin\ProvincialCustomerController@terminates')->name('admin.terminates');
        Route::get('/admin/pr/ter/{id}', 'Admin\ProvincialCustomerController@singleTerminate')->name('admin.terminate');
        Route::get('/admin/pr/amends', 'Admin\ProvincialCustomerController@amendments')->name('admin.amends');
        Route::get('/admin/pr/amend/{id}', 'Admin\ProvincialCustomerController@amend')->name('admin.amend');
        Route::get('/admin/pr/trashes', 'Admin\ProvincialCustomerController@trashes')->name('admin.pr.tr');
        Route::get('/admin/pr/{id}', 'Admin\ProvincialCustomerController@show')->name('admin.pr.show');
        Route::get('/admin/pr/files/{id}', 'Admin\ProvincialCustomerController@files')->name('admin.pr.files');
        Route::get('/admin/prRequests', 'Admin\AdminController@prRequests')->name('man.pr.requests');
        Route::get('/admin/prRequest/{id}', 'Admin\AdminController@prRequest')->name('man.pr.request');
        // Commissions Routes
        Route::get('/commissions/trashed', [CommissionController::class, 'trashed'])->name('commissions.trashed');
        Route::put('/commissions/restore/{id}', [CommissionController::class, 'restore'])->name('com.restore');
        Route::resource('/commission', 'Admin\CommissionController');
        // Marketers Routes
        Route::get('/marketers/trashed', 'Admin\marketerController@trashed')->name('marketers.trashed');
        Route::put('/marketers/restore/{id}', 'Admin\marketerController@restore')->name('marketers.restore');
        Route::resource('/marketers', 'Admin\marketerController');

        Route::get('/cancels/amendments/mr', 'Admin\AdminController@cancelsAmendments')->name('cancels.amendments.mr');
        Route::get('/cancels/amendments/mr/{id}', 'Admin\AdminController@cancelAmendment')->name('cancel.amendment.mr');
        Route::get('/cancels/prAmendments/mr', 'Admin\AdminController@cancelsPrAmendments')->name('cancels.prAmendments.mr');
        Route::get('/cancels/prAmendment/mr/{id}', 'Admin\AdminController@cancelPrAmendment')->name('cancel.PrAmendment.mr');

        Route::get('/admin/reactivates/list', 'Admin\AdminController@reactivates')->name('admin.reactivates.lists');
        Route::get('/admin/reactivate/show/{id}', 'Admin\AdminController@reactivateDetails')->name('admin.reactivates.show');
        Route::get('/admin/recontract/show/{id}', 'Admin\AdminController@recontractDetails')->name('admin.recontract.show');

        Route::get('/reports/index', 'Admin\ReportController@index')->name('reports.index');
        Route::get('/reports/customers', 'Admin\ReportController@customers')->name('reports.customers');
        Route::get('/reports/customers/export', 'Admin\ReportController@exportActiveCustomers')->name('export-active-customers');
        Route::get('/reports/installation', 'Admin\ReportController@installation')->name('reports.installation');
        Route::get('/reports/installation/export', 'Admin\ReportController@exportTotalCustomers')->name('export-total-customers');
        Route::get('/reports/terminates', 'Admin\ReportController@terminates')->name('reports.terminates');
        Route::get('/reports/terminates/export', 'Admin\ReportController@exportTerminatedCustomers')->name('export-terminated-customers');
        Route::get('/reports/recontract', 'Admin\ReportController@recontract')->name('reports.recontract');
        Route::get('/reports/recontract/export', 'Admin\ReportController@exportRecontracts')->name('export-recontracts');
        Route::get('/reports/suspends', 'Admin\ReportController@suspends')->name('reports.suspends');
        Route::get('/reports/suspends/export', 'Admin\ReportController@exportSuspends')->name('export-suspends');
        Route::get('/reports/reactivate', 'Admin\ReportController@reactivate')->name('reports.reactivate');
        Route::get('/reports/reactivate/export', 'Admin\ReportController@exportReactivates')->name('export-reactivates');
        Route::get('/reports/amendments', 'Admin\ReportController@amendments')->name('reports.amendments');
        Route::get('/reports/amendments/export', 'Admin\ReportController@exportAmendments')->name('export-amendments');
        Route::get('/reports/cancelAmendments', 'Admin\ReportController@cancelAmendments')->name('reports.cancel.amendments');
        Route::get('/reports/cancelAmendments/export', 'Admin\ReportController@exportCancelAmendments')->name('export-cancel-amendments');
        Route::get('/reports/cancels', 'Admin\ReportController@cancels')->name('reports.cancels');
        Route::get('/reports/cancels/export', 'Admin\ReportController@exportCancels')->name('export-cancels');
        Route::get('/reports/device', 'Admin\ReportController@device')->name('reports.device');
        Route::get('/reports/device/export', 'Admin\ReportController@exportDevices')->name('export-devices');
        Route::get('/reports/base', 'Admin\ReportController@base')->name('reports.base');
        Route::get('/reports/base/export', 'Admin\ReportController@exportBases')->name('export-bases');
        Route::get('/reports/package', 'Admin\ReportController@package')->name('reports.package');
        Route::get('/reports/package/export', 'Admin\ReportController@exportPackages')->name('export-packages');

        Route::get('/charts/customers', [ChartController::class, 'customers'])->name('charts.customers');
        Route::get('/charts/activated', [ChartController::class, 'activated'])->name('charts.activated');
        Route::get('/charts/terminates', [ChartController::class, 'terminates'])->name('charts.terminates');
        Route::get('/charts/recontract', [ChartController::class, 'recontract'])->name('charts.recontract');
        Route::get('/charts/suspends', [ChartController::class, 'suspends'])->name('charts.suspends');
        Route::get('/charts/reactivate', [ChartController::class, 'reactivate'])->name('charts.reactivate');
        Route::get('/charts/amendments', [ChartController::class, 'amendments'])->name('charts.amendments');
        Route::get('/charts/cancelAmendments', [ChartController::class, 'cancelAmendments'])->name('charts.cancels.amendments');
        Route::get('/charts/cancels', [ChartController::class, 'cancels'])->name('charts.cancels');
        Route::get('/charts/device', [ChartController::class, 'device'])->name('charts.device');
        Route::get('/charts/branch', [ChartController::class, 'branch'])->name('charts.branch');
        Route::get('/charts/package', [ChartController::class, 'package'])->name('charts.package');

        Route::get('/OutSource/reports/index', 'Admin\OutSourceReportsController@index')->name('outsource.reports.index');
        Route::get('/OutSource/reports/installation', 'Admin\OutSourceReportsController@installation')->name('outsource.reports.installation');
        Route::get('/OutSource/reports/installation/export', 'Admin\OutSourceReportsController@exportTotalCustomers')->name('provincial.export-total');
        Route::get('/OutSource/reports/customers', 'Admin\OutSourceReportsController@customers')->name('outsource.reports.customers');
        Route::get('/OutSource/reports/customers/export', 'Admin\OutSourceReportsController@exportActiveCustomers')->name('provincial.export-actives');
        Route::get(
            '/OutSource/reports/terminates',
            'Admin\OutSourceReportsController@terminates'
        )->name('outsource.reports.terminates');
        Route::get('/OutSource/reports/terminates/export', 'Admin\OutSourceReportsController@exportTerminatedCustomers')->name('provincial.export-terminated');
        Route::get('/OutSource/reports/recontract', 'Admin\OutSourceReportsController@recontract')->name('outsource.reports.recontract');
        Route::get('/OutSource/reports/recontract/export', 'Admin\OutSourceReportsController@exportRecontracts')->name('provincial.export.recontract');
        Route::get('/OutSource/reports/suspends', 'Admin\OutSourceReportsController@suspends')->name('outsource.reports.suspends');
        Route::get('/OutSource/reports/suspends/export', 'Admin\OutSourceReportsController@exportSuspends')->name('provincial.export-suspends');
        Route::get('/OutSource/reports/reactivate', 'Admin\OutSourceReportsController@reactivate')->name('outsource.reports.reactivate');
        Route::get('/OutSource/reports/reactivate/export', 'Admin\OutSourceReportsController@exportReactivates')->name('provincial.export-reactivate');
        Route::get('/OutSource/reports/amendments', 'Admin\OutSourceReportsController@amendments')->name('outsource.reports.amendments');
        Route::get('/OutSource/reports/amendments/export', 'Admin\OutSourceReportsController@exportAmendments')->name('provincial.export-amendments');
        Route::get('/OutSource/reports/cancelAmendments', 'Admin\OutSourceReportsController@cancelAmendments')->name('outsource.reports.cancelAmendments');
        Route::get('/OutSource/reports/cancelAmendments/export', 'Admin\OutSourceReportsController@exportCancelAmendments')->name('provincial.export-cance-amendments');
        Route::get('/OutSource/reports/cancels', 'Admin\OutSourceReportsController@cancels')->name('outsource.reports.cancels');
        Route::get('/OutSource/reports/cancels/export', 'Admin\OutSourceReportsController@exportCancels')->name('provincial.export-cancels');
        Route::get('/OutSource/reports/device', 'Admin\OutSourceReportsController@device')->name('outsource.reports.device');
        Route::get('/OutSource/reports/device/export', 'Admin\OutSourceReportsController@exportDevices')->name('provincial.export-device');
        Route::get('/OutSource/reports/base', 'Admin\OutSourceReportsController@base')->name('outsource.reports.base');
        Route::get('/OutSource/reports/base/export', 'Admin\OutSourceReportsController@exportBases')->name('provincial.export-bases');
        Route::get('/OutSource/reports/package', 'Admin\OutSourceReportsController@package')->name('outsource.reports.package');
        Route::get('/OutSource/reports/package/export', 'Admin\OutSourceReportsController@exportPackages')->name('provincial.export-packages');
        Route::get('/OutSource/reports/resellers', 'Admin\OutSourceReportsController@resellers')->name('outsource.reports.resellers');
        Route::get('/OutSource/reports/resellers/export', 'Admin\OutSourceReportsController@exportResellers')->name('provincial.export-resellers');

        Route::get('/OutSource/charts/customers', 'Admin\OutSourceChartsController@customers')->name('outsource.charts.customers');
        Route::get('/OutSource/charts/activated', 'Admin\OutSourceChartsController@activated')->name('outsource.charts.activated');
        Route::get('/OutSource/charts/terminates', 'Admin\OutSourceChartsController@terminates')->name('outsource.charts.terminates');
        Route::get('/OutSource/charts/recontract', 'Admin\OutSourceChartsController@recontract')->name('outsource.charts.recontract');
        Route::get('/OutSource/charts/suspends', 'Admin\OutSourceChartsController@suspends')->name('outsource.charts.suspends');
        Route::get('/OutSource/charts/reactivate', 'Admin\OutSourceChartsController@reactivate')->name('outsource.charts.reactivate');
        Route::get('/OutSource/charts/amendments', 'Admin\OutSourceChartsController@amendments')->name('outsource.charts.amendments');
        Route::get('/OutSource/charts/cancelAmendments', 'Admin\OutSourceChartsController@cancelAmendments')->name('outsource.charts.cancelAmendments');
        Route::get('/OutSource/charts/cancels', 'Admin\OutSourceChartsController@cancels')->name('outsource.charts.cancels');
        Route::get('/OutSource/charts/resellers', 'Admin\OutSourceChartsController@resellers')->name('outsource.charts.resellers');
        Route::get('/OutSource/charts/branch', 'Admin\OutSourceChartsController@branch')->name('outsource.charts.branch');
        Route::get('/OutSource/charts/package', 'Admin\OutSourceChartsController@package')->name('outsource.charts.package');

        Route::get('branch/trashed', 'system\BranchController@trashed')->name('branch.trashed');
        Route::put('branch/restore/{id}', 'system\BranchController@restore')->name('branch.restore');
        Route::resource('branch', 'system\BranchController');

        Route::get('province/trashed', 'system\ProvinceController@trashed')->name('province.trashed');
        Route::put('province/restore/{id}', 'system\ProvinceController@restore')->name('province.restore');
        Route::resource('province', 'system\ProvinceController');
        Route::get('/pr/admin/reactivate/{id}', 'Admin\ProvincialCustomerController@reactivateDetails')->name('pr.manager.reactivate.details');
        Route::get('/pr/admin/recontract/{id}', 'Admin\ProvincialCustomerController@recontractDetails')->name('pr.manager.recontract.details');

        // Permissions Route
        Route::get('/permissions/trashed', [PermissionController::class, 'trashed'])->name('permissions.trashed');
        Route::put('/permissions/trashed/{id}', [PermissionController::class, 'restore'])->name('permissions.restore');
        Route::resource('/permissions', 'Admin\PermissionController');
    });

    //Group middleware for support
    Route::group(['middleware' => ['support']], function () {
    });
});

Route::group(['middleware' => ['guest']], function () {

    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/signIn', [UserController::class, 'signIn'])->name('signIn');
    // Route::get('/register', 'users\usersController@register')->name('register');
    // Route::post('/signUp', 'users\usersController@signUp')->name('signUp');
});
