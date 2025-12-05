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

        $result = DB::fetchAll($query);
        $data = $result;

        $export = new DadosExport([$data],
        [
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

            
        ]);

        return $excel->download($export, $sigla . 'projetos.xlsx');
    
        
    }
}
