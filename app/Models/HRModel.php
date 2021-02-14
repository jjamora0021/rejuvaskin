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
    public function saveTimeOut($id, $data, $emp_id)
    {
        $save = DB::table('time_keeping_records')
                    ->where('id', $id)
                    ->where('emp_id', $emp_id)
                    ->update($data);

        return $save;
    }
}
