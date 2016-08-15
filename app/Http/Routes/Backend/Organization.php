<?php
Route::group([
    'prefix' => 'organization',
    'namespace' => 'Organization'
], function () {
    Route::group([
        'namespace' => 'Team'
    ], function () {
        Route::resource('team', 'TeamController');
    });
    
    Route::group([
        'namespace' => 'Project'
    ], function () {
        Route::resource('project', 'ProjectController');
    });
});