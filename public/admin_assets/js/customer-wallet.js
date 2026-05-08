var jsonDataUrl = '../admin_assets/json/customer-wallet.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        if ($.fn.DataTable.isDataTable('#customer-wallet-data')) {
            $('#customer-wallet-data').DataTable().destroy();
        }
        var table = $('#customer-wallet-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
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
                        <span>${data.Customer}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Amount' },
                { data: 'Reason' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Completed') {
                            return `<h6 class="badge-active completed-active-badge">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-active inprogress loading-inprogress">${data.Status}</h6>`;
                        }
                    }
                },
                { data: 'Date' },
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