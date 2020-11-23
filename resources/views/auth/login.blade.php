@extends('index')

@section('content')
    <main role="main" class="row h-100">
        <section class="login col-12 my-auto px-3">
            <div class="brand text-center mb-3"><span>R</span>aktár</div>
            <div class="container bg-white rounded shadow-sm p-4">
                <form action="/login/" method="post">
                    @csrf
                    <div class="wrapper mx-auto">
                        <div class="col-12 m-auto order-md-1 form-block px-0 pt-3">
                            <div class="mb-3">
                                <label for="email">E-mail cím</label>
                                <input type="email" class="form-control" id="email" required="required" name="email"
                                       <?=old("email") ? 'value="'.old("email").'"' : 'autofocus'?> />
                            </div>

                            <div class="col-md-12 mb-3 p-0">
                                <label for="passwd">Jelszó</label>
                                <input type="password" class="form-control" id="passwd" required="required" name="password" />
                            </div>

                            <button class="btn btn-primary btn-register btn-lg btn-block mt-4" type="submit">Belépés</button>

                            <div class="text-danger pt-3 text-center">
                                @if(count($errors) && $errors->first()) Hibás e-mail cím vagy jelszó! @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
