<?php

namespace App\Http\Controllers\Frontend\Scrum\AcceptanceCriteria;

use App\Models\Scrum\AcceptanceCriteria\AcceptanceCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Scrum\AcceptanceCriteria\StoreAcceptanceCriteriaRequest;
use App\Http\Requests\Frontend\Scrum\AcceptanceCriteria\ManageAcceptanceCriteriaRequest;
use App\Http\Requests\Frontend\Scrum\AcceptanceCriteria\UpdateAcceptanceCriteriaRequest;
use App\Repositories\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaRepositoryContract;

/**
 * Class AcceptanceCriteriaController
 */
class AcceptanceCriteriaController extends Controller
{
    /**
     * @var AcceptanceCriteriaRepositoryContract
     */
    protected $acceptancecriterias;
    
    /**
     * @param AcceptanceCriteriaRepositoryContract $acceptancecriterias
     */
    public function __construct(AcceptanceCriteriaRepositoryContract $acceptancecriterias)
    {
        $this->acceptancecriterias = $acceptancecriterias;
    }

	/**
     * @param ManageAcceptanceCriteriaRequest $request
     * @return mixed
     */
    public function index(ManageAcceptanceCriteriaRequest $request)
    {
    	if ($request->ajax()){
            return response()->json($this->acceptancecriterias);
        }
    
        return view('frontend.scrum.acceptancecriteria.index')
        	->withAcceptanceCriterias($this->acceptancecriterias);
    }

	/**
     * @param ManageAcceptanceCriteriaRequest $request
     * @return mixed
     */
    public function create(ManageAcceptanceCriteriaRequest $request)
    {
        return view('frontend.scrum.acceptancecriteria.create');
    }

	/**
     * @param StoreAcceptanceCriteriaRequest $request
     * @return mixed
     */
    public function store(StoreAcceptanceCriteriaRequest $request)
    {
        $this->acceptancecriterias->create(
            $request->all()
        );
        return redirect()->route('scrum.acceptancecriteria.index')->withFlashSuccess(trans('alerts.frontend.scrum.acceptancecriterias.created'));
    }
    
    /**
     * @param AcceptanceCriteria $acceptancecriteria
     * @param ManageAcceptanceCriteriaRequest $request
     * @return mixed
     */
    public function show(AcceptanceCriteria $acceptancecriteria, ManageAcceptanceCriteriaRequest $request)
    {
        return view('frontend.scrum.acceptancecriteria.detail')
        	->withAcceptanceCriteria($acceptancecriteria);
    }

	/**
     * @param AcceptanceCriteria $acceptancecriteria
     * @param ManageAcceptanceCriteriaRequest $request
     * @return mixed
     */
    public function edit(AcceptanceCriteria $acceptancecriteria, ManageAcceptanceCriteriaRequest $request)
    {
        return view('frontend.scrum.acceptancecriteria.edit')
            ->withAcceptanceCriteria($acceptancecriteria);
    }

	/**
     * @param AcceptanceCriteria $acceptancecriteria
     * @param UpdateAcceptanceCriteriaRequest $request
     * @return mixed
     */
    public function update(AcceptanceCriteria $acceptancecriteria, UpdateAcceptanceCriteriaRequest $request)
    {
        $this->acceptancecriterias->update($acceptancecriteria,
            $request->all()
        );
        return redirect()->route('scrum.acceptancecriteria.index')->withFlashSuccess(trans('alerts.frontend.scrum.acceptancecriterias.updated'));
    }

	/**
     * @param AcceptanceCriteria $acceptancecriteria
     * @param ManageAcceptanceCriteriaRequest $request
     * @return mixed
     */
    public function destroy(AcceptanceCriteria $acceptancecriteria, ManageAcceptanceCriteriaRequest $request)
    {
        $this->acceptancecriterias->destroy($acceptancecriteria);
        return redirect()->back()->withFlashSuccess(trans('alerts.frontend.scrum.acceptancecriterias.deleted'));
    }
}