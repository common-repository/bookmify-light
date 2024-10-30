<?php
namespace Bookmify;

use Bookmify\Helper;


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {exit; }


/**
 * Class HelperSettings
 */
class HelperSettings
{
	public static function bookmifySettingsGeneralTab(){
		global $wpdb;
		$result  = '';
		$result .= '<div class="title_holder">
						<h3>'.esc_html__('General', 'bookmify').'</h3>
					</div>

					<div class="general_items">';
		
		
		// ---------------------------------------
		// TIME OPTIONS START
		// ---------------------------------------
		$result .=		'<div class="general_item_group">';
		// DAY FORMAT
		$result .= 			'<div class="general_item">
								<div class="item_title">
									<label for="date_format">'.esc_html__('Day Format', 'bookmify').'</label>
								</div>
								<div class="item_content">';

		$dayFormats = Helper::bookmifyDayFormats();
		$result .= 					'<select id="date_format" class="bookmify_be_date_format" name="bookmify_be_date_format">';

										$html = '';
										foreach($dayFormats as $format => $dayFormat){
											$html .= '<option value="'.$format.'" '.bookmify_be_selected(get_option( 'bookmify_be_date_format', 'd F, Y' ), $format).'>'.$dayFormat['ct'].'</option>';
										}
		$result .= 						$html;
		$result .= 					'</select>
								</div>
							</div>';
		// TIME FORMAT
		$result .= 			'<div class="general_item">
								<div class="item_title">
									<label for="time_format">'.esc_html__('Time Format', 'bookmify').'</label>
								</div>
								<div class="item_content">';
									$timeFormats = Helper::bookmifyTimeFormats();
		$result .= 					'<select id="time_format" class="bookmify_be_time_format" name="bookmify_be_time_format">';

										$html = '';
										foreach($timeFormats as $format => $timeFormat){
											$html .= '<option value="'.$format.'" '.bookmify_be_selected(get_option( 'bookmify_be_time_format', 'h:i a' ), $format).'>'.$timeFormat['ct'].'</option>';
										}
		$result .=						$html;
		$result .= 					'</select>
								</div>
							</div>';

		// MINIMUM TIME TO BOOKING
		$result .=			'<div class="general_item">
								<div class="item_title">
									<label for="mintime_tobooking">'.esc_html__('Minimum time to Booking', 'bookmify').'</label>
								</div>
								<div class="item_content">';

									$minTimes = Helper::bookmifyMinTimeToBooking();

		$result .= 					'<select id="mintime_tobooking" class="bookmify_be_mintime_tobooking" name="bookmify_be_mintime_tobooking">';

										$html = '';
										foreach($minTimes as $format => $minTime){
											$html .= '<option value="'.$format.'" '.bookmify_be_selected(get_option( 'bookmify_be_mintime_tobooking', 'disabled' ), $format).'>'.$minTime['ct'].'</option>';
										}
		$result .= 						$html;
		$result .= 					'</select>
								</div>
							</div>';

		// MINIMUM TIME TO CANCEL
		$result .=			'<div class="general_item">
								<div class="item_title">
									<label for="mintime_tocancel">'.esc_html__('Minimum time to Cancel', 'bookmify').'</label>
								</div>
								<div class="item_content">';

		$result .= 					'<select id="mintime_tocancel" class="bookmify_be_mintime_tocancel" name="bookmify_be_mintime_tocancel">';

										$html = '';
										foreach($minTimes as $format => $minTime){
											$html .= '<option value="'.$format.'" '.bookmify_be_selected(get_option( 'bookmify_be_mintime_tocancel', 'disabled' ), $format).'>'.$minTime['ct'].'</option>';
										}
		$result .= 						$html;
		$result .= 					'</select>
								</div>
							</div>';
		// TIME INTERVAL
		$result .=			'<div class="general_item">
								<div class="item_title">
									<label for="time_interval">'.esc_html__('Time Interval', 'bookmify').'</label>
								</div>
								<div class="item_content">';
		
		$timeIntervals = Helper::bookmifyTimeInterval();
		$result .= 					'<select id="time_interval" class="bookmify_be_time_interval" name="bookmify_be_time_interval">';

										$html = '';
										foreach($timeIntervals as $format => $timeInterval){
											$html .= '<option value="'.$format.'" '.bookmify_be_selected(get_option( 'bookmify_be_time_interval', '15' ), $format).'>'.$timeInterval['ct'].'</option>';
										}
		$result .= 						$html;
		$result .= 					'</select>
								</div>
							</div>';
		$timeSlotChecked		= '';
		if(get_option('bookmify_be_service_time_as_slot', '') == 'on'){
			$timeSlotChecked	 	= 'checked="checked"';
		}
		$result .= 			'<div class="general_item">
								<div class="item_title"><label for="service_time_as_slot">'.esc_html__('Service Duration as Time Slot', 'bookmify').'</label></div>
								<div class="item_content">
									<label class="bookmify_be_switch">
										<input type="checkbox" id="service_time_as_slot" name="bookmify_be_service_time_as_slot" '.esc_attr($timeSlotChecked).'  />
										<span class="slider round"></span>
									</label>
								</div>
							</div>';
//		$clientTimeZoneOffsetChecked		= '';
//		if(get_option('bookmify_be_client_timezone', '') == 'on'){
//			$clientTimeZoneOffsetChecked	= 'checked="checked"';
//		}
//		$result .= 			'<div class="general_item">
//								<div class="item_title"><label for="client_timezone">'.esc_html__('Client Time Zone Depended Time Slots', 'bookmify').'</label></div>
//								<div class="item_content">
//									<label class="bookmify_be_switch">
//										<input type="checkbox" id="client_timezone" name="bookmify_be_client_timezone" '.esc_attr($clientTimeZoneOffsetChecked).'  />
//										<span class="slider round"></span>
//									</label>
//								</div>
//							</div>';
		$result .=		'</div>';
		// ---------------------------------------
		// TIME OPTIONS END
		// ---------------------------------------

		// ---------------------------------------
		// APPOINTMENT OPTIONS START
		// ---------------------------------------
		$result .=		'<div class="general_item_group">';
		$result .=			'<div class="general_item">
								<div class="item_title">
									<label for="default_app_status">'.esc_html__('Front-end Appointment Status', 'bookmify').'</label>
								</div>
								<div class="item_content">';

									$statuses = Helper::bookmifyFrontEndAppointmentStatus();

		$result .= 					'<select id="default_app_status" class="bookmify_be_default_app_status" name="bookmify_be_default_app_status">';

										$html = '';
										foreach($statuses as $format => $status){
											$html .= '<option value="'.$format.'" '.bookmify_be_selected(get_option( 'bookmify_be_default_app_status', 'approved' ), $format).'>'.$status['ct'].'</option>';
										}
		$result .= 						$html;
		$result .= 					'</select>
								</div>
							 </div>';
		$result .= 			'<div class="general_item">
								<div class="item_title">
									<label>'.esc_html__('Appointments Per Page', 'bookmify').'</label>
								</div>
								<div class="item_content">
									<select name="bookmify_be_appointments_pp">';

										$html = '';
										$numbers = array('all' => esc_html__('Show All', 'bookmify'));
										for($i=1; $i <= 500;){$numbers[$i] = $i; $i++;}

											foreach($numbers as $key => $number){
												$html .= '<option value="'.$key.'" '.bookmify_be_selected(get_option( 'bookmify_be_appointments_pp', '10' ), $key).'>'.$number.'</option>';
											}
		$result .= 						$html.'
									</select>
								</div>
							</div>

							<div class="general_item">
								<div class="item_title">
									<label>'.esc_html__('Appointments Filter Date Range', 'bookmify').'</label>
								</div>
								<div class="item_content">
									<select name="bookmify_be_appointments_daterange">';

										$html = '';
										$numbers = array();
										for($i=1; $i <= 90;){$numbers[$i] = $i; $i++;}

										foreach($numbers as $key => $number){
											$html .= '<option value="'.$key.'" '.bookmify_be_selected(get_option( 'bookmify_be_appointments_daterange', '30' ), $key).'>'.$number.'</option>';
										}
		$result .= 						$html.'
									</select>
								</div>
							</div>
						</div>';
		// ---------------------------------------
		// APPOINTMENT OPTIONS END
		// ---------------------------------------
		// ---------------------------------------
		// CALENDAR HOTKEYS OPTIONS START
		// ---------------------------------------
		$result .= 						'<div class="general_item_group hot_keys">';

		$hotkeyChecked			= '';
		$hotkeySwitch			= 'disabled';
		if(get_option('bookmify_be_calendar_hotkeys', '') == 'on'){
			$hotkeyChecked	 	= 'checked="checked"';
			$hotkeySwitch		= 'enabled';
		}
		$result .=							'<div class="general_item">
												<div class="item_title"><label for="calendar_hotkeys">'.esc_html__('Calendar Hot Keys', 'bookmify').'</label></div>
												<div class="item_content">
													<label class="bookmify_be_switch">
														<input type="checkbox" id="calendar_hotkeys" name="bookmify_be_calendar_hotkeys" '.esc_attr($hotkeyChecked).'  />
														<span class="slider round"></span>
													</label>
												</div>
											</div>

											<div class="general_item calendar_hotkeys '.esc_attr($hotkeySwitch).'">
												<div class="item_title">
													<label for="calendar_hotkeys_today">'.esc_html__('Go To Today', 'bookmify').'</label>
												</div>
												<div class="item_content">
													<input id="calendar_hotkeys_today" name="bookmify_be_calendar_hotkeys_today" type="text" value="'.get_option('bookmify_be_calendar_hotkeys_today', 't').'" maxlength="1" />
													<span></span>
												</div>
											</div>

											<div class="general_item calendar_hotkeys '.esc_attr($hotkeySwitch).'">
												<div class="item_title">
													<label for="calendar_hotkeys_month">'.esc_html__('Month View', 'bookmify').'</label>
												</div>
												<div class="item_content">
													<input id="calendar_hotkeys_month" name="bookmify_be_calendar_hotkeys_month" type="text" value="'.get_option('bookmify_be_calendar_hotkeys_month', 'm').'" maxlength="1" />
													<span></span>
												</div>
											</div>

											<div class="general_item calendar_hotkeys '.esc_attr($hotkeySwitch).'">
												<div class="item_title">
													<label for="calendar_hotkeys_week">'.esc_html__('Week View', 'bookmify').'</label>
												</div>
												<div class="item_content">
													<input id="calendar_hotkeys_week" name="bookmify_be_calendar_hotkeys_week" type="text" value="'.get_option('bookmify_be_calendar_hotkeys_week', 'w').'" maxlength="1" />
													<span></span>
												</div>
											</div>

											<div class="general_item calendar_hotkeys '.esc_attr($hotkeySwitch).'">
												<div class="item_title">
													<label for="calendar_hotkeys_day">'.esc_html__('Day View', 'bookmify').'</label>
												</div>
												<div class="item_content">
													<input id="calendar_hotkeys_day" name="bookmify_be_calendar_hotkeys_day" type="text" value="'.get_option('bookmify_be_calendar_hotkeys_day', 'd').'" maxlength="1" />
													<span></span>
												</div>
											</div>

											<div class="general_item calendar_hotkeys '.esc_attr($hotkeySwitch).'">
												<div class="item_title">
													<label for="calendar_hotkeys_list">'.esc_html__('List View', 'bookmify').'</label>
												</div>
												<div class="item_content">
													<input id="calendar_hotkeys_list" name="bookmify_be_calendar_hotkeys_list" type="text" value="'.get_option('bookmify_be_calendar_hotkeys_list', 'l').'" maxlength="1" />
													<span></span>
												</div>
											</div>

											<div class="general_item calendar_hotkeys '.esc_attr($hotkeySwitch).'">
												<div class="item_title">
													<label for="calendar_hotkeys_prev">'.esc_html__('Go To Previous', 'bookmify').'</label>
												</div>
												<div class="item_content">
													<input id="calendar_hotkeys_prev" name="bookmify_be_calendar_hotkeys_prev" type="text" value="'.get_option('bookmify_be_calendar_hotkeys_prev', 'ArrowLeft').'" maxlength="1" />
													<span></span>
												</div>
											</div>

											<div class="general_item calendar_hotkeys '.esc_attr($hotkeySwitch).'">
												<div class="item_title">
													<label for="calendar_hotkeys_next">'.esc_html__('Go To Next', 'bookmify').'</label>
												</div>
												<div class="item_content">
													<input id="calendar_hotkeys_next" name="bookmify_be_calendar_hotkeys_next" type="text" value="'.get_option('bookmify_be_calendar_hotkeys_next', 'ArrowRight').'" maxlength="1" />
													<span></span>
												</div>
											</div>

											<div class="general_item calendar_hotkeys '.esc_attr($hotkeySwitch).'">
												<div class="item_title">
													<label for="calendar_hotkeys_reset">'.esc_html__('Reset All Filters', 'bookmify').'</label>
												</div>
												<div class="item_content">
													<input id="calendar_hotkeys_reset" name="bookmify_be_calendar_hotkeys_reset" type="text" value="'.get_option('bookmify_be_calendar_hotkeys_reset', 'r').'" maxlength="1" />
													<span></span>
												</div>
											</div>

											
										</div>';
		// ---------------------------------------
		// CALENDAR HOTKEYS OPTIONS END
		// ---------------------------------------
		$result .= '</div>

					<div class="save_btn">
						<a class="bookmify_save_link" href="#">
							<span class="text">'.esc_html__('Save', 'bookmify').'</span>
							<span class="save_process">
								<span class="ball"></span>
								<span class="ball"></span>
								<span class="ball"></span>
							</span>
						</a>
					</div>';
		
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
		$result	= preg_replace($search, $replace, $result);
		return $result;
	}
	public static function bookmifySettingsCompanyInfoTab(){
		global $wpdb;
		$result  = '';
		$result .= '<div class="title_holder">
						<h3>'.esc_html__('Company Info', 'bookmify').'</h3>
					</div>

					<div class="general_items">';

						$attachmentID				= get_option( 'bookmify_be_company_info_img', '' );
						if($attachmentID != ''){
							$attachmentURLLarge		= Helper::bookmifyGetImageByID($attachmentID, 'large');
							$attachmentURL	 		= Helper::bookmifyGetImageByID($attachmentID);
						}else{
							$attachmentURLLarge 	= '';
							$attachmentURL 			= '';
						}

						if($attachmentURL != ''){$attOpened = 'has_image';}else{$attOpened = '';}
						if($attachmentURLLarge == ''){$attachmentURLLarge = $attachmentURL;}
		$result .= 		'<div class="general_item_group">
							<div class="general_item_left">
								<input type="hidden" class="bookmify_be_company_info_img" name="bookmify_be_company_info_img" value="'. esc_attr($attachmentID) .'" />
								<div class="bookmify_thumb_wrap '.esc_attr($attOpened).'" style="background-image:url('. esc_url($attachmentURLLarge) .')">
									<div class="bookmify_thumb_edit">
										<span class="edit">
											<img class="bookmify_be_svg" src="'.BOOKMIFY_ASSETS_URL.'img/image.svg" alt="" />
										</span>
									</div>
									<div class="bookmify_thumb_remove '.esc_attr($attOpened).'">
										<a href="#" class="bookmify_be_delete">
											<img class="bookmify_be_svg" src="'.BOOKMIFY_ASSETS_URL.'img/delete.svg" alt="" />
										</a>
									</div>
								</div>												
							</div>
							<div class="general_item_right">
								<div class="general_item">
									<div class="item_title"><label>'.esc_html__('Name', 'bookmify').'</label></div>
									<div class="item_content">
										<input id="company_info_name" type="text" name="bookmify_be_company_info_name" value="'.get_option( 'bookmify_be_company_info_name', '' ).'">
									</div>
								</div>
								<div class="general_item">
									<div class="item_title"><label>'.esc_html__('Address', 'bookmify').'</label></div>
									<div class="item_content">
										<input id="company_info_address" type="text" name="bookmify_be_company_info_address" value="'.get_option( 'bookmify_be_company_info_address', '' ).'">
									</div>
								</div>
								<div class="general_item">
									<div class="item_title"><label>'.esc_html__('Website', 'bookmify').'</label></div>
									<div class="item_content">
										<input id="company_info_website" type="text" name="bookmify_be_company_info_website" value="'.get_option( 'bookmify_be_company_info_website', '' ).'">
									</div>
								</div>
								<div class="general_item">
									<div class="item_title"><label>'.esc_html__('Phone', 'bookmify').'</label></div>
									<div class="item_content">
										<input id="company_info_phone" type="tel" name="bookmify_be_company_info_phone" value="'.get_option( 'bookmify_be_company_info_phone', '' ).'">
										<span class="bot__btn"><img class="bookmify_be_svg" src="'.BOOKMIFY_ASSETS_URL.'img/down.svg" alt="" /></span>
									</div>											
								</div>
							</div>
						</div>


					</div>

					<div class="save_btn">
						<a class="bookmify_save_link" href="#">
							<span class="text">'.esc_html__('Save', 'bookmify').'</span>
							<span class="save_process">
								<span class="ball"></span>
								<span class="ball"></span>
								<span class="ball"></span>
							</span>
						</a>
					</div>';
		
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
		$result	= preg_replace($search, $replace, $result);
		return $result;
	}
	
