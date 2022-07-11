<?php
/**
	 * Plugin Name: pressroid wordpress plugin
	 * Plugin URI: http://www.ehsankhormali.ir/perssroid_wordpress-plugin
	 * Description: provide backend rest api for client application.
	 * Version: 1.0
	 * Author: Ehsan Khormali
	 * Author URI: http://www.ehsankhormali.ir
	 */
	 
	 //get details of specific order endpoit
	 add_action( 'rest_api_init', function () {
	  register_rest_route( 'pressroid/v1', '/products/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'get_product_detials',
	  ) );
	} );
	
	//get details of specific order
	function get_product_detials($data) 
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
	 
	 //get all products of specific endpoint
	add_action( 'rest_api_init', function () {
	  register_rest_route( 'pressroid/v1', '/orders/(?P<order_id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'get_order_items',
	  ) );
	} );
	
	//get all products of specific order
	 function get_order_items($data)
	 {
		$order=wc_get_order($data['order_id']);
		$order_items=array();
		foreach ( $order->get_items() as $item_id => $item ) {
			$product=$item->get_product();
			 $p=array(
			'name'=>$product->get_name(),
			'title'=>$product->get_title(),
			'type'=>$product->get_type(),
			'id'=>$product->get_id(),
			'price'=>$product->get_price(),
			'image_url'=>wp_get_attachment_url($product->get_image_id()), 
			'description'=>$product->get_description()
			);
			array_push($order_items,$p);
		}
		echo json_encode($order_items,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_LINE_TERMINATORS);
	 }
	 ?>
