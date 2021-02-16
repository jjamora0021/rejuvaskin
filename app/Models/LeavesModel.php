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
}
