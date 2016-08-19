<?php

Route::group([
    'prefix'     => 'scrum',
    'namespace'  => 'Scrum',
], function() {

	/**
	 * UserStory Management
	 */
	Route::group(['namespace' => 'UserStory'], function() {
		Route::resource('userstory', 'UserStoryController');
		
		Route::post('userstory/import_excel', 'UserStoryController@importExcel')->name('admin.scrum.userstory.import_excel');
		Route::get('userstory/download_excel', 'UserStoryController@downloadExcel')->name('admin.scrum.userstory.download_excel');
	});
	
	// Replacer
});