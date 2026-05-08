var jsonDataUrl = '../admin_assets/json/permissions.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {

        if ($.fn.DataTable.isDataTable('#permissions-data')) {
            $('#permissions-data').DataTable().destroy();
        }
        var table = $('#permissions-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="mod-name">${data.Modules}</div>`;
                        return imageHtml;
                    }
                },
                { data: 'SubModules' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <label class="checkboxs mb-0">
                        <input type="checkbox">
                        <span><i></i></span>
                    </label>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <label class="checkboxs mb-0">
                        <input type="checkbox">
                        <span><i></i></span>
                    </label>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <label class="checkboxs mb-0">
                        <input type="checkbox">
                        <span><i></i></span>
                    </label>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <label class="checkboxs mb-0">
                        <input type="checkbox">
                        <span><i></i></span>
                    </label>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <label class="checkboxs mb-0">
                        <input type="checkbox">
                        <span><i></i></span>
                    </label>`;
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