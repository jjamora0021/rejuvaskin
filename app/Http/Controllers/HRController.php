<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HRModel;
use App\Models\LeavesModel;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;

class HRController extends Controller
{
    protected $User;
    protected $HRModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->User = new \App\Models\User;
        $this->HRModel = new \App\Models\HRModel;
        $this->LeavesModel = new \App\Models\LeavesModel;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getAllDates()
    {
        $month = Carbon::now()->format('Y-m');
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $dates = [];
        $ctr = 0;
        while ($start->lte($end)) {
            $ctr++;
            $dates[$ctr]['date'] = Carbon::parse($start->copy())->format('Y-m-d');
            $dates[$ctr]['day'] = Carbon::parse($start->copy())->format('l');
            $start->addDay();
        }

        return array_reverse($dates);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        $user_data = Auth::user()->attributesToArray();
        $today = Carbon::now()->format('Y-m-d');

        $dates = $this->getAllDates();

        $records = (array)$this->HRModel->fetchAllRecordsPerEmp($user_data['id']);
        $leaves = (array)$this->LeavesModel->getAllApprovedLeaves($user_data['id']);

        $data = [];
        foreach ($dates as $index => $value) {
            if((strtotime($value['date']) <= date('U')) == true)
            {
                $data[$index]['date'] = $value['date'];
                $data[$index]['day'] = $value['day'];

                if($value['date'] == $today && !array_key_exists('data',$data))
                {
                    $data[$index]['data'] = 'today';
                }

                foreach ($records as $key => $val) {
                    if($value['date'] == $val->date)
                    {
                        $data[$index]['data'] = (array)$val;
                    }

                    if($value['day'] == 'Saturday' || $value['day'] == 'Sunday')
                    {
                        $data[$index]['data'] = 'weekend';
                    }
                }
                foreach ($leaves as $key => $val) {
                    if($value['date'] == $val->date)
                    {
                        $data[$index]['data'] = 'on_leave';
                    }
                }
            }
        }
// dd($data);
        return view('pages.time-keeping.time-keeping', compact('today','user_data','records','data'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function saveTimeIn(Request $request)
    {
        $data = [
            'emp_id'     => $request['emp_id'],
            'date'       => $request['date'],
            'time_in'    => $request['time_in'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $save = $this->HRModel->saveTimeIn($data);

        return $save;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function saveTimeOut(Request $request)
    {
        $emp_id = $request['emp_id'];
        $date = $request['date'];

        $data = [
            'time_out'    => $request['time_out'],
            'total_hours' => $request['total_hours'],
            'updated_at'  => Carbon::now()
        ];

        $save = $this->HRModel->saveTimeOut($date, $emp_id, $data);

        return $save;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function loadTimeKeepingDisputesPage()
    {
        $data = $this->fetchAllTimeKeepingDisputes();

        return view('pages.time-keeping.time-keeping-disputes', compact('data'));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function fetchAllTimeKeepingDisputes()
    {
        $user_role = Auth::user()->user_role;

        if($user_role == 'superadmin')
        {
            $data = $this->HRModel->fetchAllTimeKeepingDisputes('all');
        }
        else
        {
            $data = $this->HRModel->fetchAllTimeKeepingDisputes(Auth::user()->id);
        }

        return $data;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function saveTimeKeepingRequest(Request $request)
    {
        $date = $request['select_date'];
        $emp_id = $request['emp_id'];
        $dispute = $request['dispute'];

        $type_of_dispute = $request['type_of_dispute'];
        switch ($request['type_of_dispute']) {
            case 'time_in':
                $dispute = Carbon::parse($dispute)->format('H:m:s');
                break;
            case 'time_out':
                $dispute = Carbon::parse($dispute)->format('H:m:s');
                break;
            case 'total_hours':
                $dispute = (float)$dispute;
                break;
            default:
                    $dispute = (string)$dispute;
                break;
        }

        $data = [
            'emp_id' => $emp_id,
            'date_in_dispute' => $date,
            'type_of_dispute' => $type_of_dispute,
            'dispute' => $dispute,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $save_dispute = $this->HRModel->saveTimeKeepingRequest($data);

        return $save_dispute;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function updateDispute(Request $request)
    {
        $dispute_id = (int)$request['dispute_id'];

        $data = [
            'status' => $request['action'],
            'remarks' => $request['remarks'],
            'approved_by' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
            'updated_at' => Carbon::now()
        ];

        $update = $this->HRModel->updateDispute($dispute_id, $data);

        if($update)
        {
            $data = (array)$this->fetchAllTimeKeepingDisputes();

            foreach ($data as $key => $value) {
                $value->date_in_dispute = Carbon::parse($value->date_in_dispute)->format('F d, Y');
                $value->type_of_dispute = str_replace('_', ' ', $value->type_of_dispute);
                $value->dispute = Carbon::parse($value->dispute)->format('h:m A');
                $value->dispute_status = strtoupper($value->dispute_status);
            }

            return json_encode($data);
        }
        else
        {
            return false;
        }
    }
}
