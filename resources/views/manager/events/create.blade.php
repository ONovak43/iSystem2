@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Vytvořit akci</div>

                    <div class="card-body">
                        <form method="POST" action="{{ action('Manager\RoomEventsController@store') }}">
                            @csrf
                            @include ('manager.events.form', [
                                'rooms' => $rooms,
                                'buttonText' => 'Vytvořit akci',
                                'event' => new App\Event
                            ])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($errors->all() as $error)
        {{ $error }}
    @endforeach
@endsection
