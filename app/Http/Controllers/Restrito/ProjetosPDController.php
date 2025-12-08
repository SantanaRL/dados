<?php

namespace App\Http\Controllers\Restrito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Excel;
use App\Exports\DadosExport;
use Uspdev\Replicado\DB;
use App\Utils\Util;
class ProjetosPDController extends Controller
{
    var $colNames =[
            'Ano do Projeto',
            'Código do Projeto',
            'Departamento',
            'Status do Projeto',
            'NUSP do Pós-Doutorando',
            'Nome do Pós-Doutorando',
            'CPF do Pós-Doutorando',
            'NUSP do Supervisor',
            'Nome do Supervisor',
            'CPF do Supervisor',
            'Titulo do Projeto',
            'Data do Início',
            'Data do Fim'

            
    ];
    function listarPlanilha(Excel $excel, Request $request){
        Gate::authorize('admin');

        $sigla = $request->departamento;
        if (is_null($sigla) || !(in_array($sigla,array_keys(Util::departamentos)))) {
            return;
        }
        $dep = Util::departamentos[$sigla];

        $query = file_get_contents(__DIR__ . '/../../../../Queries/listar_ProjetosPD.sql');
        $query = str_replace('__dep__', $dep[0], $query);
        $query = str_replace('__ano__', 2025, $query);

        $data = DB::fetchAll($query);
        
        $data = array_map(function($v)
        {   
            $v['TituloProjeto'] = html_entity_decode($v['TituloProjeto']);
            return $v;
        }
        ,$data);

        $export = new DadosExport([$data],
        $this->colNames);

        return $excel->download($export, $sigla . 'projetos.xlsx');
    
        
    }
    function listarTabela($sigla, Request $request){
        Gate::authorize('admin');

        if (is_null($sigla) || !(in_array($sigla,array_keys(Util::departamentos)))) {
            return;
        }
        $dep = Util::departamentos[$sigla];

        $query = file_get_contents(__DIR__ . '/../../../../Queries/listar_ProjetosPD.sql');
        $query = str_replace('__dep__', $dep[0], $query);
        $query = str_replace('__ano__', 2025, $query);

        $data = DB::fetchAll($query);
        $data = array_map(function($v)
        {   
            $v['TituloProjeto'] = html_entity_decode($v['TituloProjeto']);
            return $v;
        }
        ,$data);

        return view('projetosPD',[
            'table_labels' => $this->colNames,
            'table_keys' => array_keys($data[0]) ,
            'table_data' => $data,
            'page_title' => $dep[1]
        ]);
    
        
    }
    function grafico(){
        $query = file_get_contents(__DIR__ . '/../../../../Queries/contagem_ProjetosPD.sql');
        $query = str_replace('__ano__', 2025, $query);

        $dados = DB::fetchAll($query);
        
        $labels = array_map(function($v){ return $v['NomeDepartamento'];},$dados);
        $data = array_map(function($v){ return $v['projetos'];},$dados);
        $nm = 'Projetos';
        return view('projetosPDgrafico',[ "chart_labels" => $labels, 'chart_data' => $data , 'chart_name_value' => $nm]);
    
    }
}
