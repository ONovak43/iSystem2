<?php

namespace Tests\Unit;

use App\Event;
use App\Room;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $event = factory(Event::class)->create();

        $this->assertEquals('/manager/events/' . $event->id, $event->path());
    }

    /** @test */
    public function it_belongs_to_a_room()
    {
        $event = factory(Event::class)->create();

        $this->assertInstanceOf(Room::class, $event->room);
    }

    /** @test */
    public function event_for_the_room_exists()
    {
        Carbon::setTestNow(Carbon::create(2019, 10, 28, 7, 1));

        $event = factory(Event::class)->create(['date' => '2019-10-28', 'starts_at' => '7:00', 'ends_at' => '8:15']);

        $this->assertInstanceOf(Event::class, $event->room->hasEventForTime(Carbon::now()));
    }

    /** @test */
    public function event_for_the_room_doesnt_exist()
    {
        Carbon::setTestNow(Carbon::create(2019, 10, 28, 5, 2));

        $event = factory(Event::class)->create(['date' => '2019-10-28', 'starts_at' => '7:00', 'ends_at' => '8:15']);

        $this->assertNull($event->room->hasEventForTime(Carbon::now()));
    }
}
