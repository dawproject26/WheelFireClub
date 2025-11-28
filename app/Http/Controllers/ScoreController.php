<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Actualiza puntuación cuando se acierta una letra
     */
    public function letter(Request $request)
    {
        // Obtener el ID del jugador desde la sesión
        $playerId = session('player_id');
        
        if (!$playerId) {
            return response()->json(['error' => 'No hay sesión'], 401);
        }

        // Buscar el jugador con su score
        $player = Player::with('score')->find($playerId);
        
        if (!$player || !$player->score) {
            return response()->json(['error' => 'Jugador no encontrado'], 404);
        }

        // Recibir los puntos del request (por defecto +10 por letra acertada)
        $puntos = $request->input('puntos', 10);
        
        // Actualizar el score
        $player->score->score += $puntos;
        $player->score->save();

        return response()->json([
            'success' => true,
            'score' => $player->score->score
        ]);
    }

    /**
     * Actualiza puntuación cuando se adivina la frase completa
     */
    public function guess(Request $request)
    {
        // Obtener el ID del jugador desde la sesión
        $playerId = session('player_id');
        
        if (!$playerId) {
            return response()->json(['error' => 'No hay sesión'], 401);
        }

        // Buscar el jugador con su score
        $player = Player::with('score')->find($playerId);
        
        if (!$player || !$player->score) {
            return response()->json(['error' => 'Jugador no encontrado'], 404);
        }

        // Bonus por victoria: +100 puntos
        $player->score->score += 100;
        $player->score->save();

        return response()->json([
            'success' => true,
            'score' => $player->score->score,
            'result' => 'correct',
            'message' => '¡Victoria! +100 puntos'
        ]);
    }
}