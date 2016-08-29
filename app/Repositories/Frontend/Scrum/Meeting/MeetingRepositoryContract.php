<?php

namespace App\Repositories\Frontend\Scrum\Meeting;

use App\Models\Scrum\Meeting\Meeting;

/**
 * Interface MeetingRepositoryContract
 * @package App\Repositories\Meeting
 */
interface MeetingRepositoryContract
{
    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param Meeting $meeting
     * @param $input
     * @return mixed
     */
    public function update(Meeting $meeting, $input);

    /**
     * @param  Meeting $meeting
     * @return mixed
     */
    public function destroy(Meeting $meeting);

    /**
     * @param  Meeting $meeting
     * @return mixed
     */
    public function delete(Meeting $meeting);

    /**
     * @param  Meeting $meeting
     * @return mixed
     */
    public function restore(Meeting $meeting);
}