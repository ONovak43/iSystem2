<?php

namespace Tests\Unit;

use App\Http\Utilities\Lessons;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class LessonsTest extends TestCase
{
    /** @test */
    public function time_has_a_lesson()
    {
        $this->withExceptionHandling();
        $this->setTime(7, 29);

        $this->assertEquals([ 'type' => 'lesson', 'order' => -1 ], Lessons::getLessonByTime(Carbon::now()));

        $this->setTime(7, 30);

        $this->assertEquals([ 'type' => 'lesson', 'order' => 1 ], Lessons::getLessonByTime(Carbon::now()));

        $this->setTime(8, 16);

        $this->assertEquals([ 'type' => 'break', 'order' => 1 ], Lessons::getLessonByTime(Carbon::now()));

        $this->setTime(20, 10);

        $this->assertEquals([ 'type' => 'lesson', 'order' => 14 ], Lessons::getLessonByTime(Carbon::now()));

        $this->setTime(20, 30);

        $this->assertEquals([ 'type' => 'lesson', 'order' => -1 ], Lessons::getLessonByTime(Carbon::now()));
    }

    protected function setTime(int $hour, int $minute)
    {
        $knownDate = Carbon::createFromTime($hour, $minute);

        Carbon::setTestNow($knownDate);
    }
}
