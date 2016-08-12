<?php
Route::group([
    'prefix' => 'organization',
    'namespace' => 'Organization'
], function () {
    Route::group([
        'namespace' => 'Team'
    ], function () {
        Route::resource('team', 'TeamController', []);
        
        /**
         * For DataTables
         */
        Route::get('team/get', 'TeamController@get')->name('admin.organization.team.get');
    });
    
    Route::group([
        'namespace' => 'Project'
    ], function () {
        Route::resource('project', 'ProjectController');
    });
});