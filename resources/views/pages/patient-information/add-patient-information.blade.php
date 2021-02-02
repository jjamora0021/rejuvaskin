@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="header-container align-middle d-flex">
                <div class="col-md-6 py-4">
                    <h6 class="h2 text-primary d-inline-block mb-0">Add Patient Information</h6>
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
                <form method="POST" action="{{ route('store-patient-information') }}">
                    @csrf
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                    <div class="pl-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="first_name">First Name</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="Jane" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="middle_name">Middle Name</label><small><i><span class="text-danger"> Optional</span></i></small>
                                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="last_name">Last Name</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Doe" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" />
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4">Contact information</h6>
                    <div class="pl-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-address">Address</label><small><i><span class="text-danger">*</span></i></small>
                                    <br>
                                    <small class="text-muted"><i>House #, Street, Village/Subdivision, Barangay, Municipality, Province</i></small>
                                    <input type="text" name="address" class="form-control" placeholder="Home Address" value="{{ old('address') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="home_number">Home Number</label><small><i><span class="text-danger"> Optional</span></i></small>
                                    <input type="text" name="home_number" class="form-control" value="{{ old('home_number') }}" placeholder="02XXXXXXXX">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="mobile_number">Mobile Number</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="text" name="mobile_number" class="form-control" placeholder="09XXXXXXXXX" value="{{ old('mobile_number') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email Address</label><small><i><span class="text-danger">*</span></i></small>
                                    <input type="email" name="email" class="form-control" placeholder="email@sample.com" value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <div class="row justify-content-center">
                        <button class="btn btn-success" type="submit">Save</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#patient-information a').addClass('active');
        });
    </script>
@endsection
