@extends('index')

@section('content')
    <main role="main" class="flex-shrink-0">
        <section class="content my-5">
            <div class="container m-auto">
                <div class="row">
                    <div class="col-12 p-0"><h3><a href="/felhasznalok">Felhasználók</a> ›
                            <span class="small">@if(isset($content->email)) módosítás @else új hozzáadása @endif</span></h3></div>
                </div>

                <form action="@isset($content){{ route('user.update', array_merge(["id" => $content->felhasznaloID], Request::query()), false) }}@else{{ route('user.insert', Request::query(), false) }}@endisset" method="post" autocomplete="off">
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
                                        <input type="text" class="form-control" id="vezeteknev" name="vezeteknev" required="required"
                                               value="@if(old('vezeteknev')){{old('vezeteknev')}}@elseif(isset($content->vezeteknev)){{$content->vezeteknev}}@endif" />
                                        @if ($errors->has('vezeteknev'))
                                        <label class="col-red mt-1 text-danger"
                                               for="currency_name">{{ $errors->first('vezeteknev') }}</label>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-3 px-2">
                                        <label for="keresztnev">Keresztnév</label>
                                        <input type="text" class="form-control" id="keresztnev" name="keresztnev" required="required"
                                               value="@if(old('keresztnev')){{old('keresztnev')}}@elseif(isset($content->keresztnev)){{$content->keresztnev}}@endif" />
                                        @if ($errors->has('keresztnev'))
                                            <label class="col-red mt-1 text-danger"
                                                   for="currency_name">{{ $errors->first('keresztnev') }}</label>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 pl-2">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" name="email" required="required"
                                               value="@if(old('email')){{old('email')}}@elseif(isset($content->email)){{$content->email}}@endif" />
                                        @if ($errors->has('email'))
                                            <label class="col-red mt-1 text-danger"
                                                   for="currency_name">{{ $errors->first('email') }}</label>
                                        @endif
                                    </div>
                                </div>
                                @if(!isset($content))
                                <div class="form-row">
                                    <div class="form-group col-md-6 pr-2">
                                        <label for="jelszo">Jelszó</label>
                                        <input type="password" class="form-control" id="jelszo" name="jelszo" required="required" />
                                        @if ($errors->has('jelszo'))
                                            <label class="col-red mt-1 text-danger"
                                                   for="currency_name">{{ $errors->first('jelszo') }}</label>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 px-2">
                                        <label for="confirm_jelszo">Jelszó újra</label>
                                        <input type="password" class="form-control" id="confirm_jelszo"
                                               name="jelszo_confirmation" required="required" />
                                        @if ($errors->has('jelszo'))
                                            <label class="col-red mt-1 text-danger"
                                                   for="currency_name">{{ $errors->first('jelszo') }}</label>
                                        @endif
                                    </div>
                                </div>
                                @endif
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
                    </div>

                    <div class="row mt-4 p-0 px-md-2 form-buttons">
                        <div class="col-6 col-md-3 col-lg-2 p-0 pr-2 px-md-2">
                            <button type="submit" class="btn btn-primary form-main-button btn-block px-4">
                                <?=isset($content) ? 'Módosítás' : 'Hozzáadás' ?></button>
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
