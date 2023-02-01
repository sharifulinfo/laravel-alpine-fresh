<?php

use App\Http\Controllers\Sequence\WebhookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('test',function(){
    $data = [
        'name' => 'tester',
        'email_provider' => 'tester',
        'link' => 'tester',
    ];
    return view('mails.email-tracking-disabled',$data);
    // return view('mails.email-provider-sending-limit-out',$data);
});


//Route::controller(UserController::class)->middleware('auth')->group(function () {
    Route::any('welcome', [UserController::Class,'welcome'])->middleware('auth')->name('welcome');
//});
Route::post('stripe/webhook', '\App\Http\Controllers\StripeWebhookController@handleWebhook');
//Route::post('stripe/webhook', '\App\Http\Controllers\StripeWebhookController::class@handleWebhook');

//Gmail oAuth2.0
Route::get('/emails/gmail/dev','\App\Http\Controllers\GmailController@dev');
Route::get('/emails/gmail/oauth-login','\App\Http\Controllers\GmailController@gmailOAuthLogin')->name('addGmailProvider');
Route::get('/emails/gmail/oauth-redirect','\App\Http\Controllers\GmailController@gmailOAuthRedirect');

Route::post('spy-user-logout', '\App\Http\Controllers\AdminController@spyUserLogout')->name('spyUserLogout');


    Route::get('{analytics_id}/unsubscribe', '\App\Http\Controllers\Sequence\WebhookController@unsubscribe');
Route::controller(WebhookController::class)->prefix('webhook-api')->group(function () {
    Route::post('{analytics_id}/unsubscribed', 'unsubscribePost')->name('unsubscribePost');

    Route::post('send-webhook-test-data', 'sendWebhookTestData')->name('sendWebhookTestData');
    Route::post('user-alert-notification/{type}', 'handleUserAlertNotification')->name('handleUserAlertNotification');
    /**********************************************/
    /*Route::post('webhook-api/sequence/{sequence_id}', 'handleIncomingWebhook')->name('handleIncomingWebhook');
    Route::post('webhook-api/analytics/{jobId}', 'handleAnalyticsWebHook')->name('handleAnalyticsWebHook');
    Route::post('webhook-api/campaign-sending-limit-out', 'handleCampaignSendingLimitOut')->name('handleCampaignSendingLimitOut');
//    Route::post('webhook-api/user-alert-notification/{type}', 'handleUserAlertNotification')->name('handleUserAlertNotification');*/
});
