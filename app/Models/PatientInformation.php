<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;

class PatientInformation extends Model
{
    use HasFactory;

    /**
     * [store description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function store($data)
    {
    	$result = DB::table('patient_information')->insert($data);

    	return $result;
    }

    /**
     * [show description]
     * @return [type] [description]
     */
    public function fetchAll()
    {
    	$data = (DB::table('patient_information')->where('deleted_at',false)->get())->toArray();

    	return $data;
    }

    /**
     * [show description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function show($id)
    {
    	$patient = (DB::table('patient_information')->where('id',$id)->get())->toArray();

    	return $patient;
    }

    /**
     * [update description]
     * @param  [type] $data       [description]
     * @param  [type] $patient_id [description]
     * @return [type]             [description]
     */
    public function updatePatientInformation($data, $patient_id)
    {
        $result = DB::table('patient_information')->where('id',$patient_id)->update($data);

        return $result;
    }
}
