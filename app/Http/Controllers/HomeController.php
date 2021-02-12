<?php

namespace App\Http\Controllers;

use App\Models\PatientInformation;
use App\Models\PatientHistory;
use App\Models\Inventory;
use App\Models\SchedulesModel;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;

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

        $this->User = new \App\Models\User;
        $this->PatientInformation = new \App\Models\PatientInformation;
        $this->PatientHistory = new \App\Models\PatientHistory;
        $this->InventoriesModel = new \App\Models\Inventory;
        $this->SchedulesModel = new \App\Models\SchedulesModel;
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
        $schedules = json_encode($this->fetchAllSchedules());
        $patients = $this->PatientInformation->fetchAll();

        return view('pages.calendar.calendar', compact('schedules','patients'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function fetchAllSchedules()
    {
        $data = $this->SchedulesModel->fetchAllSchedules();

        return $data;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function createSchedule(Request $request)
    {
        $data = [
            'patient_id' => $request['patient'],
            'date' => $request['date_start'],
            'time' => $request['time'],
            'procedure' => $request['procedure'],
            'description' => $request['description'],
            'status' => 'to_do',
            'deleted_at' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $save = $this->SchedulesModel->createSchedule($data);

        if($save)
        {
            $scheds = json_encode($this->fetchAllSchedules());

            return response()->json($scheds);
        }
        else
        {
            return false;
        }
    }
}
