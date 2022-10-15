<?= $this->extend('master') ?>


<?= $this->section('main') ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css" />
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.js"></script>

<h1><i class="fas fa-database"></i> District Master</h1>
<hr>

<div class="row">
    <div class="col">
        <p>
            <button type="button" class="btn btn-primary" id="btn_add"><i class="far fa-plus-square"></i> District</button>
        </p>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table></table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">	

	$(document).ready(function() {
		
		var meta = document.getElementsByTagName("meta")[0];     
		var tokenHash = meta.content;
		
		$.ajaxPrefilter(function(options,originalOptions,jqXHR) {
			jqXHR.setRequestHeader('X-CSRF-Token', tokenHash);
		});
	
		$('#table').DataTable({
			processing: true,
			serverSide: true,
			ajax: 'revenueMaster/district/getAllDistrict',
			method: 'POST'
		});
	});
	
    // Get Data from Backend
    function get_data() {
        $.ajax({
            url: "<?= base_url('revenueMaster/district/getAllDistrict') ?>",
            dataType: "json",
            beforeSend: function() {
                $('.view-data').html('<i class="spinner-border"></i>');
            },
            success: function(response) {
                $('.view-data').html(response.data);
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
                $('.view-data').html(
                    `<div style="color:black;" class="card bg-light">
                        <div class="card-body">
                            <a href="#" id="btn_refreshdata"><i class="fas fa-sync"></i> Refresh</a>
                            <hr>
                            Sorry, Something Went Wrong? (<strong>${xhr.status + ' ' + thrownError}</strong>)
                        </div>
                    </div>`
                );
            }
        })
    }
   
    // When the document is ready
    $(document).ready(function() {   
        // Calling the data function()
        get_data();

        // Ketika tombol tambah data ditekan
        $('#btn_add').click(function(e) {
            $.ajax({
                url: "<?= base_url('revenuemaster/district/add') ?>",
                dataType: "json",
                beforeSend: function() {
                    $('.view-data').html('<i class="spinner-border"></i>');
                },
                success: function(response) {
                    $('.view-data').html(response.data);
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
                    $('.view-data').html(
                        `<div style="color:black;" class="card bg-light">
                            <div class="card-body">
                                <a href="#" id="btn_refresh"><i class="fas fa-sync"></i> Refresh</a>
                                <hr>
                                Sorry, Something Went Wrong? (<strong>${xhr.status + ' ' + thrownError}</strong>)
                            </div>
                        </div>`
                    );
                }
            })
        })
    });

    // On the document if it exists, and run it when refresh data is pressed
    $(document).on('click', '#btn_refresh', function(e) {
        e.preventDefault();

        get_data();
    })
</script>

<?= $this->endSection() ?>