<?php

namespace App\Http\Controllers;

use App\Models\Panel;

class PanelController extends Controller
{
    public function index()
    {
        // Panel ya viene desde los seeders de tu compañero
        $panel = Panel::with('phrases')->inRandomOrder()->first();

        if(!$panel){
            abort(500, "No hay paneles en la base de datos.");
        }

        return view('game.index', compact('panel'));
    }
}
