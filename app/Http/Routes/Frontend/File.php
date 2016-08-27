<?php

Route::group([
    'prefix'     => 'file',
    'namespace'  => 'File',
], function() {

	/**
	 * Media Management
	 */
	Route::group(['namespace' => 'Media'], function() {
		Route::resource('media', 'MediaController');
	});
});