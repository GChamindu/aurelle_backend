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
                <h5 class="modal-title">Add collections</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-0">
                <form id="collectionsForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="collections_id">

                    <div class="mb-3">
                        <label class="form-label">collections Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">collections Image</label>
                        <input type="file" name="image_file" class="form-control" accept="image/*">
                        <img id="imagePreview" class="img-fluid mt-2" style="max-height:150px;display:none;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block">Show in Header?</label>

                        <label class="me-3">
                            <input type="radio" name="show_in_header" value="1">
                            Yes
                        </label>

                        <label>
                            <input type="radio" name="show_in_header" value="0" checked>
                            No
                        </label>
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

<!-- 🔥 IMAGE OPTIMIZATION (same as Categories) -->
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>

<script>
    /* ---------------- CSRF ---------------- */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let collectionsTable;

/* ---------------- DATATABLE ---------------- */
$(document).ready(function () {
    collectionsTable = $('#collections-data').DataTable({
        ajax: {
            url: '/admin/collections/list',
            dataSrc: 'data'
        },
         order: [[0, 'desc']],
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'slug' },
            {
                data: null,
                orderable: false,
                render: function (d) {
                    return `
                        <button class="btn btn-sm me-1" onclick="editcollections(${d.id})">
                            <i class="fe fe-edit"></i>
                        </button>
                        <button class="btn btn-sm" onclick="deletecollections(${d.id})">
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

/* ---------------- 🔥 IMAGE COMPRESSION ---------------- */
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
function editcollections(id) {
    $.get(`/admin/collections/${id}`, res => {
        const c = res.data;
        $('input[name="collections_id"]').val(c.id);
        $('input[name="name"]').val(c.name);
        if (c.image) {
            $('#imagePreview').attr('src', c.image).show();
        } else {
            $('#imagePreview').hide();
        }
        $('#add-category .modal-title').text('Edit collections');

        $('input[name="show_in_header"][value="' + (c.show_in_header ? 1 : 0) + '"]')
    .prop('checked', true);

        $('#add-category').modal('show');
    }).fail(function () {
        Swal.fire('Error', 'Failed to load collections data.', 'error');
    });
}

/* ---------------- DELETE ---------------- */
function deletecollections(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this collections?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/collections/${id}`,
                type: 'DELETE',
                success: function () {
                    Swal.fire('Deleted!', 'collections has been deleted.', 'success');
                    collectionsTable.ajax.reload(null, false);
                },
                error: function () {
                    Swal.fire('Error', 'Failed to delete collections.', 'error');
                }
            });
        }
    });
}

/* ---------------- CREATE / UPDATE ---------------- */
$('#collectionsForm').on('submit', function (e) {
    e.preventDefault();

    const $saveButton = $('#saveButton');
    $saveButton.prop('disabled', true).text('Saving...');

    const formData = new FormData(this);
    const id = $('input[name="collections_id"]').val();
    let url = '/admin/collections';

    if (id) {
        url = `/admin/collections/${id}`;
        formData.append('_method', 'PUT');
    }

    const savecollections = () => {
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                Swal.fire('Success', id ? 'collections updated!' : 'collections created!', 'success');
                $('#add-category').modal('hide');
                $('#collectionsForm')[0].reset();
                $('#imagePreview').hide();
                $('input[name="collections_id"]').val('');
                $('#add-category .modal-title').text('Add collections');
                collectionsTable.ajax.reload(null, false);
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
                    savecollections();
                },
                error: function () {
                    Swal.fire('Error', 'Failed to upload image.', 'error');
                    $saveButton.prop('disabled', false).text('Save');
                }
            });
        });
    } else {
        savecollections();
    }
});

function openAddCollection() {
    $('#collectionsForm')[0].reset();
    $('input[name="collections_id"]').val('');
    $('#imagePreview').hide().attr('src', '');
    $('#add-category .modal-title').text('Add collections');
    $('#saveButton').prop('disabled', false).text('Save');
}




$(document).on('click', '#addProductBtn', function () {

    openAddCollection();
});
</script>
@endpush
