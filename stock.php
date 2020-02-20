<?php  
$ruta = realpath(__DIR__ . '/../../..');
require_once($ruta. '/wp-config.php');
require_once($ruta. '/wp-load.php');

global $wpdb;
$entityBody = file_get_contents('php://input');
$entityBody = json_decode($entityBody);
$productos = $entityBody->data;	
$error = '{"error":"FALSE"}';

foreach ($productos as  $producto) {
	actualizar_stock($producto->SKU, $producto->cantidad, $wpdb, $error);
}

echo $error;

function actualizar_stock($producto, $cantidad, $wpdb,$error){
$item = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_value LIKE '".$producto."'", OBJECT );

	$item = json_decode(json_encode($item), True);  
	if($item[0]['post_id'] != null || $item[0]['post_id'] != 0 || $item[0]['post_id']!= "" )
	{
		$query = "UPDATE {$wpdb->prefix}postmeta SET meta_value = ".$cantidad." WHERE( meta_key LIKE '_stock' ) AND post_id = ".$item[0]['post_id']." ";
		$wpdb->query($query);
	  

	    if($cantidad == "0"){
			$query = "UPDATE {$wpdb->prefix}postmeta SET meta_value = 'outofstock' WHERE( meta_key LIKE '_stock_status' ) AND post_id = ".$item[0]['post_id']." ";
			$wpdb->query($query);

		}
		else {
			$query = "UPDATE {$wpdb->prefix}postmeta SET meta_value = 'instock' WHERE( meta_key LIKE '_stock_status' ) AND post_id = ".$item[0]['post_id']." ";
			$wpdb->query($query);
		}
    
	}
	$error = my_print_error();
}

function my_print_error(){

    global $wpdb;

    if($wpdb->last_error !== '') :
    	return('{"error":"TRUE"}');
    endif;

}
?>

