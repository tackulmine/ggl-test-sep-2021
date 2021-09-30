<div class="form-group row">
    <label for="user_id" class="col-sm-2 col-form-label">Customer</label>
    <div class="col-sm-10">
        <select name="id_user" id="id_user" class="form-control">
            @foreach ($users as $key => $val)
            <option value="{!! $key !!}" {{ $key == $penjualan->id_user ? 'selected' : '' }}>{{ $val }}</option>
            @endforeach
        </select>
    </div>
</div>

<table class="table table-striped" id="penjualan-barang">
<thead>
    <tr>
        <th><button type="button" class="btn btn-success" id="btn-add">add row</button></th>
        <th>Barang</th>
        <th>Jumlah</th>
    </tr>
</thead>
<tbody>
    @if (!empty($penjualan->details))
        @foreach ($penjualan->details as $detail)
        <tr>
            <td>
                #{{ $detail->id }}
            </td>
            <td>
                {{ optional($detail->barang)->nama_barang }}
            </td>
            <td>
                <input name="old_total_barang[{!! $detail->id !!}]" class="form-control text-right" type="number" min="0" step="1" value="{!! $detail->total_barang !!}">
                <div><small><em>Please set 0 to delete!</em></small></div>
            </td>
        </tr>
        @endforeach
    @endif
    <tr>
        <td>
            <button type="button" class="btn btn-danger btn-remove">remove</button>
        </td>
        <td>
            <select name="id_barang[]" class="form-control">
                @foreach ($barangs as $key => $val)
                <option value="{!! $key !!}">{{ $val }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input name="total_barang[]" class="form-control text-right" type="number" min="1" step="1" value="1">
        </td>
    </tr>
</tbody>
<tfoot id="row-to-clone" class="d-none">
    <tr>
        <td>
            <button type="button" class="btn btn-danger btn-remove" disabled>remove</button>
        </td>
        <td>
            <select name="id_barang[]" class="form-control" disabled>
                @foreach ($barangs as $key => $val)
                <option value="{!! $key !!}">{{ $val }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input name="total_barang[]" class="form-control text-right" type="number" min="1" step="1" value="1" disabled>
        </td>
    </tr>
</tfoot>
<tfoot>
    <tr>
        <td colspan="2" align="right">Total Barang</td>
        <td align="right"><span id="total-barang">0</span></td>
    </tr>
</tfoot>
</table>
