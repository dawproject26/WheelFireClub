<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Score;
use App\Models\Timer;

class PlayerController extends Controller
{
    public function init()
    {
        $player = Player::first();

        if(!$player){
            $player = Player::create(['name' => 'Jugador']);

            Score::create([
                'player_id' => $player->id,
                'score' => 0
            ]);

            Timer::create([
                'player_id' => $player->id,
                'seconds' => 120
            ]);
        }
        

        return response()->json([
            'player_id' => $player->id,
            'seconds' => $player->timer->seconds,
            'score' => $player->score->score
        ]);
    }
    public function welcome()
    {
        return view('welcome');
    }
}
