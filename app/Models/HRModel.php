<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;

class HRModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_id', 'date', 'time_in', 'time_out', 'total_hours', 'created_at', 'updated_at'
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    public function fetchAllRecordsPerEmp($emp_id)
    {
        $records = (DB::table('time_keeping_records')
                        ->where('emp_id', $emp_id)
                        ->orderBy('date','desc')
                        ->get()
                    )->toArray();

        return $records;
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public function saveTimeIn($data)
    {
        $save = DB::table('time_keeping_records')->insert($data);

        return $save;
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @param [type] $data
     * @param [type] $emp_id
     * @return void
     */
    public function saveTimeOut($date, $emp_id, $data)
    {
        $save = DB::table('time_keeping_records')
                    ->where('date', $date)
                    ->where('emp_id', $emp_id)
                    ->update($data);

        return $save;
    }

    /**
     * Undocumented function
     *
     * @param [type] $parameter
     * @return void
     */
    public function fetchAllTimeKeepingDisputes($parameter)
    {
        if($parameter != 'all')
        {
            $data = (DB::table('time_keeping_disputes')
                        ->where('emp_id', $parameter)
                        ->leftJoin('users','time_keeping_disputes.emp_id', '=', 'users.id')
                        ->select(
                            'time_keeping_disputes.id as dispute_id',
                            'time_keeping_disputes.emp_id as employee_id',
                            'time_keeping_disputes.date_in_dispute as date_in_dispute',
                            'time_keeping_disputes.type_of_dispute as type_of_dispute',
                            'time_keeping_disputes.dispute as dispute',
                            'time_keeping_disputes.status as dispute_status',
                            'time_keeping_disputes.approved_by as approved_by',
                            DB::raw('CONCAT(users.first_name," ",users.last_name ) AS full_name'),
                            'users.user_role as user_role',
                            'users_status as user_status'
                        )
                        ->orderBy('time_keeping_disputes.date_in_dispute','desc')
                        ->get()
                    )->toArray();
        }
        else
        {
            $data = (DB::table('time_keeping_disputes')
                        ->leftJoin('users','time_keeping_disputes.emp_id', '=', 'users.id')
                        ->select(
                            'time_keeping_disputes.id as dispute_id',
                            'time_keeping_disputes.emp_id as employee_id',
                            'time_keeping_disputes.date_in_dispute as date_in_dispute',
                            'time_keeping_disputes.type_of_dispute as type_of_dispute',
                            'time_keeping_disputes.dispute as dispute',
                            'time_keeping_disputes.status as dispute_status',
                            'time_keeping_disputes.approved_by as approved_by',
                            'time_keeping_disputes.remarks as remarks',
                            DB::raw('CONCAT(users.first_name," ",users.last_name ) AS full_name'),
                            'users.user_role as user_role',
                            'users.status as user_status'
                        )
                        ->orderBy('time_keeping_disputes.date_in_dispute','desc')
                        ->get()
                    )->toArray();
        }

        return $data;
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public function saveTimeKeepingRequest($data)
    {
        $save_dispute = DB::table('time_keeping_disputes')->insert($data);

        return $save_dispute;
    }

    /**
     * Undocumented function
     *
     * @param [type] $dispute_id
     * @param [type] $data
     * @return void
     */
    public function updateDispute($dispute_id, $data)
    {
        $update = DB::table('time_keeping_disputes')
                    ->where('id', $dispute_id)
                    ->update($data);

        return $update;
    }
}
