var jsonDataUrl = '../admin_assets/json/language.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/icons/${item.image}`;
            item.icon = `../admin_assets/img/icons/${item.icon}`;
            item.flagimage = `../admin_assets/img/flags/${item.flagimage}`;
        });
        if ($.fn.DataTable.isDataTable('#language-data')) {
            $('#language-data').DataTable().destroy();
        }
        var table = $('#language-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'id' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="language-set">
                                                <img src="${data.flagimage}" alt="img">
                                                <span>${data.name}</span>
                                            </div>`;
                        return imageHtml;
                    }
                },
                { data: 'code' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="active-switch">
                                                <label class="switch">
                                                    <input type="checkbox" checked="">
                                                    <span class="sliders round"></span>
                                                </label>
                                            </div>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="active-switch">
                                                <label class="switch">
                                                    <input type="checkbox" checked="">
                                                    <span class="sliders round"></span>
                                                </label>
                                            </div>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="active-switch">
                                                <label class="switch">
                                                    <input type="checkbox" checked="">
                                                    <span class="sliders round"></span>
                                                </label>
                                            </div>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="action-language">
                                                <ul>
                                                    <li>
                                                        <a class="btn btn-grey" href="javascript:void(0);"><img
                                                                src="${data.image}"
                                                                class="me-2" alt="img">Web</a>
                                                    </li>
                                                    <li>
                                                        <a class="btn btn-grey" href="javascript:void(0);"><img
                                                                src="${data.image}"
                                                                class="me-2" alt="img">App</a>
                                                    </li>
                                                    <li>
                                                        <a class="btn btn-grey" href="javascript:void(0);"><img
                                                                src="${data.image}"
                                                                class="me-2" alt="img">Admin</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="delete-table"><i
                                                                class="far fa-edit "></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="delete-table"
                                                            data-bs-toggle="modal" data-bs-target="#delete-item"><i
                                                                class="far fa-trash-alt "></i></a>
                                                    </li>
                                                </ul>
                                            </div>`;
                        return imageHtml;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="action-language">
                                                <ul>
                                                    <li>
                                                        <a class="btn btn-primary" href="javascript:void(0);"><img src="${data.icon}" class="me-2" alt="img">Web</a>
                                                    </li>
                                                    <li>
                                                        <a class="btn btn-primary" href="javascript:void(0);"><img src="${data.icon}" class="me-2" alt="img">App</a>
                                                    </li>
                                                </ul>
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