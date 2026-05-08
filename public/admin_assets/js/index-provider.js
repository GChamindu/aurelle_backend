var jsonDataUrl = '../admin_assets/json/index-provider.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.image = `../admin_assets/img/customer/${item.image}`;
        });
        if ($.fn.DataTable.isDataTable('#index-provider-data')) {
            $('#index-provider-data').DataTable().destroy();
        }
        var table = $('#index-provider-data').DataTable({
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
                        <span>${data.ProviderName}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Email' },
                { data: 'Phone' },
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