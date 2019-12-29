@extends ('layouts.app')
@section ('room')
    <h1 class="m-0 font-weight-bold mistnost">{{ $room->building }}-{{ $room->number }}</h1>
    <a href="/rozvrh/{{ $room->id }}" class="zobrazit-rozvrh font-weight-bold" target="_blank">Zobrazit rozvrh učebny</a>
@endsection

@section ('content')
<div class="row mt-2">
    <div class="col-2">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-6">
                    <div  class="row justify-content-center align-self-center">
                        @if ($subjects['pagePrevious'])
                            <a href="/rooms/{{ $room->id }}/{{ $subjects['data'][$subjects['pagePrevious']]['startsLesson'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="36" viewBox="0 0 8 8" fill="#519136">
                                    <path d="M4 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z" transform="translate(1)" />
                                </svg>
                            </a>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="36" viewBox="0 0 8 8" fill="#4D504A">
                                <path d="M4 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z" transform="translate(1)" />
                            </svg>
                        @endif
                    </div>
                </div>
            </div>
         </div>
    </div>
    <div class="col-8 d-flex justify-content-center">
        <div class="text-center">
            @if ($event !== null && $subjects['page'] !== null)
                @include ("room.lessons.event")
            @elseif ($event !== null && $subjects['page'] === null)
                    @include ("room.lessons.eventempty")
            @elseif ($subjects['page'] === null)
                @include ("room.lessons.nolesson")
            @else
                @include ("room.lessons.{$lessonType}")
            @endif
            @include ('room.lessons.nextlesson')
            <div class="mt-3"><a href="/" class="zobrazit-rozvrh font-weight-bold">Zpět na výběr učeben</a></div>
        </div>
    </div>
    <div class="col-2">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-6 ml-auto">
                    <div  class="row justify-content-center align-self-center">
                        @if ($subjects['pageNext'])
                            <a href="/rooms/{{ $room->id }}/{{ $subjects['data'][$subjects['pageNext']]['startsLesson'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="36" viewBox="0 0 8 8" fill="#519136">
                                    <path d="M1.5 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z" transform="translate(1)" />
                                </svg>
                            </a>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="36" viewBox="0 0 8 8" fill="#4D504A">
                                <path d="M1.5 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z" transform="translate(1)" />
                            </svg>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
