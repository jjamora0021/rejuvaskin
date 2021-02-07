<?php

namespace App\Http\Controllers;

use App\Models\PatientInformation;
use App\Models\PatientHistory;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class PatientInformationController extends Controller
{
    protected $User;
    protected $PatientInformationModel;

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
        $this->Inventory = new \App\Models\Inventory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patient_list = $this->PatientInformation->fetchAll();
        
        return view('pages.patient-information.patient-information', compact('patient_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.patient-information.add-patient-information');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'first_name'    => trim($request['first_name']),
            'middle_name'   => trim($request['middle_name']),
            'last_name'     => trim($request['last_name']),
            'birth_date'    => trim($request['birth_date']),
            'gender'        => trim($request['gender']),
            'address'       => trim($request['address']),
            'home_number'   => trim($request['home_number']),
            'mobile_number' => trim($request['mobile_number']),
            'email'         => trim($request['email']),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ];

        $store = $this->PatientInformation->store($data);

        if($store)
        {
            return redirect('/add-patient-information')->with('success', 'Patient information successfully saved.');
        }
        else
        {
            return redirect('/add-patient-information')->with('fail', 'Patient information failed to be saved.')->withInput();
        }
    }

    /**
     * [fetchAll description]
     * @return [type] [description]
     */
    public function fetchAll()
    {
        $patients = $this->PatientInformation->fetchAll();

        return $patients;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientInformation  $patientInformation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = $this->PatientInformation->show($id);
        if(!empty($patient))
        {
            $patient = $patient[0];
        }
        $meds = $this->Inventory->fetchAll();
        $patient_history = $this->PatientHistory->checkPatientHistory($id);
        $visit_count = count($patient_history);

        return view('pages.patient-information.view-patient-information', compact('patient','patient_history','visit_count','meds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientInformation  $patientInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientInformation $patientInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientInformation  $patientInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientInformation $patientInformation, $patient_id)
    {
        $imageName_before = (isset($request->before_image) == true ? Carbon::today()->toDateString().'_before.'.$request->before_image->extension() : null);
        $imageName_after = (isset($request->after_image) == true ? Carbon::today()->toDateString().'_after.'.$request->after_image->extension() : null);
        
        $meds = array();
        if(isset($request['selected-meds-count']) && $request['selected-meds-count'] != 0) {
            for ($i = 1; $i < $request['selected-meds-count'] + 1; $i++) { 
                $meds[$i] = [
                    'meds_id' =>  $request['current_med_selected-'.$i],
                    'meds_name' =>  $request['current_med_selected_text-'.$i],
                    'quanity' => (int)$request['current_count-'.$i]
                ];
            }
        }

        $patient_history = [
            'patient_id'        => $patient_id,
            'last_procedure'    => $request['last_procedure'],
            'last_visit'        => $request['last_visit'],
            'remarks'           => $request['remarks'],
            'bill'              => $request['bill'],
            'discount'          => $request['discount'],
            'medicines_used'     => json_encode($meds),
            'before_image'      => $imageName_before,
            'after_image'       => $imageName_after,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ];

        $save = $this->PatientHistory->store($patient_history, $meds, $patient_id);
        
        if($save)
        {
            if(isset($request->before_image)) {
                $request->before_image->move(public_path('images'), $imageName_before);
            }
            if(isset($request->after_image)) {
                $request->after_image->move(public_path('images'), $imageName_after);
            }

            return back()->with('success', 'Patient information successfully saved.');
        }   
        else
        {
            return back()->with('fail', 'Patient information failed to be saved.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientInformation  $patientInformation
     * @return \Illuminate\Http\Response
     */
    public function deleteRecord(Request $request)
    {
        $delete = $this->PatientHistory->deleteRecord($request['id']);
        
        return $delete;
    }

    /**
     * [updatePatientInformation description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function loadUpdatePatientInformationPage(Request $request)
    {
        $patient = $this->PatientInformation->show($request->id);
        if(!empty($patient))
        {
            $patient = $patient[0];
        }
        
        return view('pages.patient-information.update-patient-information', compact('patient'));
    }

    /**
     * [updatePatientInformation description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updatePatientInformation(Request $request, PatientInformation $patientInformation, $patient_id)
    {
        $data = [
            'first_name'    => trim($request['first_name']),
            'middle_name'   => trim($request['middle_name']),
            'last_name'     => trim($request['last_name']),
            'birth_date'    => trim($request['birth_date']),
            'gender'        => trim($request['gender']),
            'address'       => trim($request['address']),
            'home_number'   => trim($request['home_number']),
            'mobile_number' => trim($request['mobile_number']),
            'email'         => trim($request['email']),
            'updated_at'    => Carbon::now()
        ];

        $update = $this->PatientInformation->updatePatientInformation($data, $request->id);

        if($update)
        {
            return back()->with('success', 'Patient information successfully updated.');
        }
        else
        {
            return back()->with('fail', 'Patient information failed to be updated.')->withInput();
        }
    }
}
