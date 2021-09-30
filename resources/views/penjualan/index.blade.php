@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Penjualan') }}</div>

    <div class="card-body">
        <p><a href="{{ route('penjualan.create') }}">Create new</a></p>

        @include('shared.success')

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Total Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->total_item }}</td>
                    <td>
                        <a href="{{ route('penjualan.edit', $item->id) }}">Edit</a>
                        |
                        <a href="#!" onclick="if(confirm('Are you sure?')) { document.getElementById('delete-{!! $item->id !!}').submit(); }">Hapus</a>
                        <form id="delete-{!! $item->id !!}" action="{{ route('penjualan.destroy', $item->id) }}" method="post">
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
