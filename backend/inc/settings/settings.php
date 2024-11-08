<?php
namespace Bookmify;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Settings extends Settings_Page {

	const PAGE_ID = 'bookmify_settings';

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function register_admin_menu() {

		add_submenu_page(
			BOOKMIFY_MENU,
			esc_html__( 'Settings', 'bookmify' ),
			esc_html__( 'Settings', 'bookmify' ),
			'bookmify_be_read_settings',
			self::PAGE_ID,
			[ $this, 'display_settings_page' ]
		);
	}
	
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function admin_menu_change_name() {
		global $submenu;

		if ( isset( $submenu['bookmify'] ) ) {
			$submenu['bookmify'][0][0] = esc_html__( 'Settings', 'bookmify' );

			$hold_menu_data = $submenu['bookmify'][0];
			$submenu['bookmify'][0] = $submenu['bookmify'][1];
			$submenu['bookmify'][1] = $hold_menu_data;
		}
	}

	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function __construct() {
		parent::__construct();
		
		add_action( 'admin_menu', [ $this, 'register_admin_menu' ], 20 );
		add_action( 'wp_ajax_query_insert_offday', [$this, 'query_insert_offday'] );
		add_action( 'wp_ajax_query_delete_offday', [$this, 'query_delete_offday'] );
		add_action( 'wp_ajax_query_update_offday', [$this, 'query_update_offday'] );
		add_action( 'wp_ajax_query_save_working_hours', [$this, 'query_save_working_hours'] );

	}
	
	/**
	 * @since 1.0.0
	 * @access protected
	*/
	protected function get_page_title() {
		return esc_html__( 'Core Settings', 'bookmify' );
	}
	
