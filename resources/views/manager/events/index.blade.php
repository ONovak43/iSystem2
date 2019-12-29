@extends ('layouts.admin')
@section ('content')
<div class="d-flex justify-content-center">
    <h1>Vyber učebnu</h1>
</div>
<table class="table text-center table-hover mt-3">
    <thead class="thead-dark">
        <tr>
            <th>Místnost</th>
            <th>Typ akce</th>
            <th>Datum</th>
            <th>Začátek akce</th>
            <th>Konec akce</th>
            <th>Odebrat</th>
        </tr>
    </thead>
    <tbody style="cursor: pointer">
        @foreach($events as $event)
            <tr  onclick="window.location.href = '/manager/events/' + {{ $event->id }} + '/edit'">
                <td>{{ $event->room->building }}-{{ $event->room->number }}</td>
                <td>{{ $event->type === 'moved' ? 'Výuka přesunuta do ' . $event->moved_to : 'Výuka zrušena' }}</td>
                <td>{{ $event->date }}</td>
                <td>{{ $event->starts_at }}</td>
                <td>{{ $event->ends_at }}</td>
                <td>
                    <form action="{{ $event->path() }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="odstranit"><img src="/img/x.svg" style="width: 100%"></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a href="/manager/events/create">Přidat rozvrhovou událost</a>
@endsection
