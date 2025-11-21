<?php
namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Score;
use Illuminate\Http\Request;

class PanelController extends Controller
{
 
    public function index()
    {
    
        $playerId = session('player_id');
        $player = Player::find($playerId);

        return view('wheelfireclub.panel', ['player' => $player]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'points' => 'required|integer'
        ]);

        Score::create([
            'points'      => $request->points,
            'player_id'   => session('player_id')
        ]);

        return response()->json(['status' => 'success']);
    }
}