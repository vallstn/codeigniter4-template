<p>
    <button type="button" class="btn btn-info" id="btn_refresh"><i class="fas fa-sync"></i> Refresh</button>
    <button type="button" class="btn btn-primary" id="btn_edit"><i class="fas fa-edit"></i> Edit</button>
	<button type="button" class="btn btn-danger" id="btn_delete"><i class="fas fa-trash-alt"></i> Delete</button>    
</p>

<div class="table-responsive">
    <table class="table table-bordered" id="table_data">
        <thead class="thead-dark">
            <tr>
                <th>
                    <input type="checkbox" id="checkbox_data">
                </th>
                <th>No</th>
                <th>LGD Code</th>
                <th>Name</th>
                <th>Name (Tamil)</th>
                <th>Short Name</th>
				<th>Agri. Dept. Code</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<script type="text/javascript">   
    // Serverside datatable integration function
    function dataServerSide() {

        let table = $('#table_data').DataTable({

            'processing': true,
            'serverSide': true,
            'order': [],
            'ajax': {
                
                'url': '<?= base_url('revenueMaster/district/ServersideDistrict') ?>',                
                'type': 'POST',

                error: function(xhr, ajaxOptions, thrownError) {
                    $('#error_message').html(
                        `<strong>${xhr.status + ' ' + thrownError}</strong>
                    <br>
                    <div class="card mt-2">
                        <div class="card-body">
                            ${xhr.responseText}
                        </div>
                    </div>`
                    );
                    $('#error_modal').modal('show');
                    $('.view-data').html(
                        `<div style="color:black;" class="card bg-light">
                        <div class="card-body">
                            <a href="#" id="btn_refreshdata"><i class="fas fa-sync"></i> Refresh</a>
                            <hr>
                            Sorry, Something Went Wrong?  (<strong>${xhr.status + ' ' + thrownError}</strong>)
                        </div>
                    </div>`
                    );
                },
            },
            //optional
            'columnDefs': [{
                'targets': 0,
                'orderable': false,
            }, ]
        })
    }

    // When the document is ready
    $(document).ready(function() {
        dataServerSide();

        // If checkbox_all is checked
        $('#checkbox_all').change(function(e) {
            if ($(this).is(':checked')) {
                $('.checkbox_data').prop('checked', true);
            } else {
                $('.checkbox_data').prop('checked', false);
            }
        })

        // If multiple delete button is pressed
        $('#btn_delete').click(function(e) {
            // Retrieve selected data
            let data_delete = document.querySelectorAll('.checkbox_user:checked');

            deleteData(data_delete);
        })

        // If the multiple edit button is pressed
        $('#btn_editdata').click(function(e) {
            // Retrieve selected data
            let data_edit = document.querySelectorAll('.checkbox_user:checked');

            editData(data_edit);
        })
    })

    // Function to delete data
    function deleteData(id_user) {
        // If no data is selected
        if (id_user.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Failed!',
                text: 'Select the data to be deleted'
            })
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Attention!',
                text: `${typeof id_user === 'object' ? id_user.length : 1} The data will be permanently deleted, Are you sure?`,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Delete!'
            }).then((result) => {
                let id_user_array = [];

                // If data is deleted single data
                if (Number.isInteger(id_user)) {
                    id_user_array[0] = id_user;
                } else {
                    for (let i = 0; i < id_user.length; i++) {
                        id_user_array[i] = id_user[i].value;
                    }
                }

                if (result.value) {
                    $.ajax({
                        type: 'post',
                        url: "<?= base_url('revenuemaster/district/delete') ?>",
                        dataType: "json",
                        data: {
                            id_user: id_user_array,
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succeed!',
                                    text: response.success,
                                }).then((result) => {
                                    dataUser();
                                })
                            } else if (response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Attention!!',
                                    text: response.error,
                                }).then((result) => {
                                    dataUser();
                                })
                            } else if (response.warning) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning!!',
                                    text: response.warning,
                                }).then((result) => {
                                    dataUser();
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            $('#error_message').html(
                                `<strong>${xhr.status + ' ' + thrownError}</strong>
                                <br>
                                <div class="card mt-2">
                                    <div class="card-body">
                                        ${xhr.responseText}
                                    </div>
                                </div>`
                            );
                            $('#error_modal').modal('show');
                        }
                    })
                }
            })
        }
    }

    // Function to change data
    function editData(id_user) {
        // If no data is selected
        if (id_user.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Attention!',
                text: 'Choose the data to be changed'
            })
        } else {
            let id_user_array = [];

            // If data is deleted single data
            if (Number.isInteger(id_user)) {
                id_user_array[0] = id_user;
            } else {
                for (let i = 0; i < id_user.length; i++) {
                    id_user_array[i] = id_user[i].value;
                }
            }

            $.ajax({
                type: 'post',
                url: "<?= base_url('UserController/editUser') ?>",
                dataType: "json",
                data: {
                    id_user: id_user_array,
                },
                success: function(response) {
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Attention!',
                            text: response.error,
                        }).then((result) => {
                            dataUser();
                        })
                    } else if (response.data) {
                        $('.view-data').html(response.data);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $('#error_message').html(
                        `<strong>${xhr.status + ' ' + thrownError}</strong>
                        <br>
                        <div class="card mt-2">
                            <div class="card-body">
                                ${xhr.responseText}
                            </div>
                        </div>`
                    );
                    $('#error_modal').modal('show');
                }
            })
        }
    }
</script>