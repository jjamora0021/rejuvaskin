<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;

use Carbon\Carbon;

class InventoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data = Inventory::firstWhere('medicine',$row[0]);
        if(empty($data))
        {
            return new Inventory([
                'medicine'      => $row[0],
                'stocks'        => (int)$row[1],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
        }
        else
        {
            return null;
        }
    }
}
