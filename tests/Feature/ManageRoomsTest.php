<?php

namespace Tests\Feature;

use App\Event;
use App\Http\Resources\SubjectCollection;
use App\Repositories\StagRepositoryInterface;
use App\User;
use Carbon\Carbon;
use Facades\Tests\Setup\RoomFactory;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class ManageRoomsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_view_rooms_on_homepage()
    {
        $this->withoutExceptionHandling();
        $room = RoomFactory::create();
        $this->get('/')
            ->assertSee($room->number)
            ->assertSee($room->building);
    }

    /** @test */
    public function a_guest_can_view_single_room()
    {
        Carbon::setTestNow(Carbon::create(2019, 10, 28, 7, 55));

        $repository = Mockery::mock(StagRepositoryInterface::class);

        $repository->shouldReceive('getSubjectByLesson')
            ->andReturn($this->getFormattedSubject());

        $this->app->instance(StagRepositoryInterface::class, $repository);

        $room = RoomFactory::create();

        $this->get($room->path())
            ->assertSee($room->number)
            ->assertSee($room->building)
            ->assertSee('KVD')
            ->assertSee('PGM1P');
    }

    /** @test */
    public function a_guest_can_view_single_room_with_event()
    {
        $this->withoutExceptionHandling();
        Carbon::setTestNow(Carbon::create(2019, 10, 28, 7, 55));

        $repository = Mockery::mock(StagRepositoryInterface::class);

        $repository->shouldReceive('getSubjectByLesson')
            ->andReturn($this->getFormattedSubject());

        $this->app->instance(StagRepositoryInterface::class, $repository);

        $event = factory(Event::class)->create(['date' => '2019-10-28', 'starts_at' => '7:30', 'ends_at' => '8:15']);
        $this->get($event->room->path())
            ->assertSee($event->room->number)
            ->assertSee($event->room->building)
            ->assertSee('zrušena');
    }

    /** @test */
    public function a_guest_can_view_rooms_time_schedule()
    {
        $this->withoutExceptionHandling();
        Carbon::setTestNow(Carbon::create(2019, 10, 28, 7, 55));

        $repository = Mockery::mock(StagRepositoryInterface::class);

        $repository->shouldReceive('getRoomsTimeSchedule')
            ->andReturn($this->getFormattedTimeSchedule());

        $this->app->instance(StagRepositoryInterface::class, $repository);

        $room = RoomFactory::create();

        $this->get("/rozvrh/{$room->id}")
            ->assertSee($room->number)
            ->assertSee($room->building)
            ->assertSee('KVD')
            ->assertSee('PGM1P')
            ->assertSee('ZPT');
    }

    /** @test */
    public function an_authorized_user_cannot_control_rooms_in_manager()
    {
        $room = RoomFactory::create();

        $assertRoomManagerForbidden = function ($redirect) use ($room) {
            $this->get('/manager/rooms')->assertRedirect($redirect);
            $this->get('/manager/rooms/create')->assertRedirect($redirect);
            $this->post('/manager/rooms', $room->toArray())->assertRedirect($redirect);
            $this->delete($room->pathInManager())->assertRedirect($redirect);
        };

        $assertRoomManagerForbidden('/login');

        $this->signIn();

        $assertRoomManagerForbidden('/manager/events');
    }

    /** @test */
    public function an_admin_can_view_rooms_in_manager()
    {
        $user = factory(User::class)->create();

        $user->setAdmin();

        $room = RoomFactory::create();

        $this->actingAs($user)
            ->get('/manager/rooms')
            ->assertSee($room->number)
            ->assertSee($room->path());
    }

    /** @test */
    public function an_admin_can_add_rooms_in_manager()
    {
        $this->withExceptionHandling();
        $this->signIn()->setAdmin();

        $this->get('/manager/rooms/create')->assertStatus(200); // check if create form exists

        $this->followingRedirects()->post('/manager/rooms', $attributes = ['number' => '211', 'building' => 'KL'])
            ->assertSee($attributes['number'])
            ->assertSee($attributes['building']);
    }

    /** @test */
    public function a_room_requires_a_number()
    {
        $user = $this->signIn();

        $user->setAdmin();

        $attributes = factory('App\Room')->raw(['number' => '']);
        $this->post('/manager/rooms', $attributes)->assertSessionHasErrors('number');
    }

    /** @test */
    public function a_room_requires_a_building()
    {
        $user = $this->signIn();

        $user->setAdmin();

        $attributes = factory('App\Room')->raw(['building' => '']);
        $this->post('/manager/rooms', $attributes)->assertSessionHasErrors('building');
    }

    /** @test */
    public function a_user_can_delete_a_room()
    {
        $room = RoomFactory::create();

        $room->owner->setAdmin();

        $this->actingAs($room->owner)
            ->delete($room->pathInManager())
            ->assertRedirect('/manager/rooms');

        $this->assertDatabaseMissing('rooms', $room->only('id'));
    }

    /**
     * @return array
     */
    protected function getFormattedSubject()
    {
        return [
            'data' => [
                7 => [
                    'department' => 'KVD',
                    'shortName' => 'PGM1P',
                    'hourFrom' => '7:30',
                    'teacher' => 'PhDr. Test Test',
                    'startsLesson' => 1,
                    'endsLesson' => 1,
                    'hourTo' => "8:15",
                ],
                9 => [
                    'department' => 'KVD',
                    'shortName' => 'ZPT',
                    'hourFrom' => '8:25',
                    'hourTo' => "9:10",
                    'teacher' => 'PhDr. Test Test',
                    'startsLesson' => 2,
                    'endsLesson' => 2
                ],
            ],
            'page' => 7,
            'pageNext' => 9,
            'pagePrevious' => null

        ];
    }

    /**
     * @return array
     */
    protected function getFormattedTimeSchedule()
    {
        return [
            'monday' => [
                7 => [
                    'department' => 'KVD',
                    'shortName' => 'PGM1P',
                    'hourFrom' => '7:30',
                    'teacher' => 'PhDr. Test Test',
                    'startsLesson' => 1,
                    'endsLesson' => 1,
                    'type' => 'Př'
                ],
                9 => [
                    'department' => 'KVD',
                    'shortName' => 'ZPT',
                    'hourFrom' => '8:25',
                    'teacher' => 'PhDr. Test Test',
                    'startsLesson' => 2,
                    'endsLesson' => 2,
                    'type' => 'Se'
                ],
            ],

        ];
    }

}
