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
  <div  class="w-75 p-3 ">
    <canvas id="myChart"></canvas>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: {{Js::from($labels)}},
      datasets: [{
        label: 'Quantidade de professores',
        data: {{Js::from($data)}},
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
      <!--
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th scope="col">Departamento</th>
                    <th scope="col">Quantidade de professores</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departamentos as $dep)
                    <tr>
                        <td>{{ $dep['nomset'] }} </td>
                        <td>{{ $dep['qtd'] }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>-->
    </div>
</div>
@endsection