<?php

namespace App\Http\Controllers;

use App\Models\PatientInformation;
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patient_list = $this->PatientInformation->show();
        
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
            'first_name'     => trim($request['first_name']),
            'middle_name'   => trim($request['middle_name']),
            'last_name'     => trim($request['last_name']),
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
     * Display the specified resource.
     *
     * @param  \App\Models\PatientInformation  $patientInformation
     * @return \Illuminate\Http\Response
     */
    public function show(PatientInformation $patientInformation)
    {
        $patients = PatientInformation::show();

        return $patients;
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
    public function update(Request $request, PatientInformation $patientInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientInformation  $patientInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientInformation $patientInformation)
    {
        //
    }
}
