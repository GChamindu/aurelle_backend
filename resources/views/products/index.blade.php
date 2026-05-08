<?php $page = 'add-page'; ?>
@extends('layout.mainlayout_admin')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-7 col-sm-12 m-auto">
                    <div class="content-page-header">
                        <h5 class="mb-2">Add Product</h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Product Id <span class="text-danger">*</span></label>
                                <input type="text" name="product_id" class="form-control" required>
                            </div>
                        </div>




                        {{-- <div class="col-lg-6">
                            <div class="form-group">
                                <label>Category </label>
                                <select class="select" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach (getAllCategories() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}


                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Categories</label>

                                <select class="select" name="categories[]" multiple required>
                                    @foreach (getAllCategories() as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>

                                {{-- <small class="text-muted">
                                    Hold <strong>Ctrl</strong> (Windows/Linux) or <strong>Cmd</strong> (Mac) to select
                                    multiple categories
                                </small> --}}
                            </div>
                        </div>



                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Slug <span class="text-danger"></span></label>
                                <input type="text" name="slug" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Available Sizes</label>
                                <select class="select" name="sizes[]" multiple>
                                    @foreach (getAllSizes() as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Unavailable Sizes (Main Color)</label>
                                <select class="select" name="main_unavailable_sizes[]" multiple>
                                    @foreach (getAllSizes() as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Old Price</label>
                                <input name="old_price" type="number" step="0.01" class="form-control">
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Price <span class="text-danger">*</span></label>
                                <input name="base_price" type="number" step="0.01" class="form-control" required>
                            </div>
                        </div>




                        <div class="mb-3 col-lg-12">
                            <label class="form-label">Keywords</label>
                            <input class="input-tags form-control" type="text" data-role="tagsinput" name="keywords"
                                value="fashion,men,women">
                        </div>

                        <div class="mb-4 col-lg-12">
                            <label class="form-label">Main Image <span class="text-danger">*</span></label>
                            <div class="upload-box main-upload">
                                <input type="file" class="imageInput" accept="image/*" hidden>
                                <div class="upload-placeholder">
                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                    <p>Click or drag image to upload</p>
                                </div>
                                <div class="image-preview d-none">
                                    <img class="previewImg">
                                    <span class="remove-btn">✕</span>
                                </div>
                                <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="main_image" class="imagePath">
                        </div>

                        <div class="mb-4 col-lg-12">
                            <label class="form-label">Hover Image <span class="text-danger">*</span></label>
                            <div class="upload-box hover-upload">
                                <!-- Unique class -->
                                <input type="file" class="imageInput" accept="image/*" hidden>
                                <div class="upload-placeholder">
                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                    <p>Click or drag image to upload</p>
                                </div>
                                <div class="image-preview d-none">
                                    <img class="previewImg">
                                    <span class="remove-btn">✕</span>
                                </div>
                                <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="hover_image" class="imagePath">
                        </div>

                        <div class="mb-4 col-lg-12">
                            <label class="form-label">Size Chart Image <span class="text-danger">*</span></label>
                            <div class="upload-box size-chart-upload">
                                <!-- changed class name to avoid conflict -->
                                <input type="file" class="imageInput" accept="image/*" hidden>
                                <div class="upload-placeholder">
                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                    <p>Click or drag size chart image to upload</p>
                                </div>
                                <div class="image-preview d-none">
                                    <img class="previewImg">
                                    <span class="remove-btn">✕</span>
                                </div>
                                <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="size_chart_image" class="imagePath">
                        </div>

                        <div class="col-lg-12 mt-3">
                            <label>Other Images (Multiple)</label>
                            <div class="upload-box gallery-upload">
                                <input type="file" class="imageInput" accept="image/*" multiple hidden>

                                <div class="upload-placeholder">
                                    <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                    <p>Click or drag images</p>
                                </div>

                                <div class="gallery-preview" data-name="main_other_images[]"></div>

                                <div class="progress-bar-container d-none mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- REMOVED THIS LINE COMPLETELY -->
                        <!-- <input type="hidden" name="main_other_images[]" value=""> -->

                        <div class="mb-4 col-lg-12">
                            <label class="form-label">Description</label>
                            <textarea id="editor" name="description"></textarea>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Main Image Color Name<span class="text-danger">*</span></label>
                                <input type="text" name="main_image_colorname" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Main Image Color<span class="text-danger">*</span></label>
                                <input type="text" name="main_image_color_code" class="form-control" required>
                            </div>
                        </div>

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
                                                    <input type="checkbox" name="show_areas[]" value="{{ $area->id }}">
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

                        <div class="col-lg-12">
                            <h3>Color Variants</h3>
                            <div id="colorVariants"></div>
                            <div class="mt-3">
                                <button type="button" id="addColorBtn" class="btn btn-primary">Add Color
                                    Variant</button>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-4">
                            <div class="btn-path">
                                <a href="{{ url()->previous() }}" class="btn btn-cancel me-3">Cancel</a>
                                <button type="submit" class="btn btn-primary">Add Product</button>
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
    CKEDITOR.replace('editor');

    const uploadEndpoint = '{{ route("upload.products") }}';
    const storeEndpoint = '{{ route("store.products") }}';

    async function compressAndUpload(file, progressCallback) {
        const options = {
            maxSizeMB: 1,
            maxWidthOrHeight: 1920,
            useWebWorker: true,
            initialQuality: 0.85
        };
        const compressedFile = await imageCompression(file, options);
        const formData = new FormData();
        formData.append('file', compressedFile);

        return axios.post(uploadEndpoint, formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: progressCallback
        });
    }

   function initSelects(context = document) {
        $(context).find('select.select').each(function () {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2({
                    width: '100%',
                    placeholder: 'Select Sizes'
                });
            }
        });
    }

    $(document).ready(function () {
        initSelects();
    });

    function setupUploadBox(box) {
        const input = box.find('.imageInput')[0];
        const placeholder = box.find('.upload-placeholder');
        const preview = box.find('.image-preview');
        const previewImg = preview.find('.previewImg')[0];
        const removeBtn = preview.find('.remove-btn');
        const pathInput = box.closest('.form-group, .col-lg-12').find('.imagePath').length ?
                          box.closest('.form-group, .col-lg-12').find('.imagePath') :
                          box.find('.mainPath');
        const gallery = box.find('.gallery-preview');
        const progressContainer = box.find('.progress-bar-container');
        const progressBar = progressContainer.find('.progress-bar');

        box.on('click', '.upload-placeholder', function() {
            input.click();
        });

        box.on('dragover', function(e) { e.preventDefault(); box.css('border-color', '#007bff'); });
        box.on('dragleave', function() { box.css('border-color', '#e2e2e2'); });
        box.on('drop', function(e) {
            e.preventDefault();
            box.css('border-color', '#e2e2e2');
            if (e.originalEvent.dataTransfer.files.length) {
                input.files = e.originalEvent.dataTransfer.files;
                handleFiles(input.files);
            }
        });

        input.addEventListener('change', () => handleFiles(input.files));

        function handleFiles(files) {
            if (files.length === 0) return;

            if (gallery.length) {
                Array.from(files).forEach(file => uploadImage(file, false));
            } else {
                uploadImage(files[0], true);
            }
        }

        async function uploadImage(file, isSingle) {
            progressContainer.removeClass('d-none');
            progressBar.css('width', '0%').text('0%');

            try {
                const response = await compressAndUpload(file, (progressEvent) => {
                    const percent = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressBar.css('width', percent + '%').text(percent + '%');
                });

                const url = response.data.url;
                const path = response.data.path;

                if (isSingle) {
                    placeholder.addClass('d-none');
                    preview.removeClass('d-none');
                    previewImg.src = url;
                    pathInput.val(path);
                } else {
                    const item = $(`
                        <div class="gallery-item">
                            <img src="${url}">
                            <span class="remove-btn">✕</span>
                            <input type="hidden" name="${gallery.data('name')}" value="${path}">
                        </div>
                    `);
                    gallery.append(item);
                }
                progressContainer.addClass('d-none');
            } catch (err) {
                alert('Upload failed: ' + (err.response?.data?.message || err.message));
                progressContainer.addClass('d-none');
            }
        }

        removeBtn.on('click', function() {
            placeholder.removeClass('d-none');
            preview.addClass('d-none');
            previewImg.src = '';
            pathInput.val('');
            input.value = '';
        });

        gallery.on('click', '.remove-btn', function() {
            $(this).parent().remove();
        });
    }

    setupUploadBox($('.main-upload'));
    setupUploadBox($('.hover-upload'));
    setupUploadBox($('.gallery-upload'));
    setupUploadBox($('.size-chart-upload'));

    let colorIndex = 0;
    $('#addColorBtn').on('click', function() {

        // const newVariant = $(`.variant-block[data-index="${colorIndex}"]`);

        colorIndex++;
        const variantHtml = `
            <div class="card mt-3 p-3 variant-block" data-index="${colorIndex}">
                <div class="row">
                    <div class="col-lg-6">
                        <label>Color Name</label>
                        <input type="text" name="colors[${colorIndex}][name]" class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label>Color Code (e.g. ff0000)</label>
                        <input type="text" name="colors[${colorIndex}][code]" class="form-control">
                    </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <label>Unavailable Sizes</label>
                            <select class="select" name="colors[${colorIndex}][unavailable_sizes][]" multiple>
                                @foreach (getAllSizes() as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3">
                        <label>Main Image for this Color</label>
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
                            <div class="progress-bar-container d-none mt-2">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="colors[${colorIndex}][main_image]" class="imagePath mainPath">
                    </div>

                    <div class="col-lg-12 mt-3">
                        <label>Other Images for this Color (Multiple)</label>
                        <div class="upload-box">
                            <input type="file" class="imageInput" accept="image/*" multiple hidden>
                            <div class="upload-placeholder">
                                <img src="{{ asset('admin_assets/img/icons/upload.svg') }}">
                                <p>Click or drag images</p>
                            </div>
                            <div class="gallery-preview" data-name="colors[${colorIndex}][other_images][]"></div>
                            <div class="progress-bar-container d-none mt-2">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;">0%</div>
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
        // $('#colorVariants').append(variantHtml);

           const $variant = $(variantHtml).appendTo('#colorVariants');


        initSelects($variant);
        setupUploadBox($(`.variant-block[data-index="${colorIndex}"] .color-main-upload`));
        setupUploadBox($(`.variant-block[data-index="${colorIndex}"] .upload-box`).last());

    });

    $('#colorVariants').on('click', '.remove-variant', function() {
        $(this).closest('.variant-block').remove();
    });

    async function storeData() {
        const description = CKEDITOR.instances.editor.getData();
        const formData = new FormData();

        formData.append('name', $('input[name="name"]').val());
        formData.append('base_price', $('input[name="base_price"]').val());
                formData.append('old_price', $('input[name="old_price"]').val());

        // formData.append('category_id', $('select[name="category_id"]').val());
        $('select[name="categories[]"] option:selected').each(function () {
            formData.append('categories[]', $(this).val());
        });

        formData.append('description', description);
        formData.append('main_image', $('input[name="main_image"]').val());
        formData.append('hover_image', $('input[name="hover_image"]').val());
        formData.append('size_chart_image', $('input[name="size_chart_image"]').val());

        formData.append('main_image_colorname', $('input[name="main_image_colorname"]').val());
        formData.append('main_image_color_code', $('input[name="main_image_color_code"]').val());

        formData.append('product_id', $('input[name="product_id"]').val());

        $('select[name="main_unavailable_sizes[]"] option:selected').each(function () {
            formData.append('main_unavailable_sizes[]', $(this).val());
        });

        $('input[name="main_other_images[]"]').each(function () {
            formData.append('main_other_images[]', $(this).val());
        });

        if ($('input[name="keywords"]').val()) {
            formData.append('keywords', $('input[name="keywords"]').val());
        }

        $('input[name="show_areas[]"]:checked').each(function () {
            formData.append('show_areas[]', $(this).val());
        });

        $('select[name="sizes[]"] option:selected').each(function() {
            if ($(this).val() !== 'all') {
                formData.append('sizes[]', $(this).val());
            }
        });



        let hasColors = false;

        $('.variant-block').each(function() {
            const index = $(this).data('index');
            const colorName = $(this).find(`input[name="colors[${index}][name]"]`).val().trim();
            const colorCode = $(this).find(`input[name="colors[${index}][code]"]`).val().trim();
            const mainImage = $(this).find(`input[name="colors[${index}][main_image]"]`).val().trim();

            if (colorName && colorCode && mainImage) {
                hasColors = true;
                formData.append(`colors[${index}][name]`, colorName);
                formData.append(`colors[${index}][code]`, colorCode);
                formData.append(`colors[${index}][main_image]`, mainImage);

                $(this).find(`input[name="colors[${index}][other_images][]"]`).each(function() {
                    const val = $(this).val().trim();
                    if (val) formData.append(`colors[${index}][other_images][]`, val);
                });
                   $(this).find(`select[name="colors[${index}][unavailable_sizes][]"] option:selected`).each(function () {
                formData.append(
                `colors[${index}][unavailable_sizes][]`,
                $(this).val()
            );
        });
            }
        });

//         if (!hasColors) {
// formData.append('colors', JSON.stringify([]));        }

        const submitBtn = $('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Saving...');

        try {
            const response = await axios.post(storeEndpoint, formData, {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            alert('Product added successfully!');
            window.location.href = '{{ route("admin.products") }}';
        } catch (error) {
            const msg = error.response?.data?.message || 'Something went wrong';
            alert('Error: ' + msg);
            console.error(error);
        } finally {
            submitBtn.prop('disabled', false).text('Add Product');
        }
    }

    $('form').on('submit', function(e) {
        e.preventDefault();
        storeData();
    });
</script>
@endpush
