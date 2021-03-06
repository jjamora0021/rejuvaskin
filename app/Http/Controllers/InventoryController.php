<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PatientInformation;
use App\Models\PatientHistory;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Imports\InventoryImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

class InventoryController extends Controller
{
    protected $User;
    protected $PatientInformationModel;
    protected $InventoriesModel;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->User = new \App\Models\User;
        $this->PatientInformation = new \App\Models\PatientInformation;
        $this->PatientHistory = new \App\Models\PatientHistory;
        $this->InventoriesModel = new \App\Models\Inventory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meds = $this->InventoriesModel->fetchAll();

        return view('pages.inventory.inventory-list', compact('meds'));
    }

    /**
     * [fetchAllMedicine description]
     * @return [type] [description]
     */
    public function fetchAllMedicine()
    {
        $meds = $this->InventoriesModel->fetchAll();

        return $meds;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMedicine(Request $request)
    {
        $now = Carbon::now();
        $meds = [];
        $quantity = [];
        // $ctr = $request['row-counter'];
        foreach ($request->all() as $key => $value)
        {
            if($key == 'meds_name')
            {
                foreach ($value as $indx => $val) {
                    $meds[] = $val;
                }
            }
            if($key == 'quantity')
            {
                foreach ($value as $indx => $val) {
                    $quantity[] = (int)$val;
                }
            }
        }

        $row_count = count($meds);

        $data = [];

        for ($i = 0; $i < $row_count; $i++) {
            $data[$i]['medicine'] = $meds[$i];
            $data[$i]['stocks'] = $quantity[$i];
            $data[$i]['created_at'] = $now;
            $data[$i]['updated_at'] = $now;
        }

        $store = $this->InventoriesModel->addMedicine($data);

        return $store;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function uploadMedicine(Request $request)
    {
        $upload = Excel::import(new InventoryImport, $request->file('file'));

        return response()->json($upload);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function updateStocks(Request $request, Inventory $inventory)
    {
        $data = [
            'id' => $request['id'],
            'stocks_delivered' => $request['stocks'],
            'delivery_date' => $request['delivery_date'],
            'updated_at' => Carbon::now()
        ];

        $update = $this->InventoriesModel->updateStocks($request['id'], $data);

        return $update;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function deleteMedicine(Request $request)
    {
        $delete = $this->InventoriesModel->deleteMedicine($request['id']);

        return $delete;
    }
}
