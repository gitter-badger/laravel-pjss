<?php

namespace App\Models\Scrum\AcceptanceCriteria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AcceptanceCriteria
 * @package App\Models\Scrum\AcceptanceCriteria
 */
class AcceptanceCriteria extends Model
{
	use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scrum_acceptance_criterias';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'condition'
    ];
    
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = '';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
