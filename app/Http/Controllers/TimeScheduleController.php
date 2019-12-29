<?php

namespace App\Http\Controllers;

use App\Repositories\StagRepositoryInterface;
use App\Room;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class TimeScheduleController extends Controller
{
    /**
     * @var StagRepositoryInterface
     */
    protected $stagRepository;

    /**
     * RoomsController constructor.
     * @param StagRepositoryInterface $stagRepository
     */
    public function __construct(StagRepositoryInterface $stagRepository)
    {
        $this->stagRepository = $stagRepository;
    }

    public function show(Room $room)
    {
        $timeSchedule = $this->stagRepository->getRoomsTimeSchedule($room->building, $room->number);
        $timeSchedule = $this->filterOldLessons($timeSchedule);
        $lessonsStartTime = \Carbon\Carbon::createFromTime(7,20);

        return view('timeschedule.show', compact('room', 'timeSchedule', 'lessonsStartTime'));
    }

    private function filterOldLessons($timeSchedule)
    {
        if(!isset($timeSchedule['others'])) {
            $timeSchedule['others'] = [];
        }
        $others = $timeSchedule['others'];

        $timeSchedule['others'] = Arr::where($others, function ($value) {
            $now = Carbon::now();
            $date = Carbon::parse($value['date']);
            return $now->isSameWeek($date); // only for current week; you can use $now->weekOfYear <= $date->weekOfYear for getting rest lessons of semester
        });

        return $timeSchedule;
    }
}
