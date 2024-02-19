<?php

if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){

	$delete_id = $_GET['id'];

	global $wpdb;

	$deleted = $wpdb->delete(
		"{$wpdb->prefix}mk_sell_vehicle",
		array( 'ID' => $delete_id )
		);

	if($deleted){
		wp_redirect( admin_url().'admin.php?page=mk_vehicle' );
	}else{
		echo '<div style="color:red;font-size:18px;">Data Not Deleted</div>';
	}

}
?>
	