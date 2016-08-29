<?php
namespace App\Http\Controllers\Backend\Scrum\UserStory;

use App\Models\Scrum\UserStory\UserStory;
use App\Models\File\Media\Media;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Scrum\UserStory\StoreUserStoryRequest;
use App\Http\Requests\Backend\Scrum\UserStory\ManageUserStoryRequest;
use App\Http\Requests\Backend\Scrum\UserStory\UpdateUserStoryRequest;
use App\Repositories\Backend\Scrum\UserStory\UserStoryRepositoryContract;
use App\Http\Requests\Backend\Scrum\UserStory\Excel\UserStoryImport;
use App\Http\Requests\Backend\Scrum\UserStory\Excel\UserStoryExport;
use App\Models\Scrum\UserStory\Traits\Enum\StoryTypeEnum;

/**
 * Class UserStoryController
 */
class UserStoryController extends Controller
{
    use StoryTypeEnum;

    /**
     *
     * @var UserStoryRepositoryContract
     */
    protected $userstories;

    /**
     *
     * @param UserStoryRepositoryContract $userstories            
     */
    public function __construct(UserStoryRepositoryContract $userstories)
    {
        $this->userstories = $userstories;
    }

    /**
     *
     * @param ManageUserStoryRequest $request            
     * @return mixed
     */
    public function index(ManageUserStoryRequest $request)
    {
        $request->session()->put('project_id', 1633);
        
        if (is_null(session('project_id'))) {
            $project_id = DB::select('select m2p.project_id from members2project m2p inner join members m on m.id = m2p.member_id where m.email = :email', [
                'email' => \Auth::user()->email
            ]);
            $request->session()->put('project_id', $project_id[0]->project_id);
        }
        
        $user_stories = UserStory::all()->where('project_id', session('project_id'))
            ->sortByDesc('priority')
            ->values();
        
        if ($request->ajax()) {
            return response()->json($user_stories->toArray());
        }
        
        return view('backend.scrum.userstory.index')->withUserStories($user_stories->toJson());
    }

    /**
     *
     * @param ManageUserStoryRequest $request            
     * @return mixed
     */
    public function create(ManageUserStoryRequest $request)
    {
        $user_story = new UserStory();
        $max_code = UserStory::all()->where('project_id', session('project_id'))->max('code');
        
        if ($max_code) {
            preg_match_all('/\d+/', $max_code, $num);
            $num = $num[0][count($num[0]) - 1];
            $new_num = sprintf("%0" . (strlen($num)) . "d", $num + 1);
            $max_code = str_replace($num, $new_num, $max_code);
        }
        
        $user_story->code = $max_code;
        return view('backend.scrum.userstory.create')->withUserStory($user_story);
    }

    /**
     *
     * @param StoreUserStoryRequest $request            
     * @return mixed
     */
    public function store(StoreUserStoryRequest $request)
    {
        $userstory = $this->userstories->create($request->except('acceptance_criteria'), $request->only('acceptance_criteria'));
        
        return redirect()->route('admin.scrum.userstory.index')->withFlashSuccess(trans('alerts.backend.scrum.userstories.created'));
    }

    /**
     *
     * @param UserStory $userstory            
     * @param ManageUserStoryRequest $request            
     * @return mixed
     */
    public function show(UserStory $userstory, ManageUserStoryRequest $request)
    {
        $this->fill($userstory);
        return view('backend.scrum.userstory.detail')->withUserStory($userstory);
    }

    /**
     *
     * @param UserStory $userstory            
     * @param ManageUserStoryRequest $request            
     * @return mixed
     */
    public function edit(UserStory $userstory, ManageUserStoryRequest $request)
    {
        $this->fill($userstory);
        return view('backend.scrum.userstory.edit')->withUserStory($userstory);
    }

    /**
     *
     * @param UserStory $userstory            
     * @param UpdateUserStoryRequest $request            
     * @return mixed
     */
    public function update(UserStory $userstory, UpdateUserStoryRequest $request)
    {
        $this->userstories->update($userstory, $request->except('acceptance_criteria'), $request->only('acceptance_criteria'));
        
        return redirect()->route('admin.scrum.userstory.index')->withFlashSuccess(trans('alerts.backend.scrum.userstories.updated'));
    }

    /**
     *
     * @param UserStory $userstory            
     * @param ManageUserStoryRequest $request            
     * @return mixed
     */
    public function destroy(UserStory $userstory, ManageUserStoryRequest $request)
    {
        $this->userstories->destroy($userstory);
        return response()->json([
            'sucs' => true
        ]);
    }

