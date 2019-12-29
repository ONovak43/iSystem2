@extends ('layouts.admin')
@section ('content')
<div class="d-flex justify-content-center">
    <h1>Správa uživatelů</h1>
</div>
<table class="table text-center table-hover mt-3">
    <thead class="thead-dark">
    <tr>
        <th>Uživatel</th>
        <th>E-mail</th>
        <th>Vytvořen</th>
        <th>Typ uživatele</th>
        <th>Odstranit</th>
    </tr>
    </thead>
    <tbody style="cursor: pointer">
        @foreach($users as $user)
            <tr onclick="window.location.href = '/manager/users/' + {{ $user->id }} + '/edit'">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->type === \App\User::DEFAULT_TYPE ? 'Běžný uživatel' : 'Administrátor' }}</td>
                <td>
                    <form action="/manager/users/{{ $user->id  }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="odstranit"><img src="/img/x.svg" style="width: 100%"></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<a href="/manager/users/create">Přidat uživatele</a>
@endsection
