@extends('index')

@section('content')
    <main role="main" class="flex-shrink-0">
        <section class="content my-5">
            <div class="container m-auto">
                <div class="row">
                    <div class="col-12 p-0"><h3><a href="/felhasznalok">Felhasználók</a> ›
                            <span class="small">új hozzáadása</span></h3></div>
                </div>

                <form action="/felhasznalok" method="post">
                    @csrf

                    <div class="container bg-white rounded shadow-sm p-3">
                        <div class="row">
                            <div class="col-12 bg-dark text-white p-2 font-weight-bolder">Adatok</div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 py-2 px-0">
                                <div class="form-row">
                                    <div class="form-group col-md-3 pr-2">
                                        <label for="vezeteknev">Vezetéknév</label>
                                        <input type="text" class="form-control" id="vezeteknev" name="vezeteknev"
                                               placeholder="" required="required" />
                                    </div>
                                    <div class="form-group col-md-3 px-2">
                                        <label for="keresztnev">Keresztnév</label>
                                        <input type="text" class="form-control" id="keresztnev" name="keresztnev"
                                               placeholder="" required="required" />
                                    </div>
                                    <div class="form-group col-md-6 pl-2">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="" required="required" />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 pr-2">
                                        <label for="jelszo">Jelszó</label>
                                        <input type="password" class="form-control" id="jelszo" name="jelszo"
                                               placeholder="" required="required" min="6" />
                                    </div>
                                    <div class="form-group col-md-6 px-2">
                                        <label for="confirm_jelszo">Jelszó újra</label>
                                        <input type="password" class="form-control" id="confirm_jelszo" name="keresztnev"
                                               placeholder="" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>

{{--                                <div class="row p-0 my-3">--}}
{{--                                    <div class="col-12 pb-2 px-0">Műfaj</div>--}}
{{--                                    <div class="col-6 col-sm-4 col-md-2 p-0" th:each="i : ${#numbers.sequence(1, 20)}">--}}
{{--                                        <div class="custom-control custom-checkbox">--}}
{{--                                            <input type="checkbox" class="custom-control-input" th:id="${'g'+(i)}"--}}
{{--                                                   name="genres[]" value="1" />--}}
{{--                                            <label class="custom-control-label" th:for="${'g'+(i)}">Thriller</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="form-group">--}}
{{--                                    <div class="row mb-2">Kép kiválasztása</div>--}}
{{--                                    <div class="custom-file">--}}
{{--                                        <input type="file" class="custom-file-input" id="customFile" accept="image/jpg,image/jpeg">--}}
{{--                                        <label class="custom-file-label" for="customFile">Kép kiválasztása</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                    </div>

                    <div class="row mt-4 p-0 px-md-2 form-buttons">
                        <div class="col-6 col-md-3 col-lg-2 p-0 pr-2 px-md-2">
                            <button type="submit" class="btn btn-primary form-main-button btn-block px-4">Hozzáadás</button>
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
