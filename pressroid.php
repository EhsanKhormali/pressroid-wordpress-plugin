<?php
/**
	 * Plugin Name: My android application backend
	 * Plugin URI: http://www.mywebsite.com/my-first-plugin
	 * Description: provide backend rest api for client application.
	 * Version: 1.0
	 * Author: Ehsan Khormali
	 * Author URI: http://www.mywebsite.com
	 */
	 
	 add_action( 'rest_api_init', function () {
	  register_rest_route( 'pressroid/v1', '/products/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'pr_get_product',
	  ) );
	} );
	
	function ab_get_product($data) 
	{
		$myproduct = wc_get_product($data['id']);
		$p=array(
			'name'=>$myproduct->get_name(),
			'title'=>$myproduct->get_title(),
			'type'=>$myproduct->get_type(),
			'id'=>$myproduct->get_id(),
			'price'=>$myproduct->get_price(),
			'image_url'=>wp_get_attachment_url($myproduct->get_image_id()), 
			'description'=>$myproduct->get_description()
			);

		echo json_encode($p,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS); 
	exit();
	}
	 
	 ?>