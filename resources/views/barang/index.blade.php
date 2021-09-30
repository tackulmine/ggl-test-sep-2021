@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Barang') }}</div>

    <div class="card-body">
        <p><a href="{{ route('barang.create') }}">Create new</a></p>

        @include('shared.success')

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>
                        @if (!empty($item->gambar_barang))
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('shared')->url($item->gambar_barang) }}" width="100" alt="">
                        @endif
                    </td>
                    <td>{{ $item->stok }}</td>
                    <td>
                        <a href="{{ route('barang.edit-stok', $item->id) }}">Edit Stok</a>
                        |
                        <a href="{{ route('barang.edit', $item->id) }}">Edit</a>
                        |
                        <a href="#!" onclick="if(confirm('Are you sure?')) { document.getElementById('delete-{!! $item->id !!}').submit(); }">Hapus</a>
                        <form id="delete-{!! $item->id !!}" action="{{ route('barang.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" align="center">No data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
