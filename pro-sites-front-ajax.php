<?php
	define('WP_USE_THEMES', false);
	require( dirname(__FILE__) .'/../../../wp-load.php' );
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