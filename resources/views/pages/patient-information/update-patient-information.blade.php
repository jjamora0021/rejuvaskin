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
                <form method="POST" action="{{ route('update-patient-information', $patient->id) }}">
                    @csrf
                    <!-- Patient Information -->
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                    <div class="pl-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="first_name">First Name</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" class="form-control" value="{{ $patient->first_name }}" placeholder="Jane" name="first_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="middle_name">Middle Name</label><small><i><span class="text-danger"> Optional</span></i></small>
                                    <input type="text" class="form-control" value="{{ $patient->middle_name }}" placeholder="" name="middle_name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="last_name">Last Name</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" class="form-control" value="{{ $patient->last_name }}" placeholder="Doe" name="last_name">
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
                                        <input class="form-control datepicker" placeholder="Select date" type="text" value="{{ $patient->birth_date }}" name="birth_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="gender">Gender</label><small><i><span class="text-danger">*</span></i></small>
                                    <select id="gender" class="form-control" name="gender">
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
                                    <input type="text" class="form-control" placeholder="Home Address" value="{{ $patient->address }}" name="address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="home_number">Home Number</label><small><i><span class="text-danger"> Optional</span></i></small>
                                    <input type="text" class="form-control" value="{{ $patient->home_number }}" placeholder="02XXXXXXXX" name="home_number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="mobile_number">Mobile Number</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" class="form-control" placeholder="09XXXXXXXXX" value="{{ $patient->mobile_number }}" name="mobile_number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email Address</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="email" class="form-control" placeholder="email@sample.com" value="{{ $patient->email }}" name="email">
                                </div>
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
    <script src="{{ asset('assets/js/components/vendor/theme.min.js') }}"></script>
@endsection
