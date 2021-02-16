@extends('layouts.app')

@section('page-css')

@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="header-container align-middle d-flex">
                <div class="col-md-6 py-4">
                    <h6 class="h2 text-primary d-inline-block mb-0">Time Keeping Disputes</h6>
                </div>
            </div>

            <div class="alert alert-success d-none" role="alert"></div>
            <div class="alert alert-danger d-none" role="alert"></div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-flush align-items-center" width="100%" id="time-keeping-dispute-table">
                        <thead class="thead-light">
                            <tr>
                                <th hidden>ID</th>
                                <th class="font-weight-bold">Employee Name</th>
                                <th class="font-weight-bold text-center">Date in dispute</th>
                                <th class="font-weight-bold text-center">Type Of Dispute</th>
                                <th class="font-weight-bold text-center">Corrected Value</th>
                                <th class="font-weight-bold text-center">Status</th>
                                <th class="font-weight-bold text-center">Approved by</th>
                                <th class="font-weight-bold">Remarks</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                                @foreach ($data as $key => $value)
                                    <tr class="font-weight-bold" id="{{ $value->dispute_id }}">
                                        <td hidden>{{ $value->dispute_id }}</td>
                                        <td>{{ $value->full_name }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($value->date_in_dispute)->format('F d, Y') }}</td>
                                        <td class="text-center text-uppercase">{{ str_replace('_', ' ', $value->type_of_dispute) }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($value->dispute)->format('h:m A') }}</td>
                                        <td class="text-center text-uppercase">{{ $value->dispute_status }}</td>
                                        <td class="text-center">{{ ($value->approved_by == null) ? '' : $value->approved_by }}</td>
                                        <td>{{ $value->remarks }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-icon btn-success" {{ ($value->dispute_status != 'pending') ? 'disabled' : '' }} onclick="timekeepingFunctions.openActionModal('approved', {{ $value->dispute_id }});" data-toggle="tooltip" data-placement="top" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-icon btn-danger" {{ ($value->dispute_status != 'pending') ? 'disabled' : '' }} onclick="timekeepingFunctions.openActionModal('declined', {{ $value->dispute_id }});" data-toggle="tooltip" data-placement="top" title="Decline">
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

{{-- Action Modal --}}
<div class="modal fade" id="action-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Approve/Decline Modal</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success d-none" role="alert"></div>
                <div class="alert alert-danger d-none" role="alert"></div>

                <form action="{{ route('update-dispute') }}" method="POST" id="action-form">
                    @csrf
                    <input type="hidden" value="" id="dispute_id" name="dispute_id">
                    <input type="hidden" value="" id="action" name="action">
                    <div class="form-group mb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="others">Remarks</label><small><i><span class="text-danger">*</span></i></small>
                                    <textarea type="text" id="others" rows="3" id="remarks" name="remarks" class="form-control" value="{{ old('remarks') }}" placeholder="Remarks" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-success" type="submit" onclick="timekeepingFunctions.updateDispute();">Update</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-link text-right ml-auto" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
    <script src="{{ asset('js/time-keeping-js.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#time-keeping-dispute-table').DataTable({
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
