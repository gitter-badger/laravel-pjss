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
        Route::get('media/{media}/download', 'MediaController@download')->name('admin.file.media.download');
    });
    
    // Replacer
});