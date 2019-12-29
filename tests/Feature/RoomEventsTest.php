<?php

namespace Tests\Feature;

use App\Event;
use App\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\RoomFactory;
use Tests\TestCase;

class RoomEventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_events_to_projects()
    {
        $this->post('/manager/events')
            ->assertRedirect('login');
    }

    /** @test */
    public function a_room_can_have_events()
    {
        $room = RoomFactory::ownedBy($this->signIn())->create();

        $this->get('/manager/events/create')->assertStatus(200); // check if create form exists

        $this->followingRedirects()->post('/manager/events', $attributes = [
            'room_id' => $room->id,
            'type' => 'cancel',
            'date' => '2019-05-05',
            'starts_at' => '11:30',
            'ends_at' => '13:30'
        ])
            ->assertSee($attributes['date'])
            ->assertSee($attributes['starts_at'])
            ->assertSee($attributes['ends_at']);
    }


    /** @test */
    public function an_event_requires_a_type()
    {
        $this->requires('type');
    }

    /** @test */
    public function an_event_requires_a_date()
    {
        $this->requires('date');
    }

    /** @test */
    public function an_event_requires_a_start_time()
    {
        $this->requires('starts_at');
    }

    /** @test */
    public function an_event_requires_an_end_time()
    {
        $this->requires('ends_at');
    }

    /** @test */
    public function unauthorized_cannot_delete_an_event()
    {
        $event = factory('App\Event')->create();

        $this->delete($event->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($event->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_his_event()
    {
        $room = RoomFactory::withEvents(1)->create();

        $this->actingAs($room->owner)
            ->delete($room->events->first()->path())
            ->assertRedirect('/manager/events');

        $this->assertDatabaseMissing('events', $room->events[0]->only('id'));
    }

    /** @test */
    public function a_user_can_update_his_event()
    {
        $user = $this->signIn();

        $event = factory(Event::class)->create(['owner_id' => $user->id]);

        $this->get('/manager/events/' . $event->id. '/edit')->assertStatus(200); // check if edit form exists

        $this->patch($event->path(), $attributes = ['starts_at' => '03:03', 'date' => '2019-05-05'])
            ->assertRedirect('/manager/events');

        $this->assertDatabaseHas('events', $attributes);
    }

    protected function requires($field)
    {
        $this->signIn();

        $attributes = factory('App\Event')->raw([$field => '']);

        $this->post('/manager/events', $attributes)
            ->assertSessionHasErrors($field);
    }
}
