@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="col-lg-6 col-7 py-4">
                <h6 class="h2 text-primary d-inline-block mb-0">Inventory</h6>
            </div>

            <table class="table align-items-center table-striped" width="100%" id="inventory-table">
                <thead>
                    <tr>
                        <th hidden>Id</th>
                        <th class="font-weight-bold">Medicine</th>
                        <th class="font-weight-bold text-center">Current Stock</th>
                        <th class="font-weight-bold text-center">Last Updated</th>
                        <th></th>
                    </tr>
                </thead>
                @if(!empty($meds))
                    <tbody>
                        @foreach($meds as $key => $val)
                            <tr>
                                <td hidden>{{ $val->id }}</td>
                                <td width="50%">{{ $val->medicine }}</td>
                                <td class="text-center" width="15%">{{ $val->stocks }}</td>
                                <td class="text-center" width="15%">{{ $val->updated_at }}</td>
                                <td class="text-center" width="20%">
                                    <a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="View Stocks History" href="#">
                                        <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>
                                    </a>
                                    <button class="btn btn-sm btn-icon btn-warning" onclick="inventoryFunctions.openUpdateStocksModal('{{ $val->medicine }}',{{ $val->id }});">
                                        <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>
                                    </button>
                                    <button class="btn btn-sm btn-icon btn-danger" onclick="inventoryFunctions.openDeleteModal({{ $val->id }});">
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

@include('pages.inventory.modals.update-modal')
@include('pages.inventory.modals.delete-modal')

@endsection

@section('page-js')
    <script type="text/javascript" src="{{ asset('js/inventory.js') }}"></script>
    <script type="text/javascript">
        $('#dashboard-link a').addClass('active');
        $(document).ready(function() {
            dataTableFunctions.onLoad();
        });
    </script>
@endsection
