<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ManagerUsersTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function non_admins_may_not_view_users()
    {
        $this->get('/manager/users')
            ->assertRedirect('/login');

        $this->signIn();

        $this->get('/manager/users')
            ->assertRedirect('/manager/events');
    }

    /** @test */
    public function an_admin_can_view_users_except_himself()
    {
        $admin = tap($this->signIn())->setAdmin();

        $this->get('/manager/users')
            ->assertDontSee($admin->email);
    }

    /** @test */
    public function non_admins_may_not_create_a_user()
    {
        $this->post('/manager/users', $newUser = $this->getUserData())
            ->assertRedirect('/login');

        $this->signIn();

        $this->post('/manager/users', $newUser = $this->getUserData())
            ->assertRedirect('/manager/events');
    }

    /** @test */
    public function an_admin_can_create_a_user()
    {
        $this->signIn()->setAdmin();

        $this->get('/manager/users/create')->assertStatus(200); // check if create form exists

        $this->post('/manager/users', $newUser = $this->getUserData())
            ->assertRedirect('/manager/users');

        unset($newUser['password']);

        $this->assertDatabaseHas('users', $newUser);
    }

    /** @test */
    public function an_admin_can_delete_a_user()
    {
        $this->signIn()->setAdmin();

        $user = factory(User::class)->create();

        $this->delete('/manager/users/' . $user->id)
            ->assertRedirect('/manager/users');

        $this->assertDatabaseMissing('users', $user->toArray());
    }

    /** @test */
    public function an_admin_cannot_delete_himself()
    {
        $admin = tap($this->signIn())->setAdmin();

        $this->delete('/manager/users/' . $admin->id)->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_update_a_user()
    {
        $this->signIn()->setAdmin();

        $user = factory(User::class)->create();

        $this->get('/manager/users/' . $user->id . '/edit')->assertStatus(200); // check if edit form exists

        $this->patch($user->path(), $attributes = ['name' => 'Changed', 'email' => 'changed@changed.com'])
            ->assertRedirect('/manager/users');

        $this->assertDatabaseHas('users', $attributes);
    }

    protected function getUserData()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'password' => $this->faker->text(50),
            'type' => 'default'
        ];
    }
}
