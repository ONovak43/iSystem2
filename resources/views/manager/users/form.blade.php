<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">Uživatelské jméno</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $user->name }}" required autocomplete="name" autofocus>

        @error('name')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">E-mailová adresa</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email  }}" required autocomplete="email">

        @error('email')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password" class="col-md-4 col-form-label text-md-right">Heslo</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Potvrdit heslo</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
    </div>
</div>

<div class="form-group row">
    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Typ účtu</label>
    <div class="col-md-6">
        <select class="form-control" name="type" required>
            <option value="{{ App\User::DEFAULT_TYPE }}">Běžný uživatel</option>
            <option value="{{ App\User::ADMIN_TYPE }}" {{ ($user->type === App\User::ADMIN_TYPE) ? 'selected' : null }}>Administrátor</option>
        </select>
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ $buttonText }}
        </button>
    </div>
</div>

