<?php
Route::group([
    'prefix' => 'organization',
    'namespace' => 'Organization'
], function () {
    Route::group([
        'namespace' => 'Team'
    ], function () {
        Route::resource('team', 'TeamController', [
            'except' => [
                'show'
            ]
        ]);
        
        /**
         * For DataTables
         */
        Route::get('team/get', 'TeamController@get')->name('admin.organization.team.get');
    });
});