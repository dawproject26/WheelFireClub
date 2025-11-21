<?php
namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 

class PlayerController extends Controller
{

    public function welcome()
    {
        if (session()->has('player_id')) {
            return redirect()->route('wheelfireclub.panel');
        }

        $highScores = Score::with('player') 
                        ->orderBy('points', 'desc') 
                        ->take(10) 
                        ->get();

        return view('welcome', [
            'highScores' => $highScores
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:players,name'
        ]);

        $player = Player::create([
            'name' => $request->name
        ]);

        
        session(['player_id' => $player->id]);

        
        return redirect()->route('wheelfireclub.panel');
    }


    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|exists:players,name'
        ]);

        $player = Player::where('name', $request->name)->first();

        session(['player_id' => $player->id]);

        return redirect()->route('wheelfireclub.panel');
    }

    public function logout()
    {
        session()->forget('player_id');
        return redirect('/');
    }
}