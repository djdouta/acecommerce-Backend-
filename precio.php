<?php
	$ruta = realpath(__DIR__ . '/../../..');
	require_once($ruta. '/wp-config.php');
	require_once($ruta. '/wp-load.php');
	global $wpdb;
	$entityBody = file_get_contents('php://input');
	$entityBody = json_decode($entityBody);
	$productos = $entityBody->data;	

	$error = '{"error":"FALSE"}';

  	$precio_mayorista = 0;
  	$precio_minorista = 0;
  	$precio_noLogeados = 0;
  	$noLogeados = intval(get_option('noInicialiados'));
	$minorista = intval(get_option('minorista'));
	$mayorista = intval(get_option('mayorista'));

	foreach ($productos as $producto) {
		$precio_noLogeados = $producto->precios[$noLogeados - 1];
		$precio_minorista = $producto->precios[$minorista - 1];
		$precio_mayorista = $producto->precios[$mayorista - 1];
		update_price($value->codigo,$precio_minorista,$precio_mayorista,$precio_noLogeados , $wpdb, $error);
		
	}
	echo ($error);
    function update_price($articulo,$precio_minorista, $precio_mayorista, $precio_noLogeados, $wpdb, $error){
        $item = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_value LIKE '".$articulo."'", OBJECT );
        $item = json_decode(json_encode($item), True);  

        if($item[0]['post_id'] != null || $item[0]['post_id'] != 0 || $item[0]['post_id']!= "" ){
        	$tabla_precio=  'a:10:{s:13:"administrator";a:2:{s:13:"regular_price";s:0:"";s:13:"selling_price";s:0:"";}s:6:"editor";a:2:{s:13:"regular_price";s:0:"";s:13:"selling_price";s:0:"";}s:6:"author";a:2:{s:13:"regular_price";s:0:"";s:13:"selling_price";s:0:"";}s:11:"contributor";a:2:{s:13:"regular_price";s:0:"";s:13:"selling_price";s:0:"";}s:10:"subscriber";a:2:{s:13:"regular_price";s:0:"";s:13:"selling_price";s:0:"";}s:8:"customer";a:2:{s:13:"regular_price";s:0:"";s:13:"selling_price";s:0:"";}s:12:"shop_manager";a:2:{s:13:"regular_price";s:0:"";s:13:"selling_price";s:0:"";}s:9:"mayorista";a:2:{s:13:"regular_price";s:'.strlen($precio_mayorista).':"'.$precio_mayorista.'";s:13:"selling_price";s:0:"";}s:9:"minorista";a:2:{s:13:"regular_price";s:'.strlen($precio_minorista).':"'.$precio_minorista.'";s:13:"selling_price";s:0:"";}s:8:"logedout";a:2:{s:13:"regular_price";s:'.strlen($precio_noLogeados).':"'.$precio_noLogeados.'";s:13:"selling_price";s:0:"";}}';

        	
            $query = "UPDATE {$wpdb->prefix}postmeta SET meta_value = '".$tabla_precio."' WHERE(meta_key LIKE '_role_based_price') AND post_id = ".$item[0]['post_id']." ";
            $wpdb->query($query);
            $error= my_print_error();
            $query = "UPDATE {$wpdb->prefix}postmeta SET meta_value = '".$precio_minorista."' WHERE(meta_key LIKE '_regular_price' OR meta_key LIKE '_price') AND post_id = ".$item[0]['post_id']." ";
            $wpdb->query($query);
            $error= my_print_error();       
        }
        

    }
    function my_print_error(){

    global $wpdb;

    if($wpdb->last_error !== '') :
    	return('{"error":"TRUE"}');
    endif;

    }
 ?>
