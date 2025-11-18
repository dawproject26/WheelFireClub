<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Panel;




class PanelController extends Controller
{
    /**
     * Display the admin panel dashboard.
     */
    public function index(): View
    {
        Panel::all();
        $alphabet = Panel::all();
        
        return view('panel.index', compact('alphabet'));
    
    }


}











?>