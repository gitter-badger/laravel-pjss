<?php
namespace App\Http\Requests\Backend\Scrum\UserStory\Excel;

class UserStoryExport extends \Maatwebsite\Excel\Files\NewExcelFile
{
    public function getFilename()
    {
        return '用户故事';
    }
}