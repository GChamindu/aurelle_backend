var jsonDataUrl = '../admin_assets/json/contact-messages.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#contact-messages-data')) {
            $('#contact-messages-data').DataTable().destroy();
        }
        var table = $('#contact-messages-data').DataTable({
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
                { data: 'Email' },
                { data: 'Phone' },
                { data: 'Message' },
                { data: 'Date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                        <a class="delete-table me-2" href="contact-messages-view">
                        <i class="fe fe-eye"></i>
                        </a>
                        <a class="delete-table" href="javascript:void(0);" data-bs-toggle="modal"
                            data-bs-target="#delete-item">
                            <i class="fe fe-trash-2"></i>
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