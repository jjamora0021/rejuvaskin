<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;

class LeavesModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_id', 'date', 'leave_type', 'description', 'status', 'created_at', 'updated_at'
    ];

    /**
     * Undocumented function
     *
     * @param [type] $user_role
     * @param [type] $emp_id
     * @return void
     */
    public function getAllLeaveApplications($user_role, $emp_id)
    {
        if($user_role == 'superadmin')
        {
            $data = (DB::table('leaves')
                        ->leftJoin('users','leaves.emp_id','users.id')
                        ->select(
                            'users.id as emp_id',
                            'users.first_name',
                            'users.last_name',
                            'leaves.id as leave_id',
                            'leaves.date',
                            'leaves.leave_type',
                            'leaves.description',
                            'leaves.status',
                            'leaves.approved_by'
                        )
                        ->get())->toArray();

            return $data;
        }
        else
        {
            $data = (DB::table('leaves')->where('emp_id',$emp_id)
                        ->leftJoin('users','leaves.emp_id','users.id')
                        ->get())->toArray();

            return $data;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $emp_id
     * @return void
     */
    public function getAllApprovedLeaves($emp_id)
    {
        $data = (DB::table('leaves')
                    ->where('emp_id', $emp_id)
                    ->where('status', 'approved')
                    ->get()
                    )->toArray();

        return $data;
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public function saveLeaveRequest($data)
    {
        $save = DB::table('leaves')->insert($data);

        return $save;
    }

    /**
     * Undocumented function
     *
     * @param [type] $leave_id
     * @param [type] $emp_id
     * @param [type] $action
     * @return void
     */
    public function actionLeaveRequest($leave_id, $emp_id, $type, $action)
    {
        try {
            $update =    DB::transaction(function () use ($leave_id, $emp_id, $type, $action) {
                            DB::table('leaves')->where('id',$leave_id)->where('emp_id', $emp_id)
                                ->update([
                                    'status' => $action,
                                    'updated_at' => Carbon::now()
                                ]);
                            DB::table('users')->where('id',$emp_id)->decrement($type, 1);
                        });
            return is_null($update) ? true : $update;
        } catch (Exception $e) {
            return false;
        }
    }
}