	public static function bookmifySettingsNotificationTab(){
		global $wpdb;
		$result  = '';
		$result .= '<div class="title_holder">
						<h3>'.esc_html__('Notifications', 'bookmify').'</h3>
					</div>

					<div class="general_items">


						<div class="general_item_group">
							<div class="general_item">
								<div class="item_title"><label for="mail_service">'.esc_html__('Mail Service', 'bookmify').'</label></div>
								<div class="item_content">';
		$mailServices = Helper::bookmifyMailServices();
		$result .= 					'<select id="mail_service" class="bookmify_be_not_mail_service" name="bookmify_be_not_mail_service">';
										$html = '';
										foreach($mailServices as $format => $mailService){
											$html .= '<option value="'.$format.'" '.bookmify_be_selected(get_option( 'bookmify_be_not_mail_service', 'php' ), $format).'>'.$mailService['ct'].'</option>';
										}
		$result .= 					$html.'
									</select>
								</div>
							</div>
						</div>

						<div class="general_item_group">
							<div class="general_item">
								<div class="item_title"><label for="sender_name">'.esc_html__('Sender Name', 'bookmify').'</label></div>
								<div class="item_content">
									<input autocomplete="off" id="sender_name" name="bookmify_be_not_sender_name" type="text" value="'.get_option('bookmify_be_not_sender_name', '').'" />
								</div>
							</div>
							<div class="general_item">
								<div class="item_title"><label for="sender_email">'.esc_html__('Sender Email', 'bookmify').'</label></div>
								<div class="item_content">
									<input autocomplete="off" id="sender_email" name="bookmify_be_not_sender_email" type="text" value="'.get_option('bookmify_be_not_sender_email', '').'" />
								</div>
							</div>
						</div>';

						$smtpDisabled 		= '';
						if(get_option( 'bookmify_be_not_mail_service', 'php') != 'smtp'){
							$smtpDisabled 	= 'disabled';
						}

		$result .=		'<div class="general_item_group smtp_options '.esc_attr($smtpDisabled).'">
							<div class="general_item">
								<div class="item_title"><label for="smtp_host">'.esc_html__('SMTP Host', 'bookmify').'</label></div>
								<div class="item_content">
									<input autocomplete="off" id="smtp_host" name="bookmify_be_not_smtp_host" type="text" value="'.get_option('bookmify_be_not_smtp_host', '').'" />
								</div>
							</div>
							<div class="general_item">
								<div class="item_title"><label for="smtp_port">'.esc_html__('SMTP Port', 'bookmify').'</label></div>
								<div class="item_content">
									<input autocomplete="off" id="smtp_port" name="bookmify_be_not_smtp_port" type="text" value="'.get_option('bookmify_be_not_smtp_port', '').'" />
								</div>
							</div>
							<div class="general_item">
								<div class="item_title"><label for="smtp_username">'.esc_html__('SMTP Username', 'bookmify').'</label></div>
								<div class="item_content">
									<input autocomplete="off" id="smtp_username" name="bookmify_be_not_smtp_username" type="text" value="'.get_option('bookmify_be_not_smtp_username', '').'" />
								</div>
							</div>
							<div class="general_item">
								<div class="item_title"><label for="smtp_password">'.esc_html__('SMTP Password', 'bookmify').'</label></div>
								<div class="item_content">
									<input autocomplete="new-password" id="smtp_password" name="bookmify_be_not_smtp_pass" type="password" value="'.get_option('bookmify_be_not_smtp_pass', '').'" />
								</div>
							</div>
							<div class="general_item">
								<div class="item_title"><label for="smtp_secure">'.esc_html__('SMTP Secure', 'bookmify').'</label></div>
								<div class="item_content">';
		$smtpSecures = Helper::bookmifySMTPSecure();
		$result .=					'<select id="smtp_secure" class="bookmify_be_not_smtp_secure" name="bookmify_be_not_smtp_secure">';
										$html = '';
										foreach($smtpSecures as $format => $smtpSecure){
											$html .= '<option value="'.$format.'" '.bookmify_be_selected(get_option( 'bookmify_be_not_smtp_secure', 'disabled' ), $format).'>'.$smtpSecure['ct'].'</option>';
										}
		$result .=						$html.'
									</select>
								</div>
							</div>
						</div>


					</div>




					<div class="save_btn">
						<a class="bookmify_save_link" href="#">
							<span class="text">'.esc_html__('Save', 'bookmify').'</span>
							<span class="save_process">
								<span class="ball"></span>
								<span class="ball"></span>
								<span class="ball"></span>
							</span>
						</a>
					</div>';
		
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
		$result	= preg_replace($search, $replace, $result);
		return $result;
	}
	
