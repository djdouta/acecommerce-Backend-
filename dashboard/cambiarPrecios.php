<?php
$ruta = realpath(__DIR__ . '/../../../..');
require_once($ruta. '/wp-config.php');
require_once($ruta. '/wp-load.php');

global $wpdb;

$precio = $_POST['precio'];
$tipo = $_POST['tipo'];


update_option($tipo, $precio);
echo "Precio " .$tipo ." Cambiado";

?>