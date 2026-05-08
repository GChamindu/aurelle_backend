var jsonDataUrl = '../admin_assets/json/refund-request.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Providerimage = `../admin_assets/img/customer/${item.Providerimage}`;
            item.Userimage = `../admin_assets/img/customer/${item.Userimage}`;
            item.Serviceimage = `../admin_assets/img/services/${item.Serviceimage}`;
        });
        if ($.fn.DataTable.isDataTable('#refund-request-data')) {
            $('#refund-request-data').DataTable().destroy();
        }
        var table = $('#refund-request-data').DataTable({
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
                        <span>${data.ProviderName}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                        <img src="${data.Userimage}"
                            class="me-2" alt="img">
                        <span>${data.UserName}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="view-service" class="table-imgname">
                        <img src="${data.Serviceimage}"
                            class="me-2" alt="img">
                        <span>${data.Service}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Amount' },
                { data: 'Date' },
                { data: 'DeletedReason' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Pending') {
                            return `<h6 class="badge-pending">${data.Status}</h6>`;
                        } else if (data.Status === 'Completed') {
                            return `<h6 class="badge-active">${data.Status}</h6>`;
                        } else if (data.Status === 'Inprogress') {
                            return `<h6 class="badge-inactive">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-active">${data.Status}</h6>`;
                        }
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