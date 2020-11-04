@extends('tenant.layouts.app')

@section('content')
 
    <tenant-binnacles-form :type-user="{{json_encode(Auth::user()->type)}}"></tenant-binnacles-form>

@endsection