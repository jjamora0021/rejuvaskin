<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeavesModel;
use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;

class LeavesController extends Controller
{
    protected $User;
    protected $LeavesModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->User = new \App\Models\User;
        $this->LeavesModel = new \App\Models\LeavesModel;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        return view('pages.leaves.leaves');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function saveLeaveRequest(Request $request)
    {
        $data = [
            'emp_id' => (int)$request['emp_id'],
            'date' => Carbon::parse($request['select_date'])->format('Y-m-d'),
            'leave_type' => $request['leave_type'],
            'description' => $request['description'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $save = $this->LeavesModel->saveLeaveRequest($data);

        return $save;
    }
}
