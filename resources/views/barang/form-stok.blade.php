<div class="form-group row">
    <label for="kode_barang" class="col-sm-2 col-form-label">Kode</label>
    <div class="col-sm-10">
        <input type="text"
            class="form-control-plaintext"
            readonly
            value="{{ $barang->kode_barang }}"
            >
    </div>
</div>
<div class="form-group row">
    <label for="nama_barang" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input type="text"
            class="form-control-plaintext"
            readonly
            value="{{ $barang->nama_barang }}">
    </div>
</div>
<div class="form-group row">
    <label for="jenis_stok_in" class="col-sm-2 col-form-label">In/Out</label>
    <div class="col-sm-10">
        <div class="form-check">
            <input class="form-check-input"
                type="radio"
                name="jenis_stok"
                id="jenis_stok1"
                value="in"
                checked>
            <label class="form-check-label" for="jenis_stok1">
                In
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input"
                type="radio"
                name="jenis_stok"
                id="jenis_stok2"
                value="out">
            <label class="form-check-label" for="jenis_stok2">
                Out
            </label>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="total_barang" class="col-sm-2 col-form-label">Total</label>
    <div class="col-sm-3">
        <input type="number"
            {{-- max="{{ $barang->stok > 0 ? $barang->stok : 0 }}" --}}
            min="1"
            step="1"
            class="form-control"
            id="total_barang"
            name="total_barang"
            value="{{ $barang->total_barang }}"
            >
    </div>
</div>
