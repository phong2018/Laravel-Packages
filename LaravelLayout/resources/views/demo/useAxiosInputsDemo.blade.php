@extends(config('laravelfortify.layout'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form Demo useAxios') }}</div>

                <div class="card-body">
                    <form method="POST" id='formDemo' action="{{ route('postInputsMethod') }}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                            <div class="col-md-6">
                                <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}"  autocomplete="age" autofocus>

                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
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

<script>
    (function() {
        document.querySelector('#formDemo').addEventListener('submit', function (e) {
            e.preventDefault();;

            axios.post(this.action, { 
                'name':document.querySelector('#name').value,
                'age':document.querySelector('#age').value,
            })
            .then((response) => {  
                clearErrors()
                this.reset()
                this.insertAdjacentHTML('afterend', '<div class="alert alert-success" id="success">User created successfully!</div>')
                document.getElementById('success').scrollIntoView()
            })
            .catch((error) => {
                const errors = error.response.data.errors;
                const firstItem = Object.keys(errors)[0];
                const firstItemDOM = document.getElementById(firstItem);
                const firstErrorMessage = errors[firstItem][0];
                // scroll to the error message
                firstItemDOM.scrollIntoView();
                clearErrors();
                // show the error message
                firstItemDOM.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`)
                // highlight the form control with the error
                firstItemDOM.classList.add('border', 'border-danger')
            });

            function clearErrors() {
                // remove all error messages
                const errorMessages = document.querySelectorAll('.text-danger')
                errorMessages.forEach((element) => element.textContent = '')
                // remove all form controls with highlighted error text box
                const formControls = document.querySelectorAll('.form-control')
                formControls.forEach((element) => element.classList.remove('border', 'border-danger'))
            }
        }); 
    })();
</script>

@endsection