@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="header-container align-middle d-flex">
                    <div class="col-md-6 py-4">
                    <h6 class="h2 text-primary d-inline-block mb-0">Patient List</h6>
                </div>
                <div class="col-md-6 py-4 text-right">
                    <a href="{{ url('add-patient-information') }}" class="btn btn-sm btn-primary text-right">
                        <i class="ni ni-fat-add"></i> Add Patient Info
                    </a>
                </div>
            </div>

            <table class="table align-items-center table-striped" width="100%" id="patient-list-table">
                <thead>
                    <tr>
                        <th hidden>ID</th>
                        <th class="font-weight-bold">First Name</th>
                        <th class="font-weight-bold">Middle Name</th>
                        <th class="font-weight-bold">Last Name</th>
                        <th class="font-weight-bold">Home Number</th>
                        <th class="font-weight-bold">Mobile Number</th>
                        <th class="font-weight-bold">Email</th>
                        <th class="font-weight-bold">Address</th>
                        <th></th>
                    </tr>
                </thead>
                @if(!empty($patient_list))
                <tbody>
                    @foreach($patient_list as $key => $value)
                        <tr>
                            <td hidden>{{ $value->id }}</td>
                            <td>{{ $value->first_name }}</td>
                            <td>{{ $value->middle_name }}</td>
                            <td>{{ $value->last_name }}</td>
                            <td>{{ $value->home_number }}</td>
                            <td>{{ $value->mobile_number }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ substr_replace($value->address, "...", 20) }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-icon btn-primary" type="button" data-toggle="tooltip" data-placement="top" title="View Patient Info">
                                    <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                </button>
                                <button class="btn btn-sm btn-icon btn-warning" type="button" data-toggle="tooltip" data-placement="top" title="Update Patient Info">
                                    <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                </button>
                                <button class="btn btn-sm btn-icon btn-danger" type="button" data-toggle="tooltip" data-placement="top" title="Delete Patient Info">
                                    <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>    
                @else
                <tbody></tbody>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection

@section('page-js')
    <script type="text/javascript">
        $(document).ready(function() {
            dataTableFunctions.onLoad();
        });
    </script>
@endsection