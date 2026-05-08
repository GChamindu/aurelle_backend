<?php $page = 'sections'; ?>
@extends('layout.mainlayout_admin')

@section('content')
<div class="page-wrapper page-settings">
    <div class="content">

        @component('admin.components.pageheader')
        @slot('title') Sections @endslot
        @slot('text') Add Section @endslot
        @endcomponent

        <div class="row">
            <div class="col-12">
                <div class="table-responsive table-div">
                    <table class="table" id="sections-data">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
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
                <h5 class="modal-title">Add Section</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-0">
                <form id="sectionForm">
                    @csrf
                    <input type="hidden" name="section_id">

                    <div class="mb-3">
                        <label class="form-label">Section Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Status</label>

                        <label class="me-3">
                            <input type="radio" name="status" value="1" checked>
                            Active
                        </label>

                        <label>
                            <input type="radio" name="status" value="0">
                            Inactive
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* ---------------- CSRF ---------------- */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let sectionTable;

/* ---------------- DATATABLE ---------------- */
$(document).ready(function () {
    sectionTable = $('#sections-data').DataTable({
        ajax: {
            url: '/admin/sections/list',
            dataSrc: 'data'
        },
         order: [[0, 'desc']],
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'slug' },
            {
                data: 'status',
                render: s =>
                    s
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>'
            },
            {
                data: null,
                orderable: false,
                render: d => `
                    <button class="btn btn-sm me-1" onclick="editSection(${d.id})">
                        <i class="fe fe-edit"></i>
                    </button>
                    <button class="btn btn-sm" onclick="deleteSection(${d.id})">
                        <i class="fe fe-trash-2"></i>
                    </button>
                `
            }
        ],
        paging: true,
        searching: false,
        info: false
    });
});

/* ---------------- EDIT ---------------- */
function editSection(id) {
    $.get(`/admin/sections/${id}`, res => {
        const s = res.data;
        $('input[name="section_id"]').val(s.id);
        $('input[name="name"]').val(s.name);
        $(`input[name="status"][value="${s.status}"]`).prop('checked', true);

        $('#add-category .modal-title').text('Edit Section');
        $('#add-category').modal('show');
    });
}

/* ---------------- DELETE ---------------- */
function deleteSection(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this section?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then(result => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/sections/${id}`,
                type: 'DELETE',
                success: function () {
                    Swal.fire('Deleted!', 'Section has been deleted.', 'success');
                    sectionTable.ajax.reload(null, false);
                },
                error: function () {
                    Swal.fire('Error', 'Failed to delete section.', 'error');
                }
            });
        }
    });
}

/* ---------------- CREATE / UPDATE ---------------- */
$('#sectionForm').on('submit', function (e) {
    e.preventDefault();

    const $saveButton = $('#saveButton');
    $saveButton.prop('disabled', true).text('Saving...');

    const id = $('input[name="section_id"]').val();
    let url = '/admin/sections';

    let formData = $(this).serialize();

    if (id) {
        url = `/admin/sections/${id}`;
        formData += '&_method=PUT';
    }

    $.post(url, formData)
        .done(() => {
            Swal.fire('Success', id ? 'Section updated!' : 'Section created!', 'success');
            $('#add-section').modal('hide');
            $('#sectionForm')[0].reset();
            $('input[name="section_id"]').val('');
            $('#add-section .modal-title').text('Add Section');
            sectionTable.ajax.reload(null, false);
        })
        .fail(() => {
            Swal.fire('Error', 'Something went wrong.', 'error');
        })
        .always(() => {
            $saveButton.prop('disabled', false).text('Save');
        });
});


function openAddCategory() {
    // Reset form
    $('#sectionForm')[0].reset();

    // Clear hidden ID
    $('input[name="section_id"]').val('');

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
