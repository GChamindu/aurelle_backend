var jsonDataUrl = '../admin_assets/json/menu-management.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/flags/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#menu-management-data')) {
            $('#menu-management-data').DataTable().destroy();
        }
        var table = $('#menu-management-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'ID' },
                { data: 'Title' },
                { data: 'CreatedAt' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <h6 class="badge-active">${data.Status}</h6>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="filter-select-set">
                                            <div class="form-group mb-0">
                                                <div class="group-image">
                                                    <img src="${data.image}"
                                                        alt="img">
                                                    <select class="select2 ">
                                                        <option>Language</option>
                                                        <option>English</option>
                                                        <option>Spanish</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>`;
                        return imageHtml;
                    },
                    createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
                        // Initialize Select2 on the created cell
                        $(cell).find('.select2').select2();
                    },
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                                <a class="btn delete-table me-2" href="edit-managemenet">
                                                   <i class="fe fe-edit"></i>
                                                </a>
                                                <button class="btn delete-table" button="button" data-bs-toggle="modal" data-bs-target="#delete-menu">
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
            columnDefs: [
                { targets: 5, className: 'select2-enabled' }
            ],
            // scrollX: false,
            // scrollY: false
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });