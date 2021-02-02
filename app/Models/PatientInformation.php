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
    public function show()
    {
    	$data = (DB::table('patient_information')->get())->toArray();

    	return $data;
    }
}
