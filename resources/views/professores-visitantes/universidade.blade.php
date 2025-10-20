@extends('main')

@section('content')



<div class="card">
    <div class="card-header">
        <h2> Professores Visitantes por universidade </h2>
    </div>

    <div class="card-body">
        <form method="get" class="form-inline">
        <select class="form-control form-control-lg" aria-label="Default select example" id="ano" name="ano">
            <option selected 
            @for ($i = date("Y"); $i >= 2009; $i--)

            <option value="{{$i}}" @if ($i == request('ano')) selected  @endif>{{ $i }}</option>
            @endfor
        </select>
        <button class="btn btn-primary btn-lg" >
            Buscar
        </button>
    </form>
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th scope="col">Universidade</th>
                    <th scope="col">Quantidade de professores</th>
                </tr>
            </thead>
            <tbody>
                @foreach($universidades as $uni)
                    <tr>
                        <td>{{ $uni['nomorgpnt'] }} </td>
                        <td>{{ $uni['Quantidade'] }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection