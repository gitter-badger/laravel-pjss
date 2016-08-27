<?php
Route::group([
    'prefix' => 'scrum',
    'namespace' => 'Scrum'
], function () {
    
    /**
     * UserStory Management
     */
    Route::group([
        'namespace' => 'UserStory'
    ], function () {
        Route::resource('userstory', 'UserStoryController');
        
        Route::post('userstory/import_excel', 'UserStoryController@importExcel')->name('admin.scrum.userstory.import_excel');
        Route::get('userstory/export_excel', 'UserStoryController@exportExcel')->name('admin.scrum.userstory.export_excel');
        
        Route::post('userstory/re_order', 'UserStoryController@reOrder')->name('admin.scrum.userstory.re_order');
        Route::post('userstory/exchange', 'UserStoryController@exchange')->name('admin.scrum.userstory.exchange');
    });
    
    /**
     * AcceptanceCriteria Management
     */
    Route::group([
        'namespace' => 'AcceptanceCriteria'
    ], function () {
        Route::resource('acceptancecriteria', 'AcceptanceCriteriaController');
    });
    
    /**
     * BacklogMeeting Management
     */
    Route::group([
        'namespace' => 'BacklogMeeting'
    ], function () {
        Route::resource('backlogmeeting', 'BacklogMeetingController');
    });
    
    // Replacer
});