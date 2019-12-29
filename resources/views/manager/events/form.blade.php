@csrf
<div class="form-group">
    <label for="room_id">Učebna</label>
    <select type="text"
            class="form-control"
            name="room_id">
        @foreach ($rooms as $room)
            <option value="{{ $room->id }}" {{ (old("room_id") == $room->id ? 'selected' : '') }}>{{ $room->building }}-{{ $room->number }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="type">Typ akce</label>
    <select type="text"
            class="form-control"
            name="type"
            id="selected-action"
            onchange="this.selectedIndex === 1 ? document.getElementById('moved-to-control').style.display = 'none' : document.getElementById('moved-to-control').style.display = 'block';">
        @if (old("type"))
            <option value="moved">Přesun výuky</option>
            <option value="cancel" {{ (old("type") == 'cancel' ? 'selected' : '') }}>Zrušení výuky</option>
        @else
            <option value="moved">Přesun výuky</option>
            <option value="cancel" {{ ($event->type == 'cancel' ? 'selected' : '') }}>Zrušení výuky</option>
        @endif
    </select>
</div>
<div class="form-group moved-to" id="moved-to-control" style="">
    <label for="moved_to">Výuka přesunuta do</label>
    <input type="text" class="form-control" name="moved_to" value="{{ old('moved_to') ?? $event->moved_to }}">

</div>
<div class="form-group moved-to">
    <label for="type">Datum</label>
    <input type="date" class="form-control" name="date" value="{{ old('date') ?? $event->date }}">

</div>
<div class="form-group moved-to">
    <label for="type">Začátek akce</label>
    <input type="time" class="form-control" name="starts_at" value="{{ old('starts_at') ?? $event->starts_at }}">

</div>
<div class="form-group moved-to">
    <label for="type">Konec akce</label>
    <input type="time" class="form-control" name="ends_at" value="{{ old('ends_at') ?? $event->ends_at }}">
</div>
<button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
