<?php $page = 'Collections'; ?>
@extends('layout.mainlayout_admin')

@section('content')
<div class="page-wrapper page-settings">
    <div class="content">

        @component('admin.components.pageheader')
        @slot('title') Products @endslot
        @slot('text') Add Product @endslot
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
                                <th>Section</th>
                                <th>Show Areas</th>
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
    /* ---------------- CSRF ---------------- */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/* ---------------- DATATABLE ---------------- */
let collectionsTable;

$(document).ready(function () {
    collectionsTable = $('#collections-data').DataTable({
        ajax: {
            url: '{{ route("admin.section.products.list") }}',
            dataSrc: 'data'
        },
        order: [[0, 'desc']], // ✅ ID DESC (latest first)
            columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'slug' },
            { data: 'category' },
            { data: 'sections' }, // ✅ must match backend key
            { data: 'show_areas' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (d) {
                    return `
                            <a href="/admin/section-products/edit/${d.id}" class="btn btn-sm me-1">
                                <i class="fe fe-edit"></i>
                            </a>
                            <button class="btn btn-sm" onclick="deleteSectionProduct(${d.id})">
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


    function deleteProduct(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send DELETE request
            axios.delete(`/admin/products/${id}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.data.success) {
                    Swal.fire(
                        'Deleted!',
                        'Product has been deleted.',
                        'success'
                    ).then(() => {
                        // Reload DataTable or page to reflect changes
                        $('#productsTable').DataTable().ajax.reload(); // If using server-side DataTables
                        // OR: location.reload(); // Simple page refresh
                    });
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error!',
                    error.response?.data?.message || 'Something went wrong!',
                    'error'
                );
            });
        }
    });
}
});


/* ---------------- DELETE PRODUCT ---------------- */
function deleteSectionProduct(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This product will be deleted permanently',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/section-products/${id}`,
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
