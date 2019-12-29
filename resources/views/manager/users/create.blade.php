@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Vytvořit uživatele</div>

                    <div class="card-body">
                        <form method="POST" action="{{ action('Manager\UsersController@store') }}">
                            @csrf
                            @include ('manager.users.form', [
                                'user' => new App\User,
                                'buttonText' => 'Vytvořit uživatele'
                            ])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
