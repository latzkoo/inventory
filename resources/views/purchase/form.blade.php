@extends('index')

@section('content')
    <main role="main" class="flex-shrink-0">
        <section class="content my-5">
            <div class="container m-auto">
                <div class="row">
                    <div class="col-12 p-0"><h3><a href="/beszerzes">Beszerzés</a> ›
                            <span class="small">@if(isset($content->email)) módosítás @else új hozzáadása @endif</span></h3></div>
                </div>

                <form action="@isset($content){{ route('purchase.update', array_merge(["id" => $content->raktarID], Request::query()), false) }}@else{{ route('purchase.insert', Request::query(), false) }}@endisset" method="post" autocomplete="off">
                    @csrf

                    <div class="container bg-white rounded shadow-sm p-3">
                        <div class="row">
                            <div class="col-12 bg-dark text-white p-2 font-weight-bolder">Adatok</div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 py-2 px-0">
                                <div class="form-row">
                                    <div class="form-group col-6 px-2">
                                        <label for="partnerID">Partner</label>
                                        <select class="form-control" name="partnerID" id="partnerID" required="required">
                                            <option value="">Válasszon!</option>
                                            @foreach($partners as $partner)
                                            <option value="{{ $partner->partnerID }}" @if((old('partnerID') && $partner->partnerID == old('partnerID')) || (isset($content) && $content->partnerID == $partner->partnerID)) selected="selected" @endif>{{ $partner->partnernev }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('partnerID'))
                                            <label class="col-red mt-1 text-danger">{{ $errors->first('partnerID') }}</label>
                                        @endif
                                    </div>

                                    <div class="form-group col-6 px-2">
                                        <label for="partnerID">Raktár</label>
                                        <select class="form-control" name="raktarID" id="raktarID" required="required">
                                            <option value="">Válasszon!</option>
                                            @foreach($inventories as $inventory)
                                                <option value="{{ $inventory->raktarID }}" @if((old('raktarID') && $inventory->raktarID == old('raktarID')) || (isset($content) && $content->raktarID == $inventory->raktarID)) selected="selected" @endif>{{ $inventory->raktarnev }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('raktarID'))
                                            <label class="col-red mt-1 text-danger">{{ $errors->first('raktarID') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container bg-white rounded shadow-sm p-3">
                        <div class="row">
                            <div class="col-12 bg-dark text-white p-2 font-weight-bolder">Cikkek</div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-12 py-2 px-0">
                                <div class="form-row movement-item">
                                    <div class="form-group col-md-4 px-2">
                                        <label for="partnerID">Cikk</label>
                                        <select class="form-control cikkID" name="cikkID[]" id="cikkID" required="required">
                                            <option value="">Válasszon!</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->cikkID }}">{{ $product->megnevezes }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 px-2">
                                        <label for="ar">Ár</label>
                                        <input type="text" class="form-control numeric" id="ar" name="ar[]" required="required" />
                                    </div>

                                    <div class="form-group col-md-4 px-2">
                                        <label for="mennyiseg">Mennyiség</label>
                                        <input type="text" class="form-control numeric" id="mennyiseg"
                                               name="mennyiseg[]" value="1" required="required" />
                                    </div>
                                </div>
                                <div id="newitems"></div>
                                <div class="form-row px-2">
                                    <button class="btn btn-sm btn-secondary" type="button" id="newitem">+ cikk hozzáadása</button>
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
                            <a href="/beszerzes">
                                <button type="button" class="btn btn-secondary form-main-button btn-block px-4">Mégsem</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