	public static function bookmifySettingsFrontEndTab(){
		$result  = '';
		$result .= '<div class="title_holder">
						<h3>'.esc_html__('Front-end Customizations', 'bookmify').'</h3>
					</div>

					<div class="general_items">


						<div class="general_item_group">
							<div class="general_item">
								<div class="item_title"><label for="main_color_1">'.esc_html__('Main Color #1', 'bookmify').'</label></div>
								<div class="item_content">
									<input id="topbar_bg" type="text" name="bookmify_be_feoption_main_color_1" class="bookmify_be_feoption_main_color_1 bookmify_color_picker" value="'.get_option('bookmify_be_feoption_main_color_1', '#5473e8').'" />
								</div>
							</div>
							<div class="general_item">
								<div class="item_title"><label for="main_color_2">'.esc_html__('Main Color #2', 'bookmify').'</label></div>
								<div class="item_content">
									<input id="main_color_2" type="text" name="bookmify_be_feoption_main_color_2" class="bookmify_be_feoption_main_color_2 bookmify_color_picker" value="'.get_option('bookmify_be_feoption_main_color_2', '#35d8ac').'" />
								</div>
							</div>
							<div class="general_item">
								<div class="item_title"><label for="main_color_3">'.esc_html__('Main Color #3', 'bookmify').'</label></div>
								<div class="item_content">
									<input id="main_color_3" type="text" name="bookmify_be_feoption_main_color_3" class="bookmify_be_feoption_main_color_3 bookmify_color_picker" value="'.get_option('bookmify_be_feoption_main_color_3', '#7e849b').'" />
								</div>
							</div>
						</div>
						
					</div>




					<div class="save_btn">
						<a class="bookmify_save_link" href="#">
							<span class="text">'.esc_html__('Save', 'bookmify').'</span>
							<span class="save_process">
								<span class="ball"></span>
								<span class="ball"></span>
								<span class="ball"></span>
							</span>
						</a>
					</div>';
		return $result;
	}
}

