@extends ('layouts.app')
@section ('room')
    <h1 class="m-0 font-weight-bold mistnost">{{ $room->building }}-{{ $room->number }}</h1>
@endsection
@section ('content')
    <div class="d-flex">
        <table class="table table-bordered table-hover mt-2" style="text-align: center">
            <tr>
                <td>&nbsp;</td>
                @for ($i = 1; $i < 15; $i++)
                    <td>
                        <div class="timeFrom">
                            {{ $lessonsStartTime->addMinutes(10)->format("H:i") }}
                        </div>
                        <div class="lessonSchedule">{{ $i }}</div>
                        <div class="timeTo">
                            {{ $lessonsStartTime->addMinutes(45)->format("H:i") }}
                        </div>
                    </td>
                @endfor
            </tr>
            @foreach ($timeSchedule as $dayKey => $day)
                @if ($dayKey !== 'others' && !empty($day))
                    <tr>
                        <td>{{ $dayKey }}</td>
                        @foreach ($day as $key => $lesson)
                            @if (!isset($day[$key - 1]))
                                @for ($i = 0; $i < $lesson['startsLesson'] - 1; $i++)
                                    <td>&nbsp;</td>
                                @endfor
                            @elseif (isset($day[$key - 1]) && $day[$key-1]['endsLesson'] + 1 !== $lesson['startsLesson'])
                                @for ($i = $day[$key - 1]['endsLesson']; $i < $lesson['startsLesson'] - 1; ++$i)
                                    <td>&nbsp;</td>
                                @endfor
                            @endif
                            <td class="{{ $lesson['type'] }}" colspan="{{ $lesson['endsLesson']-$lesson['startsLesson']+1 }}">{{ $lesson['department'] ? $lesson['department'] . '/' : null }}{{ $lesson['shortName'] }}</td>
                            @if (!isset($day[$key + 1]))
                                @for ($i = $lesson['endsLesson']; $i < 14; ++$i)
                                    <td>&nbsp;</td>
                                @endfor
                            @endif
                        @endforeach
                    </tr>

                @elseif ($dayKey === 'others')
                    @foreach ($day as $key => $lesson)
                        @if(isset($lesson['date']))
                            @if (!isset($day[$key - 1]) && !isset($day[$key + 1])))
                                <tr>
                                    <td>{{ $lesson['date'] }}</td>
                                    @for ($i = 0; $i < $lesson['startsLesson'] - 1; $i++)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td class="{{ $lesson['type'] }}" colspan="{{ $lesson['endsLesson']-$lesson['startsLesson']+1 }}">{{ $lesson['department'] ? $lesson['department'] . '/' : null }}{{ $lesson['shortName'] }}</td>
                                    @for ($i = $lesson['endsLesson']; $i < 14; ++$i)
                                            <td>&nbsp;</td>
                                    @endfor
                                </tr>
                            @elseif (isset($day[$key-1]) && $day[$key-1]["endsLesson"] >= $day[$key]["startsLesson"])
                                <tr>
                                    <td>&nbsp;</td>
                                    @for ($i = 0; $i < $lesson['startsLesson'] - 1; ++$i)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td class="{{ $lesson['type'] }}" colspan="{{ $lesson['endsLesson'] - $lesson['startsLesson'] + 1 }}">
                                        {{ $lesson['department'] ? $lesson['department'] . '/' : null }}{{ $lesson['shortName'] }}
                                    </td>
                                    @if(!isset($day[$key+1]))
                                        @for ($i = $lesson['endsLesson']; $i < 14; ++$i)
                                            <td>&nbsp;</td>
                                        @endfor
                                        </tr>
                                    @endif
                            @elseif (isset($day[$key + 1]) && $day[$key]["endsLesson"] >= $day[$key+1]["startsLesson"])
                                @if(!isset($day[$key - 1]))
                                    <tr>
                                        <td>{{ $lesson['date'] }}</td>
                                        @for ($i = 0; $i < $lesson['startsLesson'] - 1; ++$i)
                                            <td>&nbsp;</td>
                                        @endfor
                                @else
                                    @for ($i = $day[$key-1]['endsLesson']; $i < $lesson['startsLesson'] - 1; ++$i)
                                        <td>&nbsp;</td>
                                    @endfor
                                @endif
                                <td class="{{ $lesson['type'] }}" colspan="{{ $lesson['endsLesson'] - $lesson['startsLesson'] + 1 }}">{{ $lesson['department'] ? $lesson['department'] . '/' : null }}{{ $lesson['shortName'] }}</td>
                                @for ($i = $lesson['endsLesson']; $i < 14; ++$i)
                                    <td>&nbsp;</td>
                                @endfor
                                </tr>
                            @elseif (isset($day[$key+1]) && $day[$key]["endsLesson"] < $day[$key+1]["startsLesson"])
                                <tr>
                                    <td>{{ $lesson['date'] }}</td>
                                    @for ($i = 0; $i < $lesson['startsLesson'] - 1; $i++)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td class="{{ $lesson['type'] }}" colspan="{{ $lesson['endsLesson'] - $lesson['startsLesson'] + 1 }}">{{ $lesson['department'] ? $lesson['department'] . '/' : null }}{{ $lesson['shortName'] }}</td>
                            @elseif (!isset($day[$key+1]))
                                    @for ($i = $day[$key-1]['endsLesson']; $i < $lesson['startsLesson'] - 1; ++$i)
                                        <td>&nbsp;</td>
                                    @endfor
                                    <td class="{{ $lesson['type'] }}" colspan="{{ $lesson['endsLesson'] - $lesson['startsLesson'] + 1 }}">{{ $lesson['department'] ? $lesson['department'] . '/' : null }}{{ $lesson['shortName'] }}</td>
                                    @for ($i = $lesson['endsLesson']; $i < 14; ++$i)
                                        <td>&nbsp;</td>
                                    @endfor
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach
        </table>
    </div>
@endsection
