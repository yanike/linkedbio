<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     *
     * @return void
     */
    public function index(){
        $links = Link::select(['id', 'title', 'url'])
                    ->withCount('click') // Add this line to eager load the click count
                    ->where('user_id', auth()->id())
                    ->orderBy('id', 'desc')
                    ->get();

        Log::info('Dashboard Links:', $links->toArray());
    
        foreach($links as $link){
            if(strlen($link->url) > 35){
                $link->url = substr($link->url, 0, 35).'...' ;
            }
        }
    
        $stats = StatsController::stats();
    
        return view('dashboard', compact('links', 'stats'));
    }
}
