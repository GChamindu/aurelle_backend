var jsonDataUrl = '../admin_assets/json/roles.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {

        if ($.fn.DataTable.isDataTable('#roles-data')) {
            $('#roles-data').DataTable().destroy();
        }
        var table = $('#roles-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                { data: 'Name' },
                { data: 'Created' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-action d-flex">
                        <a class="me-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-role">
                            <i class="fe fe-edit-3"></i> Edit Role
                        </a>
                        <a href="permissions">
                            <i class="fe fe-shield"></i> Permissions
                        </a>
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