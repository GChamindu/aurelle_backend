var jsonDataUrl = '../admin_assets/json/offers.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
            item.Serviceimage = `../admin_assets/img/services/${item.Serviceimage}`;
        });
        if ($.fn.DataTable.isDataTable('#offers-data')) {
            $('#offers-data').DataTable().destroy();
        }
        var table = $('#offers-data').DataTable({
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
                        var imageHtml = `
                        <div class="table-namesplit">
                                            <a href="javascript:void(0);" class="table-profileimage">
                                                <img src="${data.image}" class="me-2" alt="img">
                                            </a>
                                            <a href="javascript:void(0);" class="table-name">
                                                <span>${data.UserName}</span>
                                                <p>${data.Email}</p>
                                            </a>
                        </div>`;
                        return imageHtml;
                    }
                },
                { data: 'Amount' },
                { data: 'Offer' },
                { data: 'OfferPrice' },
                { data: 'Date' },
                { data: 'EndDate' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                            <button class="btn delete-table me-2" type="button" data-bs-toggle="modal"
                                                data-bs-target="#edit-offer">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                            <button class="btn delete-table" type="button" data-bs-toggle="modal"
                                                data-bs-target="#delete-offer">
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