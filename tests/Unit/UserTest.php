<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_rooms()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->rooms);
    }

    /** @test */
    public function a_user_has_events()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->events);
    }

    /** @test */
    public function a_user_is_an_admin()
    {
        $user = factory(User::class)->create();

        $this->assertFalse($user->isAdmin());

        $user->setAdmin();

        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function a_user_gets_an_admin()
    {
        $user = factory(User::class)->create();

        $user->setAdmin();

        $admin = User::find($user)->first();

        $this->assertTrue($admin->type === User::ADMIN_TYPE);
    }

    /** @test */
    public function it_has_a_path()
    {
        $user = factory(User::class)->create();

        $this->assertEquals('/manager/users/' . $user->id, $user->path());
    }
}
