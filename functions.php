<?php

	include('wprtabs.inc.php');
	if(!function_exists('pre')){
	function pre($data){
			if(isset($_GET['debug'])){
				pree($data);
			}
		}	 
	} 	
	if(!function_exists('pree')){
	function pree($data){
				echo '<pre>';
				print_r($data);
				echo '</pre>';	
		
		}	 
	} 
	function sanitize_wc_rtabs_data( $input ) {
		if(is_array($input)){		
			$new_input = array();	
			foreach ( $input as $key => $val ) {
				$new_input[ $key ] = (is_array($val)?sanitize_wc_rtabs_data($val):stripslashes(sanitize_text_field( $val )));
			}			
		}else{
			$new_input = stripslashes(sanitize_text_field($input));			
			if(stripos($new_input, '@') && is_email($new_input)){
				$new_input = sanitize_email($new_input);
			}
			if(stripos($new_input, 'http') || wp_http_validate_url($new_input)){
				$new_input = esc_url($new_input);
			}			
		}	
		return $new_input;
	}
	function register_wprtabs_scripts($hook_suffix) {
		
		
		
		
		
		wp_enqueue_script('jquery');	
		
		if(is_admin()){
			
			wp_enqueue_style( 'wprtab-style', plugins_url('css/style.css?t='.time(), (__FILE__)), '', time() );
				
			wp_enqueue_script(
				'wprtab-scripts',
				plugins_url('js/scripts.js', __FILE__)
			);		
						
		}else{			
			
			wp_enqueue_style( 'wprtab-style', plugins_url('css/easy-responsive-tabs.css?t='.time(), (__FILE__)), '', time() );
			
			wp_enqueue_script(
				'wprtab-easyResponsiveTabs',
				plugins_url('js/easyResponsiveTabs.js', __FILE__)
			);		
		}
		
	}	
		
	function get_include_contents($filename) {
		$filename =  plugin_dir_path(__FILE__).$filename;
		if (is_file($filename)) {
			ob_start();
			include $filename;
			return ob_get_clean();
		}
		return false;
	}	
	if (is_admin()) {
		add_action('admin_menu', 'wprtabs_menu');
	}
	function wprtabs_menu()
	{
		global $wp_rtabs_pro, $wp_rtabs_data;
	
		$title = $wp_rtabs_data['Name'] . ' ' . ($wp_rtabs_pro ? ' ' . __('Pro', 'wp-docs') : '');
	
		add_options_page($title, $title, 'activate_plugins', 'wprtabs', 'wprtabs_settings');
	}	
	function wprtabs_settings()
	{
		
		include_once('admin/wprtabs_settings.php');
	}	
		
	function ertab_plugin_links($links) { 
	
		global $wp_rtabs_pro;
		
		$settings_link = '<a href="options-general.php?page=wprtabs">'.__('Settings', 'wp-docs').'</a>';		
		$page_link = '<a href="post-new.php?post_type=page">'.__('Add Page', 'wp-rtabs').'</a>';
		$premium_link = '<a href="https://shop.androidbubbles.com/product/wp-responsive-tabs-pro" title="'.__('Go Premium', 'wp-rtabs').'" target="_blank">'.__('Go Premium', 'wp-rtabs').'</a>'; 
		
		if($wp_rtabs_pro){
			array_unshift($links, $settings_link, $page_link); 
		}else{
			array_unshift($links, $settings_link, $page_link, $premium_link); 
		}
		return $links; 
	}