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
     * [fetchAll description]
     * @return [type] [description]
     */
    public function fetchAll()
    {
    	$data = (DB::table('inventories')->get())->toArray();

    	return $data;
    }
}
