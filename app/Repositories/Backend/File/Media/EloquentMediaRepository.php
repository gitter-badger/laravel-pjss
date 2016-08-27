<?php
namespace App\Repositories\Backend\File\Media;

use App\Models\File\Media\Media;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\File\Media\MediaCreated;
use App\Events\Backend\File\Media\MediaUpdated;
use App\Events\Backend\File\Media\MediaDeleted;
use App\Events\Backend\File\Media\MediaRestored;

/**
 * Class EloquentMediaRepository
 * 
 * @package App\Repositories\Media
 */
class EloquentMediaRepository implements MediaRepositoryContract
{

    /**
     */
    public function __construct()
    {}

    /**
     *
     * @param
     *            $input
     * @param
     *            $roles
     * @throws GeneralException
     * @return bool
     */
    public function create($input)
    {
        $media = $this->createMediaStub($input);
        // TODO: set properties
        
        return DB::transaction(function () use($media) {
            if ($media->save()) {
                event(new MediaCreated($media));
                return $media;
            }
            
            throw new GeneralException(trans('exceptions.backend.file.media.create_error'));
        });
    }

    /**
     *
     * @param Media $media            
     * @param
     *            $input
     * @param
     *            $roles
     * @return bool
     * @throws GeneralException
     */
    public function update(Media $media, $input)
    {
        // TODO: set $input properties
        DB::transaction(function () use($media, $input) {
            if ($media->update($input)) {
                event(new MediaUpdated($media));
                return true;
            }
            
            throw new GeneralException(trans('exceptions.backend.file.media.update_error'));
        });
    }

    /**
     *
     * @param Media $media            
     * @throws GeneralException
     * @return bool
     */
    public function destroy(Media $media)
    {
        if ($media->delete()) {
            event(new MediaDeleted($media));
            return true;
        }
        
        throw new GeneralException(trans('exceptions.backend.file.media.delete_error'));
    }

    /**
     *
     * @param Media $media            
     * @throws GeneralException
     * @return boolean|null
     */
    public function delete(Media $media)
    {
        // Failsafe
        if (is_null($media->deleted_at)) {
            throw new GeneralException("This media must be deleted first before it can be destroyed permanently.");
        }
        
        DB::transaction(function () use($media) {
            // TODO: delete related entities
            
            if ($media->forceDelete()) {
                event(new MediaPermanentlyDeleted($media));
                return true;
            }
            
            throw new GeneralException(trans('exceptions.backend.file.media.delete_error'));
        });
    }

    /**
     *
     * @param Media $media            
     * @throws GeneralException
     * @return bool
     */
    public function restore(Media $media)
    {
        // Failsafe
        if (is_null($media->deleted_at)) {
            throw new GeneralException("This media is not deleted so it can not be restored.");
        }
        
        if ($media->restore()) {
            event(new MediaRestored($media));
            return true;
        }
        
        throw new GeneralException(trans('exceptions.backend.file.media.restore_error'));
    }

    /**
     *
     * @param
     *            $input
     * @return mixed
     */
    private function createMediaStub($input)
    {
        $media = new Media();
        // TODO: set properties
        
        return $media;
    }
}
