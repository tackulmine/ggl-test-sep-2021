@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Edit Barang') }}</div>

    <form action="{{ route('barang.update', $barang->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="card-body">

            @include('shared.success')
            @include('shared.errors')

            @include('barang.form')

        </div>

        <div class="card-footer text-center">
            <a href="javascript:history.back();" class="btn btn-link">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection
