<?php
namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Uspdev\Replicado\DB;
use Illuminate\Support\Facades\Log;
use Khill\Lavacharts\Lavacharts;

use function Psy\debug;

class ProfessoresVisitantesController extends Controller
{
    public function universidade(Request $request){
        $ano = $request->input('ano');
        if (!$ano) {
            $ano = date("Y");
        }
        $query = file_get_contents(__DIR__ . '/../../../../Queries/professores_visitantes/professores_visitantes_quantidade.sql');
        $query_por_ano = str_replace('__ano__', $ano, $query);
        
        $universidades = DB::fetchAll($query_por_ano);
        return view('professores-visitantes.universidade',[ "universidades" => $universidades ]);
    }

    public function departamento(Request $request){
        $ano = $request->input('ano');
        if (!$ano) {
            $ano = date("Y");
        }
        $query = file_get_contents(__DIR__ . '/../../../../Queries/professores_visitantes/professores_visitantes_departamento.sql');
        $query_por_ano = str_replace('__ano__', $ano, $query);
        
        $departamentos = DB::fetchAll($query_por_ano);

        
        $labels = array_map(function($v){ return $v['nomset'];},$departamentos);
        $data = array_map(function($v){ return $v['qtd'];},$departamentos);
        $nm = 'Quantidade de professores';
        return view('professores-visitantes.departamento',[ "chart_labels" => $labels, 'chart_data' => $data , 'chart_name_value' => $nm]);
    }
}