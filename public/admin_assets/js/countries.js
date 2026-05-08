var jsonDataUrl = '../admin_assets/json/countries.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/flags/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#countries-data')) {
            $('#countries-data').DataTable().destroy();
        }
        var table = $('#countries-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'ID' },
                { data: 'CountryCode' },
                { data: 'CountryID' },
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
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                        <button class="btn delete-table me-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-country">
                           <i class="fe fe-edit"></i>
                        </button>
                        <button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-country">
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