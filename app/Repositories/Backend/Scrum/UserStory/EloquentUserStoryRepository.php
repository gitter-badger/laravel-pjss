<?php
namespace App\Repositories\Backend\Scrum\UserStory;

use App\Models\Scrum\UserStory\UserStory;
use App\Models\File\Media\Media;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\Scrum\UserStory\UserStoryCreated;
use App\Events\Backend\Scrum\UserStory\UserStoryUpdated;
use App\Events\Backend\Scrum\UserStory\UserStoryDeleted;
use App\Events\Backend\Scrum\UserStory\UserStoryRestored;
use App\Repositories\Backend\Scrum\AcceptanceCriteria\AcceptanceCriteriaRepositoryContract;
use App\Models\Scrum\UserStory\Traits\Enum\StoryTypeEnum;

/**
 * Class EloquentUserStoryRepository
 *
 * @package App\Repositories\UserStory
 */
class EloquentUserStoryRepository implements UserStoryRepositoryContract
{
    use StoryTypeEnum;
    
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
        
        DB::transaction(function () use($userstory, $acceptance_criterias, $input) {
            if ($userstory->save()) {
                // Attach new acceptance_criterias
                $userstory->attachAcceptanceCriterias($acceptance_criterias['acceptance_criteria']);
                
                $lo_fi_ids = explode(',', $input['lo_fi']);
                foreach ($lo_fi_ids as $id) {
                    if ($id) {
                        $lo_fi = Media::find($id);
                        $lo_fi->obj_id = $userstory->id;
                        $lo_fi->type = 'lo_fi';
                        $lo_fi->save();
                    }
                }
                
                $hi_fi_ids = explode(',', $input['hi_fi']);
                foreach ($hi_fi_ids as $id) {
                    if ($id) {
                        $hi_fi = Media::find($id);
                        $hi_fi->obj_id = $userstory->id;
                        $hi_fi->type = 'hi_fi';
                        $hi_fi->save();
                    }
                }
                
                $attachment_ids = explode(',', $input['attachments']);
                foreach ($attachment_ids as $id) {
                    if ($id) {
                        $attachment = Media::find($id);
                        $attachment->obj_id = $userstory->id;
                        $attachment->type = 'attachment';
                        $attachment->save();
                    }
                }
                
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
                
                $userstory->saveAcceptanceCriterias($acceptance_criterias['acceptance_criteria']);
                
                $lo_fi_ids = explode(',', $input['lo_fi']);
                $lo_fis = Media::all()->filter(function ($media) use($userstory) {
                    return $media->obj_id === $userstory->id && $media->type === 'lo_fi';
                })->lists('id');
                $lo_fi_deletes = array_diff($lo_fis->toArray(), $lo_fi_ids);
                Media::destroy($lo_fi_deletes);
                foreach ($lo_fi_ids as $id) {
                    if ($id) {
                        $lo_fi = Media::find($id);
                        $lo_fi->obj_id = $userstory->id;
                        $lo_fi->type = 'lo_fi';
                        $lo_fi->save();
                    }
                }
                
                $hi_fi_ids = explode(',', $input['hi_fi']);
                $hi_fis = Media::all()->filter(function ($media) use($userstory) {
                    return $media->obj_id === $userstory->id && $media->type === 'hi_fi';
                })->lists('id');
                $hi_fi_deletes = array_diff($hi_fis->toArray(), $hi_fi_ids);
                Media::destroy($hi_fi_deletes);
                foreach ($hi_fi_ids as $id) {
                    if ($id) {
                        $hi_fi = Media::find($id);
                        $hi_fi->obj_id = $userstory->id;
                        $hi_fi->type = 'hi_fi';
                        $hi_fi->save();
                    }
                }
                
                $attachment_ids = explode(',', $input['attachments']);
                $attachments = Media::all()->filter(function ($media) use($userstory) {
                    return $media->obj_id === $userstory->id && $media->type === 'attachment';
                })->lists('id');
                $attachment_deletes = array_diff($attachments->toArray(), $attachment_ids);
                Media::destroy($attachment_deletes);
                foreach ($attachment_ids as $id) {
                    if ($id) {
                        $attachment = Media::find($id);
                        $attachment->obj_id = $userstory->id;
                        $attachment->type = 'attachment';
                        $attachment->save();
                    }
                }
                
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
                    $row['story_type'] = $this->enum_story_type()[$row['story_type']];
                    
                    if ($user_story->update($row)) {
                        event(new UserStoryUpdated($user_story));
                        return true;
                    }
                } else {
                    $userstory = $this->createUserStoryStub($row);
                    $userstory->story_type = $this->enum_story_type()[$row['story_type']];
                    
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
        $userstory->description = $input['description'];
        $userstory->story_type = $input['story_type'];
        $userstory->priority = $input['priority'];
        $userstory->story_points = in_array('story_points', $input) ? $input['story_points'] : null;
        $userstory->remarks = in_array('remarks', $input) ? $input['remarks'] : '';
        $userstory->INVEST = in_array('INVEST', $input) ? $input['INVEST'] : 0;
        
        return $userstory;
    }
}
