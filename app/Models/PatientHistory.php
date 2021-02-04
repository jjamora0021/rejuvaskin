<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;

class PatientHistory extends Model
{
    use HasFactory;

    /**
     * [checkPatientHistory description]
     * @param  [type] $patient_id [description]
     * @return [type]             [description]
     */
    public function checkPatientHistory($patient_id)
    {
    	$check = (DB::table('patient_history')->where('patient_id',$patient_id)->get())->toArray();

    	return $check;
    }

    /**
     * [store description]
     * @param  [type] $patient_history     [description]
     * @param  [type] $patient_information [description]
     * @param  [type] $patient_id 		   [description]
     * @return [type]                      [description]
     */
    public function store($patient_history, $patient_id)
    {
    	$store = 	DB::transaction(function () use ($patient_history, $patient_id) {
					    $ptx_his = DB::table('patient_history')->insert($patient_history);
					    if($ptx_his)
					    {
					    	$patient_info = [
								'created_at'    => Carbon::now(),
								'updated_at'    => Carbon::now()
							];
					    	return $result = DB::table('patient_information')->where('id',$patient_id)->update($patient_info);
					    }
					    else 
					    {
					    	return $result = 'fail';
					    }
					});

    	return $store;
    }
}
