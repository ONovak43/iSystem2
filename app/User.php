<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Room;
use App\Event;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return rooms owned by the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'owner_id');
    }

    /**
     * Return events owned by the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'owner_id');
    }

    /**
     * Return if signed user is an admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    /**
     * Give a user an admin type account
     */
    public function setAdmin()
    {
        $this->type = self::ADMIN_TYPE;
        $this->save();
    }

    /**
     * Return user url
     *
     * @return string
     */
    public function path()
    {
        return '/manager/users/' . $this->id;
    }
}
