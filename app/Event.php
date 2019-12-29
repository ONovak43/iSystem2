<?php

namespace App;

use App\Room;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    /**
     * Returns event's room
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Returns url of event in manager
     *
     * @return string
     */
    public function path()
    {
        return "/manager/events/{$this->id}";
    }

    /**
     * Returns event's owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
