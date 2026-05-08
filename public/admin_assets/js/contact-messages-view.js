var jsonDataUrl = '../admin_assets/json/contact-messages-view.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#contact-messages-view-data')) {
            $('#contact-messages-view-data').DataTable().destroy();
        }
        var table = $('#contact-messages-view-data').DataTable({
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
                { data: 'Date' },
                { data: 'Message' },
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