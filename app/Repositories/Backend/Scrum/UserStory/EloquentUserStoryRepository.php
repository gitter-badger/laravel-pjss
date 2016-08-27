<?php
namespace App\Repositories\Backend\Scrum\UserStory;

use App\Models\Scrum\UserStory\UserStory;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\Scrum\UserStory\UserStoryCreated;
use App\Events\Backend\Scrum\UserStory\UserStoryUpdated;
use App\Events\Backend\Scrum\UserStory\UserStoryDeleted;
use App\Events\Backend\Scrum\UserStory\UserStoryRestored;
use App\Repositories\Backend\Scrum\AcceptanceCriteria\AcceptanceCriteriaRepositoryContract;

/**
 * Class EloquentUserStoryRepository
 * 
 * @package App\Repositories\UserStory
 */
class EloquentUserStoryRepository implements UserStoryRepositoryContract
{

    /**
     *
     * @var AcceptanceCriteriaRepositoryContract
     */
    protected $acceptance_criteria;

    /**
     *
     * @param
     *            $acceptance_criteria
     */
    public function __construct(AcceptanceCriteriaRepositoryContract $acceptance_criteria)
    {
        $this->acceptance_criteria = $acceptance_criteria;
    }

    /**
     *
     * @param
     *            $input
     * @param
     *            $roles
     * @throws GeneralException
     * @return bool
     */
    public function create($input, $acceptance_criterias)
    {
        $userstory = $this->createUserStoryStub($input);
        
        DB::transaction(function () use($userstory, $acceptance_criterias) {
            if ($userstory->save()) {
                // Attach new acceptance_criterias
                $userstory->attachAcceptanceCriterias($acceptance_criterias['acceptance_criteria']);
                
                event(new UserStoryCreated($userstory));
                return true;
            }
            
            throw new GeneralException(trans('exceptions.backend.scrum.userstories.create_error'));
        });
    }

    /**
     *
     * @param UserStory $userstory            
     * @param
     *            $input
     * @param
     *            $roles
     * @return bool
     * @throws GeneralException
     */
    public function update(UserStory $userstory, $input, $acceptance_criterias)
    {
        DB::transaction(function () use($userstory, $input, $acceptance_criterias) {
            if ($userstory->update($input)) {
                // TODO: set properties
                
                $userstory->saveAcceptanceCriterias($acceptance_criterias['acceptance_criteria']);
                
                event(new UserStoryUpdated($userstory));
                return true;
            }
            
            throw new GeneralException(trans('exceptions.backend.scrum.userstories.update_error'));
        });
    }

    /**
     *
     * @param UserStory $userstory            
     * @throws GeneralException
     * @return bool
     */
    public function destroy(UserStory $userstory)
    {
        if ($userstory->delete()) {
            event(new UserStoryDeleted($userstory));
            return true;
        }
        
        throw new GeneralException(trans('exceptions.backend.scrum.userstories.delete_error'));
    }

    /**
     *
     * @param UserStory $userstory            
     * @throws GeneralException
     * @return boolean|null
     */
    public function delete(UserStory $userstory)
    {
        // Failsafe
        if (is_null($userstory->deleted_at)) {
            throw new GeneralException("This userstory must be deleted first before it can be destroyed permanently.");
        }
        
        DB::transaction(function () use($userstory) {
            // TODO: delete related entities
            
            if ($userstory->forceDelete()) {
                event(new UserStoryPermanentlyDeleted($userstory));
                return true;
            }
            
            throw new GeneralException(trans('exceptions.backend.scrum.userstories.delete_error'));
        });
    }

    /**
     *
     * @param UserStory $userstory            
     * @throws GeneralException
     * @return bool
     */
    public function restore(UserStory $userstory)
    {
        // Failsafe
        if (is_null($userstory->deleted_at)) {
            throw new GeneralException("This userstory is not deleted so it can not be restored.");
        }
        
        if ($userstory->restore()) {
            event(new UserStoryRestored($userstory));
            return true;
        }
        
        throw new GeneralException(trans('exceptions.backend.scrum.userstories.restore_error'));
    }

    /**
     *
     * @param
     *            $input
     * @param
     *            $roles
     * @throws GeneralException
     * @return bool
     */
    public function importExcel($input)
    {
        // 删除中文标题行
        array_splice($input, 0, 1);
        
        $user_stories = UserStory::all()->where('project_id', session('project_id'));
        foreach ($input as $num => $row) {
            DB::transaction(function () use($user_stories, $row) {
                $user_story = $user_stories->first(function ($key, $value) use($row) {
                    return $value->code == $row['code'];
                });
                if (! is_null($user_story)) {
                    $row['story_type'] = $this->storyTypeEnum[$row['story_type']];
                    
                    if ($user_story->update($row)) {
                        event(new UserStoryUpdated($user_story));
                        return true;
                    }
                } else {
                    $userstory = $this->createUserStoryStub($row);
                    $userstory->story_type = $this->storyTypeEnum[$row['story_type']];
                    
                    if ($userstory->save()) {
                        event(new UserStoryCreated($userstory));
                        return true;
                    }
                }
                
                throw new GeneralException(trans('exceptions.backend.scrum.userstories.create_error'));
            });
        }
    }

    /**
     *
     * @param
     *            $input
     * @return mixed
     */
    private function createUserStoryStub($input)
    {
        $userstory = new UserStory();
        $userstory->code = $input['code'];
        $userstory->project_id = session('project_id');
        $userstory->role = in_array('role', $input) ? $input['role'] : '';
        $userstory->activity = in_array('activity', $input) ? $input['activity'] : '';
        $userstory->business_value = in_array('business_value', $input) ? $input['business_value'] : '';
        $userstory->description = $input['description'];
        $userstory->story_type = $input['story_type'];
        $userstory->priority = $input['priority'];
        $userstory->story_points = in_array('story_points', $input) ? $input['story_points'] : '';
        $userstory->remarks = in_array('remarks', $input) ? $input['remarks'] : '';
        $userstory->INVEST = in_array('INVEST', $input) ? $input['INVEST'] : 0;
        
        return $userstory;
    }

    private $storyTypeEnum = [
        '功能性' => 1,
        '技术性' => 2
    ];
}
