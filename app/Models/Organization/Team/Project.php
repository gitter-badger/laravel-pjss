<?php
namespace App\Models\Organization\Team;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project
 * 
 * @package App\Models\Organization\Team
 */
class Project extends Model
{
    
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'team_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];
}
