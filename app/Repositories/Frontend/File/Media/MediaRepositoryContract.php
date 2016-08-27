<?php
namespace App\Repositories\Frontend\File\Media;

use App\Models\File\Media\Media;

/**
 * Interface MediaRepositoryContract
 * 
 * @package App\Repositories\Media
 */
interface MediaRepositoryContract
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
     * @param Media $media            
     * @param
     *            $input
     * @return mixed
     */
    public function update(Media $media, $input);

    /**
     *
     * @param Media $media            
     * @return mixed
     */
    public function destroy(Media $media);

    /**
     *
     * @param Media $media            
     * @return mixed
     */
    public function delete(Media $media);

    /**
     *
     * @param Media $media            
     * @return mixed
     */
    public function restore(Media $media);
}