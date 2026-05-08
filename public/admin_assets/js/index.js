var jsonDataUrl = '../admin_assets/json/index.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/services/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#index-data')) {
            $('#index-data').DataTable().destroy();
        }
        var table = $('#index-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },

                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="view-service" class="table-imgname">
                        <img src="${data.image}"
                            class="me-2" alt="img">
                        <span>${data.Service}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Category' },
                { data: 'Amount' },
            ],
            paging: false,
            searching: false,
            info: false,
            // scrollX: false,
            // scrollY: false
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });