<?php

namespace App\Imports;

use App\Models\ProjetoFapesp;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class FapespImport implements OnEachRow
{
    public function onRow(Row $row)
    {
        $r = $row->toArray();

        if ($r[4] != "Universidade de São Paulo (USP). Faculdade de Filosofia, Letras e Ciências Humanas (FFLCH)") {
            return;
        }
        
        
        
        ProjetoFapesp::create([
            'titulo' => $r[1],
            'processo' => $r[0],
            'pesquisador_responsavel' => $r[9],
            'bolsista' => $r[3],
            'nivel' => $this->trataNivel($r[18]),
            'grande_area' => $r[19],
            'area' => $r[20],
            'subarea' => $r[21],
            'data_inicio' => $r[23],
            'data_termino' => $r[24]
        ]);
    }

    private function trataNivel($niv){
        $nivel = '';
        if($niv == 'Bolsas no Brasil - Pós-Doutorado'){
            $nivel = 'pós-doutorado';

        }
        else if($niv == 'Bolsas no Brasil - Mestrado'){
            $nivel = 'mestrado';

        }
        else if($niv == 'Bolsas no Brasil - Iniciação Científica'){
            $nivel = 'iniciação científica';

        }
        else if($niv == 'Bolsas no Brasil - Doutorado'){
            $nivel = 'doutorado';

        }
        else if($niv == 'Bolsas no Brasil - Doutorado Direto'){
            $nivel = 'doutorado direto';

        }
        else{
            $nivel  = 'outros';
        }
        return $nivel;
    }
}
