var jsonDataUrl = '../admin_assets/json/coupons.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        if ($.fn.DataTable.isDataTable('#coupons-data')) {
            $('#coupons-data').DataTable().destroy();
        }
        var table = $('#coupons-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'Name' },
                { data: 'Code' },
                { data: 'Type' },
                { data: 'Discount' },
                { data: 'limit' },
                { data: 'Used' },
                { data: 'ValidDate' },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.ServicesName === 'House Cleaning') {
                            return `  ${data.ServicesName} <a href="javascript:void(0);" class="more-option">+1 more</a>`;
                        } else if (data.ServicesName === 'Computer Repair') {
                            return `  ${data.ServicesName} <a href="javascript:void(0);" class="more-option">+1 more</a>`;
                        }
                        else {
                            return ` ${data.ServicesName}`;
                        }

                    }
                },

                {
                    data: null,
                    render: function (data, type, row) {
                        if (data.Status === 'Action') {
                            return ` <h6 class="badge-active">${data.Status}</h6>`;
                        } else {
                            return ` <h6 class="badge-inactive">${data.Status}</h6>`;
                        }
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
                                            <button class="btn delete-table me-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-coupon">
                                               <i class="fe fe-edit"></i>
                                            </button>
                                            <button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-coupon">
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