@extends('layouts.app')

@section('page-css')
    <style>
        .dt-center {
            text-align: center;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    <strong>{{ Session::get('success') }}</strong>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-6 col-7 py-4">
                    <h6 class="fullcalendar-title h2 text-primary d-inline-block mb-0"><span id="classification">All</span> Schedule List</h6>
                </div>
                <div class="col-lg-6 col-7 py-4 text-lg-right">
                    <button class="btn btn-sm btn-primary active" id="all-btn" onclick="dashboardFunctions.changeTableToAll()">ALL</button>
                    <button class="btn btn-sm btn-primary" id="current-month-btn" onclick="dashboardFunctions.changeTableToCurrentMonth('{{ $month }}')">CURRENT MONTH</button>
                    <button class="btn btn-sm btn-primary" id="today-btn" onclick="dashboardFunctions.changeTableToToday('{{ $today }}')">TODAY</button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-flush align-items-center" width="100%" id="clinic-schedule-table">
                        <thead class="thead-light">
                            <tr>
                                <th hidden>ID</th>
                                <th class="font-weight-bold">Patient</th>
                                <th class="font-weight-bold">Procedure</th>
                                <th class="font-weight-bold">Description</th>
                                <th class="font-weight-bold text-center">Date</th>
                                <th class="font-weight-bold text-center">Time</th>
                                <th class="font-weight-bold text-center">Status</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($scheds))
                                @foreach($scheds as $key => $value)
                                    @if($value->status == 'to_do')
                                    <tr>
                                    @elseif($value->status == 'done')
                                    <tr class="text-success font-weight-bold">
                                    @else
                                    <tr class="text-danger font-weight-bold">
                                    @endif
                                        <td hidden>{{ $value->schedule_id }}</td>
                                        <td>{{ $value->first_name . ' ' . $value->last_name }}</td>
                                        <td>{{ $value->procedure }}</td>
                                        <td>{{ $value->description }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($value->date)->format('F d, Y') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($value->time)->format('h:i A') }}</td>
                                        @if($value->status == 'to_do')
                                            <td class="text-center">TO DO</td>
                                        @elseif($value->status == 'done')
                                        <td class="text-center">DONE</td>
                                        @else
                                        <td class="text-center">CANCELLED</td>
                                        @endif
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="View Patient Info" href="{{ route('view-patient-information', $value->patient_id) }}">
                                                <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                            </a>
                                            <button class="btn btn-sm btn-icon btn-danger" onclick="dashboardFunctions.openDeleteModal({{ $value->schedule_id }});" data-toggle="tooltip" data-placement="top" title="Delete Schedule">
                                                <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pages.dashboard.modals.delete-modal')

@endsection

@section('page-js')
    <script src="{{ asset('js/dashboard-js.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            dashboardFunctions.onLoad();
        });
    </script>
@endsection
