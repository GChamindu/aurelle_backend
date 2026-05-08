var jsonDataUrl = '../admin_assets/json/provider-earnings.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Serviceimage = `../admin_assets/img/services/${item.Serviceimage}`;
        });
        if ($.fn.DataTable.isDataTable('#provider-earnings-data')) {
            $('#provider-earnings-data').DataTable().destroy();
        }
        var table = $('#provider-earnings-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-imgname">
                                            <img src="${data.Serviceimage}" class="me-2" alt="img">
                                            <span>${data.Service} </span>
                                        </a>`;
                        return imageHtml;
                    }
                },
                { data: 'User' },
                { data: 'Paymenttype' },
                { data: 'Amount' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Completed') {
                            return `<h6 class="badge-active completed-active-badge">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-inactive">${data.Status}</h6>`;
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