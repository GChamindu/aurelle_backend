var jsonDataUrl = '../admin_assets/json/verification-request.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        if ($.fn.DataTable.isDataTable('#verification-request-data')) {
            $('#verification-request-data').DataTable().destroy();
        }
        var table = $('#verification-request-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <span>${data.UserName}</span>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <span>${data.Documenttype}</span>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="#"><span>${data.DocumentName}</span></a>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-download">
                            <i class="fa-solid fa-download"></i>
                        </div>`;
                        return imageHtml;
                    }
                },
                { data: 'RejectReason' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Rejected') {
                            return ` <a href="#" class=" btn btn-rejected" data-bs-toggle="modal"
                            data-bs-target="#successmodal">${data.Status}
                        </a>`;
                        } else if (data.Status === 'Verified') {
                            return ` <a href="#" class=" btn btn-verified">${data.Status}
                            </a>`;
                        }
                        else {
                            return `<div class="table-select">
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
                        }
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