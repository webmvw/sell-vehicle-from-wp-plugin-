	<?php
  	if(isset($_GET['action']) && $_GET['action']== 'edit' && isset($_GET['id'])){
  		$edit_id = $_GET['id'];

  		global $wpdb;

  		$get_vehicle = $wpdb->get_row(
			"SELECT * FROM {$wpdb->prefix}mk_sell_vehicle WHERE id={$edit_id} ORDER BY id DESC"
		);
  	}
  	?>

<div class="wrap">
	<h1 class="wp-heading-inline">Edit Vehicle</h1>
	<a href="admin.php?page=mk_vehicle" class="page-title-action">View Vehicle</a>
	<hr>
	<form method="post" enctype="multipart/form-data">
	    <table class="form-table" role="presentation">
	    	<tbody>
	    		<tr>
	    			<th scope="row">Make</th>
	    			<td>
	    				<input type="text" name="vehicle_make" value="<?php echo $get_vehicle->make; ?>" class="regular-text" required>
	    			</td>
	    		</tr>
	    		<tr>
	    			<th scope="row">Model</th>
	    			<td>
	    				<input type="text" name="vehicle_model" value="<?php echo $get_vehicle->model; ?>" class="regular-text" required>
	    			</td>
	    		</tr>
	    		<tr>
	    			<th scope="row">Trim</th>
	    			<td>
	    				<input type="text" name="vehicle_trim" value="<?php echo $get_vehicle->trim; ?>" class="regular-text" required>
	    			</td>
	    		</tr>
	    	</tbody>
	    </table>
	    <p class="submit"><input type="submit" name="update_vehicle" id="submit" class="button button-primary" value="Update Vehicle"></p>
	</form>
</div>    


<?php
/** 
 * submit post
 */
if(! isset($_POST['update_vehicle'])){
    return;
}{

    $data['make'] = isset($_POST['vehicle_make']) ? sanitize_textarea_field($_POST['vehicle_make']) : '';
    $data['model'] = isset($_POST['vehicle_model']) ? sanitize_text_field($_POST['vehicle_model']) : '';
    $data['trim'] = isset($_POST['vehicle_trim']) ? sanitize_text_field($_POST['vehicle_trim']) : '';
	global $wpdb;

	$vehicle_updated = $wpdb->update( 
			"{$wpdb->prefix}mk_sell_vehicle",
			array('make'=>$data['make'], 'model'=>$data['model'], 'trim'=>$data['trim']),
			array( 'ID' => $edit_id ) 
		);

	if($vehicle_updated){
		echo '<div style="color:green;font-size:18px;" role="alert">Data Update Success</div>';
	}else{
		echo '<div style="color:red;font-size:18px;" role="alert">Data Not Update</div>';
	}
	
}
?>