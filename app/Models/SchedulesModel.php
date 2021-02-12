<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class SchedulesModel extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    /**
     * Undocumented function
     *
     * @return void
     */
    public function fetchAllSchedules()
    {
        $data = (DB::table('schedules')
                    ->leftJoin('patient_information', 'schedules.patient_id', '=', 'patient_information.id')
                    ->select(
                        'patient_information.id as patient_id',
                        'patient_information.first_name',
                        'patient_information.last_name',
                        'schedules.id as schedule_id',
                        'schedules.date',
                        'schedules.time',
                        'schedules.procedure',
                        'schedules.description',
                    )
                    ->where('schedules.deleted_at',false)
                    ->where('patient_information.deleted_at',false)
                    ->get())->toArray();

        return $data;
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return void
     */
    public function createSchedule($data)
    {
        $save = DB::table('schedules')->insert($data);

        return $save;
    }
}
