<?php
namespace App\Repositories\Backend\Access\Project;

use App\Models\Organization\Project\Project;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\Access\Project\ProjectCreated;
use App\Events\Backend\Access\Project\ProjectUpdated;
use App\Events\Backend\Access\Project\ProjectDeleted;
use App\Events\Backend\Access\Project\ProjectRestored;
use App\Exceptions\Backend\Access\Project\ProjectNeedsRolesException;
use App\Repositories\Backend\Access\Role\RoleRepositoryContract;
use App\Repositories\Frontend\Access\Project\ProjectRepositoryContract as FrontendProjectRepositoryContract;

/**
 * Class EloquentProjectRepository
 * 
 * @package App\Repositories\Project
 */
class EloquentProjectRepository implements ProjectRepositoryContract
{

    /**
     *
     * @var RoleRepositoryContract
     */
    protected $role;

    /**
     *
     * @var FrontendProjectRepositoryContract
     */
    protected $project;

    /**
     *
     * @param RoleRepositoryContract $role            
     * @param FrontendProjectRepositoryContract $project            
     */
    public function __construct(RoleRepositoryContract $role, FrontendProjectRepositoryContract $project)
    {
        $this->role = $role;
        $this->user = $project;
    }

    /**
     *
     * @param
     *            $input
     * @param
     *            $roles
     * @throws GeneralException
     * @throws ProjectNeedsRolesException
     * @return bool
     */
    public function create($input, $roles)
    {
        $project = $this->createProjectStub($input);
        
        DB::transaction(function () use($project, $roles) {
            if ($project->save()) {
                // Project Created, Validate Roles
                $this->validateRoleAmount($project, $roles['assignees_roles']);
                
                // Attach new roles
                $project->attachRoles($roles['assignees_roles']);
                
                // Send confirmation email if requested
                if (isset($input['confirmation_email']) && $project->confirmed == 0) {
                    $this->user->sendConfirmationEmail($project->id);
                }
                
                event(new ProjectCreated($project));
                return true;
            }
            
            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     *
     * @param Project $project            
     * @param
     *            $input
     * @param
     *            $roles
     * @return bool
     * @throws GeneralException
     */
    public function update(Project $project, $input, $roles)
    {
        $this->checkProjectByEmail($input, $project);
        
        DB::transaction(function () use($project, $input, $roles) {
            if ($project->update($input)) {
                // For whatever reason this just wont work in the above call, so a second is needed for now
                $project->status = isset($input['status']) ? 1 : 0;
                $project->confirmed = isset($input['confirmed']) ? 1 : 0;
                $project->save();
                
                $this->checkProjectRolesCount($roles);
                $this->flushRoles($roles, $project);
                
                event(new ProjectUpdated($project));
                return true;
            }
            
            throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     *
     * @param Project $project            
     * @throws GeneralException
     * @return bool
     */
    public function destroy(Project $project)
    {
        if (access()->id() == $project->id) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_delete_self'));
        }
        
        if ($project->delete()) {
            event(new ProjectDeleted($project));
            return true;
        }
        
        throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
    }

    /**
     *
     * @param Project $project            
     * @throws GeneralException
     * @return boolean|null
     */
    public function delete(Project $project)
    {
        // Failsafe
        if (is_null($project->deleted_at)) {
            throw new GeneralException("This user must be deleted first before it can be destroyed permanently.");
        }
        
        DB::transaction(function () use($project) {
            // Detach all roles & permissions
            $project->detachRoles($project->roles);
            
            if ($project->forceDelete()) {
                event(new ProjectPermanentlyDeleted($project));
                return true;
            }
            
            throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     *
     * @param Project $project            
     * @throws GeneralException
     * @return bool
     */
    public function restore(Project $project)
    {
        // Failsafe
        if (is_null($project->deleted_at)) {
            throw new GeneralException("This user is not deleted so it can not be restored.");
        }
        
        if ($project->restore()) {
            event(new ProjectRestored($project));
            return true;
        }
        
        throw new GeneralException(trans('exceptions.backend.access.users.restore_error'));
    }

    /**
     *
     * @param
     *            $input
     * @return mixed
     */
    private function createProjectv($input)
    {
        $project = new Project();
        $project->name = $input['name'];
        $project->email = $input['email'];
        $project->password = bcrypt($input['password']);
        $project->status = isset($input['status']) ? 1 : 0;
        $project->confirmation_code = md5(uniqid(mt_rand(), true));
        $project->confirmed = isset($input['confirmed']) ? 1 : 0;
        return $project;
    }
}
