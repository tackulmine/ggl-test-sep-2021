@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Create new Penjualan') }}</div>


    <form action="{{ route('penjualan.store') }}" method="post">
        @csrf

        <div class="card-body">

            @include('shared.success')
            @include('shared.errors')

            @include('penjualan.form')

        </div>

        <div class="card-footer text-center">
            <a href="javascript:history.back();" class="btn btn-link">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>

</div>
@endsection

@push('scripts')
    @include('penjualan.asset')
@endpush
