var jsonDataUrl = '../admin_assets/json/abuse-reports.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Providerimage = `../admin_assets/img/customer/${item.Providerimage}`;
            item.Reportimage = `../admin_assets/img/customer/${item.Reportimage}`;
        });
        if ($.fn.DataTable.isDataTable('#abuse-reports-data')) {
            $('#abuse-reports-data').DataTable().destroy();
        }
        var table = $('#abuse-reports-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                                            <img src="${data.Providerimage}"
                                                class="me-2" alt="img">
                                            <span>${data.Provider}</span>
                        </a>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                                            <img src="${data.Reportimage}"
                                                class="me-2" alt="img">
                                            <span>${data.ReportedByUser}</span>
                        </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Description' },
                { data: 'Date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                            <button class="btn delete-table me-2" type="button" data-bs-toggle="modal" data-bs-target="#abuse-details">
                                               <i class="fe fe-eye"></i>
                                            </button>
                                            <button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-abuse">
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