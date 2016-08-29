<?php
namespace App\Models\File\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

/**
 * Class Media
 * 
 * @package App\Models\File\Media
 */
class Media extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file_media';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];
    
    private $file;
    
    public function file() {
        if (is_null($this->file)) {
            $this->file = $this->getMedia()->first();
        }
        return $this->file;
    }
    
    public function file_type_ico() {
        $file_name = $this->file()->file_name;
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'doc':
            case 'docx':
                $icon = 'fa-file-word-o';
                break;
            case 'xls':
            case 'xlsx':
                $icon = 'fa-file-excel-o';
                break;
            default:
                $icon = 'fa-file-o';
                break;
        }
        return $icon;
    }
}
