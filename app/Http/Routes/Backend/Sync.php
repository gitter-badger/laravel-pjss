<?php
Route::group([
    'prefix' => 'sync',
    'namespace' => 'Sync'
], function () {
    Route::group([
        'prefix' => 'leangoo',
        'namespace' => 'Leangoo'
    ], function () {       
        Route::get('project/{id}', 'ProjectController@get')->name('admin.organization.project.get');
    });
   
});