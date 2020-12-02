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

    <div class="form-group col-md-3 px-2">
        <label for="mennyiseg">Mennyiség</label>
        <input type="text" class="form-control numeric" id="mennyiseg"
               name="mennyiseg[]" value="1" required="required" />
    </div>
    <div class="form-group col-md-1 px-2">
        <button type="button" class="btn btn-operations-small btn-danger ml-1 button-delete-item" title="Törlés">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
            </svg>
        </button>
    </div>
</div>
