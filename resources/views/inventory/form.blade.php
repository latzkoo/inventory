@extends('index')

@section('content')
    <main role="main" class="flex-shrink-0">
        <section class="content my-5">
            <div class="container m-auto">
                <div class="row">
                    <div class="col-12 p-0"><h3><a href="/raktarak">Raktárak</a> ›
                            <span class="small">@if(isset($content->email)) módosítás @else új hozzáadása @endif</span></h3></div>
                </div>

                <form action="@isset($content){{ route('inventory.update', array_merge(["id" => $content->raktarID], Request::query()), false) }}@else{{ route('inventory.insert', Request::query(), false) }}@endisset" method="post" autocomplete="off">
                    @csrf

                    <div class="container bg-white rounded shadow-sm p-3">
                        <div class="row">
                            <div class="col-12 bg-dark text-white p-2 font-weight-bolder">Adatok</div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 py-2 px-0">
                                <div class="form-row">
                                    <div class="form-group col-12 px-2">
                                        <label for="vezeteknev">Raktár neve</label>
                                        <input type="text" class="form-control" id="raktarnev" name="raktarnev" required="required"
                                               value="@if(old('raktarnev')){{old('raktarnev')}}@elseif(isset($content->raktarnev)){{$content->raktarnev}}@endif" />
                                        @if ($errors->has('raktarnev'))
                                        <label class="col-red mt-1 text-danger"
                                               for="currency_name">{{ $errors->first('raktarnev') }}</label>
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
                            <a href="/raktarak">
                                <button type="button" class="btn btn-secondary form-main-button btn-block px-4">Mégsem</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
