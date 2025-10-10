@extends('main')

@section('content')
  
  <p>
    <h6 class="text-center"><b>{{utf8_encode($nome_colegiado)}}  ({{utf8_encode($sglclg)}})</b></h6>
  </p>

  <table class="table table-responsive">
      <thead>
          <th scope="col">Titular</th>
          <th scope="col">Email</th>
          <th scope="col">Suplente</th>
          <th scope="col">Email</th>
          <th scope="col">Vigência</th>
        </tr>
      </thead>
      <tbody>
        @foreach($membros as $membro)
          <tr>
            <td style="color: #213d72"><b codpes="{{$membro['titular']}}"> {{ utf8_encode($membro['nome_titular']) }} 
            @if($membro['tipfncclg'] != 'Titular') ({{ utf8_encode($membro['tipfncclg']) }}) @endif </b></td>

            <td>{{ utf8_encode($membro['email_titular']) }} </td>
            @if($membro['suplente'] != 0) 
              <td><b>{{ utf8_encode($membro['nome_suplente']) }}</b> </td>
              <td>{{ utf8_encode($membro['email_suplente']) }} </td>
            @else
              <td>-</td>
              <td>-</td>
              <td>-</td>
            @endif 
            <td class="text-center">{{ date('d/m/Y', strtotime($membro['dtainimdt'] ))  }} <br> até <br> {{ date('d/m/Y', strtotime($membro['dtafimmdt']))}} </td>
            
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


@endsection

