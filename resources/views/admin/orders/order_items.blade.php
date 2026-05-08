<?php $page = 'Order Items'; ?>
@extends('layout.mainlayout_admin')

@section('content')
<div class="page-wrapper page-settings">
    <div class="content">
        @component('admin.components.pageheader')
        @slot('title') Order Item Lists @endslot
        @endcomponent

        <div class="row">
            <div class="col-12">
                <div class="tab-sets">
                    <div class="tab-contents-sets">
                        <ul class="nav nav-tabs" id="orderTabs">
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="all">All Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-status="pending">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="inprogress">Inprogress</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="ready-to-deliver">Ready to deliver</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="delivered">Delivered</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="cancelled">Cancelled</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-contents-count">
                        <h6 id="result-count">Loading orders...</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="table-responsive table-div">
                    <table class="table" id="orders-table">
                        <thead>

                            <tr>
                                <th>Order ID</th>
                                <th>Item</th>
                                <th>Date & Time</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Variants</th>
                                <th>Total Qty</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th style="display:none;">Created At Raw</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Your existing status badge styles (matching your example) */
    .badge-pending {
        background: #fff3e0;
        color: #f57c00;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-ready {
        background: #fff9c4;
        /* Light yellow */
        color: #f9a825;
        /* Dark yellow/orange */
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }


    .badge-active {
        /* Delivered */
        background: #e8f5e9;
        color: #2e7d32;
    }

    .badge-inactive {
        /* Inprogress */
        background: #e3f2fd;
        color: #1976d2;
    }

    .badge-delete {
        /* Cancelled */
        background: #ffebee;
        color: #c62828;
    }

    .item-image {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 8px;
    }

    .table-profileimage,
    .table-imgname {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: inherit;
    }

    .product-sku {
        font-size: 11px;
        color: #666;
        font-family: monospace;
        background: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
        margin-top: 3px;
    }

    .table-select {
        min-width: 140px;
    }
</style>
@endpush

@push('scripts')
<!-- Required libraries (already in your layout, just confirm) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    let ordersTable = null;
    let tableData = @json($data);
    let currentStatus = 'pending';

    function initTooltips() {
        $('[data-bs-toggle="tooltip"]').tooltip({
            html: true,
            container: 'body',
            trigger: 'hover'
        });
    }

    function initSelect2() {
        $('.select2').select2({ width: '100%' });
    }

    function filterData(status) {
        if (status === 'all') return tableData;
        return tableData.filter(row => row.status_raw === status);
    }

    function updateResultCount(data) {
        $('#result-count').text(data.length + ' Orders Found');
    }

    function renderTable(status) {
        let filteredData = filterData(status);
        updateResultCount(filteredData);

        if (ordersTable) {
            ordersTable.destroy();
        }

        ordersTable = $('#orders-table').DataTable({
            data: filteredData,
            columns: [
                { data: 'id' },
                { data: 'items_preview' },
                { data: 'created_at' },
                { data: 'customer_name' },
                { data: 'address' },
                { data: 'phone' },
                { data: 'variants' },
                { data: 'count' },
                { data: 'amount' },
                { data: 'status' },
                { data: 'action' },
                { data: 'created_at_raw', visible: false }
            ],
            ordering: true,
            order: [[11, 'desc']],
            paging: true,
            searching: false,
            info: false,
            dom: '<"custom-datatable"t><"custom-datatable"ilp>',
            drawCallback: function () {
                initSelect2();
                initTooltips();
            }
        });
    }

    // ✅ INITIAL LOAD
    renderTable(currentStatus);

    // ✅ TAB FILTER
    $('#orderTabs .nav-link').on('click', function (e) {
        e.preventDefault();

        $('#orderTabs .nav-link').removeClass('active');
        $(this).addClass('active');

        currentStatus = $(this).data('status');
        renderTable(currentStatus);
    });

    // ✅ STATUS UPDATE (NO PAGE RELOAD)
    $(document).on('change', '.order-status-select', function () {

        let orderId = $(this).data('order');
        let productId = $(this).data('product');
        let status = $(this).val();

        $.ajax({
            url: "{{ route('admin.orders.items.updateStatus') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                order_id: orderId,
                product_id: productId,
                status: status
            },
            success: function (res) {

                if (res.success) {
                    // ✅ Update tableData without reload
                    tableData = res.data; // backend must return updated data
                    renderTable(currentStatus);

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function () {
                Swal.fire("Error", "Status update failed!", "error");
            }
        });
    });

});
</script>





@endpush
