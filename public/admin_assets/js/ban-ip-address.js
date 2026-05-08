var jsonDataUrl = '../admin_assets/json/ban-ip-address.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/services/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#ban-ip-address-data')) {
            $('#ban-ip-address-data').DataTable().destroy();
        }
        var table = $('#ban-ip-address-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'IPAddress' },
                { data: 'Reason' },
                { data: 'Date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="action-language">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0);" class="delete-table"
                                                            data-bs-toggle="modal" data-bs-target="#edit-tax"><i
                                                                class="far fa-edit "></i></a>
                                                    </li>
                                                    <li>
                                                        <a class="delete-table" href="javascript:void(0);"
                                                            data-bs-toggle="modal" data-bs-target="#delete-item">
                                                            <i class="far fa-trash-alt "></i>
                                                        </a>
                                                    </li>
                                                </ul>
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