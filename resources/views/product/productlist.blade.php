<select class="form-control cikkID" name="cikkID[]" id="cikkID" required="required">
    @if(!isset($content))
        <option value="">Válasszon!</option>
    @endif
    @foreach($products as $product)
        <option value="{{ $product->cikkID }}">
            {{ $product->megnevezes }} ({{ $product->mennyiseg }} db)</option>
    @endforeach
</select>
