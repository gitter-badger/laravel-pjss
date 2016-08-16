<?php

namespace App\Repositories\Frontend\Scrum\UserStory;

use App\Models\Scrum\UserStory\UserStory;

/**
 * Interface UserStoryRepositoryContract
 * @package App\Repositories\UserStory
 */
interface UserStoryRepositoryContract
{
    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param UserStory $userstory
     * @param $input
     * @return mixed
     */
    public function update(UserStory $userstory, $input);

    /**
     * @param  UserStory $userstory
     * @return mixed
     */
    public function destroy(UserStory $userstory);

    /**
     * @param  UserStory $userstory
     * @return mixed
     */
    public function delete(UserStory $userstory);

    /**
     * @param  UserStory $userstory
     * @return mixed
     */
    public function restore(UserStory $userstory);
}