<?php

namespace App\Repositories\Backend\Organization\Project;

use App\Models\Organization\Team\Project;

/**
 * Interface ProjectRepositoryContract
 * @package App\Repositories\Project
 */
interface ProjectRepositoryContract
{

	/**
     * @param int $status
     * @param bool $trashed
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false);

    /**
     * @param $input
     * @param $members
     * @return mixed
     */
    public function create($input, $members);

    /**
     * @param Project $project
     * @param $input
     * @param $roles
     * @return mixed
     */
    public function update(Project $project, $input, $roles);

    /**
     * @param  Project $project
     * @return mixed
     */
    public function destroy(Project $project);

    /**
     * @param  Project $project
     * @return mixed
     */
    public function delete(Project $project);

    /**
     * @param  Project $project
     * @return mixed
     */
    public function restore(Project $project);
}