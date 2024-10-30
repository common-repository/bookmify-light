<?php
namespace Bookmify;

use Bookmify\Helper;


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }



class HelperService{
	
	
	public static function serviceList() {
		global $wpdb;
		$html = '';
		
		$query 		 = "SELECT
							s.id id,
							s.attachment_id attachment_id,
							s.visibility visibility,
							s.price price,
							s.duration duration,
							s.title title

						FROM 	   	   {$wpdb->prefix}bmify_services s 
							INNER JOIN {$wpdb->prefix}bmify_employee_services es 				ON es.service_id = s.id
							INNER JOIN {$wpdb->prefix}bmify_employees e 						ON es.employee_id = e.id
							WHERE s.visibility='public' AND e.visibility='public' 
						GROUP BY es.service_id ORDER BY s.title";
		$results 		= $wpdb->get_results( $query, OBJECT  );
		
		$html = '<ul class="bookmify_fe_list service_list">';
		
		foreach( $results as $result ){
			$ID						= $result->id;
			$attachmentID			= $result->attachment_id;
			$visibility				= $result->visibility;
			$price					= $result->price;
			$duration				= $result->duration;
			$title					= $result->title;
			$attachmentURL	 		= Helper::bookmifyGetImageByID($attachmentID);
			$selected	 			= bookmify_be_checked($visibility, "public");
			if($attachmentURL != ''){$opened = 'has_image';}else{$opened = '';}
			$price 					= Helper::bookmifyPriceCorrection($price, 'frontend');
			$duration2 				= Helper::bookmifyNumberToDuration($duration);
			if($visibility == 'public'){
				$html .=   '<li data-service-id="'.$ID.'" class="bookmify_fe_service_item bookmify_fe_list_item '.$opened.'">
								<div class="bookmify_fe_list_item_in">
									<input class="i_h_service_title" type="hidden" value="'.$title.'">
									<input class="i_h_service_img" type="hidden" value="'.$attachmentURL.'">
									<input class="i_h_service_duration" type="hidden" value="'.$duration.'">
									<input class="i_h_service_dur_html" type="hidden" value="'.$duration2.'">
									<div class="bookmify_service_heading bookmify_fe_list_item_header">
										<div class="heading_in header_in">
											<div class="img_and_color_holder">
												<div class="img_holder" style="background-image:url('.$attachmentURL.')"></div>
											</div>
											<div class="service_info">
												<div class="left_part">
													<span class="service_title">'.$title.'</span>
													<span class="service_duration">'.$duration2.'</span>
												</div>
												<div class="right_part">
													<span class="service_price"><span>'.$price.'</span></span>
													<span class="service_hover"><span>'.esc_html__('Book Now', 'bookmify').'</span></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>';
			}
				
		}

		$html .= '</ul>';
		
		return $html;
	   	
	}
	
	public static function priceRange($ID){
		global $wpdb;
		
		$query 		= "SELECT MIN(price) AS min_price, MAX(price) AS max_price FROM {$wpdb->prefix}bmify_employee_services WHERE service_id=".$ID;
		$results 	= $wpdb->get_results( $query, OBJECT  );
		return Helper::bookmifyPriceCorrection($results[0]->min_price) .' - '. Helper::bookmifyPriceCorrection($results[0]->max_price);
	}
	
	
}