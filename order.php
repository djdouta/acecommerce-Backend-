<?php 
$ruta = realpath(__DIR__ . '/../../..');
require_once($ruta. '/wp-config.php');
require_once($ruta. '/wp-load.php');

$ultimaOrden = get_option('orden_vcontrol');

global $wpdb;

$cliente = [];
$productos = [];

$ordenes_pendientes = $wpdb->query("SELECT * FROM {$wpdb->prefix}woocommerce_order_items WHERE order_item_type LIKE 'line_item' AND order_id > ".$ultimaOrden."", OBJECT );

if($ordenes_pendientes > 1){
    while(true){
      $ultimaOrden = $ultimaOrden + 1;
      $orden_actual = $wpdb->get_results("SELECT order_item_id FROM {$wpdb->prefix}woocommerce_order_items WHERE order_item_type LIKE 'line_item' AND order_id = ".$ultimaOrden);
        if($orden_actual != null){
            $orden_actual = json_decode(json_encode($orden_actual), True);   
           $cliente = agregarCliente($ultimaOrden, $wpdb, $cliente); 
            foreach ($orden_actual as  $value) {  
                foreach ($value as $valor) {
                	//Buscar el valor de el producto varible en el sistema.
                	//order item meta
                    $order_item_id = $valor;
                    $order_meta = $wpdb->get_results("SELECT meta_value, meta_key FROM {$wpdb->prefix}woocommerce_order_itemmeta WHERE (meta_key LIKE '_product_id' OR meta_key LIKE '_variation_id' OR meta_key LIKE '_line_total' OR meta_key LIKE '_qty') AND order_item_id = ".$order_item_id."");                    
                  	 $order_meta = json_decode(json_encode($order_meta), True);
                  	 $sku = buscarSKU($order_meta, $wpdb);
              		 $productos =  agregarProducto($order_meta,$sku, $productos);
                }
               
            } 

          break;
        }

    }
    // $orden_final = [$cliente, $productos];
    $orden_final  = new \stdClass; // Instantiate stdClass object
    $orden_final->cliente = $cliente;
    $orden_final->productos= $productos;
 	echo(json_encode($orden_final, true));    
  	//cambiarOrden($ultimaOrden);
}

else{
	$vacio = new \stdClass();
	$vacio->vacio=true;
	echo(json_encode($vacio));
}

function buscarSKU($order_meta, $wpdb){
	$producto_id = 0;
	$sku = "";
	for($i = 0 ; $i < count($order_meta) ; $i++){
		if($order_meta[$i]["meta_key"] === "_product_id"){
			$producto_id= $order_meta[$i]["meta_key"];
		}
		else if($order_meta[$i]["meta_key"] === "_variation_id" AND $order_meta[$i]["meta_value"] == 0){
			$sku = $wpdb->get_results("SELECT meta_value FROM {$wpdb->prefix}postmeta  WHERE  (meta_key LIKE '_sku' AND post_id  = ".$producto_id." " );
		}
		else if ($order_meta[$i]["meta_key"] === "_variation_id" AND $order_meta[$i]["meta_value"] !== 0){
			$producto_id = $order_meta[$i]["meta_value"];
			$sku = $wpdb->get_results("SELECT meta_value FROM {$wpdb->prefix}postmeta  WHERE  (meta_key LIKE '_sku' AND post_id  = ".$producto_id.")");
			
		}
	}
	$sku = json_decode(json_encode($sku), True);
	return $sku[0]["meta_value"];
}

function agregarCliente($order, $wpdb, $cliente){
	$datosclientes = $wpdb->get_results("SELECT meta_value, meta_key FROM {$wpdb->prefix}postmeta  WHERE  (meta_key LIKE '_billing_first_name' OR meta_key LIKE '_billing_last_name' OR meta_key LIKE '_billing_address_1' OR meta_key LIKE '_billing_state' OR meta_key LIKE '_billing_email' OR meta_key LIKE '_billing_phone' OR meta_key LIKE '_billing_cuit_dni' OR meta_key LIKE '_billing_responsable') AND post_id  = ".$order." " );
	$datosclientes = json_decode(json_encode($datosclientes), True);
	
	$momentaneo = new \stdClass();
		for($i = 0 ; $i < count($datosclientes) ; $i++){
		// foreach($datosclientes[$i] as $clave => $valor) {
			switch ($datosclientes[$i]["meta_key"]) {
				case '_billing_first_name':
					$momentaneo->nombre = $datosclientes[$i]["meta_value"];
					break;
				case '_billing_last_name':
					$momentaneo->apellido = $datosclientes[$i]["meta_value"];
					break;
				case '_billing_address_1':
					$momentaneo->direccion =$datosclientes[$i]["meta_value"];
					break;
				case '_billing_email':
					$momentaneo->correo = $datosclientes[$i]["meta_value"];
					break;
				case '_billing_phone':
					$momentaneo->telefono = $datosclientes[$i]["meta_value"];
					break;
				case '_billing_cuit_dni':
					$momentaneo->dni_cuil = $datosclientes[$i]["meta_value"];
					break;			
				case '_billing_responsable':
					if(strlen($momentaneo->dni_cuil)!== 11){
						$momentaneo->iva = 	2;	
					}
					else{
						switch (strtoupper($datosclientes[$i]["meta_value"])) {
							case 'RESP. INSCRIPTO':
								$momentaneo->iva = 0;
								break;
							case 'MINOTRIBUTO':
								$momentaneo->iva = 1;
								break;
							case 'NO RESPONSABLE':
								$momentaneo->iva = 3;
								break;
							case 'RESP. EXENTO':
								$momentaneo->iva = 4;
								break;
							case 'BIENES DE USO':
								$momentaneo->iva = 5;
								break;
							case 'RESP. NO INSCRIPTO':
							 	$momentaneo->iva = 6;
							 	break; 	
							default:
								$momentaneo->iva = 1;
								break;
						}
					}
				default:
					# code...
					break;
			}

		// }
	} 
	return $momentaneo;

}
function agregarProducto($datas_producto,$sku,$original){

	$momentaneo = new \stdClass();
	for($i = 0 ; $i < count($datas_producto) ; $i++){
        switch ($datas_producto[$i]["meta_key"]) {
            case '_line_total':
          	    $momentaneo->total = $datas_producto[$i]["meta_value"];
            	break;
            case '_qty':
            	 $momentaneo->cantidad = $datas_producto[$i]["meta_value"];
           		break;
        }
    }
    $momentaneo->precio = $momentaneo->total/$momentaneo->cantidad;
    $momentaneo->SKU= $sku;
    array_push($original, $momentaneo);
	return $original; 
	
}
function verificadorvalor(){
   if( $ultimaOrden = get_option("ultimaOrden")){
     return $ultimaOrden;
   }
   else return 1;
}
 


function cambiarOrden($ultimaOrden){
   update_option('orden_vcontrol', $ultimaOrden);
}
 ?>
