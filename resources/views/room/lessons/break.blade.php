<div class="vyuka-probiha mb-5 mt-5">Právě <b>je přestávka</b>.</div>

<div class="hodina">{{ $subjects['data'][$subjects['page']]['department'] }}/{{ $subjects['data'][$subjects['page']]['shortName'] }}</div>
<div class="vyucujici">{{ $subjects['data'][$subjects['page']]['teacher'] }}</div>

<div class="mt-5 d-flex justify-content-center">
    <div class="progress casy">
        <div class="progress-bar" role="progressbar"></div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="d-flex mt-2 casy">
        <div class="text-left mr-auto">{{ $subjects['data'][$subjects['page']]['hourFrom'] }}</div>
        <div class="text-right">{{ $subjects['data'][$subjects['page']]['hourTo'] }}</div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function() {
        window.progressBar( "{{ $subjects['data'][$subjects['page']]['hourFrom'] }}", "{{ $subjects['data'][$subjects['page']]['hourTo'] }}" );
    };
</script>





