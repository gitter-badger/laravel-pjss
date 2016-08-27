<?php
namespace App\Http\Controllers\Frontend\File\Media;

use App\Models\File\Media\Media;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\File\Media\StoreMediaRequest;
use App\Http\Requests\Frontend\File\Media\ManageMediaRequest;
use App\Http\Requests\Frontend\File\Media\UpdateMediaRequest;
use App\Repositories\Frontend\File\Media\MediaRepositoryContract;

/**
 * Class MediaController
 */
class MediaController extends Controller
{

    /**
     *
     * @var MediaRepositoryContract
     */
    protected $media;

    /**
     *
     * @param MediaRepositoryContract $media            
     */
    public function __construct(MediaRepositoryContract $media)
    {
        $this->media = $media;
    }

    /**
     *
     * @param ManageMediaRequest $request            
     * @return mixed
     */
    public function index(ManageMediaRequest $request)
    {
        if ($request->ajax()) {
            return response()->json($this->media);
        }
        
        return view('frontend.file.media.index')->withMedia($this->media);
    }

    /**
     *
     * @param ManageMediaRequest $request            
     * @return mixed
     */
    public function create(ManageMediaRequest $request)
    {
        return view('frontend.file.media.create');
    }

    /**
     *
     * @param StoreMediaRequest $request            
     * @return mixed
     */
    public function store(StoreMediaRequest $request)
    {
        $this->media->create($request->all());
        return redirect()->route('file.media.index')->withFlashSuccess(trans('alerts.frontend.file.media.created'));
    }

    /**
     *
     * @param Media $media            
     * @param ManageMediaRequest $request            
     * @return mixed
     */
    public function show(Media $media, ManageMediaRequest $request)
    {
        return view('frontend.file.media.detail')->withMedia($media);
    }

    /**
     *
     * @param Media $media            
     * @param ManageMediaRequest $request            
     * @return mixed
     */
    public function edit(Media $media, ManageMediaRequest $request)
    {
        return view('frontend.file.media.edit')->withMedia($media);
    }

    /**
     *
     * @param Media $media            
     * @param UpdateMediaRequest $request            
     * @return mixed
     */
    public function update(Media $media, UpdateMediaRequest $request)
    {
        $this->media->update($media, $request->all());
        return redirect()->route('file.media.index')->withFlashSuccess(trans('alerts.frontend.file.media.updated'));
    }

    /**
     *
     * @param Media $media            
     * @param ManageMediaRequest $request            
     * @return mixed
     */
    public function destroy(Media $media, ManageMediaRequest $request)
    {
        $this->media->destroy($media);
        return redirect()->back()->withFlashSuccess(trans('alerts.frontend.file.media.deleted'));
    }
}