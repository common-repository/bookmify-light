<?php
namespace Bookmify;


use Bookmify\Helper;
use Bookmify\HelperTime;
use Bookmify\HelperService;
use Bookmify\HelperFrontend;
use Bookmify\NotificationManagement;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }



class BookmifyAlpha{
	
	
	public static $args;
	
	
    public function __construct(){
		
		add_shortcode( 'bookmify_app_alpha', [$this, 'render'] );
		
		// get employee list of selected service
		add_action( 'wp_ajax_nopriv_ajaxQueryGetEmployeeList', [$this, 'ajaxQueryGetEmployeeList'] );
		add_action( 'wp_ajax_ajaxQueryGetEmployeeList', [$this, 'ajaxQueryGetEmployeeList'] );
		// get days off of selected employee
		add_action( 'wp_ajax_nopriv_ajaxQueryGetEmployeeDaysOff', [$this, 'ajaxQueryGetEmployeeDaysOff'] );
		add_action( 'wp_ajax_ajaxQueryGetEmployeeDaysOff', [$this, 'ajaxQueryGetEmployeeDaysOff'] );
		// get time slots of selected date
		add_action( 'wp_ajax_nopriv_ajaxQueryGetTimeSlotsOfSelectedDay', [$this, 'ajaxQueryGetTimeSlotsOfSelectedDay'] );
		add_action( 'wp_ajax_ajaxQueryGetTimeSlotsOfSelectedDay', [$this, 'ajaxQueryGetTimeSlotsOfSelectedDay'] );
		// check customer email
		add_action( 'wp_ajax_nopriv_ajaxCheckCustomerDetails', [$this, 'ajaxCheckCustomerDetails'] );
		add_action( 'wp_ajax_ajaxCheckCustomerDetails', [$this, 'ajaxCheckCustomerDetails'] );
		// create new appointment
		add_action( 'wp_ajax_nopriv_ajaxCreateNewAppointment', [$this, 'ajaxCreateNewAppointment'] );
		add_action( 'wp_ajax_ajaxCreateNewAppointment', [$this, 'ajaxCreateNewAppointment'] );

    }
	

	public function render( $args, $content = '' ) {
	   	$defaults =	shortcode_atts(
			array(
				'class'		=> '',
				'id'		=> '',			
			), $args
		);
		
		self::$args = $defaults;
		
		$servicelist 	= HelperService::serviceList();
		$html 			= '';
		$extraClass 	= '';
		$idAttr 		= '';
		if(self::$args['class'] != ''){
			$extraClass	= self::$args['class'];
		}
		if(self::$args['id'] != ''){
			$idAttr		= ' id="'.self::$args['id'].'"';
		}
		
		
		$success = 	'<div class="bookmify_fe_success abs">
						<span class="span_bg"></span>
						<div class="success_wrapper">
							<div class="success_in">
								<div class="svg_holder"><span>'.HelperFrontend::bookmifyFeSVG('check-mark').'</span></div>
								<div class="content_holder">
									<div class="success_title">
										<h3>'.esc_html__('Thank you!', 'bookmify').'</h3>
										<p>'.esc_html__('Your appointment is succesfully received. Please meet us at your selected date and time.', 'bookmify').'</p>
									</div>
									<div class="success_content">
										<p>'.esc_html__('For any kind of inquiry, please call us at 543-323-3456', 'bookmify').'</p>
									</div>
								</div>
							</div>
							<div class="success_footer">
								<a href="#">'.esc_html__('Go to services', 'bookmify').HelperFrontend::bookmifyFeSVG('right-arrow').'</a>
							</div>
						</div>
					</div>';
		$html .= '<div class="bookmify_fe_app bookmify_fe_alpha '.$extraClass.'"'.$idAttr.'>';
		// --------------------
		
		
		// --------------------
		$html .= $success;
		$html .= 	'<div class="bookmify_fe_app_in">';
		$html .=	'<div class="bookmify_fe_hidden_info">
						<h1>WordPress Appointment Booking Plugin</h1>
						<h1>Online Reservation Plugin</h1>
						<h1>Appointment Booking Plugin</h1>
						<h1>Booking Plugin</h1>
						<input class="bf_mttb" value="'.get_option( 'bookmify_be_mintime_tobooking', 'disabled' ).'" type="hidden" />
						<span class="bf_right_arrow_svg">'.HelperFrontend::bookmifyFeSVG('right-arrow').'</span>
						
						<div class="bf_details_info">
							<div class="item_details">
								<div class="item_row just_info">
									<span>'.esc_html__('Please just fill out the form.', 'bookmify').'</span>
								</div>
								<div class="item_row input_row input_first_name required_field bookmify_fe_moving_input">
									<div class="input_wrapper">
										<input type="text" placeholder="" value="" />
										<span class="moving_placeholder"><span>'.esc_html__('First Name', 'bookmify').'</span> *</span>
									</div>
								</div>
								<div class="item_row input_row input_last_name required_field bookmify_fe_moving_input">
									<div class="input_wrapper">
										<input type="text" placeholder="" value="" />
										<span class="moving_placeholder"><span>'.esc_html__('Last Name', 'bookmify').'</span> *</span>
									</div>
								</div>
								<div class="item_row input_row input_email required_field bookmify_fe_moving_input">
									<div class="input_wrapper">
										<input type="text" placeholder="" value="" />
										<span class="moving_placeholder"><span>'.esc_html__('Email', 'bookmify').'</span> *</span>
									</div>
								</div>
								<div class="item_row input_row input_phone bookmify_fe_moving_input">
									<div class="input_wrapper">
										<input type="text" placeholder="" value="" />
										<span class="moving_placeholder"><span>'.esc_html__('Phone', 'bookmify').'</span></span>
									</div>
								</div>
								<div class="item_row input_row input_message bookmify_fe_moving_input">
									<div class="input_wrapper">
										<textarea></textarea>
										<span class="moving_placeholder"><span>'.esc_html__('Message', 'bookmify').'</span></span>
									</div>
								</div>
								<div class="item_row input_row input_done">
									<div class="input_wrapper">
										<a href="#">
											<span class="text">'.esc_html__('Done','bookmify').'</span>
											<span class="save_process">
												<span class="ball"></span>
												<span class="ball"></span>
												<span class="ball"></span>
											</span>
										</a>
									</div>
								</div>
							</div>
						</div>
						
						<div class="bf_people_count_section">
							<div class="bookmify_fe_main_list_item counter_holder">
								<div class="item_header">
									<div class="header_wrapper">
										<span class="item_label">'.esc_html__('People coming together:','bookmify').'</span>
										<span class="item_result" data-empty="empty"></span>
									</div>
									<span class="check_box"><span></span>'.HelperFrontend::bookmifyFeSVG('check-box').'</span>
									<span class="d_d">'.HelperFrontend::bookmifyFeSVG('drop-down-arrow').'</span>
								</div>
								<div class="item_footer">
									'.HelperFrontend::bookmifyPreloader(1, 'loading').'
								</div>
							</div>
						</div>
						
						<div class="bookmify_be_months_hidden">
							<input class="jan" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 1), 1 ).'" />
							<input class="feb" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 2), 1 ).'" />
							<input class="mar" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 3), 1 ).'" />
							<input class="apr" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 4), 1 ).'" />
							<input class="may" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 5, 1) ).'" />
							<input class="jun" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 6, 1) ).'" />
							<input class="jul" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 7, 1) ).'" />
							<input class="aug" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 8, 1) ).'" />
							<input class="sep" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 9, 1) ).'" />
							<input class="oct" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 10, 1) ).'" />
							<input class="nov" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 11, 1) ).'" />
							<input class="dec" type="hidden" value="'.date_i18n( 'F', mktime(0, 0, 0, 12, 1) ).'" />
							<input class="def" type="hidden" value="'.get_option( 'bookmify_be_date_format', 'd F, Y' ) .'" />
						</div>
						
						<div class="bf_people_count_content">
							<div class="bookmif_fe_count_list_item">
								<div class="count_item_in">
									<div class="count_label">
										<label>
											<span class="bookmify_fe_checkbox">
												<input class="req" type="checkbox" />
												<span>'.HelperFrontend::bookmifyFeSVG('checked').'</span>
												<span class="checkmark">'.HelperFrontend::bookmifyFeSVG('checked').'</span>
											</span>
											<span class="count_title">
												'.esc_html__('Count', 'bookmify').'
											</span>
										</label>
									</div>
									<div class="extra_qty">
										<div class="bookmify_fe_quantity small disabled">
											<input class="extra_quantity" readonly disabled type="number" min="1" max="" value="1" />
											<span class="increase"><span></span></span>
											<span class="decrease"><span></span></span>
										</div>
									</div>
								</div>
							</div>
							<div class="bookmify_fe_alpha_next_button">
								<a href="#">'.esc_html__('Next', 'bookmify').'</a>
						  	</div>
						</div>
						
					</div>';
		$html .=   '<div class="bookmify_fe_price_hidden">
						<input class="currency_format" type="hidden" value="'.Helper::bookmifyGetIconPrice().'" />
						<input class="currency_position" type="hidden" value="'.get_option( 'bookmify_be_currency_position', 'lspace' ).'" />
						<input class="price_format" type="hidden" value="'.get_option( 'bookmify_be_price_format', 'cd' ).'" />
						<input class="price_decimal" type="hidden" value="'.get_option( 'bookmify_be_price_decimal', 2 ).'" />
					</div>';
		$html .= 	'<div class="bookmify_fe_wait">'.HelperFrontend::bookmifyPreloader('', 'loading big').'</div>';
		// header
		$html .= 		'<div class="bookmify_fe_app_header">';
		$html .= 			'<span class="span_bg"></span>';
		$html .= 			'<div><div>';
		$html .= 				'<h3 class="choose">'.esc_html__('Choose a Service','bookmify').'</h3>';
		$html .= 				'<h3 class="back_to">'.esc_html__('Back to Services','bookmify').'</h3>';
		$html .= 				'<span class="arrow">'.HelperFrontend::bookmifyFeSVG('left-arrow').'</span>';
		$html .= 			'</div></div>';
		$html .= 		'</div>';
		
		// content
		$html .= 		'<div class="bookmify_fe_app_content">';
