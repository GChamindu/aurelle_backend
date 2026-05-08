var jsonDataUrl = '../admin_assets/json/wallet.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Image = `../admin_assets/img/customer/${item.Image}`;
        });
        if ($.fn.DataTable.isDataTable('#wallet-data')) {
            $('#wallet-data').DataTable().destroy();
        }
        var table = $('#wallet-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-profileimage">
                                        <a href="javascript:void(0);" class="table-profileimage">
                                            <img src="${data.Image}"
                                                class="me-2" alt="img">
                                        </a>
                                        <a href="javascript:void(0);" class="table-name">
                                            <span>${data.UserName}</span>
                                            <p>${data.Email}</p>
                                        </a>
                        </div>`;
                        return imageHtml;
                    }
                },
                { data: 'Phone' },
                { data: 'Balance' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="wallet-history" class="btn btn-history">${data.Action}</a>`;
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