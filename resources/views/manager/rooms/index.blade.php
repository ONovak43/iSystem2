@extends ('layouts.admin')
@section ('content')
<div class="d-flex justify-content-center">
    <h1>Správa místností</h1>
</div>
<div class="d-flex justify-content-center mt-3">
    <table class="table text-center w-25 table-hover">
        <thead class="thead-dark">
        <tr>
            <th>Název místnosti</th>
            <th>Odstranit</th>
        </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
                <tr>
                    <td>{{ $room->building }}-{{ $room->number }}</td>
                    <td>
                        <form action="{{ $room->pathInManager() }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="odstranit"><img src="/img/x.svg" style="width: 100%"></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    <a href="/manager/rooms/create">Přidat místnost</a>
</div>
@endsection
