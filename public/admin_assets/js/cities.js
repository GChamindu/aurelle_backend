var jsonDataUrl = '../admin_assets/json/cities.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/flags/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#cities-data')) {
            $('#cities-data').DataTable().destroy();
        }
        var table = $('#cities-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'ID' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-imgname flag-image">
                        <img src="${data.image}" class="me-2"
                            alt="img">
                        <span>${data.CountryName}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                { data: 'StateName' },
                { data: 'CityName' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                                <button class="btn delete-table me-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-city">
                                                   <i class="fe fe-edit"></i>
                                                </button>
                                                <button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-city">
                                                    <i class="fe fe-trash-2"></i>
                                                </button>
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