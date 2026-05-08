var jsonDataUrl = '../admin_assets/json/featured-services.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
            item.Serviceimage = `../admin_assets/img/services/${item.Serviceimage}`;
            item.eye = `../admin_assets/img/icons/${item.eye}`;
            item.edit = `../admin_assets/img/icons/${item.edit}`;
            item.delete = `../admin_assets/img/icons/${item.delete}`;
        });
        if ($.fn.DataTable.isDataTable('#featured-services-data')) {
            $('#featured-services-data').DataTable().destroy();
        }
        var table = $('#featured-services-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-imgname">
                                            <img src="${data.Serviceimage}" class="me-2" alt="img">
                                            <span>${data.Service}</span>
                                        </a>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.ServicesStatus === 'Active') {
                            return ` <h6 class="badge-active">${data.ServicesStatus}</h6>`;
                        } else {
                            return ` <h6 class="badge-inactive">${data.ServicesStatus}</h6>`;
                        }
                    }
                },
                { data: 'Category' },
                { data: 'Amount' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-namesplit">
                                            <a href="javascript:void(0);" class="table-profileimage">
                                                <img src="${data.image}" class="me-2" alt="img">
                                            </a>
                                            <a href="javascript:void(0);" class="table-name">
                                                <span>${data.ProviderName}</span>
                                                <p>${data.Email}</p>
                                            </a>
                        </div>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Active') {
                            return ` <h6 class="badge-active">${data.Status}</h6>`;
                        } else {
                            return ` <h6 class="badge-inactive">${data.Status}</h6>`;
                        }
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                            <a class="delete-table me-2" href="view-service">
                                                <img src="${data.eye}" alt="svg">
                                             </a>
                                            <a class="delete-table me-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit-features">
                                               <img src="${data.edit}" alt="svg">
                                            </a>
                                            <a class="delete-table" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-item">
                                                <img src="${data.delete}" alt="svg">
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