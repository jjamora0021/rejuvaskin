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
        $scheds = $this->fetchAllSchedules();
        $month = date('m');
        $today = Carbon::now()->format('Y-m-d');

        return view('pages.dashboard.dashboard', compact('scheds','month','today'));
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
            'date' => Carbon::parse($request['date_start'])->format('Y-m-d'),
            'time' => Carbon::parse($request['time'])->format('H:i:s'),
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

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function updateSchedule(Request $request)
    {
        $status = '';
        switch ($request['event-status']) {
            case 'bg-success':
                $status = 'done';
                break;
            case 'bg-danger':
                $status = 'cancelled';
                break;
            default:
                $status = 'to_do';
                break;
        }

        $schedule_id = $request['id'];

        $data = [
            'patient_id' => $request['patient'],
            'date' => $request['date'],
            'time' => $request['time'],
            'procedure' => $request['procedure'],
            'description' => $request['description'],
            'status' => $status,
            'updated_at' => Carbon::now()
        ];

        $update = $this->SchedulesModel->updateSchedule($data, $schedule_id);

        if($update)
        {
            $scheds = json_encode($this->fetchAllSchedules());

            return response()->json($scheds);
        }
        else
        {
            return false;
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function fetchAllSchedulesPerMonth(Request $request)
    {
        $month = $request['month'];
        $scheds = $this->SchedulesModel->fetchAllSchedules();

        $data = [];
        foreach ($scheds as $key => $value) {
            if(explode('-',$value->date)[1] == $month)
            {
                $value->patient = $value->first_name . ' ' . $value->last_name;
                switch ($value->status) {
                    case 'to_do':
                        $value->status = 'TO DO';
                        break;
                    case 'done':
                        $value->status = 'DONE';
                        break;
                    default:
                        $value->status = 'CANCELLED';
                        break;
                }
                $value->date = Carbon::parse($value->date)->format('F d, Y');
                $value->time = Carbon::parse($value->time)->format('h:i A');
                $data[] = $value;
            }
        }

        return $data;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function fetchAllSchedulesToday(Request $request)
    {
        $today = $request['date'];

        $scheds = $this->SchedulesModel->fetchAllSchedules();

        $data = [];
        foreach ($scheds as $key => $value) {
            if($value->date == $today)
            {
                $value->patient = $value->first_name . ' ' . $value->last_name;
                switch ($value->status) {
                    case 'to_do':
                        $value->status = 'TO DO';
                        break;
                    case 'done':
                        $value->status = 'DONE';
                        break;
                    default:
                        $value->status = 'CANCELLED';
                        break;
                }
                $value->date = Carbon::parse($value->date)->format('F d, Y');
                $value->time = Carbon::parse($value->time)->format('h:i A');
                $data[] = $value;
            }
        }

        return $data;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function deleteSchedule(Request $request)
    {
        $id = $request['id'];

        $delete = $this->SchedulesModel->deleteSchedule($id);

        return $delete;
    }
}
