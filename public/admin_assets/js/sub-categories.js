var jsonDataUrl = '../admin_assets/json/sub-categories.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/services/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#sub-categories-data')) {
            $('#sub-categories-data').DataTable().destroy();
        }
        var table = $('#sub-categories-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-imgname">
                                            <a href="view-service">
                                                <img src="${data.image}" class="me-2" alt="img">
                                                <span>${data.SubCategory}</span>
                                            </a>
                        </div>`;
                        return imageHtml;
                    }
                },
                { data: 'SubCategorySlug' },
                { data: 'Category' },
                { data: 'Date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                                <button class="btn delete-table me-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-subcategory">
                                                   <i class="fe fe-edit"></i>
                                                </button>
                                                <button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-subcategory">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
                        </div>`;
                        return imageHtml;
                    }
                },
            ],
            paging: true,
            searching: false,
            info: false,
            dom: '<"custom-datatable"t><"custom-datatable"ilp>', // Customize the DataTable layout
            language: {
                paginate: {
                    first: '',
                    last: '',
                    next: '',
                    previous: ''
                },
                info: 'Showing _START_ - _END_ of _TOTAL_ items', // Customize the show info text
                infoFiltered: '', // Remove filtered info
                infoEmpty: '', // Remove empty info
            },
            // scrollX: false,
            // scrollY: false
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });