@extends('tenant.layouts.app')

@section('content')

<tenant-binnacles-index :type-user="{{json_encode(Auth::user()->type)}}"></tenant-binnacles-index>
    {{-- :type-user="{{json_encode(Auth::user()->type)}}" --}}
                            {{-- :is-client="{{ json_encode($is_client) }}" --}}
                            {{-- :type-user="{{ json_encode(auth()->user()->type) }}"
                            :import_documents="{{ json_encode($import_documents) }}"
                            :import_documents_second="{{ json_encode($import_documents_second) }}"
                            :import_documents_xml="{{ json_encode($import_documents_xml) }}" --}}

@endsection
