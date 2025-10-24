@extends('main')

@section('content')

<div class="card">
    <div class="card-header">
        <b> {{ $prefix }} </b>
    </div>

    <a href="{{ config('app.url') }}/turmas">Voltar</a>

    <br>
    <a href="{{ config('app.url') }}/turmas/{{ $prefix }}/concatenate">Versão Concatenada</a>

    <div class="card-body">
        @include('partials.simple-table')
    </div>
</div>
@endsection
