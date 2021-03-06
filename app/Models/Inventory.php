<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'medicine', 'stocks', 'created_at', 'updated_at',
    ];

    /**
     * [fetchAll description]
     * @return [type] [description]
     */
    public function fetchAll()
    {
    	$data = (DB::table('inventories')->get())->toArray();

    	return $data;
    }

    /**
     * [update description]
     * @param  [type] $meds_id [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    public function updateStocks($meds_id, $data)
    {
        try {
            $update =    DB::transaction(function () use ($meds_id, $data) {
                            DB::table('inventories')->where('id',$meds_id)->increment('stocks', $data['stocks_delivered']);
                            DB::table('inventories')->where('id',$meds_id)->update($data);
                        });
            return is_null($update) ? true : $update;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * [deleteMedicine description]
     * @param  [type] $meds_id [description]
     * @return [type]          [description]
     */
    public function deleteMedicine($meds_id)
    {
        $delete = DB::table('inventories')->where('id',$meds_id)->delete();

        return $delete;
    }

    /**
     * [addMedicine description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    public function addMedicine($data)
    {
        $store = DB::table('inventories')->insert($data);

        return $store;
    }
}
