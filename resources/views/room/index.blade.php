@extends ('layouts.app')
@section ('content')
<h1 class="vyber-ucebny-nadpis mt-5">Vyber učebnu</h1>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="vyber-ucebnu">
        @foreach($rooms as $room)
            <a href="{{ $room->path() }}">
                <div class="ucebna text-center">
                    {{ $room->building }}-{{ $room->number }}
                </div>
            </a>
        @endforeach
        </div>
    </div>
</div>

@endsection