//		$html .= 			'<div class="bookmify_fe_alpha_footer">
//								<a target="_blank" href="https://themeforest.net/user/frenify">
//									<span class="frenify_developed_text">'.esc_html__('Developed by','bookmify').'</span>
//									<span class="frenify">Frenify</span>
//								</a>
//							</div>';
		$html .= 			'<div class="bookmify_fe_service_list">'.$servicelist.'</div>';
		$html .= 			'<div class="bookmify_fe_main_list abs hidden">';
		
		// ***************************************************************************************************************************
		// ************************************************       SERVICE       ******************************************************
		// ***************************************************************************************************************************
		$html .= 				'<div class="bookmify_fe_main_list_item service_holder">';
		$html .= 					'<div class="item_header">';
		$html .= 						'<div class="info_top">';
		$html .= 							'<div class="img_holder"></div>';
		$html .= 							'<div class="chosen_holder">';
		$html .= 								'<span class="text">'.esc_html__('you have chosen','bookmify').'</span>';
		$html .= 								HelperFrontend::bookmifyFeSVG('check-box');
		$html .= 							'</div>';
		$html .= 						'</div>';
		$html .= 						'<div class="info_bottom">';
		$html .= 							'<h3></h3>'; // will be added
		$html .= 							'<p></p>'; // will be added
		$html .= 						'</div>';
		$html .= 					'</div>';
		$html .= 				'</div>';
		// ***************************************************************************************************************************
		// ************************************************       SPECIALIST       ***************************************************
		// ***************************************************************************************************************************
		$html .= 				'<div class="bookmify_fe_main_list_item specialist_holder">';
		$html .= 					'<div class="item_header">';
		$html .= 						'<div class="header_wrapper">';
		$html .= 							'<span class="item_label">'.esc_html__('Specialist:','bookmify').'</span>';
		$html .= 							'<span class="item_result" data-empty="empty"></span>'; // Will be added
		$html .= 						'</div>';
		$html .= 						'<span class="check_box"><span></span>'.HelperFrontend::bookmifyFeSVG('check-box').'</span>';
		$html .= 						'<span class="d_d">'.HelperFrontend::bookmifyFeSVG('drop-down-arrow').'</span>';
		$html .= 					'</div>';
		$html .= 					'<div class="item_footer">';
		$html .= 						HelperFrontend::bookmifyPreloader(1, 'loading'); 	// this preloader will be changed to its content
		$html .= 					'</div>';
		$html .= 				'</div>';
		// ***************************************************************************************************************************
		// **************************************************       DATE       *******************************************************
		// ***************************************************************************************************************************
		$html .= 				'<div class="bookmify_fe_main_list_item date_holder">';
		$html .= 					'<div class="item_header">';
		$html .= 						'<div class="header_wrapper">';
		$html .= 							'<span class="item_label">'.esc_html__('Date:','bookmify').'</span>';
		$html .= 							'<span class="item_result" data-empty="empty"></span>'; // Will be added
		$html .= 						'</div>';
		$html .= 						'<span class="check_box"><span></span>'.HelperFrontend::bookmifyFeSVG('check-box').'</span>';
		$html .= 						'<span class="d_d">'.HelperFrontend::bookmifyFeSVG('drop-down-arrow').'</span>';
		$html .= 					'</div>';
		$html .= 					'<div class="item_footer">';
		$html .= 						HelperFrontend::bookmifyPreloader(1, 'loading'); 	// this preloader will be changed to its content
		$html .= 					'</div>';
		$html .= 				'</div>';
		// ***************************************************************************************************************************
		// *************************************************       CUSTOMER       ****************************************************
		// ***************************************************************************************************************************
		$html .= 				'<div class="bookmify_fe_main_list_item customer_holder">';
		$html .= 					'<div class="item_header">';
		$html .= 						'<div class="header_wrapper">';
		$html .= 							'<span class="item_label">'.esc_html__('Customer:','bookmify').'</span>';
		$html .= 							'<span class="item_result" data-empty="empty"></span>'; // Will be added
		$html .= 						'</div>';
		$html .= 						'<span class="check_box"><span></span>'.HelperFrontend::bookmifyFeSVG('check-box').'</span>';
		$html .= 						'<span class="d_d">'.HelperFrontend::bookmifyFeSVG('drop-down-arrow').'</span>';
		$html .= 					'</div>';
		$html .= 					'<div class="item_footer">';
		$html .= 						HelperFrontend::bookmifyPreloader(1, 'loading'); 	// this preloader will be changed to its content
		$html .= 					'</div>';
		$html .= 				'</div>';
		// ***************************************************************************************************************************
		// *************************************************       BOTTOM       ******************************************************
		// ***************************************************************************************************************************
		$html .= 				'<div class="bookmify_fe_main_list_item bottom_holder">';
		$html .= 					'<div class="item_header">';
		
		$html .= 						'<div class="price_holder">';
		$html .= 							'<div class="price_in">';
		$html .= 								'<div class="payment_wrap">';
		$html .= 									'<span class="total_text">'.esc_html__('Payment Method', 'bookmify').'</span>';
		
		
		$paymentON = 'disabled';
		$paymentDD = '';
		$html .= 									'<span class="total_result '.$paymentON.'">
														<span class="t_text">'.esc_html__('On-site', 'bookmify').'</span>
														<span class="d_d">'.HelperFrontend::bookmifyFeSVG('drop-down-arrow').'</span>
														'.$paymentDD.'
													</span>
													
												</div>';
		$html .= 								'<div class="price_wrap">';
		$html .= 									'<span class="total_text">'.esc_html__('Total Price', 'bookmify').'</span>';
		$html .= 									'<span class="total_price">'.Helper::bookmifyPriceCorrection(0).'</span>';
		$html .= 								'</div>';
		$html .= 							'</div>';
		$html .= 						'</div>';
		
		$html .= 						'<div class="submit_holder disabled">';
		$html .= 							'<a href="#" class="bookmify_fe_main_button bookmify_fe_approve_button enabled">
												<span class="text">'.esc_html__('Approve Booking','bookmify').'</span>
												<span class="save_process">
													<span class="ball"></span>
													<span class="ball"></span>
													<span class="ball"></span>
												</span>
											</a>
											<div class="bookmify_be_paypal_payment_button bookmify_fe_approve_button"></div>
											<a href="#" class="bookmify_be_stripe_payment_button bookmify_fe_approve_button"></a>
										</div>';
		
		$html .= 					'</div>';
		$html .= 				'</div>';
		
		$html .= 			'</div>';
		$html .= 		'</div>';
		
		// footer
		$html .= 		'<div class="bookmify_fe_app_footer"></div>';
		
		$html .= 	'</div>';
		$html .= '</div>';
		
	   	return $html;
	}
	
	
	public function ajaxQueryGetEmployeeList(){
		global $wpdb;
		
		$isAjaxCall 			= false;
		if (!empty($_POST['bookmify_data'])) {
			$isAjaxCall 		= true;
			$serviceID			= $_POST['bookmify_data'];
			

			// **************************************************************************************************************
			// GET EMPLOYEE LIST
			// **************************************************************************************************************
			$serviceID 			= esc_sql($serviceID);
			$query 		 = "SELECT
								e.first_name firstName,
								e.last_name lastName,
								e.id empID,
								es.price servicePrice,
								es.capacity_min capacityMin,
								es.capacity_max capacityMax

							FROM 	   	   {$wpdb->prefix}bmify_employee_services es 
								INNER JOIN {$wpdb->prefix}bmify_employees e 				ON es.employee_id = e.id

							WHERE e.visibility='public' AND es.service_id=".$serviceID." ORDER BY e.first_name";
			$results 		= $wpdb->get_results( $query, OBJECT  );

			$employeeList 	= '<ul class="bookmify_fe_radio_items employe_list">';
			foreach($results as $result){
				$employeeList .=    '<li data-employee-id="'.$result->empID.'" class="bookmify_fe_radio_item employee_item">
										<div class="radio_inner">
											<input type="hidden" class="i_h_employee_name" value="'.$result->firstName.' '.$result->lastName.'" />
											<input type="hidden" class="i_h_service_price" value="'.$result->servicePrice.'" />
											<input type="hidden" class="i_h_service_cap_min" value="'.$result->capacityMin.'" />
											<input type="hidden" class="i_h_service_cap_max" value="'.$result->capacityMax.'" />
											
											<label>
												<span class="bookmify_be_radiobox">
													<input class="req" type="radio" name="radio" />
													<span></span>
												</span>
												<span class="label_in">
													<span class="e_name">'.$result->firstName.' '.$result->lastName.'</span>
													<span class="e_symbol">—</span>
													<span class="s_price">'.Helper::bookmifyPriceCorrection($result->servicePrice, 'frontend').'</span>
												</span>
											</label>
										</div>
									</li>';
			}

			$employeeList .= '</ul>';
			
			$employeeList .= '<div class="bookmify_fe_alpha_next_button disabled">
								<a href="#">'.esc_html__('Next', 'bookmify').'</a>
							  </div>';
			
			// **************************************************************************************************************
			// GET EXTRAS LIST
			// **************************************************************************************************************
			$serviceID 		= esc_sql($serviceID);
			$query 		 = "SELECT
								es.title extraTitle,
								es.id extraID,
								es.duration extraDuration,
								es.price extraPrice,
								es.capacity_max extraMax

							FROM 	   	   {$wpdb->prefix}bmify_extra_services es

							WHERE es.service_id=".$serviceID;
			$results 		= $wpdb->get_results( $query, OBJECT  );
			$extraList		= '';
			$footerPart		= '';
			if(!empty($results)){
				$extraList .= 				'<div class="bookmify_fe_main_list_item extra_holder">';
				$extraList .= 					'<div class="item_header">';
				$extraList .= 						'<div class="header_wrapper">';
				$extraList .= 							'<span class="item_label">'.esc_html__('Extras:','bookmify').'</span>';
				$extraList .= 							'<span class="item_result" data-empty="empty"></span>'; // Will be added
				$extraList .= 						'</div>';
				$extraList .= 						'<span class="check_box"><span></span>'.HelperFrontend::bookmifyFeSVG('check-box').'</span>';
				$extraList .= 						'<span class="d_d">'.HelperFrontend::bookmifyFeSVG('drop-down-arrow').'</span>';
				$extraList .= 					'</div>';
				// footer
				$extraList .= 					'<div class="item_footer">';
				$footerPart .= 						'<div class="bookmif_fe_extras_list">';
				foreach($results as $result){
					$footerPart .= 					'<div class="bookmif_fe_extras_list_item">
														<div class="extra_item_in">';
					if($result->extraDuration == 0){
						$extraDurationContent = '('.Helper::bookmifyPriceCorrection($result->extraPrice, 'frontend').')';
					}else{
						$extraDurationContent = '('.Helper::bookmifyNumberToDuration($result->extraDuration).'/'.Helper::bookmifyPriceCorrection($result->extraPrice, 'frontend').')';
					}
					$footerPart .=	 						'<div class="extra_label">
																<label>
																	<span class="bookmify_fe_checkbox">
																		<input class="req" type="checkbox" />
																		<span>'.HelperFrontend::bookmifyFeSVG('checked').'</span>
																		<span class="checkmark">'.HelperFrontend::bookmifyFeSVG('checked').'</span>
																	</span>
																	<input class="i_h_extra_duration" type="hidden" value="'.$result->extraDuration.'" />
																	<input class="i_h_extra_title" type="hidden" value="'.$result->extraTitle.'" />
																	<input class="i_h_extra_id" type="hidden" value="'.$result->extraID.'" />
																	<input class="i_h_extra_price" type="hidden" value="'.$result->extraPrice.'" />
																	<span class="extra_title_duration">
																		<span class="extra_title">'.$result->extraTitle.'</span>
																		<span class="extra_duration">'.$extraDurationContent.'</span>
																	</span>
																</label>
															</div>
															<div class="extra_qty">
																<div class="bookmify_fe_quantity small disabled">
																	<input class="extra_quantity" readonly disabled type="number" min="1" max="'.$result->extraMax.'" value="1" />
																	<span class="increase"><span></span></span>
																	<span class="decrease"><span></span></span>
																</div>
															</div>';
					$footerPart .= 							'</div>';
					$footerPart .= 						'</div>';
				}
				$footerPart .= 						'</div>';
				$footerPart .= 						'<div class="bookmify_fe_alpha_next_button">
														<a href="#">'.esc_html__('Next', 'bookmify').'</a>
													</div>';
				$footerPart .= 					'</div>';
				
				$extraList	.= 					$footerPart;
				// --------------------------------------
				$extraList .= 				'</div>';
			}
			
			
			// **************************************************************************************************************
			// GET CUSTOMFIELDS LIST
			// **************************************************************************************************************
			$array = HelperFrontend::cfForAlphaShortcode($serviceID);

			// remove whitespaces form the ajax HTML
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
			$employeeList 	= preg_replace($search, $replace, $employeeList);
			$extraList 		= preg_replace($search, $replace, $extraList);
			$footerPart 	= preg_replace($search, $replace, $footerPart);


			$buffyArray = array(
				'html'				=> $employeeList, 			// employee list
				'html2'				=> $extraList,				// extras list
				'html3'				=> $footerPart,				// footer part of extras
				'html4'				=> $array['content'],		// footer part of extras
				'html5'				=> $array['footer'],		// footer part of extras
			);
			if ( true === $isAjaxCall ) {die(json_encode($buffyArray));} 
			else {return json_encode($buffyArray);}
		}
	}
	
	public function ajaxQueryGetEmployeeDaysOff(){
		global $wpdb;
		$isAjaxCall 			= false;
		
		if (!empty($_POST['bookmify_employee_id'])) {
			$isAjaxCall			= true;
			$employeeID 		= $_POST['bookmify_employee_id'];
			
			// получение неежегодных выходных дней (по дням) из БД
			$html				= array();
			$today				= HelperTime::getCurrentDateTimeWithoutFormat();
			$today				= $today->format('Y-m-d');
			$employeeID 		= esc_sql($employeeID);
			$today 				= esc_sql($today);
			$query 				= "SELECT date FROM {$wpdb->prefix}bmify_dayoff WHERE (employee_id=".$employeeID." OR employee_id IS NULL) AND date >= '".$today."' AND every_year=0";
			$results 			= $wpdb->get_results( $query, OBJECT  );
			foreach($results as $result){
				$html[] 		= $result->date;
			}
			// получение ежегодных выходных дней (по дням) из БД
			$arr2				= array();
			$employeeID 		= esc_sql($employeeID);
			$today 				= esc_sql($today);
			$query 				= "SELECT date FROM {$wpdb->prefix}bmify_dayoff WHERE (employee_id=".$employeeID." OR employee_id IS NULL) AND date >= '".$today."' AND every_year=1";
			$results 			= $wpdb->get_results( $query, OBJECT  );
			foreach($results as $result){
				$arr2[] 		= date('m-d',strtotime($result->date)); // month/day
			}
			
			// получение выходных дней недели (по каким дням недели отдыхает работник) из БД
			$employeeID 		= esc_sql($employeeID);
			$query 				= "SELECT start_time,end_time,day_index FROM {$wpdb->prefix}bmify_employee_business_hours WHERE employee_id=".$employeeID;
			$results 			= $wpdb->get_results( $query, OBJECT  );
			$dayIndex 			= [1,2,3,4,5,6,7];
			foreach($results as $result){
				$endTimeInMinutes 	= date('H', strtotime($result->end_time))*60+date('i', strtotime($result->end_time));
				if($endTimeInMinutes == 0){
					$endTimeInMinutes = 24 * 60;
				}
				$startTimeInMinutes = date('H', strtotime($result->start_time))*60+date('i', strtotime($result->start_time));
				$endTimeInMinutes  	= $endTimeInMinutes - $startTimeInMinutes;
				if($endTimeInMinutes > 0){
					$del_val 		= $result->day_index;
					if (($key = array_search($del_val, $dayIndex)) !== false) {
						unset($dayIndex[$key]);
					}
				}
			}
			
			// отправка обработанных данных
			$buffyArray = array(
				'bookmify_be_data' 		=> $html,
				'bookmify_be_time' 		=> $dayIndex,
				'arr2' 					=> $arr2,
			);
			
			if ( true === $isAjaxCall ) {die(json_encode($buffyArray));} 
			else {return json_encode($buffyArray);}
			
		}
	}
	
	
	public function ajaxQueryGetTimeSlotsOfSelectedDay(){
		global $wpdb;
		$isAjaxCall 			= false;
		
		if (!empty(sanitize_text_field($_POST['serID']))) {
			$isAjaxCall			= true;
			$serviceID 			= sanitize_text_field($_POST['serID']);
			$appID 				= 0;
			$employeeID 		= sanitize_text_field($_POST['empID']);
			$dateValue 			= sanitize_text_field($_POST['dateVal']);
			$selDayBetween 		= sanitize_text_field($_POST['selDayBetween']);
			$newHours 			= sanitize_text_field($_POST['newHours']);
			$newMinutes 		= sanitize_text_field($_POST['newMinutes']);
			$selectedDayIndex 	= date('N', strtotime($dateValue));
			$extraDuration 		= sanitize_text_field($_POST['extraDuration']);
			if(!$extraDuration){
				$extraDuration 	= 0;
			}
			
			// проверка на тайм зону
			$timezoneOffset		= 0;
			
			$appCount			= Helper::appointmentCount($employeeID,$dateValue);
			
			// время работы (от и до) выбранного работника, для выбранной даты по индексу дня в формате чч:мм
			$startTime 			= Helper::bookmifyWorkingHoursOfEmployee($employeeID,$selectedDayIndex,'start_time');
			$endTime 			= Helper::bookmifyWorkingHoursOfEmployee($employeeID,$selectedDayIndex,'end_time');
			
			
			// суммарное время которое уйдет на выбранный сервис (здесь учитывается длительность самого сервиса а также время до и после этого сервиса)
			$serviceBuffBefore 	= 0;
			$serviceBuffAfter	= 0;
			$query 				= "SELECT duration, buffer_before, buffer_after FROM {$wpdb->prefix}bmify_services WHERE id=".$serviceID;
			$results 			= $wpdb->get_results( $query, OBJECT  );
			foreach($results as $result){
				$serviceDuration 	= $result->duration; 			// в секундах
				$serviceBuffBefore 	= $result->buffer_before;		// в секундах
				$serviceBuffAfter 	= $result->buffer_after;		// в секундах
			}
			$summaryDuration 		= ($serviceDuration+$serviceBuffBefore+$serviceBuffAfter+$extraDuration) / 60; // в минутах
//			$summaryDuration 		= ($serviceDuration+$serviceBuffAfter+$extraDuration) / 60; // в минутах
			
			
			// слот времени: по выбранному слоту (в минутах) будет добавляться время, к примеру: 8:00, 8:15, 8:30 и т.д.
			$timeSlot 				= get_option( 'bookmify_be_time_interval', '15' ); // получить тайм интервал из настроек
			// проверить включена ли время сервиса как интервал в настройках, в случае положительного ответа применить его как слот времени
			if(get_option('bookmify_be_service_time_as_slot', '') == 'on'){
				$timeSlot 			= $summaryDuration;
			}
			
			// время работы (от и до) для выбранного работника, для выбранной даты по индексу дня в минутах
			$startTimeInMinutes = date('H',strtotime($startTime))*60 + date('i',strtotime($startTime)) + $timezoneOffset;
			$endTimeCheck 		= date('H',strtotime($endTime))*60 + date('i',strtotime($endTime));
			if($endTimeCheck == 0){
				$endTimeCheck = 24*60;
			}
			$endTimeInMinutes 	= $endTimeCheck - ($serviceBuffBefore / 60) + $timezoneOffset;
			
			// данная проверка добавлена из-за добавления рассчета тайм зону клиента. Пояснение: при получении слотов время начала и конца работы может выйти из рамки от 00:00 до 24:00.
			if($endTimeInMinutes > 1440){
				$endTimeInMinutes = 1440;
			}
			if($startTimeInMinutes < 0){
				$startTimeInMinutes = 0;
			}
			
			// если выбран сегодняшний или завтрашний день, установить минимум время для подсчета слотов
			$minTimeInMinutes = 0;
			if($selDayBetween == 0){
				$minTimeInMinutes = intval($newHours * 60 + $newMinutes);
			}
			if(($selDayBetween == 1) && ($newHours >=24)){
				$minTimeInMinutes = intval(($newHours - 24) * 60 + $newMinutes);
			}
			
			
			// получение всевозможных перерывов выбранного работника для выбранной даты по индексу дня в массиве
			$breakArray = array();
			$selectedDayIndex 	= esc_sql($selectedDayIndex);
			$employeeID 		= esc_sql($employeeID);
			$select 			= "SELECT start_time,end_time FROM {$wpdb->prefix}bmify_employee_business_hours_breaks WHERE day_index=".$selectedDayIndex." AND employee_id=".$employeeID;
			$breaks 			= $wpdb->get_results( $select, OBJECT  );
			foreach($breaks as $key => $break){
				$startBreak = date('H', strtotime($break->start_time))*60 + date('i', strtotime($break->start_time)) + $timezoneOffset;
				$endBreak 	= date('H', strtotime($break->end_time))*60 + date('i', strtotime($break->end_time)) + $timezoneOffset;
				$breakArray[$key]['start'] 	= $startBreak;
				$breakArray[$key]['end'] 	= $endBreak;
			}
			
			// начало работы выбранного работника в секундах
			$startTime = strtotime($startTime) + $serviceBuffBefore + ($timezoneOffset * 60); // здесь мы прибавляем время buffer_before для того, чтобы работник смог подготовиться к работе в начале работы
			
			// данная проверка добавлена из-за добавления рассчета тайм зону клиента. Пояснение: при получении слотов время начала и конца работы может выйти из рамки от 00:00 до 24:00.
			if($startTime < 0){
				$startTime = 0;
			}
			
			// количество слотов без каких либо учетов
			$to = intval(($endTimeInMinutes - $startTimeInMinutes) / $timeSlot);
			// ОБЩИЙ массив без каких либо учетов
			$allArray = array();
			for($i = 0; $i < $to; $i++){
				$firstTime = $i*$timeSlot + $startTimeInMinutes;
				if($firstTime <= ($endTimeInMinutes - $summaryDuration)){
					$allArray[] = date("H", strtotime('+'.($i*$timeSlot).' minutes', $startTime))*60 + date("i", strtotime('+'.($i*$timeSlot).' minutes', $startTime));
				}
			}
			
			
			// получение всевозможных слотов, которых нужно удалить из ОБЩЕГО масива (все ПЕРЕРЫВЫ того дня недели)
			$removableValues = array();
			foreach($breakArray as $key => $result){
				$min 	= intval($result['start']) - $summaryDuration;
				$max 	= intval($result['end']) + ($serviceBuffBefore / 60); // здесь мы прибавляем время buffer_before для того, чтобы работник смог подготовиться к работе после каждого перерыва
				$removableValues[] 	= array_filter($allArray, function ($value) use($min,$max)  { return ($value > $min && $value < $max); });
			}
			$removableArr = array();
			foreach($removableValues as $results){
				foreach($results as $result){
					$removableArr[] = $result;
				}
			}
			
			// удаление полученных слотов, которых нужно было удалить из ОБЩЕГО массива (все ПЕРЕРЫВЫ того дня недели)
			$difference = array_diff($allArray,$removableArr);
			
			
			//****************************************************************************************************************************************
			// получение всевозможных ВСТРЕЧ выбранного работника для выбранной даты в массиве
			
			// добавлена, для того, чтобы получить слот, существующих встреч, если количество людей не достигнуто
			
			/////////////////////////////////////////////////////
			$capacityMax 			= sanitize_text_field($_POST['capacityMax']);////
			$peopleCount 			= sanitize_text_field($_POST['peopleCount']);///
			$duration 				= sanitize_text_field($_POST['duration']);/////
			/////////////////////////////////////////////////
			
			$appointmentArray 		= array();
			$chosenDay 				= date("Y-m-d",strtotime($dateValue));
			$nextDay 				= date("Y-m-d",strtotime($dateValue."+1 days"));
			$startDate				= $chosenDay . " 00:00:00";
			$endDate				= $nextDay . " 00:00:00";
			$startDate				= date("Y-m-d H:i:s", strtotime($startDate));
			$endDate				= date("Y-m-d H:i:s", strtotime($endDate));
			$employeeID 			= esc_sql($employeeID);
			$startDate	 			= esc_sql($startDate);
			$endDate	 			= esc_sql($endDate);
			$select	 				= "SELECT 
											a.start_date appStartDate,
											a.end_date appEndDate,
											a.service_id appServiceID,
											es.capacity_min serviceCapacityMin,
											es.capacity_max serviceCapacityMax,
											GROUP_CONCAT(ca.customer_id ORDER BY ca.id) customerIDs,
											GROUP_CONCAT(ca.number_of_people ORDER BY ca.id) customerPeopleCounts,
											GROUP_CONCAT(ca.status ORDER BY ca.id) customerStatuses

										FROM 	   	   {$wpdb->prefix}bmify_appointments a 
											INNER JOIN {$wpdb->prefix}bmify_customer_appointments ca 			ON ca.appointment_id = a.id 
											INNER JOIN {$wpdb->prefix}bmify_employee_services es 				ON a.service_id = es.service_id AND a.employee_id = es.employee_id
										
										WHERE a.employee_id=".$employeeID." AND a.start_date>='".$startDate."' AND a.start_date<'".$endDate."' AND a.status in ('pending', 'approved')  GROUP BY a.id ORDER BY a.start_date";
			$appointments 			= $wpdb->get_results( $select, OBJECT  );
			$additionalTimeSlots = array();
			foreach($appointments as $key => $appointment){
				$hasSlot = 0;
				$newServiceID					= $appointment->appServiceID;
				if($newServiceID == $serviceID){
					$serviceCapacityMax			= $appointment->serviceCapacityMax;
					$approvedPeopleCount 		= 0;
					
					$customerIDs 				= explode(',', $appointment->customerIDs); 					// creating array from string
					$customerStatuses 			= explode(',', $appointment->customerStatuses); 			// creating array from string
					$customerPeopleCounts 		= explode(',', $appointment->customerPeopleCounts); 		// creating array from string
					foreach($customerIDs as $key2 => $customerID){
						if($customerStatuses[$key2] == 'approved' || $customerStatuses[$key2] == 'pending'){
							$approvedPeopleCount += $customerPeopleCounts[$key2];
						}
					}
					if($serviceCapacityMax >= ($approvedPeopleCount + $peopleCount + 1)){
						$hasSlot = 1;
					}
					$approvedPeopleCount 		= 0;
				}
				if(is_numeric($newServiceID)){
					$newServiceID		= esc_sql($newServiceID);
					$select 			= "SELECT buffer_before, buffer_after FROM {$wpdb->prefix}bmify_services WHERE id=".$newServiceID;
					$results 			= $wpdb->get_results( $select, OBJECT  );
					$bufferBefore		= $results[0]->buffer_before / 60;
					$bufferAfter		= $results[0]->buffer_after / 60;
					$startDateInMinutes = date('H', strtotime($appointment->appStartDate))*60 + date('i', strtotime($appointment->appStartDate));
					$endDateInMinutes 	= date('H', strtotime($appointment->appEndDate))*60 + date('i', strtotime($appointment->appEndDate));
					if($hasSlot == 1){
						if(($endDateInMinutes - $startDateInMinutes) >= ($duration / 60)){
							$additionalTimeSlots[] = $startDateInMinutes;
						}
					}
					$startAppointment 	= $startDateInMinutes - $bufferBefore;
					$endAppointment		= $endDateInMinutes + $bufferAfter;
					$appointmentArray[$key]['start'] 	= $startAppointment;
					$appointmentArray[$key]['end'] 		= $endAppointment;
				}
					
			}
			// получение всевозможных слотов, которых нужно удалить из ОБЩЕГО масива (все ВСТРЕЧИ того дня)
			$removableValues = array();
			foreach($appointmentArray as $result){
				$min 	= intval($result['start']) - $summaryDuration;
				$max 	= intval($result['end']) + ($serviceBuffBefore / 60); // здесь мы прибавляем время buffer_before для того, чтобы работник смог подготовиться к работе после каждого перерыва
				$removableValues[] 	= array_filter($allArray, function ($value) use($min,$max)  { return ($value > $min && $value < $max); });
			}
			$removableArr = array();
			foreach($removableValues as $results){
				foreach($results as $result){
					$removableArr[] = $result;
				}
			}
			// удаление полученных слотов, которых нужно было удалить из ОБЩЕГО массива (все ВСТРЕЧИ того дня)
			$difference = array_diff($difference,$removableArr);
			//****************************************************************************************************************************************
			
			$html = '';
			
			
			// получение ГОТОВОГО массива с учетом полученного времени с минимум установленным временем до заказа, если выбран сегодняшний или же завтрашний день
			if($minTimeInMinutes != 0){
				$minTimeArray 		= array_filter($difference, function($value) use($minTimeInMinutes) {return ($value >= $minTimeInMinutes); });
				$minTimeArray 		= array_merge($minTimeArray,$additionalTimeSlots); // добавление в массив, тех встреч, где есть допольнительные места
				asort($minTimeArray); // сортировка массива после добавления
				foreach($minTimeArray as $result){
					$resHours 		= intval($result/60);
					if($resHours < 10){$resHours = "0".$resHours;}
					$resMinutes 	= $result % 60;
					if($resMinutes < 10){$resMinutes = "0".$resMinutes;}
					$hourMinutes 	= $resHours.":".$resMinutes;
					$timeHTML 		= date_i18n(get_option('bookmify_be_time_format', 'h:i a'),strtotime($hourMinutes));
					$html .= '<li>';
					$html .= 	'<div class="time_item">';
					$html .= 		'<input class="time_val" type="hidden" value="'.$hourMinutes.'" />';
					$html .= 		'<span>'.$timeHTML.'</span>';
					$html .= 	'</div>';
					$html .= '</li>';
				}
			}
			
			// получение ГОТОВОГО массива, если выбранная дата не явлется ни сегодняшней и ни завтрашней
			if($minTimeInMinutes == 0){
				$difference 		= array_merge($difference,$additionalTimeSlots); // добавление в массив, тех встреч, где есть допольнительные места
				asort($difference); // сортировка массива после добавления
				foreach($difference as $result){
					$resHours 		= intval($result/60);
					if($resHours < 10){$resHours = "0".$resHours;}
					$resMinutes 	= $result % 60;
					if($resMinutes < 10){$resMinutes = "0".$resMinutes;}
					$hourMinutes 	= $resHours.":".$resMinutes;
					$timeHTML 		= date_i18n(get_option('bookmify_be_time_format', 'h:i a'),strtotime($hourMinutes));
					$html .= '<li>';
					$html .= 	'<div class="time_item">';
					$html .= 		'<input class="time_val" type="hidden" value="'.$hourMinutes.'" />';
					$html .= 		'<span>'.$timeHTML.'</span>';
					$html .= 	'</div>';
					$html .= '</li>';
				}
			}
			
			
			if($html == ''){
				$timeResultHTML = '<div class="bookmify_fe_infobox danger"><label>'.esc_html__('Busy Day. Please, select another day.', 'bookmify').'</label></div>';
			}else{
				$timeResultHTML = '<ul>'.$html.'</ul>';
			}
			
			// ОТПРАВКА РЕЗУЛЬТАТА
			$timeResult  = '';
			if(!$appCount){
				$timeResult .= '<div class="bookmify_fe_infobox danger bm_20"><label>'.esc_html__('That day\'s limit is reached.', 'bookmify').'</label></div>';
			}
			$timeResult .= '<div class="time_header">';
			$timeResult .= 		'<h3>'.esc_html__('Time Slots', 'bookmify').'</h3>';
			$timeResult .= '</div>';
			$timeResult .= '<div class="time_content" id="bokmify_fe_alpha_time_content">';
			$timeResult .= 		$timeResultHTML;
			$timeResult .= '</div>';
			
			
			// remove whitespaces form the ajax HTML
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
			$timeResult = preg_replace($search, $replace, $timeResult);
			
			
			// Отправка обработанных данных на jQuery
			$buffyArray = array(
				'bookmify_be_data' 		=> $timeResult,//timeResult timezoneOffset
				'extra_slots'			=> count($additionalTimeSlots),
				'app_count'				=> $appCount,
			);
			
			if ( true === $isAjaxCall ) {die(json_encode($buffyArray));} 
			else {return json_encode($buffyArray);}
			
		}
	}
	
	public function ajaxCheckCustomerDetails(){
		global $wpdb;
		$isAjaxCall 				= false;
		
		if (!empty(sanitize_email($_POST['email']))) {
			$isAjaxCall				= true;
			
			$email 					= sanitize_email($_POST['email']);
			$firstName 				= sanitize_text_field($_POST['firstName']);
			$lastName 				= sanitize_text_field($_POST['lastName']);
			$err 	= '';
			$email	= esc_sql($email);
			$count 	= $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}bmify_customers WHERE email='".$email."'" );
			if($count > 0){
				$email				= esc_sql($email);
				$query 				= "SELECT first_name,last_name FROM {$wpdb->prefix}bmify_customers WHERE email='".$email."'";
				$results 			= $wpdb->get_results( $query, OBJECT  );
				
				if(strtolower($results[0]->first_name) != strtolower($firstName)){
					$err 			.= 'f';
				}
				if(strtolower($results[0]->last_name) != strtolower($lastName)){
					$err 			.= 'l';
				}
				$exist				= 'exist';
			}else{
				$exist				= 'new';
			}
			switch($err){
				case 'f': 	$errorMessage = esc_html__('This email already exists with different first name!', 'bookmify'); break;
				case 'l': 	$errorMessage = esc_html__('This email already exists with different last name!', 'bookmify'); break;
				case 'fl': 	$errorMessage = esc_html__('This email already exists with different name!', 'bookmify'); break;
				default: 	$errorMessage = ''; break;
			}
			// Отправка обработанных данных на jQuery
			$buffyArray = array(
				'error' 		=> $errorMessage,
				'exist' 		=> $exist,
			);
			
			if ( true === $isAjaxCall ) {die(json_encode($buffyArray));} 
			else {return json_encode($buffyArray);}
			
		}
	}
	
	public function ajaxCreateNewAppointment(){
		global $wpdb;
		$isAjaxCall = false;
		
		if (!empty(sanitize_text_field($_POST['serviceID']))) {
			$isAjaxCall			= true;
			$serID 				= sanitize_text_field($_POST['serviceID']);
			$empID 				= sanitize_text_field($_POST['employeeID']);
			$dateApp 			= sanitize_text_field($_POST['date']);
			$timeApp 			= sanitize_text_field($_POST['time']);
			$details	 		= json_decode(stripslashes($_POST['details']));
			$extras	 			= json_decode(stripslashes($_POST['extras']));
			$status 			= get_option('bookmify_be_default_app_status', 'approved');
			$timeAppStart		= date("H:i:s",strtotime($timeApp));
			$timeAppEnd			= date("H:i:s",strtotime($timeApp) + sanitize_text_field($_POST['duration']));
			$dateApp 			= date("Y-m-d",strtotime($dateApp));
			$startDate			= $dateApp . " " . $timeAppStart;
			$endDate			= $dateApp . " " . $timeAppEnd;
			$startDate			= date("Y-m-d H:i:s", strtotime($startDate));
			$endDate			= date("Y-m-d H:i:s", strtotime($endDate));
			$peopleCount		= (sanitize_text_field($_POST['peopleCount']) + 1); // мы прибавляем единицу, так как peopleCount это количество людей, которые придут вместе с клиентом, а это в свою очередь означает, что клиента мы тоже должны добавить к данному количеству
			$extraSlotsCount	= sanitize_text_field($_POST['extraSlotsCount']);
			
			$customFields		= '';
			$cfDialog			= '';
			if(isset($_POST['customFields'])){
				$customFields	= json_decode(stripslashes($_POST['customFields']));
				$array			= array();
				foreach($customFields as $key => $customField){
					if($key == 'checkbox'){
						foreach($customField as $checkbox){
							$rCheckbox	= esc_sql($checkbox[0]);
							$query 	= "SELECT cf_label,cf_value FROM {$wpdb->prefix}bmify_customfields WHERE id=".$rCheckbox;
							$cfs	= $wpdb->get_results( $query, OBJECT  );
							$label	= $cfs[0]->cf_label;
							$vals	= array();
							$values = unserialize($cfs[0]->cf_value);
							$cfDialog .= '<strong>'.$label.'</strong><br />';
							foreach($checkbox[1] as $cc){
								$vals[] = $values[$cc]['label'];
								$cfDialog .= '-'.$values[$cc]['label'].'<br />';
							}
							$object = new \stdClass();
							$object->label = $label;
							$object->value = $vals;
							$array[] = $object;
						}
					}else if($key == 'radio'){
						foreach($customField as $radio){
							$rRadio	= esc_sql($radio[0]);
							$query 	= "SELECT cf_label,cf_value FROM {$wpdb->prefix}bmify_customfields WHERE id=".$rRadio;
							$cfs	= $wpdb->get_results( $query, OBJECT  );
							$label	= $cfs[0]->cf_label;
							$cfDialog .= '<strong>'.$label.'</strong><br />';
							$values = unserialize($cfs[0]->cf_value);
							$object = new \stdClass();
							$object->label = $label;
							$object->value = $values[$radio[1]]['label'];
							$cfDialog .= '-'.$values[$radio[1]]['label'].'<br />';
							$array[] = $object;
						}
					}else if($key == 'select'){
						foreach($customField as $select){
							$rSelect = esc_sql($select[0]);
							$query 	= "SELECT cf_label,cf_value FROM {$wpdb->prefix}bmify_customfields WHERE id=".$rSelect;
							$cfs	= $wpdb->get_results( $query, OBJECT  );
							$label	= $cfs[0]->cf_label;
							$cfDialog .= '<strong>'.$label.'</strong><br />';
							$values = unserialize($cfs[0]->cf_value);
							$object = new \stdClass();
							$object->label = $label;
							$object->value = $values[((int)$select[1])-1]['label'];
							$cfDialog .= '-'.$values[((int)$select[1])-1]['label'].'<br />';
							$array[] = $object;
						}
					}else if($key == 'text'){
						foreach($customField as $text){
							$rText	= esc_sql($text[0]);
							$query 	= "SELECT cf_label FROM {$wpdb->prefix}bmify_customfields WHERE id=".$rText;
							$cfs	= $wpdb->get_results( $query, OBJECT  );
							$label	= $cfs[0]->cf_label;
							$cfDialog .= '<strong>'.$label.'</strong><br />';
							$object = new \stdClass();
							$object->label = $label;
							$object->value = $text[1];
							$cfDialog .= '-'.$text[1].'<br />';
							$array[] = $object;
						}
					}else if($key == 'textarea'){
						foreach($customField as $textarea){
							$rTextarea	= esc_sql($textarea[0]);
							$query 	= "SELECT cf_label FROM {$wpdb->prefix}bmify_customfields WHERE id=".$rTextarea;
							$cfs	= $wpdb->get_results( $query, OBJECT  );
							$label	= $cfs[0]->cf_label;
							$cfDialog .= '<strong>'.$label.'</strong><br />';
							$object = new \stdClass();
							$object->label = $label;
							$object->value = $textarea[1];
							$cfDialog .= '-'.$textarea[1].'<br />';
							$array[] = $object;
						}
					}
				}
				$customFields 	= json_encode(($array));
			}
				
			
			/*************************************************************************************************/
			$paymentStatus		= '';
			if (!empty(sanitize_text_field($_POST['status']))) {
				$paymentStatus	= strtolower(sanitize_text_field($_POST['status']));
			}
			$paymentType		= 'local';
			if (!empty(sanitize_text_field($_POST['paymentType']))) {
				$paymentType	= sanitize_text_field($_POST['paymentType']);
			}
			$paid				= '';
			if($paymentType == 'paypal' && $paymentStatus	== 'completed'){
				$paid			= 'paid';
			}
			if($paymentType == 'stripe'){
				$paid			= 'paid';
			}
			/*************************************************************************************************/
			/* CUSTOMERS */
			$customerExist		= $_POST['customerExist'];
			$c_fname			= $details->first_name;
			$c_lname			= $details->last_name;
			$c_email			= $details->email;
			$c_phone			= $details->phone;
			$c_message			= $details->message;
			$c_fullName			= $c_fname . ' ' . $c_lname;
			
			$createdDate 		= HelperTime::getCurrentDateTime();
			
			// 1. CREATE NEW CUSTOMER IF customer email doesn't exist on customers database
			if($customerExist == 'new'){
				// INSERT (Best Practice)
				$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_customers ( first_name, last_name, email, phone, registration_date ) VALUES ( %s, %s, %s, %s, %s )", $c_fname, $c_lname, $c_email, $c_phone, $createdDate ));
				
				// get this customer ID (for new customer)
				$query 			= "SELECT id FROM {$wpdb->prefix}bmify_customers ORDER BY id DESC LIMIT 1;";
				$results 		= $wpdb->get_results( $query, OBJECT  );
				$customerID 	= $results[0]->id;
				
				$c_wp_user_id	= 0;
				// update customer: add wordpress user id
				$wpdb->query($wpdb->prepare( "UPDATE {$wpdb->prefix}bmify_customers SET wp_user_id=%d WHERE id=%d", $c_wp_user_id, $customerID));
			}else{
				// get this customer ID (for existing customer)
				$c_email		= esc_sql($c_email);
				$query 			= "SELECT id FROM {$wpdb->prefix}bmify_customers WHERE email='".$c_email."'";
				$results 		= $wpdb->get_results( $query, OBJECT  );
				$customerID 	= $results[0]->id;
			}
			/*************************************************************************************************/
			// 2. CREATE NEW APPOINTMENT and send notification to employee
			
			// get if this appointment is part of existing appointment
			$newID = '';
			if($extraSlotsCount > 0){
				$serID			= esc_sql($serID);
				$empID			= esc_sql($empID);
				$query 			= "SELECT id FROM {$wpdb->prefix}bmify_appointments WHERE service_id=".$serID." AND employee_id=".$empID." AND start_date='".$startDate."'";
				$results 		= $wpdb->get_results( $query, OBJECT  );
				foreach($results as $result){$newID = $result->id;};
			}
			// check if this appointment is part of existing appointment
			if($newID != ''){
				$appointmentID 		= $newID;
			}else{
				
				//
				$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_appointments ( service_id, employee_id, start_date, end_date, status ) VALUES ( %d, %d, %s, %s, %s )", $serID, $empID, $startDate, $endDate, $status ));
				
				
				// get this appoointment ID
				$query 				= "SELECT id FROM {$wpdb->prefix}bmify_appointments ORDER BY id DESC LIMIT 1;";
				$results 			= $wpdb->get_results( $query, OBJECT  );
				$appointmentID 		= $results[0]->id;
			}
			

			
			
			// get customer information to send a notification to employee
			$infoObject						= new \stdClass();
			$serviceName					= Helper::bookmifyGetServiceCol($serID);
			$employeeEmail					= Helper::bookmifyGetEmployeeCol($empID, 'email');
			$infoObject->sendTo				= 'employee';
			$infoObject->appID				= $appointmentID;
			$infoObject->userID				= $empID;
			$infoObject->service_name 		= $serviceName;
			$infoObject->appointment_date 	= $dateApp;
			$infoObject->appointment_time 	= $timeAppStart;
			$infoObject->status			 	= $status;
			$infoObject->employee_email	 	= $employeeEmail;
			$infoObject->customer_count	 	= 1;
			$infoObject->customer_name	 	= $c_fullName;
			$infoObject->customer_email	 	= $c_email;
			$infoObject->customer_phone	 	= $c_phone;
			$infoObject->cf	 				= $cfDialog;
			$this->pretraintmentToSendNotification($infoObject); // send notification to new employee
			
			/*************************************************************************************************/
			// 3. CREATE NEW CUSTOMER APPOINTMENT
			
			// get service price
			$empID				= esc_sql($empID);
			$serID				= esc_sql($serID);
			$query 				= "SELECT price FROM {$wpdb->prefix}bmify_employee_services WHERE service_id=".$serID." AND employee_id=".$empID;
			$results 			= $wpdb->get_results( $query, OBJECT  );
			$serPrice 			= $results[0]->price;
			
			// create new customer appointment
			$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_customer_appointments ( customer_id, appointment_id, number_of_people, price, status, created_date, cf ) VALUES ( %d, %d, %d, %f, %s, %s, %s )", $customerID, $appointmentID, $peopleCount, $serPrice, $status, $createdDate, $customFields ));
			
			
			// get new customer appointment id
			$query 				= "SELECT id FROM {$wpdb->prefix}bmify_customer_appointments ORDER BY id DESC LIMIT 1;";
			$results 			= $wpdb->get_results( $query, OBJECT  );
			$custAppID 			= $results[0]->id;
			
			// payment price: service price * people count
			$paymentPrice		 = ($serPrice * $peopleCount);
			
			// create new customer appoinment extras if exist
			if($_POST['haveExtras'] == 'yes'){
				foreach($extras as $extra){
					$extraID	= $extra[0];
					$quantity	= $extra[1];
					// get extra price
					$extraID	= esc_sql($extraID);
					$query 		= "SELECT price FROM {$wpdb->prefix}bmify_extra_services WHERE id=".$extraID;
					$results 	= $wpdb->get_results( $query, OBJECT  );
					$price 		= $results[0]->price;
					
					// create new extras
					$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_customer_appointments_extras ( customer_appointment_id, extra_id, quantity, price ) VALUES ( %d, %d, %d, %f )", $custAppID, $extraID, $quantity, $price ));
					
					// add to payment price all extras price 
					$paymentPrice 	+= ($quantity * $price);
				}
			}
			
			// insert new payment
			if($paid == 'paid'){
				$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_payments ( total_price, created_date, paid_type, paid, status ) VALUES ( %f, %s, %s, %f, %s )", $paymentPrice, $createdDate, $paymentType, $paymentPrice, 'full' ));
			}else{
				$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_payments ( total_price, created_date ) VALUES ( %f, %s )", $paymentPrice, $createdDate ));
			}
				

			// get this payment ID
			$query 				= "SELECT id FROM {$wpdb->prefix}bmify_payments ORDER BY id DESC LIMIT 1;";
			$results 			= $wpdb->get_results( $query, OBJECT  );
			$paymentID 			= $results[0]->id;

			// insert paymentID to last customer appointment 
			$wpdb->query($wpdb->prepare( "UPDATE {$wpdb->prefix}bmify_customer_appointments SET payment_id=%d WHERE id=%d", $paymentID, $custAppID));

			// notification	|| send notification to customer
			$infoObject						= new \stdClass();
			$infoObject->sendTo				= 'customer';
			$infoObject->appID				= $appointmentID;
			$infoObject->userID				= $customerID;
			$infoObject->service_name 		= $serviceName;
			$infoObject->appointment_date 	= $dateApp;
			$infoObject->appointment_time 	= $timeAppStart;
			$infoObject->status			 	= $status;
			$infoObject->customer_name	 	= $c_fullName;
			$infoObject->customer_email	 	= $c_email;
			$infoObject->customer_phone	 	= $c_phone;
			$infoObject->cf	 				= $cfDialog;
			$this->pretraintmentToSendNotification($infoObject); // send notification to new customer
			
			
			$paymentPrice = 0;
		}
		

		$buffyArray = array(
			'asdasd' 				=> $cfDialog,
		);

		if ( true === $isAjaxCall ){die(json_encode($buffyArray));} 
		else{return json_encode($buffyArray);}
	}
	
	// подготовка к отправке уведомлении
	private function pretraintmentToSendNotification($object)
    {
		$receiver 		= $object->sendTo;
		$checkSender 	= Helper::bookmifyCheckForNotificationSender();
		
		if($checkSender){
			if($receiver == 'employee'){
				NotificationManagement::sendInfoToEmployeeAboutAppointment( $object );
			}else if($receiver == 'customer'){
				NotificationManagement::sendInfoToCustomerAboutAppointment( $object );
			}
		}
        
		return false;
    }
	
	
}

new BookmifyAlpha;
