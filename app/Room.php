<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    /**
     * Returns url of room
     *
     * @return string
     */
    public function path()
    {
        return "/rooms/{$this->id}";
    }

    /**
     * Returns url of room in manager
     *
     * @return string
     */
    public function pathInManager()
    {
        return "/manager/rooms/{$this->id}";
    }

    /**
     * Returns room's owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns room's events
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Adding a new event to the room
     *
     * @param $eventData
     * @return Model
     */
    public function addEvent($eventData)
    {
        $eventData['owner_id'] = auth()->user()->id;

        return $this->events()->create($eventData);
    }

    /**
     * @param Carbon $date
     * @return
     */
    public function hasEventForTime(Carbon $date)
    {
        $d = $date->format('G:i');

        return $this->events()
            ->where('date', $date->format('Y-m-d'))
            ->where(function ($query) use ($d) {
                $query->where('starts_at', '<=', $d);
                $query->where('ends_at', '>=', $d);
            })
            ->first();
    }
}
