var jsonDataUrl = '../admin_assets/json/providers.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#providers-data')) {
            $('#providers-data').DataTable().destroy();
        }
        var table = $('#providers-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-namesplit">
                                        <a href="javascript:void(0);" class="table-profileimage">
                                            <img src="${data.image}" class="me-2" alt="img">
                                        </a>
                                        <a href="javascript:void(0);" class="table-name">
                                            <span>${data.Name}</span>
                                            <p>${data.Email}</p>
                                        </a>
                        </div>`;
                        return imageHtml;
                    }
                },
                { data: 'Mobile' },
                { data: 'Created' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.LastActivity === 'Online') {
                            return `<div class="online-set">
                            <span class="online-path"></span>
                            <h6>${data.LastActivity}</h6>
                        </div>`;
                        } else {
                            return `${data.LastActivity}`;
                        }
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Active') {
                            return `<h6 class="badge-active">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-inactive">${data.Status}</h6>`;
                        }
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                        <button class="btn delete-table me-2" type="button" data-bs-toggle="modal"
                            data-bs-target="#edit-provider">
                            <i class="fe fe-edit"></i>
                        </button>
                        <button class="btn delete-table" type="button" data-bs-toggle="modal"
                            data-bs-target="#delete-provider">
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