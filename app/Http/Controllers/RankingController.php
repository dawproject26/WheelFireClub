<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    /**
     * Obtiene los 10 primeros usuarios ordenados por score
     */
    public function index()
    {
        // Obtener los 10 usuarios con mayor score, ordenados descendentemente
        $topPlayers = DB::table('players')
            ->join('scores', 'players.id', '=', 'scores.player_id')
            ->select('players.id', 'players.name', 'scores.score')
            ->orderBy('scores.score', 'DESC')
            ->take(10)
            ->get();

        return view('ranking', compact('topPlayers'));
    }
}