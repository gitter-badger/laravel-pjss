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
    });
});