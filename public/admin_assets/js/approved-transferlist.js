var jsonDataUrl = '../admin_assets/json/approved-transferlist.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Invoice = `../admin_assets/img/${item.Invoice}`;
            item.CustomerImage = `../admin_assets/img/customer/${item.CustomerImage}`;
            item.ServiceImage = `../admin_assets/img/services/${item.ServiceImage}`;
        });
        if ($.fn.DataTable.isDataTable('#approved-transferlist-data')) {
            $('#approved-transferlist-data').DataTable().destroy();
        }
        var table = $('#approved-transferlist-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-imgname">
                                            <img src="${data.ServiceImage}"
                                                class="me-2" alt="img">
                                            <span>${data.Service}</span>
                                        </a>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                                            <img src="${data.CustomerImage}"
                                                class="me-2" alt="img">
                                            <span>${data.Customer}</span>
                                        </a>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-imgname">
                                            <img src="${data.Invoice}" class="me-2"
                                                alt="img">
                                            <span>${data.Receipt}</span>
                        </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Description' },
                { data: 'Date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Pending') {
                            return `<h6 class="badge-pending">${data.Status}</h6>`;
                        } else if (data.Status === 'Successful') {
                            return `<h6 class="badge-active">${data.Status}</h6>`;
                        } else if (data.Status === 'Approved') {
                            return `<h6 class="badge-inactive">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-delete">${data.Status}</h6>`;
                        }
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="text-center">
                                            <a class="delete-table" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Transfer View</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item">Transfer Edit</a>
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