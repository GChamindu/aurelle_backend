var jsonDataUrl = '../admin_assets/json/email-newsletter.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
            item.sms = `../admin_assets/img/icons/${item.sms}`;
            item.delete = `../admin_assets/img/icons/${item.delete}`;
        });
        if ($.fn.DataTable.isDataTable('#email-newsletter-data')) {
            $('#email-newsletter-data').DataTable().destroy();
        }
        var table = $('#email-newsletter-data').DataTable({
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
                            <img src="${data.image}"
                                class="me-2" alt="img">
                        </a>
                        <a href="javascript:void(0);" class="table-name">
                            <span>${data.Name}</span>
                            <p>${data.Email}</p>
                        </a>
                    </div>`;
                        return imageHtml;
                    }
                },
                { data: 'SubcribedDate' },
                { data: 'LastActivity' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                            <a class="delete-table me-2" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#send-email">
                                                <img src="${data.sms}"
                                                    alt="svg">
                                            </a>
                                            <a class="delete-table" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#delete-newsletter">
                                                <img src="${data.delete}"
                                                    alt="svg">
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