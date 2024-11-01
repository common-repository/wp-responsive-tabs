<?php
	
	global $erta_count;
	$erta_count=0;
	
	function erta_func( $atts ) {
		global $erta_count;
		$erta_count++;
		//echo $erta_count.'<br />';		
		
		$tab_content = '';
		
		if($erta_count<2){
			
			$atts = shortcode_atts( array(
			  'orientation' => 'horizontal',
			  'group' => '0'
			), $atts );
			
			$atts['orientation'] = ($atts['orientation']=='vertical'?'vertical':'horizontal');
			
				
				
			if($atts['group']>0){
				
				$tab_content_divs = array();
				$tab_titles = get_post_meta( $atts['group'], 'tab_titles', true );
				$tab_descriptions = get_post_meta( $atts['group'], 'tab_descriptions', true);
				//pree($tab_descriptions);
				$tab_id = $atts['orientation'].'Tab-'.$atts['group'];
				
				
				$tab_content .= '<div id="'.$tab_id.'" class="wprtab-'.$atts['group'].'">';
			
				$tab_content .= '<ul class="resp-tabs-list">';
				if(!empty($tab_titles)){
					$tab_count = 0;
					foreach($tab_titles as $key=>$titles){
						
						$tab_count++;
						
						$the_content_inner = $tab_descriptions[$key];
						/*if(substr($the_content, 0, 1)=='[' && substr($the_content, -1, 1)==']'){
							$the_content = do_shortcode($tab_descriptions[$key]);
							//echo ':)';
						}*/
						
						//remove_shortcode('wprtabs');
						//$the_content_inner = apply_filters('the_content', $the_content_inner);
						$the_content_inner = do_shortcode($the_content_inner);
						//add_shortcode( 'wprtabs', 'erta_func' );
						
						$tab_content.='<li>'.$titles.'</li>';
						$tab_content_divs[] = '<div>
							<p>'.$the_content_inner.'</p>
						</div>';
						
					}
				}
				$tab_content .= '</ul>';
				
				//pree($tab_content_divs);
				
				$tab_content .= '<div class="resp-tabs-container">'.implode(' ', $tab_content_divs).'</div></div>';
				
				$tab_content .= '<script type="text/javascript" language="javascript"> jQuery(document).ready(function($) { $("#'.$tab_id.'").easyResponsiveTabs({ type: \''.$atts['orientation'].'\',width: \'auto\',fit: true
			}); }); </script>';
			}
				
		}
		  
		 return $tab_content;
	}
	add_shortcode( 'wprtabs', 'erta_func' );
	
	
	
	/**
	 * Adds a box to the main column on the Post and Page edit screens.
	 */
	function wprtabs_add_meta_box() {
	
		$screens = array( 'post', 'page' );
	
		foreach ( $screens as $screen ) {
	
			add_meta_box(
				'wprtabs_sectionid',
				   'WP Responsive Tabs',
				'wprtabs_meta_box_callback',
				$screen
			);
		}
	}
	add_action( 'add_meta_boxes', 'wprtabs_add_meta_box' );
	
	/**
	 * Prints the box content.
	 * 
	 * @param WP_Post $post The object for the current post/page.
	 */
	function wprtabs_meta_box_callback( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'wprtabs_meta_box', 'wprtabs_meta_box_nonce' );
	
		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
	
		$tab_titles = get_post_meta( $post->ID, 'tab_titles', true );
		$tab_descriptions = get_post_meta( $post->ID, 'tab_descriptions', true);
		
		$shortcodes = array();
		$shortcodes_arr = array();
	
		$shortcodes_arr['WP Docs']['link'] = 'https://wordpress.org/plugins/wp-docs/developers/';
		$shortcodes_arr['WP Docs']['icon'] = 'https://plugins.svn.wordpress.org/wp-docs/assets/icon-128x128.gif';
		$shortcodes_arr['WP Docs']['codes'] = array('[wpdocs]', '[wpdocs dir="number"]', '[wpdocs dir="number" breadcrumb="true"]', '[wpdocs dir="number" breadcrumb="true" view="list"]', '[wpdocs dir="number" breadcrumb="true" view="icons"]', '[wpdocs dir="number" breadcrumb="true" view="details"]');
	
		$shortcodes_arr['WooCommerce']['link'] = 'https://wordpress.org/plugins/woocommerce/developers/';
		$shortcodes_arr['WooCommerce']['icon'] = 'https://plugins.svn.wordpress.org/woocommerce/assets/icon-128x128.png';
		$shortcodes_arr['WooCommerce']['codes'] = array('[woocommerce_cart]', '[woocommerce_checkout]', '[woocommerce_order_tracking]', '[woocommerce_my_account order_count="12"]', '[recent_products per_page="12" columns="4"]', '[featured_products per_page="12" columns="4"]', '[product id="99"] & [product sku="FOO"]', '[products ids="1, 2, 3, 4, 5"]', '[products skus="foo, bar, baz" orderby="date" order="desc"]', '[add_to_cart id="99"]', '[add_to_cart_url id="99"]', '[product_page id="99"] & [product_page sku="FOO"]', '[product_category category="appliances"]', '[product_categories number="12" parent="0"]', '[sale_products per_page="12"]', '[best_selling_products per_page="12"]', '[top_rated_products per_page="12"]', '[product_attribute attribute="color" filter="black"]', '[related_products per_page="12"]');	
	
		$shortcodes_arr['WP eCommerce']['link'] = 'https://wordpress.org/plugins/wp-e-commerce/developers/';
		$shortcodes_arr['WP eCommerce']['icon'] = 'https://plugins.svn.wordpress.org/wp-e-commerce/assets/icon-128x128.png';
		$shortcodes_arr['WP eCommerce']['codes'] = array('[productspage]', '[shoppingcart]', '[transactionresults]', '[userlog]', '[wpsc_products product_id=000]', '[buy_now_button product_id=000]', '[add_to_cart=000]', '[showcategories]', '[wpsc-cart]', '[wpsc-products]', '[wpsc-add-to-cart]', '[buy_now_button]');
		
		
		
		if(!empty($shortcodes_arr)){
			$shortcodes[] = '<ul>';
			foreach($shortcodes_arr as $section=>$arr){
				$shortcodes[] = '<li><h2>'.$section.'</h2><a href="'.$arr['link'].'" target="_blank"><img src="'.$arr['icon'].'" /></a><ul>';
				$codes = $arr['codes'];
				if(!empty($codes)){
					foreach($codes as $sc){
				
						$shortcodes[] = '<li>'.$sc.'</li>';
					}
				}
				$shortcodes[] = '</ul></li>';
			}
			$shortcodes[] = '</ul>';
		}
		$shortcodes = (!empty($shortcodes)?implode('', $shortcodes):'');
	
	
		echo '<label for="wprtabs_new_field">';
		
		_e( 'Shortcode:', 'wp-rtabs');
		echo '</label> ';
		echo '<input readonly="readonly" type="text" id="wprtabs_new_field" name="wprtabs_new_field" value="[wprtabs group='.$post->ID.' orientation=horizontal]" size="45" />';
		echo '<a class="wprtabs_shortcodes">'.__('Click here for more shortcodes', 'wp-rtabs').'</a><div class="wprtabs_shortcodes_list">'.$shortcodes.'<br />'.__('Note', 'wp-rtabs').': '.__('You can copy/paste these shortcodes in description area and', 'wp-rtabs').' WP Responsive Tabs '.__('will display relevant pages/lists', 'wp-rtabs').'.<br /></div>';
		
		
		include('admin/wprtabs_metabox.php');
	}
	
	
	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	function wprtabs_save_meta_box_data( $post_id ) {
	
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
	
		// Check if our nonce is set.
		if ( ! isset( $_POST['wprtabs_meta_box_nonce'] ) ) {
			return;
		}
	
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['wprtabs_meta_box_nonce'], 'wprtabs_meta_box' ) ) {
			return;
		}
	
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
	
		} else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
	
		/* OK, it's safe for us to save the data now. */
		
		// Make sure that it is set.
		if ( ! isset( $_POST['wprtabs_new_field'] ) ) {
			return;
		}
	
		// Sanitize user input.
		$tab_title = sanitize_wc_rtabs_data($_POST['tab_title']);
		$tab_description = $_POST['tab_description'];//sanitize_wc_rtabs_data(addslashes())
		//pree($tab_title);
		//pree($tab_description);
		//pree($_POST);exit;
		
	
		// Update the meta field in the database.
		update_post_meta( $post_id, 'tab_titles', $tab_title );
		update_post_meta( $post_id, 'tab_descriptions', $tab_description );
		
	}
	add_action( 'save_post', 'wprtabs_save_meta_box_data' );