<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Exception;
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
    public function store($patient_history, $meds, $patient_id)
    {
    	try {
            $store =    DB::transaction(function () use ($patient_history, $meds, $patient_id) {
                            $timestamps = [
                                'created_at'    => Carbon::now(),
                                'updated_at'    => Carbon::now()
                            ];
                            // Patient History
                            DB::table('patient_history')->insert($patient_history);
                            
                            // Patient Information
                            DB::table('patient_information')->where('id',$patient_id)->update($timestamps);

                            // Inventories
                            foreach ($meds as $key => $value) {
                                DB::table('inventories')->where('id',$value['meds_id'])->decrement('stocks', $value['quanity']);
                                DB::table('inventories')->where('id',$value['meds_id'])->update(['updated_at' => Carbon::now()]);
                            }
                        }); 
            return is_null($store) ? true : $store;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function deleteRecord($id)
    {
        $deleted_at = [
            'deleted_at' => true,
            'updated_at' => Carbon::now()
        ];
        $result = DB::table('patient_information')->where('id',$id)->update($deleted_at);

        return $result;
    }
}
