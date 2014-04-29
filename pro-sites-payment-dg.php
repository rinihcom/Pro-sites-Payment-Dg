<?php
/*
Plugin Name: Pro-sites Dealguardian
Plugin URI: http://dizduz.com
Description: Collect IPN information from dealguardian
Author: Fahri Ar
Version: 1.1
Author URI: http://dizduz.com
Text Domain: psdg
Network: true
WDP ID: 498
*/

register_activation_hook(__FILE__,'psts_dg_install');
function psts_dg_install(){
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	global $wpdb;
	$table = $wpdb->base_prefix . 'pro_sites_dealguardian';
	if($wpdb->get_var( "SHOW TABLES LIKE '$table'" ) != $table){
		$sql = 'CREATE TABLE IF NOT EXISTS '.$table.' (
			  `dg_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `transaction_id` varchar(255) NOT NULL,
			  `transaction_amount` varchar(255) NOT NULL,
			  `transaction_date` varchar(50) NOT NULL,
			  `transaction_type` varchar(10) NOT NULL,
			  `transaction_parent_id` bigint(20) NOT NULL,
			  `transaction_affiliate` varchar(255) NOT NULL,
			  `transaction_jv` varchar(255) NOT NULL,
			  `transaction_subscription_id` varchar(255) NOT NULL,
			  `transaction_subscription_pay_number` varchar(255) NOT NULL,
			  `product_name` varchar(255) NOT NULL,
			  `product_id` varchar(255) NOT NULL,
			  `product_price_point` varchar(255) NOT NULL,
			  `buyer_first_name` varchar(255) NOT NULL,
			  `buyer_last_name` varchar(255) NOT NULL,
			  `buyer_email` varchar(255) NOT NULL,
			  `secret_key` varchar(255) NOT NULL,
			  `note` text NOT NULL,
			  PRIMARY KEY (`dg_id`)
		)';
		dbDelta($sql);
	}
}


add_action( 'network_admin_menu', 'menu_page' );
function menu_page(){
	//$page = add_submenu_page( 'psts', __('Dealguardian', 'psts'), __('Dealguardian', 'psts'), 'manage_network_options', 'psts-dg-settings', array(&$this, 'psts_dg_settings') );
	if (is_plugin_active('pro-sites/pro-sites.php') ) {
		add_menu_page( 'Pro Sites Dealguardian','Pro Sites Dealguardian', 'manage_network_options', 'psts_dg', 'psts_dg_view', plugins_url( '/pro-sites-payment-dg/') . 'images/plus.png' );
	}
}


add_action( 'wp_ajax_psts_dg_ipn', 'psts_dg_ipn' );
add_action( 'wp_ajax_nopriv_psts_dg_ipn', 'psts_dg_ipn' );

function psts_dg_ipn(){
	global $wpdb;
	if(!$_POST)
		die();
	$data = '';
	foreach (getallheaders() as $name => $value) {
		$data .= "$name: $value\n";
	}
	$wpdb->query("INSERT INTO {$wpdb->base_prefix}pro_sites_dealguardian(
			transaction_id,
			transaction_amount,
			transaction_date,
			transaction_type,
			transaction_parent_id,
			transaction_affiliate,
			transaction_jv,
			transaction_subscription_id,
			transaction_subscription_pay_number,
			product_name,
			product_id,
			product_price_point,
			buyer_first_name,
			buyer_last_name,
			buyer_email,
			secret_key	
			) VALUES(
			'".$_REQUEST['transaction_id']."',
			'".$_REQUEST['transaction_amount']."',
			'".$_REQUEST['transaction_date']."',
			'".$_REQUEST['transaction_type']."',
			'".$_REQUEST['transaction_parent_id']."',
			'".$_REQUEST['transaction_affiliate']."',
			'".$_REQUEST['transaction_jv']."',
			'".$_REQUEST['transaction_subscription_id']."',
			'".$_REQUEST['transaction_subscription_pay_number']."',
			'".$_REQUEST['product_name']."',
			'".$_REQUEST['product_id']."',
			'".$_REQUEST['product_price_point']."',
			'".$_REQUEST['buyer_first_name']."',
			'".$_REQUEST['buyer_last_name']."',
			'".$_REQUEST['buyer_email']."',
			'".$_REQUEST['secret_key']."'
			) ");
}

function psts_dg_view() {
	global $wpdb,$psts_list;
	$psts_list->manage();
}


include 'manage.php';