@extends('index')

@section('content')
    <main role="main" class="flex-shrink-0">
        <section class="content my-5">
            <div class="container m-auto">
                <div class="row">
                    <div class="col-12 p-0"><h3><a href="/ertekesites">Értékesítés</a> ›
                            <span class="small">@if(isset($content)) módosítás @else új hozzáadása @endif</span></h3></div>
                </div>

                <form action="@isset($content){{ route('sale.update', array_merge(["id" => $content->mozgasID], Request::query()), false) }}@else{{ route('sale.insert', Request::query(), false) }}@endisset" method="post" autocomplete="off">
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
                                        @if(isset($content))
                                            <input type="hidden" name="partnerID" value="{{ $content->partnerID }}" />
                                        @endif
                                        <select class="form-control" @if(!isset($content)) name="partnerID" @endif
                                        id="partnerID" required="required"
                                            @if(isset($content)) disabled="disabled" @endif>
                                            @if(!isset($content))
                                            <option value="">Válasszon!</option>
                                            @endif
                                            @foreach($partners as $partner)
                                            <option value="{{ $partner->partnerID }}" @if((old('partnerID') && $partner->partnerID == old('partnerID')) || (isset($content) && $content->partnerID == $partner->partnerID)) selected="selected" @endif>{{ $partner->partnernev }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('partnerID'))
                                            <label class="col-red mt-1 text-danger">{{ $errors->first('partnerID') }}</label>
                                        @endif
                                    </div>

                                    <div class="form-group col-6 px-2">
                                        <label for="inventory">Raktár</label>
                                        @if(isset($content))
                                            <input type="hidden" name="raktarID" value="{{ $content->raktarID }}" />
                                        @endif
                                        <select class="form-control" @if(!isset($content))name="raktarID"@endif
                                                id="inventory" required="required"
                                            @if(isset($content)) disabled="disabled" @endif>
                                            @if(!isset($content))
                                            <option value="">Válasszon!</option>
                                            @endif
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
                                @if(isset($items) && !empty($items))
                                    @foreach($items as $i => $item)
                                        <div class="form-row movement-item">
                                            <div class="form-group col-md-4 px-2">
                                                <label for="partnerID">Cikk</label>
                                                <select class="form-control cikkID" name="cikkID[]" id="cikkID" required="required">
                                                    @if(!isset($content))
                                                        <option value="">Válasszon!</option>
                                                    @endif
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->cikkID }}"
                                                        @if($item->cikkID == $product->cikkID)
                                                        selected="selected" @endif>{{ $product->megnevezes }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4 px-2">
                                                <label for="ar">Eladási ár</label>
                                                <input type="text" class="form-control numeric" id="ar" name="ar[]"
                                                       data-mul="1.2" required="required" value="{{ $item->ar }}" />
                                            </div>

                                            <div class="form-group col-md-<?=$i > 0 ? 3 : 4?> px-2">
                                                <label for="mennyiseg">Mennyiség</label>
                                                <input type="text" class="form-control numeric" id="mennyiseg"
                                                       name="mennyiseg[]" required="required" value="{{ $item->mennyiseg }}" />
                                            </div>
                                            @if($i > 0)
                                            <div class="form-group col-md-1 px-2">
                                                <button type="button" class="btn btn-operations-small btn-danger ml-1 button-delete-item" title="Törlés">
                                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                <div class="form-row movement-item">
                                    <div class="form-group col-md-4 px-2">
                                        <label for="partnerID">Cikk</label>
                                        <div class="product-holder">
                                            <select class="form-control cikkID" name="cikkID[]" id="cikkID" required="required">
                                                <option value="">Válasszon raktárat!</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4 px-2">
                                        <label for="ar">Eladási ár</label>
                                        <input type="text" class="form-control numeric" id="ar" name="ar[]"
                                               data-mul="1.2" required="required" />
                                    </div>

                                    <div class="form-group col-md-4 px-2">
                                        <label for="mennyiseg">Mennyiség</label>
                                        <input type="text" class="form-control numeric" id="mennyiseg"
                                               name="mennyiseg[]" value="1" required="required" />
                                    </div>
                                </div>
                                @endif

                                <div id="newitems"></div>
                                <div class="form-row px-2">
                                    <button class="btn btn-sm btn-secondary" type="button" id="newitem"
                                            data-type="ertekesites">+ cikk hozzáadása</button>
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
                            <a href="/ertekesites">
                                <button type="button" class="btn btn-secondary form-main-button btn-block px-4">Mégsem</button>
                            </a>
                        </div>
                    </div>
                    @if ($errors->has('cikkID'))
                        <div class="row mt-4 p-0 px-2">
                            <div class="col-12 mt-4 p-0 px-2">
                                <div class="alert alert-danger" role="alert">
                                    <div class="font-weight-bold">{{ $errors->first('cikkID') }}</div>
                                    <div>Kérem, ellenőrizze a raktárkészletet!</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </section>
    </main>
@endsection
