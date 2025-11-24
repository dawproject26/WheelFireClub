<?php

namespace App\Http\Controllers;

use App\Models\Panel;
use App\Models\Player;
use Illuminate\Http\Request;


class PanelController extends Controller
{
    public function index()
    {
        $panel = Panel::with('phrases')->inRandomOrder()->first();

        if(!$panel){
            abort(500, "No hay paneles en la base de datos.");
        }

        return view('wheelfireclub.panel', compact('panel'));
    }

    public function welcome()
    {
        return view('player.welcome');
    }

    public function register(Request $request)
    {
        $player = Player::create([
            'name' => $request->name
        ]);

        session(['player_id' => $player->id]);

        return redirect()->route('wheelfireclub.panel');
    }

    public function login(Request $request)
    {
        $player = Player::where('name', $request->name)->first();

        if (!$player) {
            return back()->with('error', 'Jugador no encontrado');
        }

        session(['player_id' => $player->id]);

        return redirect()->route('wheelfireclub.panel');
    }

    public function logout()
    {
        session()->forget('player_id');
        return redirect()->route('welcome');
    }
    }


