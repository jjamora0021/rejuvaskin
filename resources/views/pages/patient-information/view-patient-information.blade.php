@extends('layouts.app')
    
@section('page-css')
    
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="header-container align-middle d-flex">
                    <div class="col-md-6 py-4">
                    <h6 class="h2 text-primary d-inline-block mb-0">Patient Information and History</h6>
                </div>
                <div class="col-md-6 py-4 text-right">
                    <a href="{{ url('patient-information') }}" class="btn btn-sm btn-warning text-right">
                        Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ Session::get('success') }}</strong>
                    </div>
                @endif
                @if (Session::has('fail'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ Session::get('fail') }}</strong>
                    </div>
                @endif
                <form method="POST" action="{{ route('update-patient-history', $patient->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Patient Information -->
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                    <div class="pl-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="first_name">First Name</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" class="form-control" value="{{ $patient->first_name }}" placeholder="Jane" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="middle_name">Middle Name</label><small><i><span class="text-danger"> Optional</span></i></small>
                                    <input type="text" class="form-control" value="{{ $patient->middle_name }}" placeholder="" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="last_name">Last Name</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" class="form-control" value="{{ $patient->last_name }}" placeholder="Doe" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="birth_date">Date of Birth</label><small><i><span class="text-danger">*</span></i></small>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" value="{{ $patient->birth_date }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="gender">Gender</label><small><i><span class="text-danger">*</span></i></small>
                                    <select id="gender" class="form-control" disabled>
                                        <option value="">Select</option>
                                        <option value="male" {{ $patient->gender === 'male' ? "selected" : "" }}>Male</option>
                                        <option value="female" {{ $patient->gender === 'female' ? "selected" : "" }}>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <h6 class="heading-small text-muted mb-4">Contact information</h6>
                    <div class="pl-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-address">Address</label><small><i><span class="text-danger">*</span></i></small>
                                    <br>
                                    <small class="text-muted"><i>House #, Street, Village/Subdivision, Barangay, Municipality, Province</i></small>
                                    <input type="text" class="form-control" placeholder="Home Address" value="{{ $patient->address }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="home_number">Home Number</label><small><i><span class="text-danger"> Optional</span></i></small>
                                    <input type="text" class="form-control" value="{{ $patient->home_number }}" placeholder="02XXXXXXXX" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="mobile_number">Mobile Number</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" class="form-control" placeholder="09XXXXXXXXX" value="{{ $patient->mobile_number }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email Address</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="email" class="form-control" placeholder="email@sample.com" value="{{ $patient->email }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <!-- Patient History -->
                    <h6 class="heading-small text-muted mb-4">Patient History</h6>
                    <div class="pl-md-4">
                        <div id="patient-history-container">
                            <input type="text" id="visit_count" value="{{ $visit_count }}" hidden>
                            @if(!empty($patient_history))
                                <div id="accordion">  
                                    @foreach($patient_history as $key => $value)
                                        <div class="card" id="card-{{ $value->id }}">
                                            <div class="card-header d-flex p-3 bg-primary" id="heading'+visit_count+'" data-toggle="collapse" data-target="#collapse{{ $value->id }}" aria-expanded="true" aria-controls="collapse{{ $value->id }}">
                                                <div class="col-md-11 p-0">
                                                    <h4 class="mb-0 text-white">
                                                        Visit {{ $value->id }} : {{ \Carbon\Carbon::parse($value->last_visit)->format('F d, Y') }}
                                                    </h4>
                                                </div>
                                                {{-- <div class="col-md-1 p-0 text-right">
                                                    <button class="btn btn-sm btn-danger" id="remove-card-btn" type="button" onclick="generalFunctions.removeAccordionCard({{ $visit_count }});">X</button>
                                                </div> --}}
                                            </div>
                                            <div id="collapse{{ $value->id }}" class="collapse" aria-labelledby="heading{{ $value->id }}" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="last_procedure">Procedure</label><small><i><span class="text-danger">*</span></i></small>
                                                                <input type="text" name="last_procedure" class="form-control" value="{{ $value->last_procedure }}" placeholder="Facial" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="email">Date of Visit</label><small><i><span class="text-danger">*</span></i></small>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                                    </div>
                                                                    <input class="form-control datepicker" placeholder="Select date" value="{{ $value->last_visit }}" type="text" name="last_visit" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="remarks">Doctor Remarks</label><small><i><span class="text-danger">*</span></i></small>
                                                                <textarea class="form-control" name="remarks" rows="3" placeholder="Remarks here..." disabled>{{ $value->remarks }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr class="my-4">

                                                    <div class="row justify-content-center pb-4">
                                                        <div class="col-md-6">
                                                            <div class="form-group text-left">
                                                                <label class="form-control-label" for="after_image">Medicines Used</label>
                                                            </div>
                                                            @if(!empty($value->medicines_used))
                                                                <ul class="list-group">
                                                                    @foreach(json_decode($value->medicines_used) as $key => $val)
                                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                            {{ $val->meds_name }}
                                                                            <span class="badge badge-primary badge-pill"><span class="text-primary font-weight-bold">x</span> {{ $val->quanity }}</span>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <label class="form-control-label">No medicines used.</label>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <hr class="my-4">

                                                    <div class="row pb-4">
                                                        @if($value->before_image != null)
                                                            <div class="col-md-6 text-center">
                                                                <div class="form-group text-left">
                                                                    <label class="form-control-label" for="before_image">Before</label><small><i><span class="text-danger">*</span></i></small>
                                                                </div>
                                                                <img src="{{ asset('images') }}/{{ $value->before_image }}" class="rounded" alt="Cinque Terre" width="50%">
                                                            </div>
                                                        @else
                                                            <div class="col-md-6 text-center align-middle">
                                                                <div class="form-group align-middle">
                                                                    <label class="form-control-label" for="before_image">No Before Image Uploaded</label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($value->after_image != null)
                                                            <div class="col-md-6 text-center">
                                                                <div class="form-group text-left">
                                                                    <label class="form-control-label" for="after_image">After</label><small><i><span class="text-danger">*</span></i></small>
                                                                </div>
                                                                <img src="{{ asset('images') }}/{{ $value->after_image }}" class="rounded" alt="Cinque Terre" width="50%">
                                                            </div>
                                                        @else
                                                            <div class="col-md-6 text-center align-middle">
                                                                <div class="form-group align-middle">
                                                                    <label class="form-control-label" for="before_image">No After Image Uploaded</label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                     <hr class="my-4">

                                                    <div class="row justify-content-center">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="bill">Total Bill</label><small><i><span class="text-danger">*</span></i></small>
                                                                <input type="text" name="bill" class="form-control" value="{{ $value->bill }}" placeholder="1000" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="form-control-label" for="discount">Discount</label><small><i><span class="text-danger">*</span></i></small>
                                                                <input type="text" name="discount" class="form-control" value="{{ $value->discount }}" placeholder="500" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <h3 class="text-center no-history"><i>No History Yet</i></h3>
                                <div id="accordion">  
                                </div>
                            @endif
                            <div class="row justify-content-center">
                                <button class="btn btn-sm btn-primary" id="add-card-btn" type="button" onclick="generalFunctions.renderPatientHistoryFields({{ $patient->id }},{{ $visit_count }}, {{ json_encode($meds) }});">Add Record</button>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <div class="row justify-content-center">
                        <button class="btn btn-success" type="submit">Update</button>
                        <a href="{{ url('patient-information') }}" class="btn btn-danger text-right">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
    
@endsection
