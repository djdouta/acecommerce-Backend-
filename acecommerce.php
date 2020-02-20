<?php
/**
 * @package vcontrol
 * @version 1.0.1
 */
/*
Plugin Name: Acecommerce
Plugin URI: http://endesarrollo.
Description: Este es un plugin que permite la conexion del sistema ACE de escrtorio con la tienda virtual woocommerce
Version: 1.0.0
Author URI: jesus rojas
*/


//Agregar funcion de configuracion Admin
if(!function_exists("dashboard_function_vcontrol")){
	function dashboard_function_vcontrol(){
		add_menu_page("Acecommerce","Acecommerce","manage_options","m", "acecommerce_options","
						dashicons-products",2 );
	}
}
function acecommerce_options(){
 require_once ABSPATH . "/wp-content/plugins/acecommerce/dashboard/index.php";
}
add_action('admin_menu', 'dashboard_function_vcontrol');

//Css de tabla para Admin
function load_admin_style() {
	wp_enqueue_style( 'admin_css', plugin_dir_url( __FILE__ ) . '/dashboard/acecommerce.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'load_admin_style' );

//Script para cambiar el precio
function wpdocs_selectively_enqueue_admin_script( $hook ) {
    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . '/dashboard/acecommerce.js', array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script' );
