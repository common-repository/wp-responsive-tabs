<?php 
/*
	Plugin Name: WP Responsive Tabs
	Plugin URI: https://androidbubble.com/blog/wordpress/plugins/wp-responsive-tabs
	Description: An easy way to create tabs for unique posts/pages and feel freedom to use them anywhere in your content or files.
	Version: 1.2.8
	Author: Fahad Mahmood 
	Text Domain: wp-rtabs
    Domain Path: /languages
	Author URI: https://www.androidbubbles.com
	License: GPL3
*/ 


	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
 
	global $wp_rtabs_pro, $wp_rtabs_data, $wp_rtabs_url;
	
	$wp_rtabs_data = get_plugin_data(__FILE__);
	$wp_rtabs_dir = plugin_dir_path( __FILE__ );
    $wp_rtabs_url = plugin_dir_url( __FILE__ );
	
	$wp_rtabs_pro_file = $wp_rtabs_dir.'pro/wp-rtabs-pro.php';
	
    $wp_rtabs_pro = file_exists($wp_rtabs_pro_file);
    if($wp_rtabs_pro){
        include($wp_rtabs_pro_file);
    }	
	
    include('functions.php');

	
	
	add_action( 'wp_enqueue_scripts', 'register_wprtabs_scripts' );
	if(is_admin()){
		add_action( 'admin_enqueue_scripts', 'register_wprtabs_scripts' );
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'ertab_plugin_links' );
	}