<div class="vyuka-probiha mb-5 mt-5">
    Výuka předmětu
    {{ $subjects['data'][$subjects['page']]['department'] }}/{{ $subjects['data'][$subjects['page']]['shortName'] }}
    <b>{{ $event->type === 'moved' ? 'přesunuta. ' : 'zrušena.' }}</b>
</div>
<div class="hodina">{{ $event->type === 'moved' ? 'Přesunuto do ' .  $event->moved_to : 'Výuka zrušena.' }}</div>


<div class="mt-5 d-flex justify-content-center">
    <div class="progress casy">
        <div class="progress-bar" role="progressbar" style="width: 100%; background-color: #ff4455"></div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="d-flex mt-2 casy">
        <div class="text-left mr-auto">{{ $subjects['data'][$subjects['page']]['hourFrom'] }}</div>
        <div class="text-right">{{ $subjects['data'][$subjects['page']]['hourTo'] }}</div>
    </div>
</div>
