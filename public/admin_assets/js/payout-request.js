var jsonDataUrl = '../admin_assets/json/payout-request.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#payout-request-data')) {
            $('#payout-request-data').DataTable().destroy();
        }
        var table = $('#payout-request-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                        <img src="${data.image}"
                            class="me-2" alt="img">
                        <span>${data.Name}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                { data: 'PayoutMethod' },
                { data: 'Amount' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Pending') {
                            return `<h6 class="badge-pending">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-delete">${data.Status}</h6>`;
                        }
                    }
                },
                { data: 'CreatedAt' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-select table-selectpayouts">
                        <div class="form-group mb-0">
                            <select class="select2">
                                <option>Select Status</option>
                                <option> Pending</option>
                                <option> Inprogress</option>
                                <option>Completed</option>
                                <option>cancelled</option>
                            </select>
                        </div>
                    </div>`;
                        return imageHtml;
                    },
                    createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
                        // Initialize Select2 on the created cell
                        $(cell).find('.select2').select2();
                    },
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
            columnDefs: [
                { targets: 5, className: 'select2-enabled' }
            ],
            // scrollX: false,
            // scrollY: false
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });