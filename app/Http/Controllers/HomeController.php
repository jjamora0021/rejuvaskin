<?php

namespace App\Http\Controllers;

use App\Models\PatientInformation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.dashboard.dashboard');
    }

    /**
     * [calendar description]
     * @return [type] [description]
     */
    public function calendar()
    {
        return view('pages.calendar.calendar');
    }
}
