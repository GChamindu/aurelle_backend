<?php $page = 'edit-page'; ?>
@extends('layout.mainlayout_admin')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <form id="productForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-7 col-sm-12 m-auto">
                    <div class="content-page-header">
                        <h5 class="mb-2">Edit Product</h5>
                    </div>

                    <div class="row">
                        <!-- Name -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Namessssssssss <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $product->name) }}" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Sections <span class="text-danger">*</span></label>
                                <select class="select" name="section_id" required>
                                    <option value="">Select Sections</option>
                                    @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" {{ $product->sections->contains('id',
                                        $section->id) ? 'selected' : '' }}>
                                        {{ $section->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Product ID -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Product Id <span class="text-danger">*</span></label>
                                <input type="text" name="product_id" class="form-control"
                                    value="{{ old('product_id', $product->product_id) }}" required>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Category <span class="text-danger">*</span></label>
                                <select class="select" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach (getAllCategories() as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) ==
                                        $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                         <!-- Slug -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Slug</label>
                                <input type="text" name="slug" class="form-control"
                                    value="{{ old('slug', $product->slug) }}">
                            </div>
                        </div>

                        <!-- Sizes -->
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Available Sizes <span class="text-danger">*</span></label>
                                <select class="select" name="sizes[]" multiple required>
                                    @foreach (getAllSizes() as $size)
                                    <option value="{{ $size->id }}" {{ in_array($size->id, old('sizes',
                                        $product->variants->pluck('size_id')->unique()->toArray())) ? 'selected' : ''
                                        }}>
                                        {{ $size->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                         <!--Old  Price -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Price</span></label>
                                <input name="base_price" type="number" step="0.01" class="form-control"
                                    value="{{ old('old_price', $product->old_price) }}">
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Price <span class="text-danger">*</span></label>
                                <input name="base_price" type="number" step="0.01" class="form-control"
                                    value="{{ old('base_price', $product->base_price) }}" required>
                            </div>
                        </div>



                        <!-- Keywords -->
                        <div class="mb-3 col-lg-12">
                            <label class="form-label">Keywords</label>
                            <input class="input-tags form-control" type="text" data-role="tagsinput" name="keywords"
                                value="{{ old('keywords', $product->keywords ? implode(',', json_decode($product->keywords, true)) : '') }}">
                        </div>

                        <!-- Main Image -->
                        <div class="mb-4 col-lg-12">
                            <label class="form-label">Main Image <span class="text-danger">*</span></label>
                            <div class="upload-box main-upload">
                                <input type="file" class="imageInput" accept="image/*" hidden>
                                @if($mainImage = $product->images->firstWhere('image_type',
                                \App\Enums\ProductImageType::DEFAULT_MAIN))
                                <div class="image-preview">
                                    <img class="previewImg"
                                        src="{{ \App\Helpers\R2Helper::getFileUrl($mainImage->image_path) }}">
                                    <span class="remove-btn">✕</span>
                                </div>
                                <input type="hidden" name="main_image" class="imagePath"
                                    value="{{ $mainImage->image_path }}">
                                @else
                                <div class="upload-placeholder">
                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                    <p>Click or drag image to upload</p>
                                </div>
                                <input type="hidden" name="main_image" class="imagePath">
                                @endif
                                <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hover Image -->
                        <div class="mb-4 col-lg-12">
                            <label class="form-label">Hover Image <span class="text-danger">*</span></label>
                            <div class="upload-box hover-upload">
                                <input type="file" class="imageInput" accept="image/*" hidden>
                                @if($hoverImage = $product->images->firstWhere('image_type',
                                \App\Enums\ProductImageType::DEFAULT_HOVER))
                                <div class="image-preview">
                                    <img class="previewImg"
                                        src="{{ \App\Helpers\R2Helper::getFileUrl($hoverImage->image_path) }}">
                                    <span class="remove-btn">✕</span>
                                </div>
                                <input type="hidden" name="hover_image" class="imagePath"
                                    value="{{ $hoverImage->image_path }}">
                                @else
                                <div class="upload-placeholder">
                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                    <p>Click or drag image to upload</p>
                                </div>
                                <input type="hidden" name="hover_image" class="imagePath">
                                @endif
                                <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Size Chart Image (NEW) -->
                        <!-- Size Chart Image (NEW) – preview div is ALWAYS present -->
                        <div class="mb-4 col-lg-12">
                            <label class="form-label">Size Chart Image</label>
                            <div class="upload-box size-chart-upload">
                                <input type="file" class="imageInput" accept="image/*" hidden>

                                <!-- Always render preview div – hide it if no image -->
                                <div class="image-preview {{ $product->size_chart_image ? '' : 'd-none' }}">
                                    <img class="previewImg"
                                        src="{{ $product->size_chart_image ? \App\Helpers\R2Helper::getFileUrl($product->size_chart_image) : '' }}"
                                        alt="Size Chart Preview">
                                    <span class="remove-btn">✕</span>
                                </div>

                                <!-- Placeholder only shown when no image -->
                                <div class="upload-placeholder {{ $product->size_chart_image ? 'd-none' : '' }}">
                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                    <p>Click or drag size chart image to upload</p>
                                </div>

                                <input type="hidden" name="size_chart_image" class="imagePath"
                                    value="{{ $product->size_chart_image ?? '' }}">

                                <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- Gallery -->
                        <div class="col-lg-12 mt-3">
                            <label>Other Images (Multiple)</label>
                            <div class="upload-box gallery-upload">
                                <input type="file" class="imageInput" accept="image/*" multiple hidden>
                                <div class="upload-placeholder">
                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                    <p>Click or drag images</p>
                                </div>
                                <div class="gallery-preview" data-name="main_other_images[]">
                                    @php
                                    $mainColorId = $product->images->firstWhere('image_type',
                                    \App\Enums\ProductImageType::DEFAULT_MAIN)?->color_id;
                                    @endphp
                                    @foreach($product->images->where('image_type',
                                    \App\Enums\ProductImageType::GALLERY)->where('color_id', $mainColorId) as $img)
                                    <div class="gallery-item">
                                        <img src="{{ \App\Helpers\R2Helper::getFileUrl($img->image_path) }}">
                                        <span class="remove-btn">✕</span>
                                        <input type="hidden" name="main_other_images[]" value="{{ $img->image_path }}">
                                    </div>
                                    @endforeach
                                </div>
                                <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4 col-lg-12">
                            <label class="form-label">Description</label>
                            <textarea id="editor"
                                name="description">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <!-- Main Color -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Main Image Color Name <span class="text-danger">*</span></label>
                                <input type="text" name="main_image_colorname" class="form-control"
                                    value="{{ old('main_image_colorname', $mainColor?->name ?? '') }}" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Main Image Color <span class="text-danger">*</span></label>
                                <input type="text" name="main_image_color_code" class="form-control"
                                    value="#{{ old('main_image_color_code', $mainColor?->code ?? '') }}" required>
                            </div>
                        </div>

                        <!-- Show Areas -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6>Show Area</h6>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="custom-checkboxbtn">
                                            @foreach (getAllShowAreas() as $area)
                                            <li>
                                                <label class="checkboxsets">
                                                    <input type="checkbox" name="show_areas[]" value="{{ $area->id }}"
                                                        {{ in_array($area->id, old('show_areas',
                                                    $product->showAreas->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                    <span class="checkmark-checkbox"></span>
                                                    {{ $area->name }}
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Color Variants -->
                        <div class="col-lg-12">
                            <h3>Color Variants</h3>
                            <div id="colorVariants">

                                @if($product->images->where('image_type',
                                \App\Enums\ProductImageType::VARIANT_MAIN)->isNotEmpty())


                                @foreach($product->variants->groupBy('color_id') as $loopIndex => $variantGroup)
                                @php
                                $color = $variantGroup->first()->color;
                                $mainImg = $product->images->where('image_type',
                                \App\Enums\ProductImageType::VARIANT_MAIN)
                                ->where('color_id', $color->id)->first();
                                $galleryImgs = $product->images->where('image_type',
                                \App\Enums\ProductImageType::GALLERY)
                                ->where('color_id', $color->id);
                                @endphp
                                <div class="card mt-3 p-3 variant-block" data-index="{{ $loopIndex }}">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Color Name</label>
                                            <input type="text" name="colors[{{ $loopIndex }}][name]"
                                                class="form-control" value="{{ old(" colors.$loopIndex.name",
                                                $color->name) }}" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Color Code</label>
                                            <input type="text" name="colors[{{ $loopIndex }}][code]"
                                                class="form-control" value="#{{ old(" colors.$loopIndex.code",
                                                $color->code) }}" required>
                                        </div>

                                        <!-- Variant Main Image -->
                                        <div class="col-lg-12 mt-3">
                                            <label>Main Image for this Color</label>
                                            <div class="upload-box color-main-upload">
                                                <input type="file" class="imageInput" accept="image/*" hidden>
                                                @if($mainImg)
                                                <div class="image-preview">
                                                    <img class="previewImg"
                                                        src="{{ \App\Helpers\R2Helper::getFileUrl($mainImg->image_path) }}">
                                                    <span class="remove-btn">✕</span>
                                                </div>
                                                <input type="hidden" name="colors[{{ $loopIndex }}][main_image]"
                                                    class="imagePath mainPath" value="{{ $mainImg->image_path }}">
                                                @else
                                                <div class="upload-placeholder">
                                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                                    <p>Click or drag image</p>
                                                </div>
                                                <input type="hidden" name="colors[{{ $loopIndex }}][main_image]"
                                                    class="imagePath mainPath">
                                                @endif
                                                <div class="progress-bar-container d-none mt-2">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar">0%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Variant Gallery -->
                                        <div class="col-lg-12 mt-3">
                                            <label>Other Images for this Color (Multiple)</label>
                                            <div class="upload-box">
                                                <input type="file" class="imageInput" accept="image/*" multiple hidden>
                                                <div class="upload-placeholder">
                                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                                    <p>Click or drag images</p>
                                                </div>
                                                <div class="gallery-preview"
                                                    data-name="colors[{{ $loopIndex }}][other_images][]">
                                                    @foreach($galleryImgs as $img)
                                                    <div class="gallery-item">
                                                        <img
                                                            src="{{ \App\Helpers\R2Helper::getFileUrl($img->image_path) }}">
                                                        <span class="remove-btn">✕</span>
                                                        <input type="hidden"
                                                            name="colors[{{ $loopIndex }}][other_images][]"
                                                            value="{{ $img->image_path }}">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="progress-bar-container d-none mt-2">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar">0%</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-3 text-end">
                                            <button type="button" class="btn btn-danger remove-variant">Remove
                                                Variant</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @endif



                            </div>

                            <div class=" mt-3">
                                <button type="button" id="addColorBtn" class="btn btn-primary">Add Color
                                    Variant</button>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 mt-4">
                            <div class="btn-path">
                                <a href="{{ route('admin.products') }}" class="btn btn-cancel me-3">Cancel</a>
                                <button type="submit" id="updateButton" class="btn btn-primary">Update Product</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .upload-box {
        border: 2px dashed #e2e2e2;
        padding: 25px;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        position: relative;
    }

    .upload-placeholder img {
        width: 50px;
        opacity: 0.6;
    }

    .upload-placeholder p {
        margin-top: 10px;
        color: #666;
    }

    .image-preview {
        position: relative;
        display: inline-block;
    }

    .image-preview img {
        width: 100%;
        max-height: 300px;
        object-fit: contain;
        border-radius: 8px;
    }

    .remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff3b3b;
        color: #fff;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        z-index: 10;
    }

    .gallery-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .gallery-item {
        position: relative;
        width: 150px;
    }

    .gallery-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

    .gallery-item .remove-btn {
        top: 5px;
        right: 5px;
    }

    .progress {
        height: 20px;
        background: #f0f0f0;
    }

    .progress-bar {
        background: #007bff;
        color: white;
        text-align: center;
    }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('editor', { height: 300 });

    const uploadEndpoint = '{{ route("upload.products") }}';
    const updateEndpoint = '{{ route("admin.section.products.update", $product->id) }}';

    // Compress & Upload (unchanged)
    async function compressAndUpload(file, progressCallback) {
        const options = { maxSizeMB: 1, maxWidthOrHeight: 1920, useWebWorker: true, initialQuality: 0.85 };
        const compressed = await imageCompression(file, options);
        const formData = new FormData();
        formData.append('file', compressed);
        return axios.post(uploadEndpoint, formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: progressCallback
        });
    }

    // Create placeholder if missing (unchanged)
    function createPlaceholder(box) {
        if (box.find('.upload-placeholder').length === 0) {
            const html = `
                <div class="upload-placeholder">
                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                    <p>Click or drag image to upload</p>
                </div>
            `;
            box.prepend(html);
        }
        return box.find('.upload-placeholder');
    }

    // Ensure hidden path input (unchanged)
    function ensurePathInput(box, index = null) {
        let pathInput = box.find('.imagePath');

        if (pathInput.length === 0) {
            let nameAttr = 'main_image';
            if (index !== null) {
                nameAttr = `colors[${index}][main_image]`;
            } else if (box.closest('.variant-block').length > 0) {
                const variantIndex = box.closest('.variant-block').data('index');
                nameAttr = `colors[${variantIndex}][main_image]`;
            }

            const inputHtml = `<input type="hidden" name="${nameAttr}" class="imagePath mainPath" value="">`;
            box.append(inputHtml);
            pathInput = box.find('.imagePath');
        }

        return pathInput;
    }

    // Setup Upload Box – only remove handler is improved
    function setupUploadBox(box) {
        if (!box.length) return;

        const isGallery = box.hasClass('gallery-upload') || box.find('.gallery-preview').length > 0;
        const input = box.find('.imageInput')[0];
        if (!input) return;

        let placeholder = box.find('.upload-placeholder');
        const preview = box.find('.image-preview');
        const progressContainer = box.find('.progress-bar-container');
        const progressBar = progressContainer.find('.progress-bar');

        if (placeholder.length === 0 && preview.length > 0) {
            placeholder = createPlaceholder(box);
            placeholder.hide();
        }

        placeholder.on('click', function(e) {
            e.stopPropagation();
            input.click();
        });

        box.on('dragover', e => { e.preventDefault(); box.css('border-color', '#007bff'); });
        box.on('dragleave drop', () => box.css('border-color', '#e2e2e2'));

        box.on('drop', e => {
            e.preventDefault();
            if (e.originalEvent.dataTransfer?.files?.length) {
                input.files = e.originalEvent.dataTransfer.files;
                handleFiles(input.files);
            }
        });

        input.addEventListener('change', () => {
            if (input.files.length) handleFiles(input.files);
        });

        function handleFiles(files) {
            if (!files.length) return;

            if (isGallery) {
                Array.from(files).forEach(file => uploadImage(file, false));
            } else {
                uploadImage(files[0], true);
            }
        }

        async function uploadImage(file, isSingle) {
            progressContainer.removeClass('d-none');
            progressBar.css('width', '0%').text('0%');

            try {
                const res = await compressAndUpload(file, e => {
                    const p = Math.round((e.loaded * 100) / e.total);
                    progressBar.css('width', p + '%').text(p + '%');
                });

                const { url, path } = res.data;

                if (isSingle) {
                    placeholder.hide();
                    preview.removeClass('d-none');

                    const img = preview.find('.previewImg');
                    if (img.length === 0) {
                        preview.html('<img class="previewImg" src="' + url + '">');
                    } else {
                        img[0].src = url;
                    }

                    const pathInput = box.find('.imagePath');
                    if (pathInput.length) {
                        pathInput.val(path);
                    }
                } else {
                    const gallery = box.find('.gallery-preview');
                    gallery.append(`
                        <div class="gallery-item">
                            <img src="${url}">
                            <span class="remove-btn">✕</span>
                            <input type="hidden" name="${gallery.data('name')}" value="${path}">
                        </div>
                    `);
                }
            } catch (err) {
                Swal.fire('Error', 'Upload failed: ' + (err.response?.data?.message || err.message), 'error');
            } finally {
                progressContainer.addClass('d-none');
            }
        }

        // FIXED REMOVE HANDLER – this makes it work after remove
        box.on('click', '.remove-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const container = $(this).closest('.image-preview, .gallery-item');

            if (container.hasClass('image-preview')) {
                const preview = container;
                const pathInput = box.find('.imagePath');
                const fileInput = box.find('.imageInput')[0];

                // Hide preview
                preview.addClass('d-none');

                // Show placeholder (fresh lookup)
                let placeholder = box.find('.upload-placeholder');
                if (placeholder.length === 0) {
                    placeholder = createPlaceholder(box);
                }
                placeholder.removeClass('d-none').show();

                // Clear preview
                preview.find('.previewImg').attr('src', '');
                pathInput.val('');
                fileInput.value = '';

                // Re-attach click handler to placeholder
                placeholder.off('click').on('click', function(ev) {
                    ev.stopPropagation();
                    input.click();
                });

                // Allow clicking anywhere in the box to trigger file input (after remove)
                box.off('click.upload-trigger').on('click.upload-trigger', function(ev) {
                    if (!$(ev.target).is('.remove-btn') && !$(ev.target).closest('.remove-btn').length) {
                        input.click();
                    }
                });
            } else {
                container.remove();
            }
        });
    }

    // Initialize
    $(document).ready(function () {
        $('.upload-box').each(function () {
            setupUploadBox($(this));
        });

        // No need for extra setupUploadBox($('.size-chart-upload')) – loop already handles it

        // Add new color variant
        let colorIndex = {{ $product->variants->groupBy('color_id')->count() }};

    $('#addColorBtn').on('click', function () {
    const index = Date.now(); // ✅ unique index (BEST)

    const variantHtml = `
        <div class="card mt-3 p-3 variant-block" data-index="${index}">
            <div class="row">
                <div class="col-lg-6">
                    <label>Color Name</label>
                    <input type="text" name="colors[${index}][name]" class="form-control" required>
                </div>
                <div class="col-lg-6">
                    <label>Color Code</label>
                    <input type="text" name="colors[${index}][code]" class="form-control" required>
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Main Image</label>
                    <div class="upload-box color-main-upload">
                        <input type="file" class="imageInput" accept="image/*" hidden>
                        <div class="upload-placeholder">
                            <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                            <p>Click or drag image</p>
                        </div>
                        <div class="image-preview d-none">
                            <img class="previewImg">
                            <span class="remove-btn">✕</span>
                        </div>
                        <input type="hidden" name="colors[${index}][main_image]" class="imagePath">
                           <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar">0%</div>
                                    </div>
                                </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-3">
                    <label>Other Images</label>
                    <div class="upload-box">
                        <input type="file" class="imageInput" accept="image/*" multiple hidden>
                        <div class="upload-placeholder">
                            <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                            <p>Click or drag images</p>
                        </div>
                        <div class="gallery-preview" data-name="colors[${index}][other_images][]"></div>

                           <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar">0%</div>
                                    </div>
                                </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-3 text-end">
                    <button type="button" class="btn btn-danger remove-variant">Remove Variant</button>
                </div>
            </div>
        </div>
    `;

    $('#colorVariants').append(variantHtml);

    const newBlock = $(`.variant-block[data-index="${index}"]`);
    setupUploadBox(newBlock.find('.color-main-upload'));
    setupUploadBox(newBlock.find('.upload-box').last());
});


        $('#colorVariants').on('click', '.remove-variant', function () {
            $(this).closest('.variant-block').remove();
        });

        $('#productForm').on('submit', async function (e) {
            e.preventDefault();

            const submitBtn = $('#updateButton');
            submitBtn.prop('disabled', true).text('Updating...');

            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            try {
                const response = await axios.post(updateEndpoint, formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });

                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Product updated successfully',
                        confirmButtonText: 'OK',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.reload();
                    });
                }
            } catch (error) {
                Swal.fire('Error!', error.response?.data?.message || 'Update failed', 'error');
            } finally {
                submitBtn.prop('disabled', false).text('Update Product');
            }
        });
    });
</script>
@endpush
