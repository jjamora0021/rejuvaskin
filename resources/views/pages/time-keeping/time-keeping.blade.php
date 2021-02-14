@extends('layouts.app')

@section('page-css')

@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-success d-none" role="alert"></div>

            <div class="header-container align-middle d-flex">
                <div class="col-md-6 py-4">
                    <h6 class="h2 text-primary d-inline-block mb-0">Time Keeping</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-center text-default display-3" id="clock" style="text-shadow: 2px 2px #949494;"></div>

                <div class="card-body">
                    <table class="table table-striped table-flush align-items-center" width="100%" id="time-sheet-table">
                        <thead class="thead-light">
                            <tr>
                                <th hidden>ID</th>
                                <th class="font-weight-bold">Date</th>
                                <th class="font-weight-bold text-center">Time In</th>
                                <th class="font-weight-bold text-center">Time Out</th>
                                <th class="font-weight-bold text-center">Total Hours</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($records))
                                @if($first_row == false)
                                    <tr class="font-weight-bold" id="{{ $today }}">
                                        <td hidden>{{ $id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($today)->format('F d, Y') }}</td>
                                        <td class="text-center time_in">
                                            <button class="btn btn-sm btn-primary" onclick="timekeepingFunctions.saveTimeIn('{{ $today }}', {{ Auth::user()->id }}, this);">TIME IN</button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary" onclick="timekeepingFunctions.saveTimeOut('{{ $today }}', {{ Auth::user()->id }}, this, {{ $id }});">TIME OUT</button>
                                        </td>
                                        <td class="text-center total_hours">0</td>
                                        <td class="text-center">
                                        </td>
                                    </tr>
                                @endif
                                @foreach($records as $key => $value)
                                    <tr class="font-weight-bold" id="{{ $today }}">
                                        <td hidden>{{ $value->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($value->date)->format('F d, Y') }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($value->time_in)->format('h:i A') }}</td>
                                        @if($value->time_out != null)
                                            <td class="text-center">
                                                {{  \Carbon\Carbon::parse($value->time_out)->format('h:i A') }}
                                            </td>
                                        @else
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary" onclick="timekeepingFunctions.saveTimeOut('{{ $today }}', {{ Auth::user()->id }}, this, {{ $id }});">TIME OUT</button>
                                            </td>
                                        @endif
                                        <td class="text-center total_hours">{{ $value->total_hours }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-icon btn-warning" data-toggle="tooltip" data-placement="top" title="Update Time Sheet" href="#">
                                                <span class="btn-inner--icon">Dispute</span>
                                            </a>
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
            timekeepingFunctions.onLoad();
        });
    </script>
@endsection