	public function query_insert_offday(){
		global $wpdb;
		
		$html 			= '';
		$params 		= array();
		$isAjaxCall 	= false;
		$offday_repeat 	= 0;

		if (!empty($_POST['bookmify_data'])) {
			$isAjaxCall = true;
			
			// we need to convert form data to array from string
 			parse_str($_POST['bookmify_data'], $params);
			$off_day_name 	= $params['offday_name'];
			$offday_days 	= $params['offday_days'];//'2018-01-01';//
			
			if(!empty($_POST['offday_repeat'])){$offday_repeat 	= $params['offday_repeat'];}
			if($offday_repeat == ''){$offday_repeat = 0;}
			
			
		}
		$ab = explode(', ', $offday_days);
		$numberOfPost = 0;
		foreach($ab as $abc){
			// INSERT (Best Practice)
			$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_dayoff (title, date, every_year) VALUES ( %s, %s, %d )", $off_day_name, $abc, $offday_repeat));
			$numberOfPost++;
		}
		$result = '';
		// SELECT
		$numberOfPost	= esc_sql($numberOfPost);
		$query 			= "SELECT * FROM {$wpdb->prefix}bmify_dayoff ORDER BY id DESC LIMIT ".$numberOfPost;
		$holidays	 	= $wpdb->get_results( $query, OBJECT  );
		foreach($holidays as $key => $holiday){
			$every_year = 'no';
			$checked = '';
			$title = '';
			$date = '';
			if($holiday->every_year == 1){
				$every_year = 'yes';
			}
			if($every_year == 'yes'){
				$checked = 'checked';
			}
			
			$holidayID		= $holiday->id;
			$holidayTitle	= $holiday->title;
			$holidayDate	= $holiday->date;
			
			$edit_delete_panel = '<div class="buttons_holder">
									<div class="btn_item btn_edit">
										<a href="#" class="bookmify_be_edit">
											<img class="bookmify_be_svg edit" src="'.BOOKMIFY_ASSETS_URL.'img/edit.svg" alt="" />
											<img class="bookmify_be_svg checked" src="'.BOOKMIFY_ASSETS_URL.'img/checked.svg" alt="" />
										</a>
									</div>
									<div class="btn_item">
										<a href="#" class="bookmify_be_delete" data-entity-id="'.$holidayID.'">
											<img class="bookmify_be_svg" src="'.BOOKMIFY_ASSETS_URL.'img/delete.svg" alt="" />
											<span class="bookmify_be_loader small">
												<span class="loader_process">
													<span class="ball"></span>
													<span class="ball"></span>
													<span class="ball"></span>
												</span>
											</span>
										</a>
									</div>
								</div>';
			$update_block		= '<div class="bookmify_day_off_edit_dd">
										<form autocomplete="off">
											<div class="do_item">
												<label for="mdp-do-month-'.$holidayID.'">'.esc_html__('Date', 'bookmify').'<span>*</span></label>
												<input data-selected-day="'.$holidayDate.'" class="mdp-do-hidden" id="mdp-do-month-'.$holidayID.'" type="text" name="offday_days" placeholder="'.esc_attr__('yy-mm-dd', 'bookmify').'" />
												<input class="offday_hidden_day" type="hidden" name="offday_hidden_day" id="offday_hidden_day_'.$holidayID.'" />
											</div>
											<div class="do_item">
												<label for="offday_name-'.$holidayID.'">'.esc_html__('Title', 'bookmify').'<span>*</span></label>
												<input id="offday_name-'.$holidayID.'" type="text" name="offday_name" placeholder="'.esc_attr__('Enter Off Day Title...', 'bookmify').'" value="'.$holidayTitle.'" />
											</div>
											<div class="do_dd_footer">
												<div class="left_part">
													<label class="switch">
														<input type="checkbox" id="repeat-'.$holidayID.'" value="1" name="offday_repeat" '.$checked.' />
														<span class="slider round"></span>
													</label>
													<label class="repeater" for="repeat-'.$holidayID.'">'.esc_html__('Repeat Every Year', 'bookmify').'</label>
												</div>
												<div class="right_part">
													<a class="add" href="#">'.esc_html__('Save', 'bookmify').'</a>
												</div>
											</div>
										</form>
									</div>';
			// date format URI: https://codex.wordpress.org/Formatting_Date_and_Time
			
			$date 	= '<span class="list_date">'.date_i18n(get_option('bookmify_be_date_format', 'd F, Y'), strtotime($holidayDate)).'</span>';
			$title 	= '<span class="list_title">'.$holidayTitle.'</span>';
			
			$result .= '<li class="bookmify_be_list_item" data-entity-id="'.$holidayID.'">
							<div class="bookmify_be_list_item_in">
								<div class="bookmify_be_list_item_header">
									<div class="header_in item" data-yearly="'.$every_year.'">
										<div class="header_info">
											<span class="f_year"></span>'.$date.$title.'
										</div>
										'.$edit_delete_panel.'	
									</div>
								</div>
								'.$update_block.'
							</div>
						</li>';
		}
		$html .= $result;
		
		
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
		$html = preg_replace($search, $replace, $html);
		
		
		$buffyArray = array(
			'off_day_name' 			=> $off_day_name,
			'html'					=> $html
		);
		if ( true === $isAjaxCall ) {die(json_encode($buffyArray));} 
		else {return json_encode($buffyArray);}

	}
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function query_delete_offday(){
		global $wpdb;
		$params = array();
		
		if (!empty($_POST['bookmify_offday_id'])) {
			$offday_id = $_POST['bookmify_offday_id'];
			
			$wpdb->query($wpdb->prepare( "DELETE FROM {$wpdb->prefix}bmify_dayoff WHERE id=%d", $offday_id));
		}
	}
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public function query_update_offday(){
		global $wpdb;
		$params 		= array();
		$offday_repeat 	= 0;
		
		if (!empty($_POST['bookmify_data'])) {
			parse_str($_POST['bookmify_data'], $params);
			$offday_title 		= $params['offday_name'];
			$offday_date 		= $params['offday_hidden_day'];
			$offday_id 			= $_POST['offDayID'];
			
			if(!empty($_POST['offday_repeat'])){$offday_repeat 	= $params['offday_repeat'];}
			if($offday_repeat == ''){$offday_repeat = 0;}
			
			$wpdb->query($wpdb->prepare( "UPDATE {$wpdb->prefix}bmify_dayoff SET title=%s, date=%s, every_year=%d WHERE id=%d", $offday_title, $offday_date, $offday_repeat, $offday_id));
			
			$offday_id	= esc_sql($offday_id);
			$query 		= "SELECT date FROM {$wpdb->prefix}bmify_dayoff WHERE id=".$offday_id;
			$holidays 	= $wpdb->get_results( $query, OBJECT  );
			foreach($holidays as $holiday){
				$dateeee = date_i18n(get_option('bookmify_be_date_format', 'd F, Y'), strtotime($holiday->date));
			}
			
			
			$buffyArray = array(
				'html'					=> $dateeee,
				'repeat'				=> $offday_repeat,
			);
			die(json_encode($buffyArray));
		}
	}
	
