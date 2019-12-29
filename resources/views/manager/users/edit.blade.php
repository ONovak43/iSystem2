@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upravit data uživatele</div>

                    <div class="card-body">
                        <form method="POST" action="{{ action('Manager\UsersController@update', $user) }}">
                            @csrf
                            @method ('PATCH')
                            @include ('manager.users.form', [
                                'buttonText' => 'Upravit uživatele'
                            ])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
