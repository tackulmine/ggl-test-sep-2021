<div class="form-group row">
    <label for="kode_barang" class="col-sm-2 col-form-label">Kode</label>
    <div class="col-sm-10">
        <input type="text"
            class="form-control"
            id="kode_barang"
            name="kode_barang"
            value="{{ $barang->kode_barang }}"
            placeholder="Kode Barang"
            >
    </div>
</div>
<div class="form-group row">
    <label for="nama_barang" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input type="text"
            class="form-control"
            id="nama_barang"
            name="nama_barang"
            value="{{ $barang->nama_barang }}"
            placeholder="Nama Barang"
            >
    </div>
</div>
<div class="form-group row">
    <label for="gambar_barang" class="col-sm-2 col-form-label">Gambar</label>
    <div class="col-sm-10">
        @if (!empty($barang->gambar_barang))
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('shared')->url($barang->gambar_barang) }}" width="300" alt=""><br>
        @endif
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="gambar_barang" name="gambar_barang" accept="image/png,image/gif,image/jpeg">
            <label class="custom-file-label" for="gambar_barang">Choose an image file</label>
        </div>
    </div>
</div>
