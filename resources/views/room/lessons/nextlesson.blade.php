@if ($subjects['pageNext'] !== null)
    <div class="nasleduje mt-5">
        <div>a od {{ $subjects['data'][$subjects['pageNext']]['hourFrom'] }} následuje</div>
        <div class="nasledujici-hodina">{{ $subjects['data'][$subjects['pageNext']]['department'] }}/{{ $subjects['data'][$subjects['pageNext']]['shortName'] }}</div>
    </div>
@else
    <div class="zadna-hodina mt-5">Dnes v této učebně již nenásleduje žádná další výuka.</div>
@endif
