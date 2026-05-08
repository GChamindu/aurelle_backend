<?php $page = 'categories'; ?>
@extends('layout.mainlayout_admin')

@section('content')
<div class="page-wrapper page-settings">
    <div class="content">
        @component('admin.components.pageheader')
        @slot('title') Categories @endslot
        @slot('text') Add Category @endslot
        @endcomponent

        <div class="row">
            <div class="col-12">
                <div class="table-responsive table-div">
                    <table class="table" id="categories-data">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Count</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="add-category">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-0">
                <form id="categoryForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_id">

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="image_file" class="form-control" accept="image/*">
                        <img id="imagePreview" class="img-fluid mt-2" style="max-height:150px;display:none;">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- 🔥 ADDED: Next.js-style image compression -->
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>

<script>
    /* ---------------- CSRF ---------------- */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let categoryTable;

/* ---------------- DATATABLE ---------------- */
$(document).ready(function () {
    categoryTable = $('#categories-data').DataTable({
        ajax: {
            url: '/admin/categories/list',
            dataSrc: 'data'
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'slug' },
            { data: 'product_count' },
            {
                data: null,
                orderable: false,
                render: function (d) {
                    return `
                        <button class="btn btn-sm me-1" onclick="editCategory(${d.id})">
                            <i class="fe fe-edit"></i>
                        </button>
                        <button class="btn btn-sm" onclick="deleteCategory(${d.id})">
                            <i class="fe fe-trash-2"></i>
                        </button>
                    `;
                }
            }
        ],
        paging: true,
        searching: false,
        info: false
    });
});

/* ---------------- IMAGE PREVIEW ---------------- */
$('input[name="image_file"]').on('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => $('#imagePreview').attr('src', e.target.result).show();
    reader.readAsDataURL(file);
});

/* ---------------- 🔥 ADDED: IMAGE COMPRESS FUNCTION ---------------- */
async function compressImage(file) {
    return await imageCompression(file, {
        maxSizeMB: 2.5,
        maxWidthOrHeight: 2400,
        initialQuality: 0.95,
        useWebWorker: true,
        alwaysKeepResolution: true
    });
}

/* ---------------- EDIT ---------------- */
function editCategory(id) {
    $.get(`/admin/categories/${id}`, res => {
        const c = res.data;
        $('input[name="category_id"]').val(c.id);
        $('input[name="name"]').val(c.name);
        if (c.image) {
            $('#imagePreview').attr('src', c.image).show();
        } else {
            $('#imagePreview').hide();
        }
        $('#add-category .modal-title').text('Edit Category');
        $('#add-category').modal('show');
    });
}

/* ---------------- DELETE ---------------- */
function deleteCategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this category?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/categories/${id}`,
                type: 'DELETE',
                success: function () {
                    Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                    categoryTable.ajax.reload(null, false);
                },
                error: function () {
                    Swal.fire('Error', 'Failed to delete category.', 'error');
                }
            });
        }
    });
}

/* ---------------- CREATE / UPDATE ---------------- */
$('#categoryForm').on('submit', function (e) {
    e.preventDefault();

    const $saveButton = $('#saveButton');
    $saveButton.prop('disabled', true).text('Saving...');

    const formData = new FormData(this);
    const id = $('input[name="category_id"]').val();
    let url = '/admin/categories';

    if (id) {
        url = `/admin/categories/${id}`;
        formData.append('_method', 'PUT');
    }

    const saveCategory = () => {
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                Swal.fire('Success', id ? 'Category updated!' : 'Category created!', 'success');
                $('#add-category').modal('hide');
                $('#categoryForm')[0].reset();
                $('#imagePreview').hide();
                $('input[name="category_id"]').val('');
                $('#add-category .modal-title').text('Add Category');
                categoryTable.ajax.reload(null, false);
            },
            error: function () {
                Swal.fire('Error', 'Something went wrong.', 'error');
            },
            complete: function () {
                $saveButton.prop('disabled', false).text('Save');
            }
        });
    };

    const file = formData.get('image_file');

    if (file && file.size > 0) {
        compressImage(file).then(compressed => {
            const upload = new FormData();
            upload.append('file', compressed);

            $.ajax({
                url: '/admin/media/upload',
                method: 'POST',
                data: upload,
                processData: false,
                contentType: false,
                success: res => {
                    formData.append('image', res.url);
                    saveCategory();
                },
                error: function () {
                    Swal.fire('Error', 'Image upload failed.', 'error');
                    $saveButton.prop('disabled', false).text('Save');
                }
            });
        });
    } else {
        saveCategory();
    }
});

function openAddCategory() {
    // Reset form
    $('#categoryForm')[0].reset();

    // Clear hidden ID
    $('input[name="category_id"]').val('');

    // Hide image preview
    $('#imagePreview').hide().attr('src', '');

    // Reset modal title
    $('#add-category .modal-title').text('Add Category');

    // Reset save button state
    $('#saveButton').prop('disabled', false).text('Save');
}


$(document).on('click', '#addProductBtn', function () {
    openAddCategory();
});

</script>
@endpush
