<?php
Route::group([
    'prefix' => 'file',
    'namespace' => 'File'
], function () {
    
    /**
     * Media Management
     */
    Route::group([
        'namespace' => 'Media'
    ], function () {
        Route::resource('media', 'MediaController');
        
        Route::post('media/upload', 'MediaController@upload')->name('admin.file.media.upload');
    });
    
    // Replacer
});