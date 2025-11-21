<?php

namespace App\Http\Controllers;

use App\Models\Roulette; // Asumo que tienes este modelo
use Illuminate\Http\Request;

class RouletteController extends Controller
{

    public function spin()
    {
        $option = Roulette::inRandomOrder()->first();

        session(['actual_optio' => $option]);

        return response()->json([
            'status' => 'success',
            'option' => $option
        ]);
    }
}