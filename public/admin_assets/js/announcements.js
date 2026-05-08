var jsonDataUrl = '../admin_assets/json/announcements.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Providerimage = `../admin_assets/img/customer/${item.Providerimage}`;
            item.Reportimage = `../admin_assets/img/customer/${item.Reportimage}`;
        });
        if ($.fn.DataTable.isDataTable('#announcements-data')) {
            $('#announcements-data').DataTable().destroy();
        }
        var table = $('#announcements-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                { data: 'Subject' },
                { data: 'Message' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.SendTo === 'Provider') {
                            return ` <h6 class="badge bg-warning badge-inactive">${data.SendTo}</h6>`;
                        } else {
                            return ` <h6 class="badge bg-success badge-inactive">${data.SendTo}</h6>`;
                        }
                    }
                },
                {data: 'Date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                                <button class="btn delete-table me-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-announcement">
                                                   <i class="fe fe-edit"></i>
                                                </button>
                                                <button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-announcement">
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