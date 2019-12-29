<?php

namespace Tests\Unit;

use App\Event;
use App\Room;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_a_path()
    {
        $room = factory(Room::class)->create();

        $this->assertEquals('/rooms/' . $room->id, $room->path());
    }

    /** @test */
    public function has_a_path_in_manager()
    {
        $room = factory(Room::class)->create();

        $this->assertEquals('/manager/rooms/' . $room->id, $room->pathInManager());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $room = factory(Room::class)->create();

        $this->assertInstanceOf(User::class, $room->owner);
    }

    /** @test */
    public function a_room_has_an_event()
    {
        $room = factory(Room::class)->create();

        $this->assertInstanceOf(Collection::class, $room->events);
    }

    /** @test */
    public function it_can_add_an_event()
    {
        $this->signIn();
        $room = factory(Room::class)->create();

        $event = $room->addEvent(
            factory(Event::class)->raw()
        );

        $this->assertCount(1, $room->events);
        $this->assertTrue($room->events->contains($event));
    }
}
