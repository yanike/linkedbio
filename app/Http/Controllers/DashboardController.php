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
                    ->withCount('click', 'thisWeekClicks', 'lastWeekClicks')
                    ->where('user_id', auth()->id())
                    ->orderBy('order')
                    ->orderBy('id', 'desc')
                    ->get();

        Log::info('Dashboard Links:', $links->toArray());

        // Calculate percentage change for each link
        $links->each(function ($link) {
            $thisWeek = $link->this_week_clicks_count;
            $lastWeek = $link->last_week_clicks_count;

            $percentageChange = 0;
            if ($lastWeek > 0) {
                $percentageChange = (($thisWeek - $lastWeek) / $lastWeek) * 100;
            } elseif ($thisWeek > 0) {
                $percentageChange = 100; // Infinite increase if last week was 0 and this week is > 0
            }

            $link->performance_change = round($percentageChange, 2);
        });

        foreach($links as $link){
            if(strlen($link->url) > 35){
                $link->url = substr($link->url, 0, 35).'...' ;
            }
        }
    
        $stats = StatsController::stats();
    
        return view('dashboard', compact('links', 'stats'));
    }
}
