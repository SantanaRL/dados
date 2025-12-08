@extends('main')

@section('content')

<div class="card">
    <div class="card-header">
        <b> {{ $page_title }} </b>
    </div>

    <div class="card-body">
        @include('partials.simple-table')
    </div>
</div>
@endsection