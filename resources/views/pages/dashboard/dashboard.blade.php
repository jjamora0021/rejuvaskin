@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    <strong>{{ Session::get('success') }}</strong>
                </div>
            @endif

            <div class="col-lg-6 col-7 py-4">
                <h6 class="h2 text-primary d-inline-block mb-0">Dashboard</h6>
            </div>

            <table class="table align-items-center" width="100%" id="clinic-schedule-table">
                <thead>
                    <tr>
                        <th class="font-weight-bold">Patient</th>
                        <th class="font-weight-bold">Procedure</th>
                        <th class="font-weight-bold">Schedule</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@section('page-js')
    <script type="text/javascript">
        $('#dashboard-link a').addClass('active');
        $(document).ready(function() {
            dataTableFunctions.onLoad();
        });
    </script>
@endsection
