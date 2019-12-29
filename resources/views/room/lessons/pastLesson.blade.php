<div class="vyuka-probiha mb-5 mt-5">
    Dnes od {{ $subjects['data'][$subjects['page']]['hourFrom'] }} do {{ $subjects['data'][$subjects['page']]['hourTo'] }}
    <b>probíhala</b> výuka
</div>
<div class="hodina">{{ $subjects['data'][$subjects['page']]['department'] }}/{{ $subjects['data'][$subjects['page']]['shortName'] }}</div>
<div class="vyucujici">{{ $subjects['data'][$subjects['page']]['teacher'] }}</div>
<div class="mt-5 d-flex justify-content-center">
    <div class="progress casy">
        <div class="progress-bar" role="progressbar" style="width: 100%"></div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="d-flex mt-2 casy">
        <div class="text-left mr-auto">{{ $subjects['data'][$subjects['page']]['hourFrom'] }}</div>
        <div class="text-right">{{ $subjects['data'][$subjects['page']]['hourTo'] }}</div>
    </div>
</div>



