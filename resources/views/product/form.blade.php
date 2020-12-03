@extends('index')

@section('content')
    <main role="main" class="flex-shrink-0">
        <section class="content my-5">
            <div class="container m-auto">
                <div class="row">
                    <div class="col-12 p-0"><h3><a href="/cikkek">Cikkek</a> ›
                            <span class="small">@if(isset($content)) módosítás @else új hozzáadása @endif</span></h3></div>
                </div>

                <form action="@isset($content){{ route('product.update', array_merge(["id" => $content->cikkID], Request::query()), false) }}@else{{ route('product.insert', Request::query(), false) }}@endisset" method="post" autocomplete="off">
                    @csrf

                    <div class="container bg-white rounded shadow-sm p-3">
                        <div class="row">
                            <div class="col-12 bg-dark text-white p-2 font-weight-bolder">Adatok</div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 py-2 px-0">
                                <div class="form-row">
                                    <div class="form-group col-md-12 px-2">
                                        <label for="megnevezes">Megnevezés</label>
                                        <input type="text" class="form-control" id="megnevezes" name="megnevezes" required="required"
                                               value="@if(old('megnevezes')){{old('megnevezes')}}@elseif(isset($content->megnevezes)){{$content->megnevezes}}@endif" />
                                        @if ($errors->has('megnevezes'))
                                            <label class="col-red mt-1 text-danger"
                                                   for="megnevezes">{{ $errors->first('megnevezes') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 py-2 px-0">
                                <div class="form-row">
                                    <div class="form-group col-md-6 px-2">
                                        <label for="termekkod">Termékkód</label>
                                        <input type="text" class="form-control" id="termekkod" name="termekkod" required="required"
                                               value="@if(old('termekkod')){{old('termekkod')}}@elseif(isset($content->termekkod)){{$content->termekkod}}@endif" />
                                        @if ($errors->has('termekkod'))
                                        <label class="col-red mt-1 text-danger"
                                               for="termekkod">{{ $errors->first('termekkod') }}</label>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 px-2">
                                        <label for="ar">Beszerzési ár</label>
                                        <input type="text" class="form-control numeric" id="ar" name="ar" required="required"
                                               value="@if(old('ar')){{old('ar')}}@elseif(isset($content->ar)){{$content->ar}}@endif" />
                                        @if ($errors->has('ar'))
                                            <label class="col-red mt-1 text-danger"
                                                   for="ar">{{ $errors->first('ar') }}</label>
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
                            <a href="/cikkek">
                                <button type="button" class="btn btn-secondary form-main-button btn-block px-4">Mégsem</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
