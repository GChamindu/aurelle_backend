var jsonDataUrl = '../admin_assets/json/deleted-services.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/services/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#deleted-services-data')) {
            $('#deleted-services-data').DataTable().destroy();
        }
        var table = $('#deleted-services-data').DataTable({
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
                                                <span>${data.Service}</span>
                                            </a>
                        </div>`;
                        return imageHtml;
                    }
                },
                { data: 'Category' },
                { data: 'SubCategory' },
                { data: 'Price' },
                { data: 'Duration' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Pending') {
                            return `<h6 class="badge-pending">${data.Status}</h6>`;
                        } else if (data.Status === 'Active') {
                            return `<h6 class="badge-active">${data.Status}</h6>`;
                        } else if (data.Status === 'Inactive') {
                            return `<h6 class="badge-inactive">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-delete">${data.Status}</h6>`;
                        }
                    }
                },
                { data: 'CreatedBy' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="action-language">
                                                <a class="table-edit" href="edit-service"> 
                                                    <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                                                </a>
                                                <a class="table-delete" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-item"> 
                                                    <i class="fa-solid fa-trash-can"></i><span>Delete</span>
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