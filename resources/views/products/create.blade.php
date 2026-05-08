
<?php $page = 'products'; ?>
@extends('layout.mainlayout_admin')

@section('content')
<div class="page-wrapper page-settings">
    <div class="content">
        @component('admin.components.pageheader')
            @slot('title') Products @endslot
            @slot('text') Manage Products @endslot
        @endcomponent

        <!-- Add "Add Product" button on the page -->
        <div class="row mb-3">
            <div class="col-12 text-end">
                {{-- <button type="button" class="btn btn-primary" id="addProductBtn">
                    <i class="fe fe-plus"></i> Add New Product
                </button> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover" id="products-data">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Base Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="productForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="">

                    <!-- Basic Info -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach(App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Base Price <span class="text-danger">*</span></label>
                            <input type="number" name="base_price" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Variants & Inventory -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Variants (Colors)</h6>
                            <button type="button" class="btn btn-sm btn-success" id="addColorBtn">Add Color</button>
                        </div>
                        <div id="colors-wrapper"></div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let colorCounter = 0;
let allSizes = @json(App\Models\Size::orderBy('id')->get());

// Render existing image with checkbox for primary
function renderExistingImage(img, primaryId, colorIdx) {
    const checked = img.id == primaryId ? 'checked' : '';
    return `
    <div class="position-relative me-3 mb-3" style="width:120px;height:120px;" data-image-id="${img.id}">
        <img src="/storage/${img.image_path}" class="img-thumbnail w-100 h-100" style="object-fit:cover">
        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-existing-image">×</button>
        <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white p-1 w-100 text-center">
            <label class="form-check form-check-inline mb-0">
                <input class="form-check-input primary-image-checkbox" type="checkbox"
                       name="colors[${colorIdx}][primary_image_id]" value="${img.id}" ${checked}>
                <small>Main Image</small>
            </label>
        </div>
    </div>`;
}

// Add new color section
function addColorSection(colorData = null) {
    colorCounter++;
    const idx = colorCounter;

    let imagesHtml = '';
    let primaryId = null;

    if (colorData) {
        primaryId = colorData.images?.find(i => i.is_primary)?.id || null;
        (colorData.images || []).forEach(img => {
            imagesHtml += renderExistingImage(img, primaryId, idx);
        });
    }

    const sectionHtml = `
    <div class="card mb-3 color-section" data-index="${idx}">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Color Variant ${idx}</span>
            <button type="button" class="btn btn-sm btn-danger remove-color">Delete Color</button>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Color Name <span class="text-danger">*</span></label>
                    <input type="text" name="colors[${idx}][name]" class="form-control" value="${colorData?.name || ''}" required>
                    <input type="hidden" name="colors[${idx}][color_id]" value="${colorData?.id || ''}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Color Code (Hex) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="colors[${idx}][code]" class="form-control" value="${colorData?.code || ''}" required>
                        <input type="color" class="form-control form-control-color" onchange="this.previousElementSibling.value = this.value">
                    </div>
                </div>
            </div>

            <!-- Images Upload & Preview -->
            <div class="mb-4">
                <label class="form-label">Images for this color</label>
                <input type="file" name="colors[${idx}][new_images][]" class="form-control mb-3" accept="image/*" multiple>
                <div class="d-flex flex-wrap" id="images-preview-${idx}">
                    ${imagesHtml}
                </div>
                <input type="hidden" name="colors[${idx}][delete_images]" value="">
            </div>

            <!-- Available Sizes -->
            <div class="mb-3">
                <label class="form-label">Available Sizes</label>
                <div class="row">
                    ${allSizes.map(size => {
                        const variant = colorData?.variants?.find(v => v.size_id == size.id);
                        const checked = variant ? 'checked' : '';
                        const display = variant ? 'block' : 'none';
                        const priceVal = variant?.price || '';
                        const stockVal = variant?.stock || 0;
                        const variantId = variant?.id || '';

                        return `
                        <div class="col-md-4 col-lg-3 mb-3">
                            <div class="form-check">
                                <input class="form-check-input size-checkbox" type="checkbox" id="size-${idx}-${size.id}"
                                       ${checked}>
                                <label class="form-check-label fw-bold" for="size-${idx}-${size.id}">${size.name}</label>
                            </div>
                            <div class="variant-details ms-4 mt-2" style="display:${display};">
                                <input type="hidden" name="colors[${idx}][variants][${size.id}][size_id]" value="${size.id}">
                                <input type="hidden" name="colors[${idx}][variants][${size.id}][variant_id]" value="${variantId}">
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text">Price</span>
                                    <input type="number" name="colors[${idx}][variants][${size.id}][price]" class="form-control" step="0.01"
                                           value="${priceVal}" placeholder="Use base">
                                </div>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Stock</span>
                                    <input type="number" name="colors[${idx}][variants][${size.id}][stock]" class="form-control"
                                           value="${stockVal}" min="0">
                                </div>
                            </div>
                        </div>`;
                    }).join('')}
                </div>
            </div>
        </div>
    </div>`;
    $('#colors-wrapper').append(sectionHtml);
    initImagePreview(idx);
}

// Preview new uploaded images with "Main Image" checkbox
function initImagePreview(idx) {
    $(`input[name="colors[${idx}][new_images][]"]`).off('change').on('change', function(e) {
        const files = e.target.files;
        for (let file of files) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const wrapper = $(`
                <div class="position-relative me-3 mb-3" style="width:120px;height:120px;">
                    <img src="${ev.target.result}" class="img-thumbnail w-100 h-100" style="object-fit:cover">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0">×</button>
                    <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white p-1 w-100 text-center">
                        <label class="form-check form-check-inline mb-0">
                            <input class="form-check-input primary-image-checkbox" type="checkbox"
                                   name="colors[${idx}][primary_image_id]" value="new-${Date.now()}">
                            <small>Main Image</small>
                        </label>
                    </div>
                </div>`);

                wrapper.find('button').on('click', () => wrapper.remove());
                $(`#images-preview-${idx}`).append(wrapper);
            };
            reader.readAsDataURL(file);
        }
        // Clear input to allow re-upload of same files
        this.value = '';
    });
}

// Events
$(document).on('click', '#addColorBtn', () => addColorSection());

$(document).on('click', '.remove-color', function() {
    $(this).closest('.color-section').remove();
});

$(document).on('change', '.size-checkbox', function() {
    $(this).closest('.col-md-4, .col-lg-3').find('.variant-details').toggle(this.checked);
});

$(document).on('click', '.delete-existing-image', function() {
    const wrapper = $(this).closest('[data-image-id]');
    const colorIdx = wrapper.closest('.color-section').data('index');
    const imageId = wrapper.data('image-id');

    wrapper.remove();

    let deleted = $(`input[name="colors[${colorIdx}][delete_images]"]`).val().split(',').filter(Boolean);
    deleted.push(imageId);
    $(`input[name="colors[${colorIdx}][delete_images]"]`).val(deleted.join(','));
});

// Ensure only one primary image per color
$(document).on('change', '.primary-image-checkbox', function() {
    if (this.checked) {
        const colorIdx = $(this).closest('.color-section').data('index');
        $(`#images-preview-${colorIdx} .primary-image-checkbox`).not(this).prop('checked', false);
    }
});

// Open Add Modal
$(document).on('click', '#addProductBtn', function () {
    $('#productForm')[0].reset();
    $('input[name="product_id"]').val('');
    $('.modal-title').text('Add Product');
    $('#colors-wrapper').empty();
    colorCounter = 0;
    addColorSection(); // Add first color by default
    $('#productModal').modal('show');
});

// Edit Product
window.editProduct = function (id) {
    $.get(`/admin/products/${id}`, function (res) {
        if (res.success && res.data) {
            const p = res.data;
            $('#productForm')[0].reset();
            $('input[name="product_id"]').val(p.id);
            $('input[name="name"]').val(p.name);
            $('select[name="category_id"]').val(p.category_id);
            $('input[name="base_price"]').val(p.base_price);
            $('textarea[name="description"]').val(p.description || '');
            $('.modal-title').text('Edit Product');

            $('#colors-wrapper').empty();
            colorCounter = 0;

            (p.colors || []).forEach(color => {
                addColorSection({
                    id: color.id,
                    name: color.name,
                    code: color.code,
                    images: color.images || [],
                    variants: color.variants || []
                });
            });

            if ((p.colors || []).length === 0) addColorSection();

            $('#productModal').modal('show');
        }
    });
};

// Delete Product
window.deleteProduct = function (id) {
    if (confirm('Are you sure you want to delete this product?')) {
        $.ajax({
            url: `/admin/products/${id}`,
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: () => $('#products-data').DataTable().ajax.reload()
        });
    }
};

// Form Submit
$('#productForm').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const id = $('input[name="product_id"]').val();
    const url = id ? `/admin/products/${id}` : '/admin/products';
    if (id) formData.append('_method', 'PUT');

    $.ajax({
        url,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: () => {
            $('#productModal').modal('hide');
            $('#products-data').DataTable().ajax.reload();
        },
        error: (xhr) => {
            alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
        }
    });
});

// DataTable
$('#products-data').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("admin.products.list") }}',
    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'category.name' },
        { data: 'base_price', render: d => 'Rs ' + parseFloat(d).toFixed(2) },
        {
            data: null,
            orderable: false,
            className: 'text-end',
            render: data => `
                <button class="btn btn-sm btn-primary me-2" onclick="editProduct(${data.id})">
                    <i class="fe fe-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${data.id})">
                    <i class="fe fe-trash-2"></i>
                </button>
            `
        }
    ]
});
</script>
@endpush

