<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Utils\Util;

class RestritoController extends Controller
{
    public function restrito()
    {
        Gate::authorize('admin');
        $dep = Util::departamentos;
        return view('restrito', ['departamentos' => $dep]);
    }
}