    private function fill(&$userstory)
    {
        $userstory->acceptance_criterias = $userstory->acceptance_criterias->map(function ($acceptance_criteria) {
            return [
                'id' => $acceptance_criteria->id,
                'condition' => $acceptance_criteria->condition
            ];
        });
        
        $lo_fi = Media::all()->filter(function ($media) use($userstory) {
            return $media->obj_id === $userstory->id && $media->type === 'lo_fi';
        })->values();
        $hi_fi = Media::all()->filter(function ($media) use($userstory) {
            return $media->obj_id === $userstory->id && $media->type === 'hi_fi';
        })->values();
        $attachments = Media::all()->filter(function ($media) use($userstory) {
            return $media->obj_id === $userstory->id && $media->type === 'attachment';
        })->values();
        
        $userstory->lo_fi = $lo_fi->map(function ($media) {
            return [
                'id' => $media->id,
                'file_name' => $media->file()->file_name,
                'file_size' => $media->file()->size,
                'type_ico' => $media->file_type_ico(),
            ];
        });
        
        $userstory->hi_fi = $hi_fi->map(function ($media) {
            return [
                'id' => $media->id,
                'file_name' => $media->file()->file_name,
                'file_size' => $media->file()->size,
                'type_ico' => $media->file_type_ico(),
            ];
        });
        
        $userstory->attachments = $attachments->map(function ($media) {
            return [
                'id' => $media->id,
                'file_name' => $media->file()->file_name,
                'file_size' => $media->file()->size,
                'type_ico' => $media->file_type_ico(),
            ];
        });
    }

    /**
     *
     * @param UserStroyImport $import            
     * @return mixed
     */
    public function importExcel(UserStoryImport $import)
    {
        $results = $import->toArray();
        $this->userstories->importExcel($results[0]);
        
        return response()->json([
            'sucs' => true
        ]);
    }

    /**
     *
     * @return mixed
     */
    public function exportExcel(UserStoryExport $export)
    {
        return $export->sheet('用户故事', function($sheet)
        {
            $user_stories = UserStory::all()->where('project_id', session('project_id'))
                ->sortByDesc('priority')
                ->values();
            $user_stories = $user_stories->toArray();
            array_remove_keys($user_stories, ['id', 'project_id', 'INVEST', 'created_at', 'updated_at', 'deleted_at']);
            $enums = array_flip($this->enum_story_type());
            foreach ($user_stories as $i => &$user_story) {
                $user_story['story_type'] = $enums[$user_story['story_type']];
            }
            array_splice($user_stories, 0, 0, [[
                'code' => '故事编号',
                'description' => '用户故事',
                'story_type' => '故事类型',
                //'acceptance_criterias' => '验收标准',
                'priority' => '优先级',
                'story_points' => '故事点数',
                'remarks' => '备注',
            ]]);
            
            $sheet->fromArray($user_stories);
            
            $sheet->cells('A2:G2', function($cells) {
                $cells->setFontWeight('bold');
                $cells->setAlignment('center');
            });
            $sheet->setAllBorders('solid');
            $sheet->setFreeze('A3');
            $sheet->setHeight(1, 0);
            $sheet->setWidth(array(
                'A' => 10,
                'B' => 50,
                'C' => 10,
                'D' => 8,
                'E' => 10,
                'F' => 20,
            ));
            $sheet->setColumnFormat(array(
                'D' => '0',
                'E' => '0',
            ));
        })->export('xlsx');
    }

    /**
     *
     * @return mixed
     */
    public function reOrder()
    {
        $ids = request('ids');
        
        $user_stories = UserStory::all()->where('project_id', session('project_id'))
            ->sortByDesc('priority')
            ->values();
        $priorities = array_column($user_stories->toArray(), 'priority');
        
        foreach ($ids as $i => $id) {
            $user_story = $user_stories->first(function ($i, $user_story) use($id) {
                return $user_story->id == $id;
            });
            
            $user_story->update([
                'priority' => $priorities[$i]
            ]);
        }
        
        return response()->json([
            'sucs' => true
        ]);
    }

    /**
     *
     * @return mixed
     */
    public function exchange()
    {
        $ids = request('ids');
        
        $user_stories = UserStory::all()->where('project_id', session('project_id'))
            ->sortByDesc('priority')
            ->values();
        $priorities = array_column($user_stories->toArray(), 'priority');
        
        $one = $user_stories->first(function ($i, $user_story) use($ids) {
            return $user_story->id == $ids[0];
        });
        $another = $user_stories->first(function ($i, $user_story) use($ids) {
            return $user_story->id == $ids[1];
        });
        
        $temp = $one->priority;
        $one->update([
            'priority' => $another->priority
        ]);
        $another->update([
            'priority' => $temp
        ]);
        
        return response()->json([
            'sucs' => true
        ]);
    }
}