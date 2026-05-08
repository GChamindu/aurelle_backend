var jsonDataUrl = '../admin_assets/json/review-type.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/services/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#review-type-data')) {
            $('#review-type-data').DataTable().destroy();
        }
        var table = $('#review-type-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                { data: 'ReviewsType' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var checkboxHtml = `
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" ${data.featured ? 'checked' : ''}>
                                    <span class="sliders round"></span>
                                </label>
                            </div>`;
                        return checkboxHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                        <button class="btn delete-table me-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-review-type">
                           <i class="fe fe-edit"></i>
                        </button>
                        <button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-review-type">
                            <i class="fe fe-trash-2"></i>
                        </button>
                    </div>	`;
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