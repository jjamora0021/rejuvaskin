<?php

namespace App\Http\Controllers;

use App\Models\HRModel;
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
        $first_row = true;

        $records = $this->HRModel->fetchAllRecordsPerEmp($user_data['id']);
        $id = 0;
        if(!empty($records))
        {
            if($records[0]->date != $today)
            {
                $first_row = false;
                $id = $records[0]->id + 1;
            }
            else
            {
                $id = $records[0]->id;
            }
        }

        return view('pages.time-keeping.time-keeping', compact('today','user_data','records','first_row','id'));
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
        $id = $request['id'];

        $data = [
            'time_out'    => $request['time_out'],
            'total_hours' => $request['total_hours'],
            'updated_at'  => Carbon::now()
        ];

        $save = $this->HRModel->saveTimeOut($id, $data, $emp_id);

        return $save;
    }
}
