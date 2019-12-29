<?php

namespace App\Http\Controllers\Manager;

use App\Event;
use App\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomEventsController extends Controller
{

    /**
     * View all events.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $events = auth()->user()->events;

        return view('manager.events.index', compact('events'));
    }

    /**
     * Create a new event
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $rooms = Room::all();
        return view('manager.events.create', compact('rooms'));
    }

    /**
     * Persist a new room's event.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $attributes = $this->validateRequest();

        $room = Room::find($attributes['room_id']);

        $room->addEvent($attributes);

        return redirect('/manager/events');
    }

    public function edit(Event $event)
    {
        $rooms = Room::all();
        return view('manager.events.edit', compact('event', 'rooms'));
    }

    public function update(Event $event)
    {
        $this->authorize('delete', $event);
        $event->update($this->validateRequest());
        return redirect('/manager/events');
    }

    /**
     * Delete an event.
     *
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect('/manager/events');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'room_id' => 'sometimes|required|exists:rooms,id',
            'type' => 'sometimes|required|in:cancel,moved',
            'moved_to' => 'sometimes|required_if:type,moved|nullable',
            'date' => 'sometimes|required|date',
            'starts_at' => 'sometimes|required|date_format:H:i',
            'ends_at'  => 'sometimes|required|date_format:H:i'
        ]);
    }
}
