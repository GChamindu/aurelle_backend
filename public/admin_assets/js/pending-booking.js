var jsonDataUrl = '../admin_assets/json/pending-booking.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Providerimage = `../admin_assets/img/customer/${item.Providerimage}`;
            item.Userimage = `../admin_assets/img/customer/${item.Userimage}`;
            item.Serviceimage = `../admin_assets/img/services/${item.Serviceimage}`;
        });
        if ($.fn.DataTable.isDataTable('#pending-booking-data')) {
            $('#pending-booking-data').DataTable().destroy();
        }
        var table = $('#pending-booking-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                { data: 'Date' },
                { data: 'BookingTime' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                        <img src="${data.Providerimage}"
                            class="me-2" alt="img">
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
                        <img src="${data.Userimage}"
                            class="me-2" alt="img">
                        <span>${data.User}</span>
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
                            return `<h6 class="badge-delete">${data.Status}</h6>`;
                        }
                    }
                },
                { data: 'Status_2' },
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