<?php
/**
 * SSO
 */
Route::group([
    'prefix' => 'sso',
], function () {
    /*
     * 畅言
     */
    Route::group([
        'prefix' => 'changyan',
    ], function () {
        Route::get('/', 'SSOController@changyan')->name('oauth.sso.changyan.info');
    });
});