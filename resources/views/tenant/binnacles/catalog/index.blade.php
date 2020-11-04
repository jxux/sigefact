@extends('tenant.layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-12 ui-sortable">
            <tenant-binnacles-category-index :type-user="{{json_encode(Auth::user()->type)}}"></tenant-binnacles-category-index>
        </div>
        <div class="col-lg-6 col-md-12 ui-sortable">
            <tenant-binnacles-service-index :type-user="{{json_encode(Auth::user()->type)}}"></tenant-binnacles-service-index>
        </div>
        <div class="col-lg-4 col-md-12 ui-sortable">


        </div>
    </div>
@endsection
