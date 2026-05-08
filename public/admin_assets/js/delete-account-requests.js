var jsonDataUrl = '../admin_assets/json/delete-account-requests.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#delete-account-requests-data')) {
            $('#delete-account-requests-data').DataTable().destroy();
        }
        var table = $('#delete-account-requests-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'UserID' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-namesplit">
                                        <a href="javascript:void(0);" class="table-profileimage">
                                            <img src="${data.image}"
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
                { data: 'RequisitionDate' },
                { data: 'DeleteRequestDate' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex align-items-center">
                        <a href="javascript:void(0);" class="btn badge-active" data-bs-toggle="modal" data-bs-target="#accept-delete-account">Confirm</a>
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