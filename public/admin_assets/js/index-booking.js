var jsonDataUrl = '../admin_assets/json/index-booking.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        data.forEach(item => {
            item.ProviderImage = `../admin_assets/img/customer/${item.ProviderImage}`;
            item.UserImage = `../admin_assets/img/customer/${item.UserImage}`;
            item.ServiceImage = `../admin_assets/img/services/${item.ServiceImage}`;
        });
        if ($.fn.DataTable.isDataTable('#index-booking-data')) {
            $('#index-booking-data').DataTable().destroy();
        }
        var table = $('#index-booking-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: '#' },
                { data: 'Date' },
                { data: 'BookingTime' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <a href="javascript:void(0);" class="table-profileimage">
                        <img src="${data.ProviderImage}"
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
                        <img src="${data.UserImage}"
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
                        <img src="${data.ServiceImage}"
                            class="me-2" alt="img">
                        <span>${data.Service}</span>
                    </a>`;
                        return imageHtml;
                    }
                },
                { data: 'Amount' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Pending') {
                            return `<h6 class="badge-pending">${data.Status}</h6>`;
                        } else if (data.Status === 'Completed') {
                            return `<h6 class="badge-active">${data.Status}</h6>`;
                        } else if (data.Status === 'Inprogress') {
                            return `<h6 class="badge-inactive">${data.Status}</h6>`;
                        } else {
                            return `<h6 class="badge-delete">${data.Status}</h6>`;
                        }
                    }
                },
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