<?php
namespace Bookmify;

use Bookmify\Helper;
use Bookmify\HelperAdmin;
use Bookmify\HelperCalendar;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Calendar{

	const PAGE_ID = 'bookmify_calendar';

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function register_admin_menu() {

		add_submenu_page(
			BOOKMIFY_MENU,
			esc_html__( 'Calendar', 'bookmify' ),
			esc_html__( 'Calendar', 'bookmify' ),
			'bookmify_be_read_calendar',
			self::PAGE_ID,
			[ $this, 'display_calendar_page' ]
		);
	}
	
	public function display_calendar_page() {
		global $wpdb;

		echo HelperAdmin::bookmifyAdminContentStart();
		?>
		
		<div class="bookmify_be_content_wrap bookmify_be_calendar_page">
			
			<!-- PAGE TITLE -->
			<div class="bookmify_be_page_title">
				<h3><?php echo esc_html($this->get_page_title()); ?></h3>
<!--
				<div class="bookmify_be_add_new_item bookmify_be_add_new_appointment_from_calendar">
					<a href="#" class="bookmify_button add_new bookmify_add_new_button">
						<span class="text"><?php //esc_html_e('Add New Appointment','bookmify');?></span>
						<span class="plus">
							<span class="icon"></span>
							<span class="bookmify_be_loader small">
								<span class="loader_process">
									<span class="ball"></span>
									<span class="ball"></span>
									<span class="ball"></span>
								</span>
							</span>
						</span>
					</a>
				</div>
-->
			</div>
			<!-- /PAGE TITLE -->
			
			
			<!-- PAGE CONTENT -->
			<div class="bookmify_be_page_content">
				
				<!-- HIDDEN INFO -->
				<div class="bookmify_be_hidden_info">
					<span class="approved icon">
						<img class="bookmify_be_svg" src="<?php echo BOOKMIFY_ASSETS_URL.'img/checked.svg' ?>" alt="" />
					</span>
					<span class="pending icon">
						<img class="bookmify_be_svg" src="<?php echo BOOKMIFY_ASSETS_URL.'img/circle.svg' ?>" alt="" />
					</span>
					<span class="canceled rejected icon">
						<img class="bookmify_be_svg" src="<?php echo BOOKMIFY_ASSETS_URL.'img/cancel.svg' ?>" alt="" />
					</span>
					<span class="edit icon">
						<img class="bookmify_be_svg" src="<?php echo BOOKMIFY_ASSETS_URL.'img/edit.svg' ?>" alt="" />
					</span>
					<span class="delete icon">
						<img class="bookmify_be_svg" src="<?php echo BOOKMIFY_ASSETS_URL.'img/delete.svg' ?>" alt="" />
					</span>
					<input class="h_cal_hotkey" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys', '');?>" />
					<input class="h_cal_hotkey_today" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys_today', 't');?>" />
					<input class="h_cal_hotkey_month" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys_month', 'm');?>" />
					<input class="h_cal_hotkey_week" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys_week', 'w');?>" />
					<input class="h_cal_hotkey_day" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys_day', 'd');?>" />
					<input class="h_cal_hotkey_list" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys_list', 'l');?>" />
					<input class="h_cal_hotkey_reset" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys_reset', 'r');?>" />
					<input class="h_cal_hotkey_prev" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys_prev', 'ArrowLeft');?>" />
					<input class="h_cal_hotkey_next" type="hidden" value="<?php echo get_option('bookmify_be_calendar_hotkeys_next', 'ArrowRight');?>" />
					<div class="btn_wrap">
						<div class="buttons_holder">
							<div class="btn_item btn_edit">
								<a href="#" class="bookmify_be_edit">
									<img class="bookmify_be_svg edit" src="<?php echo BOOKMIFY_ASSETS_URL.'img/edit.svg' ?>" alt="" />
									<span class="bookmify_be_loader small">
										<span class="loader_process">
											<span class="ball"></span>
											<span class="ball"></span>
											<span class="ball"></span>
										</span>
									</span>
								</a>
							</div>
							<div class="btn_item">
								<a href="#" class="bookmify_be_delete">
									<img class="bookmify_be_svg" src="<?php echo BOOKMIFY_ASSETS_URL.'img/delete.svg' ?>" alt="" />
									<span class="bookmify_be_loader small">
										<span class="loader_process">
											<span class="ball"></span>
											<span class="ball"></span>
											<span class="ball"></span>
										</span>
									</span>
								</a>
							</div>
						</div>
					</div>
					<input class="bookmify_hdn_time_interval" type="hidden" value="<?php echo date('H:i:s', (get_option('bookmify_be_time_interval', 15)*60));?>" />
				</div>
				<!-- /HIDDEN INFO -->
				
				<!-- CALENDAR WRAP -->
				<div class="bookmify_be_calendar">
					<div class="bookmify_be_calendar_content">
						
						<!-- PAGE FILTER -->
						<?php echo HelperCalendar::allFilter();?>
						<!-- /PAGE FILTER -->
						
						<?php echo wp_kses_post($this->calendar_content()); ?>
					</div>
				</div>
				<!-- /CALENDAR WRAP -->
				
			</div>
			<!-- /PAGE CONTENT -->
			
		</div>
		<?php echo HelperAdmin::bookmifyAdminContentEnd();
		
	}
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function calendar_content(){		
		$html = '<div class="bookmify_be_fullcalendar_wrap">
					<div class="bookmify_be_fullcalendar_loader">
						<span class="bookmify_be_loader">
							<span class="loader_process">
								<span class="ball"></span>
								<span class="ball"></span>
								<span class="ball"></span>
							</span>
						</span>
					</div>
					<div class="bookmify_be_fullcalendar"></div>
				</div>';
		return $html;
	}

	public function ajaxAppointmentListCalendar(){
		global $wpdb;
		$isAjaxCall 	= false;
		$startDate  	= date('Y-m-01');
		$endDate  		= date('Y-m-t');
		
		$employeeIDs		= array();
		$filterByService	= array();
		$filterByCustomer	= '';
		$filterByEmployee	= '';
		$filterByStatus		= '';
		
		
		if (!empty(esc_html($_POST['bookmify_startDate']))) {
			$isAjaxCall 			= true;
			$startDate 				= esc_html($_POST['bookmify_startDate']);
			$endDate 				= esc_html($_POST['bookmify_endDate']);
			
			if(!empty($_POST['bookmify_services'])){
				$filterByService = esc_html($_POST['bookmify_services']);
			}
			$filterByCustomer		= esc_html($_POST['bookmify_customer']);
			$filterByEmployee		= esc_html($_POST['bookmify_employee']);
			$filterByStatus			= esc_html($_POST['bookmify_status']);
		}
		
		
		$query 		 = "SELECT
								a.id appID,
								a.service_id appServiceID,
								a.employee_id appEmployeeID,
								a.location_id appLocationID,
								a.status appStatus,
								a.start_date appStartDate,
								a.end_date appEndDate,
								a.info appInfo,
								a.created_from appCreatedFrom,
								a.employee_id employeeID
								
							FROM 	   	   {$wpdb->prefix}bmify_appointments a 
								LEFT JOIN {$wpdb->prefix}bmify_customer_appointments ca  ON ca.appointment_id = a.id
									  
							WHERE";
		


		if(!empty($filterByService)){
			$filterByService 	= esc_sql($filterByService);
			$query .= " a.service_id IN (" . implode(",", array_map("intval", $filterByService)) . ") AND";
		}
		if($filterByCustomer != ''){
			$filterByCustomer 	= esc_sql($filterByCustomer);
			$query .= " ca.customer_id = '".$filterByCustomer."' AND";
		}
		if($filterByEmployee != ''){
			$filterByEmployee 	= esc_sql($filterByEmployee);
			$query .= " a.employee_id = '".$filterByEmployee."' AND";
		}
		if($filterByStatus != ''){
			$filterByStatus 	= esc_sql($filterByStatus);
			$query .= " a.status = '".$filterByStatus."' AND";
		}
		
		$startDate 	= esc_sql($startDate);
		$endDate 	= esc_sql($endDate);
		$query .= " (a.start_date BETWEEN '".$startDate."' AND '".$endDate."') AND";




		$query = rtrim($query, 'AND');
		$query = rtrim($query, 'WHERE');
		
		
		$query .= " GROUP BY a.id ORDER BY start_date";
		
		$rs 		= $wpdb->get_results( $query );
		
		$events 	= array();
		$employeeIDs = array();
		foreach($rs as $key => $app){
			$ID						= $app->appID;
			$ID 					= esc_sql($ID);
			$count					= $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}bmify_customer_appointments WHERE appointment_id=".$ID);
			$customerName 			= '';
			$customerPhone 			= '';
			$customerEmail 			= '';
			$group		 			= '';
			if($count == 1){
				$query 				= "SELECT customer_id FROM {$wpdb->prefix}bmify_customer_appointments WHERE appointment_id=".$ID;
				$rs 				= $wpdb->get_results( $query );
				$customerID			= $rs[0]->customer_id;
				$customerName 		= Helper::bookmifyGetCustomerCol($customerID);
				$customerPhone 		= Helper::bookmifyGetCustomerCol($customerID, 'phone');
				$customerEmail 		= Helper::bookmifyGetCustomerCol($customerID, 'email');
			}else if($count > 1){
				$group 				= esc_html__('Customers', 'bookmify');
			}
			
			$event = array(
				'id' 				=> $app->appID,
				'start' 			=> $app->appStartDate,
				'end' 				=> $app->appEndDate,
				'status' 			=> $app->appStatus,
				'color' 			=> Helper::bookmifyGetServiceCol($app->appServiceID,'color'),
				'title' 			=> Helper::bookmifyGetServiceCol($app->appServiceID),
				'count' 			=> $count,
				'group' 			=> $group,
				'customer' 			=> $customerName,
				'customer_phone' 	=> $customerPhone,
				'customer_email' 	=> $customerEmail,
				'employee' 			=> Helper::bookmifyGetEmployeeCol($app->appEmployeeID),
				'employee_img' 		=> wp_get_attachment_url(Helper::bookmifyGetEmployeeCol($app->appEmployeeID, 'img')),
				'location' 			=> Helper::getLocationDataByEmployeeID($app->appEmployeeID),
				
			);
			$events[] = $event;
			$employeeIDs[] = $app->employeeID;
		}
		$indexes = array();
		if(count($employeeIDs)){
			$employeeIDs = array_unique($employeeIDs);
			
			$employeeIDs = esc_sql($employeeIDs);
			$query 		= "SELECT ebh.day_index FROM {$wpdb->prefix}bmify_employee_business_hours ebh WHERE ebh.employee_id IN (" . implode(",", array_map("intval", $employeeIDs)) . ")";
			$results 	= $wpdb->get_results( $query );
			$dayIndexes	= array();
			foreach($results as $result){
				$dayIndexes[] = $result->day_index;
			}
			$dayIndexes = array_unique($dayIndexes);
			$dayIndex 	= [1,2,3,4,5,6,7];
			$indexes = array_diff($dayIndex, $dayIndexes);
		}
		
		
		$buffyArray = array(
			'bookmify_be_data' 		=> $events,
			'ids' 					=> $indexes,
		);
		
		if ( true === $isAjaxCall ){die(json_encode($buffyArray));}
		else{return json_encode($buffyArray);}
	}
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function enqueue_scripts() {
		wp_register_script('bookmify-fullcalendar', BOOKMIFY_CALENDAR_ASSETS_URL . 'js/fullcalendar.min.js',['jquery',], BOOKMIFY_VERSION, true);
		wp_register_script('bookmify-locales-all', BOOKMIFY_CALENDAR_ASSETS_URL . 'js/locales-all.js',['jquery',], BOOKMIFY_VERSION, true);
		wp_register_script('bookmify-calendar', BOOKMIFY_CALENDAR_ASSETS_URL . 'js/calendar.js',['jquery',], BOOKMIFY_VERSION, true);
		
		wp_localize_script(
			'bookmify-calendar',
			'bookmifyConfig',
			[
				'ajaxUrl' 				=> admin_url( 'admin-ajax.php' ),
				'employee' 				=> esc_html__( 'Employee', 'bookmify' ),
			]
		);
		
		wp_enqueue_script( 'bookmify-fullcalendar' );
		wp_enqueue_script( 'bookmify-locales-all' );
		wp_enqueue_script( 'bookmify-calendar' );
	}
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function enqueue_styles() {
		wp_register_style( 'bookmify-fullcalendar', BOOKMIFY_CALENDAR_ASSETS_URL . 'css/fullcalendar.min.css', '', BOOKMIFY_VERSION);
		wp_register_style( 'bookmify-fullcalendar-custom', BOOKMIFY_CALENDAR_ASSETS_URL . 'css/custom.css', '', BOOKMIFY_VERSION);
		
		wp_enqueue_style( 'bookmify-fullcalendar' );
		wp_enqueue_style( 'bookmify-fullcalendar-custom' );
	}
	

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 20 );
		
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		
		add_action( 'wp_ajax_ajaxAppointmentListCalendar', [$this, 'ajaxAppointmentListCalendar'] );
	}
	

	/**
	 * @since 1.0.0
	 * @access protected
	*/
	protected function get_page_title() {
		return esc_html__( 'Calendar', 'bookmify' );
	}
}
	

