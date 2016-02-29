<?php 
/**
Plugin Name: EDD Customer Role Manager
Plugin URI: https://wpbean.com/
Description: Easy Digital Downloads Customer Role Manager
Author: wpbean
Version: 1.0
Author URI: https://wpbean.com
text-domain: edd_crm
*/



/*
 *
 * Modify the user role that is given to users that register during checkout depending upon the cart_price 
 *
 * If cart amount is zero it will return free_customer
 *
 * else cart amount is greater than zero it will return premium_customer
 *
 */

add_filter( 'edd_insert_user_args', 'wpb_edd_customer_user_role', 10, 2 );

if( !function_exists('wpb_edd_customer_user_role') ):
function wpb_edd_customer_user_role( $user_args, $user_data ) {
	$cart_price = edd_get_cart_total();

	if( floatval($cart_price) <= 0 ){
		$user_args['role'] = 'free_customer';
	}else {
		$user_args['role'] = 'premium_customer';
	}
	
	return $user_args;
}
endif;



/**
 * Adding custom user roles on plugin activation
 */

register_activation_hook( __FILE__, 'wpb_add_roles_on_plugin_activation' );

function wpb_add_roles_on_plugin_activation() {
    add_role( 'premium_customer', 'Premium Customer', array( 'read' => true, 'level_0' => true ) );
    add_role( 'free_customer', 'Free Customer', array( 'read' => true, 'level_0' => true ) );
}