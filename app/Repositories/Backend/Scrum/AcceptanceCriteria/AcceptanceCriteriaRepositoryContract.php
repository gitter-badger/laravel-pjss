<?php
namespace App\Repositories\Backend\Scrum\AcceptanceCriteria;

use App\Models\Scrum\AcceptanceCriteria\AcceptanceCriteria;

/**
 * Interface AcceptanceCriteriaRepositoryContract
 * 
 * @package App\Repositories\AcceptanceCriteria
 */
interface AcceptanceCriteriaRepositoryContract
{

    /**
     *
     * @param
     *            $input
     * @return mixed
     */
    public function create($input);

    /**
     *
     * @param AcceptanceCriteria $acceptancecriteria            
     * @param
     *            $input
     * @return mixed
     */
    public function update(AcceptanceCriteria $acceptancecriteria, $input);

    /**
     *
     * @param AcceptanceCriteria $acceptancecriteria            
     * @return mixed
     */
    public function destroy(AcceptanceCriteria $acceptancecriteria);

    /**
     *
     * @param AcceptanceCriteria $acceptancecriteria            
     * @return mixed
     */
    public function delete(AcceptanceCriteria $acceptancecriteria);

    /**
     *
     * @param AcceptanceCriteria $acceptancecriteria            
     * @return mixed
     */
    public function restore(AcceptanceCriteria $acceptancecriteria);
}