<?php

namespace App\Repositories\Frontend\Scrum\BacklogMeeting;

use App\Models\Scrum\BacklogMeeting\BacklogMeeting;

/**
 * Interface BacklogMeetingRepositoryContract
 * @package App\Repositories\BacklogMeeting
 */
interface BacklogMeetingRepositoryContract
{
    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param BacklogMeeting $backlogmeeting
     * @param $input
     * @return mixed
     */
    public function update(BacklogMeeting $backlogmeeting, $input);

    /**
     * @param  BacklogMeeting $backlogmeeting
     * @return mixed
     */
    public function destroy(BacklogMeeting $backlogmeeting);

    /**
     * @param  BacklogMeeting $backlogmeeting
     * @return mixed
     */
    public function delete(BacklogMeeting $backlogmeeting);

    /**
     * @param  BacklogMeeting $backlogmeeting
     * @return mixed
     */
    public function restore(BacklogMeeting $backlogmeeting);
}