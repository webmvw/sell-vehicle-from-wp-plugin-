<div class="wrap">
	<h1 class="wp-heading-inline">Vehicle</h1>
	<!-- <a href="admin.php?page=mk_services&action=create" class="page-title-action">Add New Service</a> -->
	<hr>
    <h3>Input sell vehicle information</h3>
    <span id="mk_error_info"></span>
    <span id="mk_submit_info"></span>
    <table class="form-table">
        <tr>
            <td><input type="text" id="mk_vehicle_make" placeholder="Make" required/></td>
            <td><input type="text" id="mk_vehicle_model" placeholder="Model" required/></td>
            <td><input type="text" id="mk_vehicle_trim" placeholder="Trim" required/></td>
            <td><button id="mk_vehicle_submit">Submit</button></td>
        </tr>
    </table>
    <hr>
	<table id="mk_dataTable" class="display" style="background: #fff !important">
    	<thead>
    		<tr>
    			<th>#</th>
    			<th>Make</th>
    			<th>Model</th>
    			<th>Trim</th>
    			<th>Action</th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php
    		if(count($mk_sell_vehicle_data) > 0){
    			foreach($mk_sell_vehicle_data as $key=>$value){
    				?>
    				<tr>
    					<td><?php echo "#" ?></td>
    					<td><?php echo $value->make; ?></td>
    					<td><?php echo $value->model; ?></td>
    					<td><?php echo $value->trim; ?></td>
    					<td>
    						<a href="<?php echo admin_url('admin.php?page=mk_vehicle&action=edit&id='.$value->id); ?>" style="text-decoration: none"><span class="dashicons dashicons-edit-page"></span></a> &nbsp;|&nbsp;
    						<a href="<?php echo admin_url('admin.php?page=mk_vehicle&action=delete&id='.$value->id); ?>" style="text-decoration: none" onclick="return confirm('Are you sure to delete it?');"><span class="dashicons dashicons-trash" style="color:red"></span></a>
    					</td>
    				</tr>
    				<?php
    			}
    		}
    		?>
    	</tbody>
    	<tfoot>
    		<tr>
    			<th>#</th>
                <th>Make</th>
                <th>Model</th>
                <th>Trim</th>
                <th>Action</th>
    		</tr>
    	</tfoot>
    </table>
</div>
<script>
	let table = new DataTable('#mk_dataTable');

    // form submition ajax 
    jQuery(document).ready(function($){
        $("#mk_vehicle_submit").on("click", function(){
            var mk_vehicle_make = $("#mk_vehicle_make").val();
            var mk_vehicle_model = $("#mk_vehicle_model").val();
            var mk_vehicle_trim = $("#mk_vehicle_trim").val();
            if(mk_vehicle_make == "" || mk_vehicle_model == "" || mk_vehicle_trim == ""){
                $("#mk_error_info").show().html("<span style='color:red;font-size:18px;'>All fields are required</span>");
                setTimeout(function(){
                    $("#mk_error_info").hide();
                }, 4000);
            }else{
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: "POST",
                    data: {
                        action: "sell_vehicle_insert_action",
                        mk_vehicle_make: mk_vehicle_make,
                        mk_vehicle_model: mk_vehicle_model,
                        mk_vehicle_trim: mk_vehicle_trim
                    },
                    success: function(data){
                        $("#mk_submit_info").append('<span style="color:green;font-size:18px;">Data Insert Success</span>');
                        var strdata = data.slice(0, -1);
                        var jsondata = JSON.parse(strdata);
                        
                        $.each(jsondata,function(key,v){
                            
                            var editdata = "<?php echo admin_url('admin.php?page=mk_vehicle&action=edit&id='); ?>"+v.id;
                            var deletedata = "<?php echo admin_url('admin.php?page=mk_vehicle&action=delete&id='); ?>"+v.id;
                            var deleteMessage = "Are you sure to delete it?";

                            $('#mk_dataTable tbody tr:first').before('<tr><td>#</td><td>'+v.make+'</td><td>'+v.model+'</td><td>'+v.trim+'</td><td><a href="'+editdata+'" style="text-decoration: none"><span class="dashicons dashicons-edit-page"></span></a> &nbsp;|&nbsp;<a href="'+deletedata+'" style="text-decoration: none" onclick="return confirm('+deleteMessage+');"><span class="dashicons dashicons-trash" style="color:red"></span></a></td></tr>');
                        });
                        setTimeout(function(){
                            $("#mk_submit_info").hide();
                        }, 4000);
                    }

                });
            }
        });
    });

</script>