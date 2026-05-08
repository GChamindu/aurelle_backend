var jsonDataUrl = '../admin_assets/json/database-backup.json';

fetch(jsonDataUrl)
    .then(response => response.json())
    .then(data => {
        if ($.fn.DataTable.isDataTable('#database-backup-data')) {
            $('#database-backup-data').DataTable().destroy();
        }
        var table = $('#database-backup-data').DataTable({
            ordering: true,
            data: data,
            columns: [
                { data: 'name' },
                { data: 'date' },
                {
                    data: null,
                    render: function (data, type, row) {
                        var imageHtml = `
                        <div class="table-actions d-flex">
													<button class="btn delete-table me-2" type="button">
													   <i class="fe fe-download"></i>
													</button>
													<button class="btn delete-table" type="button" data-bs-toggle="modal" data-bs-target="#delete-backup">
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