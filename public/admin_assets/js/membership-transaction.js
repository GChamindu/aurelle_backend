var jsonDataUrl = '../admin_assets/json/membership-transaction.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        if ($.fn.DataTable.isDataTable('#membership-transaction-data')) {
            $('#membership-transaction-data').DataTable().destroy();
        }
        var table = $('#membership-transaction-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                                            <span>${data.ProviderName}</span>
                                        </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Subscription' },
                { data: 'Amount' },
                { data: 'Duration' },
                { data: 'StartDate' },
                { data: 'EndDate' },
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