var jsonDataUrl = '../admin_assets/json/sales-transactions.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Providerimage = `../admin_assets/img/customer/${item.Providerimage}`;
            item.Userimage = `../admin_assets/img/customer/${item.Userimage}`;
            item.Serviceimage = `../admin_assets/img/services/${item.Serviceimage}`;
        });
        if ($.fn.DataTable.isDataTable('#sales-transactions-data')) {
            $('#sales-transactions-data').DataTable().destroy();
        }
        var table = $('#sales-transactions-data').DataTable({
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
                            <img src="${data.Userimage}"
                                class="me-2" alt="img">
                        </a>
                        <a href="javascript:void(0);" class="table-name">
                            <span>${data.Customer}</span>
                            <p>${data.CustomerEmail}</p>
                        </a>
                    </div>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-namesplit">
                        <a href="javascript:void(0);" class="table-profileimage">
                            <img src="${data.Providerimage}"
                                class="me-2" alt="img">
                        </a>
                        <a href="javascript:void(0);" class="table-name">
                            <span>${data.Provider}</span>
                            <p>${data.ProviderEmail}</p>
                        </a>
                    </div>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-imgname">
                                            <img src="${data.Serviceimage}"
                                                class="me-2" alt="img">
                                            <span>${data.Service}</span>
                         </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Amount' },
                { data: 'Discount' },
                { data: 'Tax' },
                { data: 'Date' },
                { data: 'PaymentType' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Successful') {
                            return `<h6 class="badge-active">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-delete">${data.Status}</h6>`;
                        }
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                                <a class="delete-table me-2" href="javascript:void(0);">
                                                   <img src="../admin_assets/img/icons/pdf.svg" alt="svg">
                                                </a>
                                                <a class="delete-table" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-item">
                                                    <img src="../admin_assets/img/icons/delete.svg" alt="svg">
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