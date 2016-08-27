<?php
namespace App\Repositories\Backend\Scrum\UserStory;

use App\Models\Scrum\UserStory\UserStory;

/**
 * Interface UserStoryRepositoryContract
 * 
 * @package App\Repositories\UserStory
 */
interface UserStoryRepositoryContract
{

    /**
     *
     * @param
     *            $input
     * @param
     *            $acceptance_criterias
     * @return mixed
     */
    public function create($input, $acceptance_criterias);

    /**
     *
     * @param UserStory $userstory            
     * @param
     *            $input
     * @return mixed
     */
    public function update(UserStory $userstory, $input, $acceptance_criterias);

    /**
     *
     * @param UserStory $userstory            
     * @return mixed
     */
    public function destroy(UserStory $userstory);

    /**
     *
     * @param UserStory $userstory            
     * @return mixed
     */
    public function delete(UserStory $userstory);

    /**
     *
     * @param UserStory $userstory            
     * @return mixed
     */
    public function restore(UserStory $userstory);

    /**
     *
     * @param
     *            $input
     * @return mixed
     */
    public function importExcel($input);
}