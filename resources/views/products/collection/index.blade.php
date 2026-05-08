<?php $page = 'Collections'; ?>
@extends('layout.mainlayout_admin')

@section('content')
<div class="page-wrapper page-settings">
    <div class="content">

        @component('admin.components.pageheader')
        @slot('title') Collections @endslot
        @slot('text') Add Collection @endslot
        @endcomponent

        <div class="row">
            <div class="col-12">
                <div class="table-responsive table-div">
                    <table class="table" id="collections-data">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Category</th>
                                <th>Collections</th>
                                <th>Show Areas</th>
                                <th>Is Sold Out</th>

                                <th width="120">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* ---------------- CSRF Setup ---------------- */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* ---------------- DataTable Initialization ---------------- */
    let collectionsTable;

    $(document).ready(function () {
        collectionsTable = $('#collections-data').DataTable({
            ajax: {
                url: '{{ route("admin.collection.products.list") }}',
                dataSrc: 'data'
            },
            order: [[0, 'desc']], // ID descending (newest first)
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'slug' },
                { data: 'category' },
                { data: 'collections' },

                { data: 'show_areas' },

                {
                    data: 'sold_out',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (soldOut, type, row) {
                        const checked = soldOut ? 'checked' : '';
                        return `<input type="checkbox" class="form-check-input sold-out-toggle" data-id="${row.id}" ${checked}>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (d) {
                        return `
                            <a href="/admin/collection-products/edit/${d.id}" class="btn btn-sm me-1">
                                <i class="fe fe-edit"></i>
                            </a>
                            <button class="btn btn-sm" onclick="deleteCollectionProduct(${d.id})">
                                <i class="fe fe-trash-2"></i>
                            </button>
                        `;
                    }
                }
            ],
            paging: true,
            searching: true,
            ordering: true,
            info: true
        });
    });

    $(document).on('change', '.sold-out-toggle', function () {
        const checkbox = $(this);
        const id = checkbox.data('id');
        const soldOut = checkbox.is(':checked');

        checkbox.prop('disabled', true);

        $.ajax({
            url: `/admin/collection-products/${id}/sold-out`,
            type: 'PATCH',
            data: {
                sold_out: soldOut ? 1 : 0
            },
            success: function () {
                Swal.fire('Updated!', 'Sold out status updated successfully.', 'success');
            },
            error: function (xhr) {
                let message = 'Unable to update sold out status.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                checkbox.prop('checked', !soldOut);
                Swal.fire('Error', message, 'error');
            },
            complete: function () {
                checkbox.prop('disabled', false);
            }
        });
    });

    /* ---------------- Delete Collection Product ---------------- */
   function deleteCollectionProduct(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This product will be deleted permanently',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/collection-products/${id}`,
                type: 'DELETE',
                success: function () {
                    Swal.fire('Deleted!', 'Product deleted successfully.', 'success');
                    collectionsTable.ajax.reload(null, false);
                },
                error: function () {
                    Swal.fire('Error', 'Unable to delete product.', 'error');
                }
            });
        }
    });
}
</script>

@endpush
