@extends(config('laravelfortify.layout'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form Demo useAxios') }}</div>

                <div class="card-body">
                    <form method="POST" id='formDemo' action="{{ route('postMethod') }}">
                        @csrf
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

            })
            .then((response) => { 
                console.log(response);
            })
            .catch((error) => {
                const errors = error.response.data.errors 
                console.log(errors);
            });
        }); 
    })();
</script>

@endsection