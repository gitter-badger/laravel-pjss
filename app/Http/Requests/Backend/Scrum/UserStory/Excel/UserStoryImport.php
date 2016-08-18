<?php
namespace App\Http\Requests\Backend\Scrum\UserStory\Excel;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class UserStroyImport extends \Maatwebsite\Excel\Files\ExcelFile
{

    public function getFile()
    {
        // Import a user provided file
        $file = Input::file('file');
        $filename = $this->upload($file);
        
        // Return it's location
        return $filename;
    }

    public function getFilters()
    {
        return [
            'chunk'
        ];
    }

    private function upload(UploadedFile $file)
    {
        $storage_dir = app()->storagePath() . '/app/public/uploads/';
        $storage_file = Str::quickRandom() . '.' . $file->getClientOriginalExtension();
        $file->move($storage_dir, $storage_file);
        return $storage_dir . $storage_file;
    }
}