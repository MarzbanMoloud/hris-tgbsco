<?php


namespace App\Http\Controllers;


use App\Event;


/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     *
     */
    const PREFIX_VIEW = 'dashboard.';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $events = Event::
            whereBetween('alert_date', [now()->timestamp, now()->addDays(7)->timestamp])
            ->latest()
            ->get();

        return view(self::PREFIX_VIEW . 'index', compact('events'));
    }
}
