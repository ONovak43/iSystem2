<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    /**
     * View all users
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::all()->except(auth()->id());
        return view('manager.users.index', compact('users'));
    }

    /**
     * Create a user form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('manager.users.create');
    }

    /**
     * Persist a new user
     *
     * @param  array  $data
     * @return \App\User
     */
    public function store()
    {
        User::create($this->validateRequest());

        return redirect(action('Manager\UsersController@index'));
    }

    public function edit(User $user)
    {
        return view('manager.users.edit', compact('user'));
    }

    /**
     * Update a user data
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user)
    {
        $user->update($this->validateRequest($user));

        return redirect(action('Manager\UsersController@index'));
    }

    /**
     * Delete a user
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user, 'Administrátor nemůže smazat svůj účet.');

        $user->delete();
        return redirect(action('Manager\UsersController@index'));
    }

    /**
     * Validate the request attributes
     *
     * @return mixed
     */
    protected function validateRequest($user = null)
    {
        $attributes = request()->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email' . ($user ? ',' . $user->id .',id' : null),
            'password' => 'sometimes|string|min:8' . ($user ? '|nullable' : null),
            'type' => 'sometimes|required|in:' . User::DEFAULT_TYPE . ',' . User::ADMIN_TYPE,
        ]);

        if(array_key_exists('password', $attributes)) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        return $attributes;
    }
}
