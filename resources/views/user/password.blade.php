@extends('index')

@section('content')
    <main role="main" class="flex-shrink-0">
        <section class="content my-5">
            <div class="container m-auto">
                <div class="row">
                    <div class="col-12 p-0"><h3>Jelszó módosítása</h3></div>
                </div>

                <form action="{{ route('user.password.update') }}" method="post">
                    @csrf

                    <div class="container bg-white rounded shadow-sm p-3">
                        <div class="row">
                            <div class="col-12 bg-dark text-white p-2 font-weight-bolder">Adatok</div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-12 px-0">
                                <div class="row pt-3">
                                    <div class="col-12 pb-2 px-0">
                                        <div class="form-row">
                                            <div class="form-group col-md-4 pr-2">
                                                <label for="old_jelszo">Jelenlegi jelszó</label>
                                                <input type="password" class="form-control" id="old_jelszo" name="old_jelszo"
                                                        autocomplete="new-password" required="required" />
                                                @if ($errors->has('old_jelszo'))
                                                    <label class="col-red mt-1 text-danger"
                                                           for="currency_name">{{ $errors->first('old_jelszo') }}</label>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-4 pr-2">
                                                <label for="new_jelszo">Új jelszó</label>
                                                <input type="password" class="form-control" id="new_jelszo" name="new_jelszo"
                                                       autocomplete="new-password" required="required" />
                                                @if ($errors->has('new_jelszo'))
                                                    <label class="col-red mt-1 text-danger"
                                                           for="currency_name">{{ $errors->first('new_jelszo') }}</label>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-4 px-2">
                                                <label for="confirm_jelszo">Új jelszó újra</label>
                                                <input type="password" class="form-control" id="confirm_jelszo" required="required"
                                                       name="new_jelszo_confirmation" autocomplete="new-password" />
                                                @if ($errors->has('new_jelszo_confirmation'))
                                                    <label class="col-red mt-1 text-danger"
                                                           for="currency_name">{{ $errors->first('new_jelszo_confirmation') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 p-0 px-md-2 form-buttons">
                        <div class="col-6 col-md-3 col-lg-2 p-0 pr-2 px-md-2">
                            <button type="submit" class="btn btn-primary form-main-button btn-block px-4">Módosítás</button>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2 p-0 pl-2 px-md-2">
                            <a href="/felhasznalok">
                                <button type="button" class="btn btn-secondary form-main-button btn-block px-4">Mégsem</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
