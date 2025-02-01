<?php

namespace App\Http\Controllers;

use App\Models\Partida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $ultimaPartida = Partida::where('user_id', Auth::id())->latest()->first();

        $partidasActivas = Partida::where('user_id', Auth::id())
        ->where('estadoPartida', 'activa')
        ->orderBy('created_at', 'desc')
        ->get();

        
        return view('dashboard', compact('ultimaPartida', 'partidasActivas'));
    }
}