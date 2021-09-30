@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Edit Stok Barang') }}</div>

    <form action="{{ route('barang.update-stok', $barang->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="card-body">

            @include('shared.success')
            @include('shared.errors')

            @include('barang.form-stok')

        </div>

        <div class="card-footer text-center">
            <a href="javascript:history.back();" class="btn btn-link">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection
