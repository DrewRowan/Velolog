<?php

namespace App\Http\Controllers;


class StravaSettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function completeRegistration()
    {
        echo env('CT_STRAVA_REDIRECT_URI', '');
        echo env('CT_STRAVA_SECRET_ID', '');
    }
}
