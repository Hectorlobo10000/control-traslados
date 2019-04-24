@extends('layouts.custom.app')

@section('content-login')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header mb-4"> {{config('app.name', 'Laravel')}}  {{ __(' - Iniciar sesion')}}</div>
        <div class="card-body">
          <form action="{{ route('login') }}" method="POST">
            @csrf
            
            {{-- E-mail --}}
            <div class="form-group row">
              <div class="col-md-8 offset-md-2">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </div>
                  <input type="email" id="email" placeholder="Correo" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                  @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
            </div>
            {{-- E-mail --}}

            {{-- Password --}}
            <div class="form-group row">
              <div class="col-md-8 offset-md-2">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-key"></i>
                    </span>
                  </div>
                  <input type="password" id="password" placeholder="Contrasena" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                  @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
            </div>
            {{-- Password --}}

            {{-- Remember me --}}
            <div class="form-group row">
              <div class="col-md-8 offset-md-2">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label for="remember" class="form-check-label">{{ __('Recordarme') }}</label>
                </div>
                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="btn btn-link pl-0">
                    {{ __('Olvido su contrasena?') }}
                  </a>
                @endif
              </div>
            </div>
            {{-- Remember me --}}

            {{-- Submit --}}
            <div class="form-group row">
              <div class="col-md-8 offset-md-2">
                <button type="submit" class="btn btn-success btn-block">{{ __('Iniciar') }}</button>
              </div>
            </div>
            {{-- Submit --}}
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection