<?php


namespace Tests\Setup;


use App\Event;
use App\Room;
use App\User;

class RoomFactory
{
    protected $eventsCount = 0;
    protected $owner = null;

    /**
     * Set a number of events, that will be created
     *
     * @param $count
     * @return $this
     */
    public function withEvents($count)
    {
        $this->eventsCount = $count;

        return $this;
    }

    /**
     * Set an owner of the room and events
     *
     * @param $owner
     * @return $this
     */
    public function ownedBy($owner)
    {
        $this->owner = $owner;

        return $this;
    }


    /**
     * Create a room and events (if it's set). If there is no user, it creates one
     *
     * @return mixed
     */
    public function create()
    {
        $this->owner = $this->owner ?? factory(User::class);
        $room = factory(Room::class)->create([
            'owner_id' => $this->owner
        ]);

        factory(Event::class, $this->eventsCount)->create([
           'owner_id' => $room->owner,
           'room_id' => $room->id
        ]);

        return $room;
    }
}
