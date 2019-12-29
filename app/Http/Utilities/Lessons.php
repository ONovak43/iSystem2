<?php


namespace App\Http\Utilities;


use Carbon\Carbon;

class Lessons
{
    /**
     * Get lesson number by time
     *
     * @param Carbon $time
     * @return array|int
     */
    public static function getLessonByTime(Carbon $time)
    {
        $firstLessonStart = Carbon::createFromTime(7, 30);

        $breakFrom = 46/55;

        $timeDiff = $time->diffInMinutes($firstLessonStart)/55;

        $rounded = floor($timeDiff);

        if (($rounded + 1) > 14 || $time->lessThan($firstLessonStart)) {
            return [ 'type' => 'lesson', 'order' => -1 ];
        } else if (($breakFrom + $rounded) <= $timeDiff) {
            return [ 'type' => 'break', 'order' => $rounded + 1 ];
        }

        return [ 'type' => 'lesson', 'order' => $rounded + 1 ];
    }
}
