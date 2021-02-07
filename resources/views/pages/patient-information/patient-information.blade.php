@extends('layouts.app')

@section('page-css')
    
@endsection

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
                <thead class="thead-light">
                    <tr>
                        <th hidden>ID</th>
                        <th class="font-weight-bold">First Name</th>
                        <th class="font-weight-bold">Middle Name</th>
                        <th class="font-weight-bold">Last Name</th>
                        <th class="font-weight-bold">Date of Birth</th>
                        <th class="font-weight-bold">Gender</th>
                        <th class="font-weight-bold">Home Number</th>
                        <th class="font-weight-bold">Mobile Number</th>
                        <th class="font-weight-bold">Email</th>
                        <th class="font-weight-bold">Address</th>
                        <th></th>
                    </tr>
                </thead>
                @if(!empty($patient_list))
                <tbody class="list">
                    @foreach($patient_list as $key => $value)
                        <tr>
                            <td hidden>{{ $value->id }}</td>
                            <td>{{ $value->first_name }}</td>
                            <td>{{ $value->middle_name }}</td>
                            <td>{{ $value->last_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($value->birth_date)->format('F d, Y') }}</td>
                            <td class="text-capitalize">{{ $value->gender }}</td>
                            <td>{{ $value->home_number }}</td>
                            <td>{{ $value->mobile_number }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ substr_replace($value->address, "...", 20) }}</td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="View Patient Info" href="{{ route('view-patient-information', $value->id) }}">
                                    <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                </a>
                                <a class="btn btn-sm btn-icon btn-warning" data-toggle="tooltip" data-placement="top" title="Update Patient Info" href="{{ url('update-patient-information') }}/{{ $value->id }}">
                                    <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                </a>
                                <button class="btn btn-sm btn-icon btn-danger" onclick="generalFunctions.openDeleteModal({{ $value->id }});">
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

@include('pages.patient-information.modals.delete-modal')

@endsection

@section('page-js')
    <script type="text/javascript">
        $(document).ready(function() {
            dataTableFunctions.onLoad();
        });
    </script>
@endsection
