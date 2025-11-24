<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Phrase;

class PanelController extends Controller
{

    private $phraseSeleccionada;
    /**
     * Muestra la vista principal
     */
    public function show()
    {
        //Peticion a BBDD que nos devuelve una phrase aleatoria
        $this -> phraseSeleccionada = Phrase::inRandomOrder()->first();

        //Devolvemos la phrase seleccionada y es el html el que se encarga de mostrar los espacios
        return view('wheelfireclub.panel', [
            'phraseSeleccionada' => $this -> phraseSeleccionada -> phrase, 'title' => $this -> phraseSeleccionada -> movie
        ]);
    }

    public function comprobarLetra(){
         $this -> phraseSeleccionada;
    }
}