	public function query_save_working_hours(){
		global $wpdb;
		$html	 				= '';
		$params 				= array();
		$isAjaxCall 			= false;

		$mondayChecked			= '';
		$tuesdayChecked			= '';
		$wednesdayChecked		= '';
		$thursdayChecked		= '';
		$fridayChecked			= '';
		$saturdayChecked		= '';
		$sundayChecked			= '';
		if (!empty($_POST['bookmify_data'])) {
			$isAjaxCall = true;
			
			// we need to convert form data to array from string
 			parse_str($_POST['bookmify_data'], $params);
			
			if(!empty($params['monday_checked'])){$mondayChecked 		= $params['monday_checked'];}
			if(!empty($params['tuesday_checked'])){$tuesdayChecked 		= $params['tuesday_checked'];}
			if(!empty($params['wednesday_checked'])){$wednesdayChecked 	= $params['wednesday_checked'];}
			if(!empty($params['thursday_checked'])){$thursdayChecked 	= $params['thursday_checked'];}
			if(!empty($params['friday_checked'])){$fridayChecked 		= $params['friday_checked'];}
			if(!empty($params['saturday_checked'])){$saturdayChecked 	= $params['saturday_checked'];}
			if(!empty($params['sunday_checked'])){$sundayChecked 		= $params['sunday_checked'];}
		}
		
		// AFTER HARD WORK
		$count	= $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}bmify_business_hours_breaks" );
		if($count != 0){
			$wpdb->query($wpdb->prepare( "DELETE FROM {$wpdb->prefix}bmify_business_hours_breaks"));
			$wpdb->query($wpdb->prepare( "ALTER TABLE {$wpdb->prefix}bmify_business_hours_breaks AUTO_INCREMENT = 1"));
		}
		
		if($mondayChecked == 'on'){
			if(!empty($_POST['monday'])){
				foreach($_POST['monday'] as $mykey => $item){
					if(($mykey % 2) == 0){$monday_start = $item;}else{
						$monday_end = $item;
						$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_business_hours_breaks (start_time, end_time, day_index) VALUES ( %s, %s, %d )", $monday_start, $monday_end, 1));
					}
				}
			}
		}
		if($tuesdayChecked == 'on'){
			if(!empty($_POST['tuesday'])){
				foreach($_POST['tuesday'] as $mykey => $item){
					if(($mykey % 2) == 0){$tuesday_start = $item;}else{
						$tuesday_end = $item;
						$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_business_hours_breaks (start_time, end_time, day_index) VALUES ( %s, %s, %d )", $tuesday_start, $tuesday_end, 2));
					}
				}
			}
		}
		if($wednesdayChecked == 'on'){
			if(!empty($_POST['wednesday'])){
				foreach($_POST['wednesday'] as $mykey => $item){
					if(($mykey % 2) == 0){$wednesday_start = $item;}else{
						$wednesday_end = $item;
						$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_business_hours_breaks (start_time, end_time, day_index) VALUES ( %s, %s, %d )", $wednesday_start, $wednesday_end, 3));
					}
				}
			}
		}
		if($thursdayChecked == 'on'){
			if(!empty($_POST['thursday'])){
				foreach($_POST['thursday'] as $mykey => $item){
					if(($mykey % 2) == 0){$thursday_start = $item;}else{
						$thursday_end = $item;
						$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_business_hours_breaks (start_time, end_time, day_index) VALUES ( %s, %s, %d )", $thursday_start, $thursday_end, 4));
					}
				}
			}
		}
		if($fridayChecked == 'on'){
			if(!empty($_POST['friday'])){
				foreach($_POST['friday'] as $mykey => $item){
					if(($mykey % 2) == 0){$friday_start = $item;}else{
						$friday_end = $item;
						$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_business_hours_breaks (start_time, end_time, day_index) VALUES ( %s, %s, %d )", $friday_start, $friday_end, 5));
					}
				}
			}
		}
		if($saturdayChecked == 'on'){
			if(!empty($_POST['saturday'])){
				foreach($_POST['saturday'] as $mykey => $item){
					if(($mykey % 2) == 0){$saturday_start = $item;}else{
						$saturday_end = $item;
						$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_business_hours_breaks (start_time, end_time, day_index) VALUES ( %s, %s, %d )", $saturday_start, $saturday_end, 6));
					}
				}
			}
		}
		if($sundayChecked == 'on'){
			if(!empty($_POST['sunday'])){
				foreach($_POST['sunday'] as $mykey => $item){
					if(($mykey % 2) == 0){$sunday_start = $item;}else{
						$sunday_end = $item;
						$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_business_hours_breaks (start_time, end_time, day_index) VALUES ( %s, %s, %d )", $sunday_start, $sunday_end, 7));
					}
				}
			}
		}
		
		
		$buffyArray = array(
				'html'					=> $html,
		);
		die(json_encode($buffyArray));
	}
	
}
	

