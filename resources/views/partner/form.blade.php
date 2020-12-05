@extends('index')

@section('content')
    <main role="main" class="flex-shrink-0">
        <section class="content my-5">
            <div class="container m-auto">
                <div class="row">
                    <div class="col-12 p-0"><h3><a href="/partnerek">Partnerek</a> ›
                            <span class="small">@if(isset($content)) módosítás @else új hozzáadása @endif</span></h3></div>
                </div>

                <form action="@isset($content){{ route('partner.update', array_merge(["id" => $content->partnerID], Request::query()), false) }}@else{{ route('partner.insert', Request::query(), false) }}@endisset" method="post" autocomplete="off">
                    @csrf

                    <div class="container bg-white rounded shadow-sm p-3">
                        <div class="row">
                            <div class="col-12 bg-dark text-white p-2 font-weight-bolder">Adatok</div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 py-2 px-0">
                                <div class="form-row">
                                    <div class="form-group col-12 px-2">
                                        <label for="partnernev">Partner neve</label>
                                        <input type="text" class="form-control" id="partnernev" name="partnernev" required="required"
                                               value="@if(old('partnernev')){{old('partnernev')}}@elseif(isset($content->partnernev)){{$content->partnernev}}@endif" />
                                        @if ($errors->has('partnernev'))
                                        <label class="col-red mt-1 text-danger">{{ $errors->first('partnernev') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 py-2 px-0">
                                <div class="form-row">
                                    <div class="form-group col-6 px-2">
                                        <label for="iranyitoszam">Irányítószám</label>
                                        <input type="text" class="form-control numeric" id="iranyitoszam"
                                               name="iranyitoszam" required="required"
                                               value="@if(old('iranyitoszam')){{old('iranyitoszam')}}@elseif(isset($content->iranyitoszam)){{$content->iranyitoszam}}@endif" maxlength="5" />
                                        @if ($errors->has('iranyitoszam'))
                                            <label class="col-red mt-1 text-danger">{{ $errors->first('iranyitoszam') }}</label>
                                        @endif
                                    </div>

                                    <div class="form-group col-6 px-2">
                                        <label for="telepules">Település</label>
                                        <input type="text" class="form-control" id="telepules" name="telepules" required="required"
                                               value="@if(old('telepules')){{old('telepules')}}@elseif(isset($content->telepules)){{$content->telepules}}@endif" />
                                        @if ($errors->has('telepules'))
                                            <label class="col-red mt-1 text-danger">{{ $errors->first('telepules') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 py-2 px-0">
                                <div class="form-row">
                                    <div class="form-group col-6 px-2">
                                        <label for="utca">Utca</label>
                                        <input type="text" class="form-control" id="utca" name="utca"
                                               value="@if(old('utca')){{old('utca')}}@elseif(isset($content->utca)){{$content->utca}}@endif" />
                                        @if ($errors->has('utca'))
                                            <label class="col-red mt-1 text-danger">{{ $errors->first('utca') }}</label>
                                        @endif
                                    </div>

                                    <div class="form-group col-6 px-2">
                                        <label for="telepules">Házszám</label>
                                        <input type="text" class="form-control numeric" id="hazszam" name="hazszam"
                                               value="@if(old('hazszam')){{old('hazszam')}}@elseif(isset($content->hazszam)){{$content->hazszam}}@endif" />
                                        @if ($errors->has('hazszam'))
                                            <label class="col-red mt-1 text-danger">{{ $errors->first('hazszam') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 p-0 px-md-2 form-buttons">
                        <div class="col-6 col-md-3 col-lg-2 p-0 pr-2 px-md-2">
                            <button type="submit" class="btn btn-primary form-main-button btn-block px-4">
                                <?=isset($content) ? 'Módosítás' : 'Hozzáadás' ?></button>
                        </div>
                        <div class="col-6 col-md-3 col-lg-2 p-0 pl-2 px-md-2">
                            <a href="/partnerek">
                                <button type="button" class="btn btn-secondary form-main-button btn-block px-4">Mégsem</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
