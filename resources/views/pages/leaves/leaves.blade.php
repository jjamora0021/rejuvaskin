@extends('layouts.app')

@section('page-css')

@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-success d-none" role="alert"></div>
            <div class="alert alert-danger d-none" role="alert"></div>

            <div class="row">
                <div class="col-lg-6 col-7 py-4">
                    <h6 class="fullcalendar-title h2 text-primary d-inline-block mb-0"> Leave Applications</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-flush align-items-center" width="100%" id="leaves-application-table">
                        <thead class="thead-light">
                            <tr>
                                <th hidden>ID</th>
                                <th class="font-weight-bold">Date</th>
                                <th class="font-weight-bold">Employee</th>
                                <th class="font-weight-bold text-center">Type Of Leave</th>
                                <th class="font-weight-bold text-center">Description</th>
                                <th class="font-weight-bold text-center">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($leave_applications))
                                @foreach ($leave_applications as $key => $val)
                                    <tr class="font-weight-bold {{ ($val->status == 'approved') ? 'text-success' : 'text-danger' }}" id="{{ $val->leave_id }}">
                                        <td hidden>{{ $val->leave_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($val->date)->format('F d, Y') }}</td>
                                        <td>{{ $val->first_name . ' ' . $val->last_name }}</td>
                                        <td class="text-capitalize text-center">{{ str_replace('_', ' ', $val->leave_type) }}</td>
                                        <td class="text-center">{{ $val->description }}</td>
                                        <td class="text-uppercase text-center">{{ $val->status }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-icon btn-success" {{ ($val->status != 'pending') ? 'disabled' : '' }} onclick="timekeepingFunctions.actionLeave({{ $val->leave_id }}, {{ $val->emp_id }}, '{{ $val->leave_type }}', 'approved')" data-toggle="tooltip" data-placement="top" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon btn-danger" {{ ($val->status != 'pending') ? 'disabled' : '' }} onclick="timekeepingFunctions.actionLeave({{ $val->leave_id }}, {{ $val->emp_id }}, '{{ $val->leave_type }}', 'decline')" data-toggle="tooltip" data-placement="top" title="Decline">
                                                <i class="fas fa-times"></i>
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

@endsection

@section('page-js')
    <script src="{{ asset('js/time-keeping-js.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#leaves-application-table').DataTable({
                language: {
                    paginate: {
                        previous: '<i class="ni ni-bold-left"></i>', // or '>'
                        next: '<i class="ni ni-bold-right"></i>' // or '<'
                    }
                },
                ordering: false,
            });
        });
    </script>
@endsection
