<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::middleware(['subscription'])->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::post('get-workspace-member', 'getWorkspaceMembers')->name('getWorkspaceMembers')->middleware('permission:member_view');
        Route::post('create-workspaces', 'createWorkspace')->name('createWorkspace')->middleware('permission:member_create');
        Route::post('update-workspaces', 'updateWorkspace')->name('updateWorkspace');
        Route::post('remove-workspaces', 'removeWorkspace')->name('removeWorkspace');
        Route::post('update-workspace-member', 'updateWorkspaceMember')->name('updateWorkspaceMember')->middleware('permission:member_edit');
        Route::post('remove-workspace-member', 'removeWorkspaceMember')->name('removeWorkspaceMember')->middleware('permission:member_remove');
        Route::post('send-workspaces-invitation', 'sendWorkspaceInvitation')->name('sendWorkspaceInvitation')->middleware('permission:member_invite');
        #Settings
        Route::get('settings', 'settings')->name('settings');
        Route::post('profile-update', 'profileUpdate')->name('profileUpdate');
        Route::post('password-update', 'updatePassword')->name('updatePassword');
        Route::post('upload-profile-picture', 'uploadProfilePicture')->name('uploadProfilePicture');
    });

    Route::get('get-workspaces', 'getWorkspaces')->name('getWorkspaces');
    Route::post('switch-workspaces', 'switchWorkspace')->name('switchWorkspace');
    Route::get('get-workspace-invitation', 'getWorkspaceInvitation')->name('getWorkspaceInvitation');
    Route::post('accept-invitation', 'acceptInvitation')->name('acceptInvitation');
    Route::post('reject-invitation', 'rejectInvitation')->name('rejectInvitation');


    Route::post('get-summery-stats', 'getSummeryStats')->name('getSummeryStats');
    Route::post('warmup-chart-stats', 'warmupChartStats')->name('warmupChartStats');
    Route::post('sequence-chart-stats', 'sequenceChartStats')->name('sequenceChartStats');
    Route::post('get-dashboard-emails', 'getDashboardEmails')->name('getDashboardEmails');
    Route::post('get-dashboard-sequences', 'getDashboardSequences')->name('getDashboardSequences');
//    Route::post('get-daily-warmup-data', 'getWarmupChartStats')->name('getWarmupChartStats');

});

Route::controller(BillingController::class)->prefix('billing')->group(function () {
    Route::get('/', 'index')->name('billing-index');
    Route::post('create-stripe-session', 'createStripeSession')->name('createStripeSession');
    Route::post('add-workspace-quantity', 'addWorkspaceQuantity')->name('addWorkspaceQuantity');
    Route::post('add-addons-item', 'addSubscriptionItemAddons')->name('addSubscriptionItemAddons');
    Route::get('invoices', 'getInvoices')->name('getInvoices');
    Route::get('update-card', 'updateCard')->name('updateCard');
});

Route::controller(UserController::class)->prefix('notification')->group(function () {
    Route::get('get', 'getNotifications')->name('getNotifications');
    Route::get('count', 'countNotification')->name('countNotification');
    Route::post('read', 'readNotification')->name('readNotification');
});

Route::controller(InboxController::class)->prefix('inbox')->group(function () {
    Route::get('/', 'inbox')->name('inboxList')->middleware('permission:read_inbox');
    Route::post('get-inboxes', 'getInboxes')->name('getInboxes')->middleware('permission:read_inbox');
    Route::post('update-status', 'updateStatus')->name('updateStatus');
    Route::post('reply-from-inbox', 'replyFromInbox')->name('replyFromInbox');
    Route::post('delete-from-inbox', 'deleteInboxes')->name('deleteInboxes')->middleware('permission:delete_inbox');
});

Route::controller(ProspectController::class)->prefix('prospects')->middleware(['subscription'])->group(function () {
    Route::get('/', 'prospectList')->name('prospectList')->middleware('permission:prospects_view');
    Route::post('get-prospects', 'getProspects')->name('getProspects')->middleware('permission:prospects_view');
    Route::post('create-prospects', 'createProspect')->name('createProspect')->middleware('permission:prospect_create');
    Route::post('delete-prospects', 'deleteProspects')->name('deleteProspects')->middleware('permission:prospects_delete');
    Route::get('get-prospect-list', 'getProspectList')->name('getProspectList');
    Route::post('save-new-list', 'saveNewList')->name('saveNewList');
    Route::post('update-list-name', 'updateListName')->name('updateListName');
    Route::post('delete-list', 'deleteProspectList')->name('deleteProspectList');
    Route::post('move-to-graveyard', 'moveToGraveyard')->name('moveToGraveyard')->middleware('permission:move_to_graveyard_list');
    Route::post('download-prospect-by-list', 'downloadProspectByList')->name('downloadProspectByList')->middleware('permission:prospects_download');
    Route::post('update-prospect', 'updateProspect')->name('updateProspect')->middleware('permission:prospects_edit');
    Route::post('upload-prospects', 'uploadProspects')->name('uploadProspects')->middleware('permission:prospect_create');
    Route::post('prospect-verify-status', 'prospectVerifyStatus')->name('prospectVerifyStatus');
    Route::post('verify-prospect-email', 'verifyProspectEmail')->name('verifyProspectEmail')->middleware('permission:email_verify');
    Route::post('download-prospects-by-id', 'downloadProspects')->name('downloadProspects')->middleware('permission:prospects_download');
    Route::post('download-all-prospects', 'downloadAllProspects')->name('downloadAllProspects')->middleware('permission:prospects_download');
    Route::get('marketplace', 'marketplaceIntegrations')->name('marketplaceIntegrations')->middleware('permission:prospects_view');
    Route::post('marketplace-data', 'marketplaceIntegrationsData')->name('marketplaceIntegrationsData')->middleware('permission:prospects_view');
    Route::post('marketplace/create-authorize-link', 'createAuthorizeLink')->name('createAuthorizeLink')->middleware('permission:prospects_view');
    Route::post('marketplace/grab-lists-by-api', 'grabListsByAPI')->name('grabListsByAPI')->middleware('permission:prospects_view');
    Route::post('marketplace/grab-lists-by-token', 'grabListsByToken')->name('downloadAllProspects')->middleware('permission:prospects_view');
    Route::post('marketplace/grab-contacts', 'grabContacts')->name('grabContacts')->middleware('permission:prospects_view');
});
