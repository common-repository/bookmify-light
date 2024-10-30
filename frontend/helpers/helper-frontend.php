<?php
namespace Bookmify;

use Bookmify\HelperFrontend;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }



class HelperFrontend{
	
	public static function bookmifyFeSVG($icon = '', $class = ''){
		return '<img class="bookmify_fe_svg '.$class.'" src="'.BOOKMIFY_ASSETS_URL.'img/'.$icon.'.svg" alt="" />';
	}
	
	public static function bookmifyPreloader($size = '', $extraClass = ''){
		if($size == 1){$size = 'small';}
		$html = '<span class="bookmify_fe_loader '.$size.' '.$extraClass.'">
					<span class="loader_process">
						<span class="ball"></span>
						<span class="ball"></span>
						<span class="ball"></span>
					</span>
				</span>';
		return $html;
	}
	
	public static function cfForAlphaShortcode($serviceID){
		global $wpdb;
		$query 		= "SELECT id,services_ids FROM {$wpdb->prefix}bmify_customfields";
		$results 	= $wpdb->get_results( $query, OBJECT  );
		$cfIDs		= array();
		foreach($results as $result){
			$arr 	= explode(',', $result->services_ids);
			if(in_array($serviceID, $arr)){
				$cfIDs[] = $result->id;
			}
		}
		$cfList				= '';
		$cfFooterPart		= '';
		if(!empty($cfIDs)){
			$query 		= "SELECT * FROM {$wpdb->prefix}bmify_customfields WHERE `id` IN (" . implode(',', array_map('intval', $cfIDs)) . ") ORDER BY position, id";
			$results 	= $wpdb->get_results( $query, OBJECT  );

			if(!empty($results)){
				$cfList .= 				'<div class="bookmify_fe_main_list_item details_holder">';
				$cfList .= 					'<div class="item_header">';
				$cfList .= 						'<div class="header_wrapper">';
				$cfList .= 							'<span class="item_label">'.esc_html__('Details:','bookmify').'</span>';
				$cfList .= 							'<span class="item_result" data-empty="empty"></span>'; // Will be added
				$cfList .= 						'</div>';
				$cfList .= 						'<span class="check_box"><span></span>'.HelperFrontend::bookmifyFeSVG('check-box').'</span>';
				$cfList .= 						'<span class="d_d">'.HelperFrontend::bookmifyFeSVG('drop-down-arrow').'</span>';
				$cfList .= 					'</div>';
				// footer
				$cfList .= 					'<div class="item_footer">';
				$cfFooterPart .= 				'<div class="bookmif_fe_cf_list">';
				$requiredKey = 0;
				foreach($results as $result){
					$cfID		= $result->id;
					$cfType 	= $result->cf_type;
					$cfRequired = $result->cf_required;
					$values 	= unserialize($result->cf_value);
					$options 	= '';
					if(!empty($values)){
						foreach($values as $keyy => $value){
							if($cfType == 'checkbox'){
								$options .= '<label>
												<span class="bookmify_fe_checkbox">
													<input class="req" type="checkbox" />
													<span>'.HelperFrontend::bookmifyFeSVG('checked').'</span>
													<span class="checkmark">'.HelperFrontend::bookmifyFeSVG('checked').'</span>
												</span>
												<span class="count_title">
													'.$value['label'].'
												</span>
											</label>';
							}else if($cfType == 'radiobuttons'){
								$options .= '<label>
												<span class="bookmify_be_radiobox">
													<input class="req" type="radio" name="radio" />
													<span></span>
												</span>
												<span class="label_in">
													<span class="e_name">'.$value['label'].'</span>
												</span>
											</label>';
							}else if($cfType == 'textcontent'){
								$options .= '<div class="bookmify_fe_infobox"><label>'.$value['label'].'</label></div>';
							}else if($cfType == 'selectbox'){
								$options .= '<option value="t'.$keyy.'">'.$value['label'].'</option>';
							}
						}
					}
					$itemIn = '';
					$requiredStar = '';
					$cfRequiredClass = '';
					if($cfRequired == 1){
						$requiredKey++; // all required customfields
						$requiredStar = '<span class="reqq">*</span>';
						$cfRequiredClass = 'required_cf';
					}
					if($cfType == 'checkbox'){
						$itemIn .= '<div class="bookmify_fe_cf_checkbox bookmify_fe_cf_item">';
						$itemIn .= 		'<div class="bookmify_fe_cf_checkbox_top bookmify_fe_cf_top">';
						$itemIn .= 			'<label>'.$result->cf_label.$requiredStar.'</label>';
						$itemIn .= 		'</div>';
						$itemIn .= 		'<div class="bookmify_fe_cf_checkbox_bot bookmify_fe_cf_bot">';
						$itemIn .= 			$options;
						$itemIn .= 		'</div>';
						$itemIn .= '</div>';
					}else if($cfType == 'radiobuttons'){
						$itemIn .= '<div class="bookmify_fe_cf_radiobox bookmify_fe_cf_item">';
						$itemIn .= 		'<div class="bookmify_fe_cf_radiobox_top bookmify_fe_cf_top">';
						$itemIn .= 			'<label>'.$result->cf_label.$requiredStar.'</label>';
						$itemIn .= 		'</div>';
						$itemIn .= 		'<div class="bookmify_fe_cf_radiobox_bot bookmify_fe_cf_bot">';
						$itemIn .= 			$options;
						$itemIn .= 		'</div>';
						$itemIn .= '</div>';
					}else if($cfType == 'text'){
						$itemIn .= '<div class="bookmify_fe_cf_text bookmify_fe_cf_item">';
						$itemIn .= 		'<div class="bookmify_fe_cf_text_top bookmify_fe_cf_top">';
						$itemIn .= 			'<label>'.$result->cf_label.$requiredStar.'</label>';
						$itemIn .= 		'</div>';
						$itemIn .= 		'<div class="bookmify_fe_cf_text_bot bookmify_fe_cf_bot">';
						$itemIn .= 			'<input type="text" value="" />';
						$itemIn .= 		'</div>';
						$itemIn .= '</div>';
					}else if($cfType == 'textarea'){
						$itemIn .= '<div class="bookmify_fe_cf_textarea bookmify_fe_cf_item">';
						$itemIn .= 		'<div class="bookmify_fe_cf_textarea_top bookmify_fe_cf_top">';
						$itemIn .= 			'<label>'.$result->cf_label.$requiredStar.'</label>';
						$itemIn .= 		'</div>';
						$itemIn .= 		'<div class="bookmify_fe_cf_textarea_bot bookmify_fe_cf_bot">';
						$itemIn .= 			'<textarea></textarea>';
						$itemIn .= 		'</div>';
						$itemIn .= '</div>';
					}else if($cfType == 'textcontent'){
						$itemIn .= '<div class="bookmify_fe_cf_textcontent bookmify_fe_cf_item">';
						$itemIn .= 		'<div class="bookmify_fe_infobox bookmify_fe_cf_top">';
						$itemIn .= 			'<label>'.$result->cf_label.$requiredStar.'</label>';
						$itemIn .= 		'</div>';
						$itemIn .= '</div>';
					}else if($cfType == 'selectbox'){
						$itemIn .= '<div class="bookmify_fe_cf_select bookmify_fe_cf_item">';
						$itemIn .= 		'<div class="bookmify_fe_cf_select_top bookmify_fe_cf_top">';
						$itemIn .= 			'<label>'.$result->cf_label.$requiredStar.'</label>';
						$itemIn .= 		'</div>';
						$itemIn .= 		'<div class="bookmify_fe_cf_select_bot bookmify_fe_cf_bot">';
						$itemIn .= 			'<select>
												<option disabled selected value>'.esc_html__('Select an option', 'bookmify').'</option>
												'.$options.'
											 </select>';
						$itemIn .= 		'</div>';
						$itemIn .= '</div>';
					}
					$itemIn .= '<input type="hidden" value="'.$cfID.'" class="bookmify_fe_cf_id" />';
					
					$cfFooterPart .= 				'<div class="bookmify_fe_cf_list_item '.$cfRequiredClass.'">
														<div class="cf_item_in">';
					$cfFooterPart .=	 					$itemIn;
					$cfFooterPart .= 					'</div>';
					$cfFooterPart .= 				'</div>';
				}
				$cfFooterPart .= 					'</div>';
				
				$disabled = '';
				if($requiredKey > 0){
					$disabled = 'disabled';
				}
//				$cfFooterPart .= 					'<div class="bookmify_fe_alpha_next_button cf_button '.$disabled.'">
				$cfFooterPart .= 					'<div class="bookmify_fe_alpha_next_button cf_button">
														<a href="#">'.esc_html__('Next', 'bookmify').'</a>
													</div>';
				$cfFooterPart .= 				'</div>';

				$cfList	.= 					$cfFooterPart;
				// --------------------------------------
				$cfList .= 				'</div>';
			}
		}
		
		
		// remove whitespaces form the HTML
		$search = array(
			'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
			'/[^\S ]+\</s',  // strip whitespaces before tags, except space
			'/(\s)+/s'       // shorten multiple whitespace sequences
		);
		$replace = array(
			'>',
			'<',
			'\\1'
		);
		$cfList 			= preg_replace($search, $replace, $cfList);
		$cfFooterPart 		= preg_replace($search, $replace, $cfFooterPart);
		$array = array();
		$array['content'] 	= $cfList;
		$array['footer'] 	= $cfFooterPart;
		return $array;
	}
	
}