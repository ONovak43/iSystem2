@extends ('layouts.admin')
@section ('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Přidat místnost</div>
                    <div class="card-body">
                        <form method="POST" action="/manager/rooms">
                            @csrf
                            <div class="form-group">
                                <label for="building">Budova</label>
                                <select name="building" class="form-control">
                                    @foreach ($buildings as $building => $forHumans)
                                        <option value="{{ $building }}">{{ $forHumans }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="number">Číslo místnosti</label>
                                <input type="text"
                                       class="form-control"
                                       name="number"
                                       placeholder="Například 206"
                                       required
                                       maxlength="255">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Přidat</button>
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
