@extends('layouts.app')

@section('page-css')

@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="header-container align-middle d-flex">
                <div class="col-md-6 py-4">
                    <h6 class="h2 text-primary d-inline-block mb-0">Time Keeping</h6>
                </div>
                <div class="col-md-6 py-4 text-right">
                    <button class="btn btn-sm btn-success text-right" data-toggle="modal" data-target="#leave-request-modal">
                        Leave Request
                    </button>
                    {{-- <button class="btn btn-sm btn-warning text-right" data-toggle="modal" data-target="#dispute-time-keeping-modal">
                        Time Keeping Correction
                    </button> --}}
                </div>
            </div>

            <div class="alert alert-success d-none" role="alert"></div>

            <div class="card">
                <div class="card-header text-center text-default display-3" id="clock" style="text-shadow: 2px 2px #949494;"></div>

                <div class="card-body">
                    <table class="table table-flush align-items-center" width="100%" id="time-sheet-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="font-weight-bold">Day</th>
                                <th class="font-weight-bold">Date</th>
                                <th class="font-weight-bold text-center">Time In</th>
                                <th class="font-weight-bold text-center">Time Out</th>
                                <th class="font-weight-bold text-center">Total Hours</th>
                            </tr>
                        </thead>
                        <tbody class="font-weight-bold">
                            @foreach ($data as $key => $dt)
                                @if(array_key_exists('data', $dt))
                                    @if ($dt['data'] == 'weekend')
                                        <tr id="{{ $dt['date'] }}">
                                            <td class="text-capitalize">{{ $dt['day'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dt['date'])->format('F d, Y') }}</td>
                                            <td colspan="2" class="text-center">REST DAY</td>
                                            <td class="text-center">0</td>
                                            <td hidden></td>
                                        </tr>
                                    @elseif ($dt['data'] == 'on_leave')
                                        <tr id="{{ $dt['date'] }}">
                                            <td class="text-capitalize">{{ $dt['day'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dt['date'])->format('F d, Y') }}</td>
                                            <td colspan="2" class="text-center text-info">ON LEAVE</td>
                                            <td class="text-center text-info">7</td>
                                            <td hidden></td>
                                        </tr>
                                    @elseif(strtotime($dt['date']) == strtotime($today))
                                        <tr id="{{ $dt['date'] }}">
                                            <td class="text-capitalize">{{ $dt['day'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dt['date'])->format('F d, Y') }}</td>
                                            @if($dt['data'] == 'today')
                                                <td class="text-center time_in text-primary">
                                                    <button class="btn btn-sm btn-primary" onclick="timekeepingFunctions.saveTimeIn('{{ $today }}', {{ Auth::user()->id }}, this);">TIME IN</button>
                                                </td>
                                                <td class="text-center text-primary">
                                                    <button class="btn btn-sm btn-primary" onclick="timekeepingFunctions.saveTimeOut('{{ $today }}', {{ Auth::user()->id }}, this);">TIME OUT</button>
                                                </td>
                                                <td class="text-center total_hours">0</td>
                                            @else
                                                @if($dt['data']['time_in'] == null)
                                                    <td class="text-center time_in text-primary">
                                                        <button class="btn btn-sm btn-primary" onclick="timekeepingFunctions.saveTimeIn('{{ $today }}', {{ Auth::user()->id }}, this);">TIME IN</button>
                                                    </td>
                                                @else
                                                    <td class="text-center text-success">{{ \Carbon\Carbon::parse($dt['data']['time_in'])->format('h:i A') }}</td>
                                                @endif
                                                @if($dt['data']['time_out'] == null)
                                                    <td class="text-center text-primary">
                                                        <button class="btn btn-sm btn-primary" onclick="timekeepingFunctions.saveTimeOut('{{ $today }}', {{ Auth::user()->id }}, this);">TIME OUT</button>
                                                    </td>
                                                @else
                                                    <td class="text-center text-success">{{ \Carbon\Carbon::parse($dt['data']['time_out'])->format('h:i A') }}</td>
                                                @endif
                                                @if($dt['data']['time_in'] != null && $dt['data']['time_in'] != null)
                                                    <td class="text-center text-success">{{  $dt['data']['total_hours'] }}</td>
                                                @else
                                                    <td class="text-center text-success">0</td>
                                                @endif
                                            @endif
                                        </tr>
                                    @elseif(is_array($dt['data']))
                                        <tr id="{{ $dt['date'] }}">
                                            <td class="text-capitalize">{{ $dt['day'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dt['date'])->format('F d, Y') }}</td>
                                            <td class="text-center text-success">{{ \Carbon\Carbon::parse($dt['data']['time_in'])->format('h:i A') }}</td>
                                            <td class="text-center text-success">{{ \Carbon\Carbon::parse($dt['data']['time_out'])->format('h:i A') }}</td>
                                            <td class="text-center text-success">{{  $dt['data']['total_hours'] }}</td>
                                        </tr>
                                    @else
                                        <tr id="{{ $dt['date'] }}">
                                            <td class="text-capitalize">{{ $dt['day'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($dt['date'])->format('F d, Y') }}</td>
                                            <td colspan="2" class="text-center text-danger">ABSENT</td>
                                            <td class="text-center text-danger">0</td>
                                            <td hidden></td>
                                        </tr>
                                    @endif
                                @else
                                    <tr id="{{ $dt['date'] }}">
                                        <td class="text-capitalize">{{ $dt['day'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($dt['date'])->format('F d, Y') }}</td>
                                        <td colspan="2" class="text-center text-danger">ABSENT</td>
                                        <td class="text-center text-danger">0</td>
                                        <td hidden></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pages.time-keeping.modals.time-keeping-disputes-modal')
@include('pages.time-keeping.modals.leave-request-modal')

@endsection

@section('page-js')
    <script src="{{ asset('js/time-keeping-js.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#time-sheet-table').DataTable({
                ordering: false,
                bPaginate: false,
                pageLength: 50,
                bInfo: false
            });
            timekeepingFunctions.displayCurrentTime();
        });
    </script>
@endsection
