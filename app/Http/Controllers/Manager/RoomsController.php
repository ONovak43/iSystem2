<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Utilities\Buildings;
use App\Repositories\RESTStagRepository;
use App\Room;
use App\Rules\RoomExists;
use Illuminate\Validation\Rule;

class RoomsController extends Controller
{
    /**
     * @var RESTStagRepository
     */
    protected $stag;

    /**
     * @param RESTStagRepository $stag
     */
    public function __construct(RESTStagRepository $stag)
    {
        $this->stag = $stag;
    }
    /**
     * View all rooms
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::orderBy('building')->orderBy('number')->get();

        return view('manager.rooms.index', compact('rooms'));
    }

    /**
     * Create a new room
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buildings = Buildings::allWithFullName();
        return view('manager.rooms.create', compact('buildings'));
    }

    /**
     * Persist a new room
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
         $attributes = request()->validate([
             'building' => ['required', Rule::in(Buildings::all())],
             'number' => [
                 'required',
                 'unique:rooms,number,NULL,id,building,' . request()->building,
                 'existsinstag' => new RoomExists($this->stag, request()->building ?? '')
             ],
        ], [
            'number.required' => 'Zadejte prosím název místnosti.',
            'number.unique' => 'Tato místnost se v databázi již nachází.',
         ]);

        auth()->user()->rooms()->create($attributes);

        return redirect('/manager/rooms');
    }


    /**
     *
     *
     * @param Room $room
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect(action('Manager\RoomsController@index'));
    }
}
