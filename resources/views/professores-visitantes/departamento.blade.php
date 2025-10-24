@extends('main')

@section('content')



<div class="card">
    <div class="card-header">
       <h2> departamentos que convidaram os professores visitantes</h2>
    </div>

    <div class="card-body d-flex ">
      <form method="get" class="form-inline">
        <select class="form-control form-control-lg" onchange="this.form.submit()" aria-label="Default select example" id="ano" name="ano">
            <option selected 
            @for ($i = date("Y"); $i >= 2009; $i--)
              <option value="{{$i}}" @if ($i == request('ano')) selected  @endif>{{ $i }}</option>
            @endfor
        </select>
      </form>
  
      @include('partials.simple-chart')
    </div>
</div>
@endsection