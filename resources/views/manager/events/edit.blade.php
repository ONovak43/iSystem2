@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upravit rozvrhovou akci</div>

                    <div class="card-body">
                        <form method="POST" action="{{ action('Manager\RoomEventsController@update', $event) }}">
                            @csrf
                            @method ('PATCH')
                            @include ('manager.events.form', [
                                'buttonText' => 'Upravit akci'
                            ])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include ('errors')
@endsection
