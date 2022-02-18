@extends(config('laravelfortify.layout'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tow factor Challenge') }}</div>

                <div class="card-body">
                    {{ __('Please enter your authentication code to login.') }}

                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('code') }}</label>

                            <div class="col-md-6">
                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="code">

                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>

             
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    {{ __('Please enter your recovery code to login.') }}

                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="recovery_code" class="col-md-4 col-form-label text-md-right">{{ __('recovery code') }}</label>

                            <div class="col-md-6">
                                <input id="recovery_code" type="text" class="form-control @error('recovery_code') is-invalid @enderror" name="recovery_code" required autocomplete="recovery_code">

                                @error('recovery_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>

             
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection