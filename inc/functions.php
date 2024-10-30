<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
bookmify_pro_cores();
function bookmify_pro_cores(){
	$free = true;

	
	if ($free){
		add_filter( 'plugin_action_links_' . BOOKMIFY_PLUGIN_BASE, 'bookmify_go_pro_version' );
	}
}


function bookmify_go_pro_version($links){
	$links[] = '<a target="_blank" href="https://codecanyon.net/item/bookmify-appointment-booking-wordpress-plugin/23837899" style="color: #43B854; font-weight: bold">'. esc_html__('Go Pro', 'bookmify') .'</a>';
	return $links;
}
// activate chosen option in select
function bookmify_be_selected($chosen, $value){
	if($value == $chosen){
		return 'selected="selected"';
	}
}

// activate chosen option in checkbox
function bookmify_be_checked($chosen, $value){
	if($value == $chosen){
		return 'checked="checked"';
	}
}

// disable input
function bookmify_be_disabled($chosen, $value){
	if($value == $chosen){
		return 'disabled';
	}
}

function bookmify_be_get_uncommon_el_from_multiple_array(&$a, $b) {
    return $a ? array_merge(array_diff($a, $b), array_diff($b, $a)) : $b;
}

//  FILTER
add_filter('wp_kses_allowed_html', 'bookmify_filter_allowed_html', 10, 2);

function bookmify_filter_allowed_html($allowed, $context){

	if (is_array($context))
	{
		return $allowed;
	}

	if ($context === 'post')
	{
		// Custom Allowed Tag Atrributes and Values
		
		$allowed['div']['data-yearly'] = true;
		$allowed['div']['data-value'] = true;
		$allowed['a']['data-entity-id'] = true;
		$allowed['a']['data-page'] = true; 
		$allowed['ul']['data-entity'] = true; 
		$allowed['input']['data-entity-id'] = true;
		$allowed['input']['type=text'] = true;
		$allowed['input']['type=checkbox'] = true;
		$allowed['input']['type=hidden'] = true;
		$allowed['input']['id'] = true;
		$allowed['input']['placeholder'] = true;
		$allowed['input']['class'] = true;
		$allowed['form']['autocomplete'] = true;
		$allowed['input']['type'] = true;
		$allowed['input']['name'] = true;
		$allowed['input']['data-selected-day'] = true;
		$allowed['input']['value'] = true;
		$allowed['input']['checked'] = true;
		$allowed['form']['autocomplete'] = true;
		$allowed['*']['data-*'] = true;
		$allowed['option']['value'] = true;
		$allowed['option']['selected'] = true;
		$allowed['option']['*'] = true;
		
	}

	return $allowed;
}