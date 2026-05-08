<?php $page = 'Orders'; ?>
@extends('layout.mainlayout_admin')

@section('content')
<div class="page-wrapper page-settings">
    <div class="content">
        @component('admin.components.pageheader')
        @slot('title') Order List @endslot
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

                    {{-- <div class="tab-contents-count">
                        <h6 id="result-count">Loading orders...</h6>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="table-responsive table-div">
                    <table class="table" id="orders-table">
                        <thead>
                            {{-- <tr>
                                <th>Item Id</th>
                                <th>Name with image</th>
                                <th>Date & Time</th>
                                <th>Customer Name</th>
                                <th>Address</th>
                                <th>Numbers</th>

                                <th>Count</th>
                                <th>Size</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr> --}}



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
                                <th>Bank Slip</th>
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

    .customer-email-wrap {
        position: relative;
        display: inline-block;
    }

    .customer-email-name {
        cursor: pointer;
        text-decoration: underline dotted;
        text-underline-offset: 3px;
    }

    .customer-email-popup {
        display: none !important;
        position: absolute;
        top: auto;
        bottom: calc(100% + 8px);
        left: 0;
        z-index: 1200;
        min-width: 240px;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
        padding: 10px;
    }

    .customer-email-wrap.is-open .customer-email-popup {
        display: block !important;
    }

    .customer-email-wrap.hide-after-copy .customer-email-popup {
        display: none !important;
    }

    .customer-email-popup .email-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 2px;
        display: block;
    }

    .customer-email-popup .email-value {
        font-size: 13px;
        color: #212529;
        word-break: break-all;
        margin-bottom: 8px;
        display: block;
    }

    .copy-email-btn {
        display: none !important;
    }

    .customer-email-wrap.is-open .customer-email-popup .copy-email-btn {
        display: inline-block !important;
    }

    .copy-email-btn.copied {
        background-color: #198754;
        border-color: #198754;
        color: #fff;
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<!-- Required libraries (already in your layout, just confirm) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).ready(function () {

    let ordersTable;
    let currentStatus = 'pending';

    function initTooltips() {
        $('[data-bs-toggle="tooltip"]').tooltip({
            html: true,
            container: 'body'
        });
    }

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function extractCustomerName(rawValue) {
        const rawText = $('<div>').html(rawValue || '').text() || '';
        const normalized = rawText.replace(/\s+/g, ' ').trim();

        // Backend value can be like: "John DoeEmailjohn@mail.comCopy" (no space before Email).
        // Keep everything before the first "Email" occurrence so full customer name stays intact.
        const emailMarkerIndex = normalized.search(/Email/i);
        const fromEmailMarker = emailMarkerIndex >= 0
            ? normalized.slice(0, emailMarkerIndex).trim()
            : '';
        if (fromEmailMarker) {
            return fromEmailMarker;
        }

        // Fallback cleanup if Email marker is missing.
        const cleaned = normalized
            .replace(/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/ig, ' ')
            .replace(/\bCopy\b/gi, ' ')
            .replace(/\s+/g, ' ')
            .trim();

        return cleaned || 'N/A';
    }

    function buildCustomerCell(name, email) {
        const safeName = escapeHtml(name || 'N/A');
        const safeEmail = escapeHtml(email || '');

        if (!safeEmail || safeEmail === 'N/A') {
            return safeName;
        }

        return "<span class='customer-email-wrap'>"
            + "<span class='customer-email-name'>" + safeName + "</span>"
            + "<span class='customer-email-popup'>"
            + "<span class='email-label'>Email</span>"
            + "<span class='email-value'>" + safeEmail + "</span>"
            + "<button type='button' class='btn btn-sm btn-outline-primary copy-email-btn' data-email='" + safeEmail + "'>Copy</button>"
            + "</span>"
            + "</span>";
    }

    function loadOrders(status = 'all') {
        if (ordersTable) {
            ordersTable.destroy();
        }

        ordersTable = $('#orders-table').DataTable({
            ajax: {
                url: "{{ route('admin.orders.data') }}",
                data: { status: status },
                dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                { data: 'items_preview' },
                { data: 'created_at' },
                {
                    data: 'customer_name',
                    render: function (data, type, row) {
                        const plainName = extractCustomerName(data);
                        return buildCustomerCell(plainName, row.customer_email || '');
                    }
                },
                { data: 'address' },
                { data: 'phone' },
                { data: 'variants' },
                { data: 'count' },
                { data: 'amount' },
                { data: 'bank_slip' },
                { data: 'status' },
                { data: 'action' },
                { data: 'created_at_raw', visible: false }
            ],
            ordering: true,
            order: [[12, 'desc']],
            paging: true,
            searching: false,
            info: false,
            dom: '<"custom-datatable"t><"custom-datatable"ilp>',
            drawCallback: function () {
                $('.select2').select2({ width: '100%' });
                initTooltips();
            }
        });
    }

    // INITIAL LOAD
    loadOrders(currentStatus);

    // TAB FILTER
    $('#orderTabs .nav-link').on('click', function (e) {
        e.preventDefault();
        $('#orderTabs .nav-link').removeClass('active');
        $(this).addClass('active');

        currentStatus = $(this).data('status');
        loadOrders(currentStatus);
    });

    // STATUS UPDATE
    $(document).on('change', '.order-status-select', function () {
        let orderId = $(this).data('order');
        let productId = $(this).data('product');
        let status = $(this).val();

        $.post("{{ route('admin.orders.updateStatus') }}", {
            _token: "{{ csrf_token() }}",
            order_id: orderId,
            product_id: productId,
            status: status
        }, function (res) {
            loadOrders(currentStatus); // refresh table
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
            });
        });
    });

    $(document).on('click', '.copy-email-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const $btn = $(this);
        const $wrap = $btn.closest('.customer-email-wrap');
        const email = $btn.attr('data-email') || '';
        if (!email) return;

        const markCopied = () => {
            $btn.text('Copied');
            $btn.addClass('copied');
            $wrap.addClass('hide-after-copy');
            setTimeout(function () {
                $wrap.removeClass('hide-after-copy');
            }, 700);
        };

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(email).then(markCopied);
            return;
        }

        const $temp = $('<textarea>');
        $('body').append($temp);
        $temp.val(email).trigger('select');
        document.execCommand('copy');
        $temp.remove();
        markCopied();
    });

    // Show popup only when hovering customer name (or popup itself).
    $(document).on('mouseenter', '.customer-email-name', function () {
        $(this).closest('.customer-email-wrap').addClass('is-open');
    });

    $(document).on('mouseleave', '.customer-email-wrap', function () {
        const $wrap = $(this);
        setTimeout(function () {
            if (!$wrap.is(':hover')) {
                $wrap.removeClass('is-open');
            }
        }, 80);
    });

    $(document).on('mouseenter', '.customer-email-popup', function () {
        $(this).closest('.customer-email-wrap').addClass('is-open');
    });

});
</script>




@endpush
