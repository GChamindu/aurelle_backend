var jsonDataUrl = '../admin_assets/json/page-list.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/services/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#page-list-data')) {
            $('#page-list-data').DataTable().destroy();
        }
        var table = $('#page-list-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                { data: 'Title' },
                { data: 'Language' },
                { data: 'Location' },
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
                { data: 'Date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                        <a class="btn delete-table me-2" href="edit-page">
                           <i class="fe fe-edit"></i>
                        </a>
                        <button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-page">
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