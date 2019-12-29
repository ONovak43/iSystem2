<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Utilities\Lessons;
use App\Repositories\StagRepositoryInterface;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoomsController extends Controller
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

    /**
     * View all rooms.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rooms = Room::orderBy('building')->orderBy('number')->get();

        return view('room.index', compact('rooms'));
    }

    /**
     * View room and its subjects
     *
     * @param Room $room
     * @param int|null $lesson
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Room $room, int $lesson = null)
    {
        $now = Carbon::now();
        $lessonByTime = Lessons::getLessonByTime($now);

        $subjects = $this->stagRepository->getSubjectByLesson($room->building, $room->number, $lesson ?? $lessonByTime['order']);

        if($lesson && $subjects['page']) {
            $time = Carbon::createFromTimeString($subjects['data'][$subjects['page']]['hourFrom']);
            $event = $room->hasEventForTime($time);
        } else {
            $event = $room->hasEventForTime($now);
        }

        $lessonType = ($lesson && $subjects['page'] !== null) ? $this->getLessonType($subjects['data'][$subjects['page']], $lessonByTime['order']) : $lessonByTime['type'];

        return view('room.show', compact('room', 'subjects', 'lessonType', 'event'));
    }

    /**
     * Return type of lesson (if its going to happened, it's happening or it happened)
     *
     * @param $subject
     * @param int $lesson
     * @return string
     */
    protected function getLessonType($subject, int $lesson)
    {
        if ($subject['startsLesson'] <= $lesson && $subject['endsLesson'] >= $lesson) {
            return'lesson';
        } else if ($subject['endsLesson'] > $lesson) {
            return 'futureLesson';
        } else {
            return 'pastLesson';
        }
    }

}
