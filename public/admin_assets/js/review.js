var jsonDataUrl = '../admin_assets/json/review.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.Provideimage = `../admin_assets/img/customer/${item.Provideimage}`;
            item.Userimage = `../admin_assets/img/customer/${item.Userimage}`;
            item.Serviceimage = `../admin_assets/img/services/${item.Serviceimage}`;
        });
        if ($.fn.DataTable.isDataTable('#review-data')) {
            $('#review-data').DataTable().destroy();
        }
        var table = $('#review-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                { data: 'Date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                        <img src="${data.Provideimage}"
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
                { data: 'Type' },
                { data: 'Ratings' },
                { data: 'Comments' },
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