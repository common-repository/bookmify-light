<?php
namespace Bookmify;
use Bookmify;

use Bookmify\Helper;
use Bookmify\HelperTime;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class NotificationManagement{
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function replacePlaceholders($text, $codes)
    {
        $placeholders = array_map(
            function ($placeholder) {
                return "{{{$placeholder}}}";
            },
            array_keys($codes)
        );

        return str_replace($placeholders, array_values($codes), $text);
    }
	
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function demoPlaceholders()
    {
        $placeholders = [
			'appointment_date' 			=> 'March 12, 2020',
			'appointment_start_time' 	=> '10:30 am',
			'company_address' 			=> '9500 Euclid Avenue Cleveland, OH 44195-5108',
			'company_name' 				=> 'Frenify Health Clinic',
			'company_phone' 			=> '(216) 444–2200',
			'company_website' 			=> 'https://codecanyon.net/user/frenify/portfolio',
			'customer_full_name' 		=> 'Aron Beltran',
			'customer_first_name' 		=> 'Aron',
			'customer_last_name' 		=> 'Beltran',
			'customer_phone' 			=> '532-3243-3445',
			'customer_email' 			=> 'beltran@mail.com',
			'employee_full_name' 		=> 'Dr. Ramos Cejudo',
			'employee_email' 			=> 'cejudor@gmail.com',
			'employee_phone' 			=> '877-463-2010',
			'service_name' 				=> 'Pediatric Cardiology',
			'site_address' 				=> BOOKMIFY_SITE_URL,
			'new_username' 				=> 'Falimaya',
			'new_password' 				=> 'passwordtest2018!',
		];
		
        return $placeholders;
    }
	


	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function _sender($receiver, $subject, $content)
	{
		$mailService 	= get_option('bookmify_be_not_mail_service', 'php');
		$senderEmail 	= get_option('bookmify_be_not_sender_email', '');
		$senderName 	= get_option('bookmify_be_not_sender_name', '');
		$from 			= array($senderName,$senderEmail);
		$headers 		= "MIME-Version: 1.0\r\n" .
		"From: " .$senderName . " <". $senderEmail . ">\r\n" .
		"Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\r\n";
		
		
		if($senderEmail != '' & $senderName != ''){
			switch($mailService){
				default:
				case 'php': 	mail( $receiver, $subject, $content, $headers ); break;
				case 'wp':		wp_mail( $receiver, $subject, $content, $headers ); break;
			}
		}
	}
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function sendEmailToCustomer($receiver, $subject, $content, $notificationID, $customerID, $appID = '')
	{
		global $wpdb;
		$mailService 	= get_option('bookmify_be_not_mail_service', 'php');
		$senderEmail 	= get_option('bookmify_be_not_sender_email', '');
		$senderName 	= get_option('bookmify_be_not_sender_name', '');
		$from 			= array($senderName,$senderEmail);
		$headers = "MIME-Version: 1.0\r\n" .
		"From: " .$senderName . " <". $senderEmail . ">\r\n" .
		"Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\r\n";
		
		
		$demo 			= '';
		
		
		if($demo == ''){
			if($senderEmail != '' & $senderName != ''){
				switch($mailService){
					default:
					case 'php': 	mail( $receiver, $subject, $content, $headers ); break;
					case 'wp':		wp_mail( $receiver, $subject, $content, $headers ); break;
				}
			}
		}
			
		
		
		
		
		$sendDate = HelperTime::getCurrentDateTime();
		if($appID == ''){
			$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_notifications_sent ( notification_id, customer_id, sent_date ) VALUES ( %d, %d, %s )", $notificationID, $customerID, $sendDate));
		}else{
			$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_notifications_sent ( notification_id, appointment_id, customer_id, sent_date ) VALUES ( %d, %d, %d, %s )", $notificationID, $appID, $customerID, $sendDate));
		}
		
	}
	
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function sendEmailToEmployee($receiver, $subject, $content, $notificationID, $employeeID, $appID = '')
	{
		global $wpdb;
		$mailService 	= get_option('bookmify_be_not_mail_service', 'php');
		$senderEmail 	= get_option('bookmify_be_not_sender_email', '');
		$senderName 	= get_option('bookmify_be_not_sender_name', '');
		$from 			= array($senderName,$senderEmail);
		$headers 		= "MIME-Version: 1.0\r\n" .
		"From: " .$senderName . " <". $senderEmail . ">\r\n" .
		"Content-Type: text/html; charset=\"" . get_option('blog_charset') . "\"\r\n";
		
		
		$demo 			= '';
		
		if($demo == ''){
			if($senderEmail != '' & $senderName != ''){
				switch($mailService){
					default:
					case 'php': 	mail( $receiver, $subject, $content, $headers ); break;
					case 'wp':		wp_mail( $receiver, $subject, $content, $headers ); break;
				}
			}
		}
		
		
		
		$sendDate = HelperTime::getCurrentDateTime();
		if($appID == ''){
			$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_notifications_sent ( notification_id, employee_id, sent_date ) VALUES ( %d, %d, %s )", $notificationID, $employeeID, $sendDate));
		}else{
			$wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}bmify_notifications_sent ( notification_id, appointment_id, employee_id, sent_date ) VALUES ( %d, %d, %d, %s )", $notificationID, $appID, $employeeID, $sendDate));
		}
	}
	
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function sendNewUserCredentials( $customer, $username, $password, $customerID )
    {

		$placeholders = [
			'customer_first_name' 	=> $customer->first_name,
			'customer_last_name'  	=> $customer->last_name,
			'customer_full_name'  	=> $customer->first_name. ' ' .$customer->last_name,
			'customer_email'      	=> $customer->email,
			'customer_phone'      	=> $customer->phone,
			'new_username'      	=> $username,
			'new_password'      	=> $password,
			'site_address'      	=> BOOKMIFY_SITE_URL,
		];

		$notification_subject 	= self::getSubject('customer_login_message', 'email', 1);
		$notification_message 	= self::getMessage('customer_login_message', 'email', 1);
		$notification_id	 	= self::getID('customer_login_message', 'email', 1);

		$notification_subject 	= self::replacePlaceholders($notification_subject, $placeholders);
		$notification_message 	= self::replacePlaceholders($notification_message, $placeholders);

		self::sendEmailToCustomer($customer->email, $notification_subject, $notification_message, $notification_id, $customerID);
		
    }
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function sendNewEmployeeCredentials( $employee, $username, $password, $employeeID )
    {

		$placeholders = [
			'employee_first_name' 	=> $employee->first_name,
			'employee_last_name'  	=> $employee->last_name,
			'employee_full_name'  	=> $employee->first_name. ' ' .$employee->last_name,
			'employee_email'      	=> $employee->email,
			'employee_phone'      	=> $employee->phone,
			'new_username'      	=> $username,
			'new_password'      	=> $password,
			'site_address'      	=> BOOKMIFY_SITE_URL,
		];

		$notification_subject 	= self::getSubject('employee_login_message', 'email', 1);
		$notification_message 	= self::getMessage('employee_login_message', 'email', 1);
		$notification_id	 	= self::getID('employee_login_message', 'email', 1);

		$notification_subject 	= self::replacePlaceholders($notification_subject, $placeholders);
		$notification_message 	= self::replacePlaceholders($notification_message, $placeholders);

		self::sendEmailToEmployee($employee->email, $notification_subject, $notification_message, $notification_id, $employeeID);
		
    }
	
	public static function sendInfoToEmployeeAboutAppointment($object, $rescheduled = '', $scheduled = ''){
		
		$customerCount	 				=  $object->customer_count;
		if($customerCount == 1){
			$customerName				= $object->customer_name;
			$customerEmail				= $object->customer_email;
			$customerPhone				= $object->customer_phone;
		}else{
			$customerName				= $customerCount 			. ' ' . esc_html__('Customers', 'bookmify');
			$customerEmail				= $object->customer_email 	. ' ' . esc_html__('Emails', 'bookmify');
			$customerPhone				= $object->customer_phone 	. ' ' . esc_html__('Phones', 'bookmify');
		}
		
		if(isset($object->cf)){
			$cf = $object->cf;
		}else{
			$cf = '';
		}
		
		$placeholders = [
			'service_name' 				=> $object->service_name,
			'appointment_date'  		=> date(get_option('bookmify_be_date_format', 'd F, Y'), strtotime($object->appointment_date)),
			'appointment_start_time'  	=> date(get_option('bookmify_be_time_format', 'h:i a'), strtotime($object->appointment_time)),
			'customer_full_name'   		=> $customerName,
			'customer_phone'      		=> $customerPhone,
			'customer_email'      		=> $customerEmail,
			'company_address'			=> get_option( 'bookmify_be_company_info_address', '' ),
			'company_name'				=> get_option( 'bookmify_be_company_info_name', '' ),
			'company_phone'				=> get_option( 'bookmify_be_company_info_phone', '' ),
			'company_website'			=> get_option( 'bookmify_be_company_info_website', '' ),
			'custom_fields'				=> $cf,
		];
		
		switch($object->status){
			case 'approved':
				$notification_subject 	= self::getSubject('employee_approved_message', 'email', 1);
				$notification_message 	= self::getMessage('employee_approved_message', 'email', 1);
				$notification_id	 	= self::getID('employee_approved_message', 'email', 1);
				break;
			case 'pending':
				$notification_subject 	= self::getSubject('employee_pending_message', 'email', 1);
				$notification_message 	= self::getMessage('employee_pending_message', 'email', 1);
				$notification_id	 	= self::getID('employee_pending_message', 'email', 1);
				break;
			case 'canceled':
				$notification_subject 	= self::getSubject('employee_canceled_message', 'email', 1);
				$notification_message 	= self::getMessage('employee_canceled_message', 'email', 1);
				$notification_id	 	= self::getID('employee_canceled_message', 'email', 1);
				break;
			case 'rejected':
				$notification_subject 	= self::getSubject('employee_rejected_message', 'email', 1);
				$notification_message 	= self::getMessage('employee_rejected_message', 'email', 1);
				$notification_id	 	= self::getID('employee_rejected_message', 'email', 1);
				break;
		}
		
		if($rescheduled == 'rescheduled'){
			$notification_subject 	= self::getSubject('employee_rescheduled_message', 'email', 1);
			$notification_message 	= self::getMessage('employee_rescheduled_message', 'email', 1);
			$notification_id	 	= self::getID('employee_rescheduled_message', 'email', 1);
		}

		if($scheduled == 'one_day'){
			$notification_subject 	= self::getSubject('employee_reminder_prev_day', 'email', 1);
			$notification_message 	= self::getMessage('employee_reminder_prev_day', 'email', 1);
			$notification_id	 	= self::getID('employee_reminder_prev_day', 'email', 1);
		}
		
		$notification_subject = self::replacePlaceholders($notification_subject, $placeholders);
		$notification_message = self::replacePlaceholders($notification_message, $placeholders);
		
		
		self::sendEmailToEmployee($object->employee_email,$notification_subject,$notification_message,$notification_id,$object->userID,$object->appID);
	}
	
	public static function sendInfoToCustomerAboutAppointment($object, $rescheduled = '', $scheduled = ''){
		global $wpdb;
		if(isset($object->cf)){
			$cf = $object->cf;
		}else{
			$cf = '';
		}
		if(isset($object->appID)){
			$appID 				= $object->appID;
			$appID 				= esc_sql($appID);
			$query 				= "SELECT employee_id FROM {$wpdb->prefix}bmify_appointments WHERE id=".$appID;
			$results	 		= $wpdb->get_results( $query, OBJECT  );
			$employeeID			= $results[0]->employee_id;
			
			$employeeFullName 	= Helper::bookmifyGetEmployeeCol($employeeID);
			$locationName 		= Helper::getLocationDataByEmployeeID($employeeID);
		}else{
			$employeeFullName 	= '';
			$locationName 		= '';
		}
		$placeholders = [
			'service_name' 				=> $object->service_name,
			'customer_full_name'		=> $object->customer_name,
			'appointment_date'  		=> date(get_option('bookmify_be_date_format', 'd F, Y'), strtotime($object->appointment_date)),
			'appointment_start_time'  	=> date(get_option('bookmify_be_time_format', 'h:i a'), strtotime($object->appointment_time)),
			'company_address'			=> get_option( 'bookmify_be_company_info_address', '' ),
			'company_name'				=> get_option( 'bookmify_be_company_info_name', '' ),
			'company_phone'				=> get_option( 'bookmify_be_company_info_phone', '' ),
			'company_website'			=> get_option( 'bookmify_be_company_info_website', '' ),
			'custom_fields'				=> $cf,
			'location_name'				=> $locationName,
			'employee_full_name'		=> $employeeFullName,
		];
		
		switch($object->status){
			case 'approved':
				$notification_subject 	= self::getSubject('customer_approved_message', 'email', 1);
				$notification_message 	= self::getMessage('customer_approved_message', 'email', 1);
				$notification_id	 	= self::getID('customer_approved_message', 'email', 1);
				break;
			case 'pending':
				$notification_subject 	= self::getSubject('customer_pending_message', 'email', 1);
				$notification_message 	= self::getMessage('customer_pending_message', 'email', 1);
				$notification_id	 	= self::getID('customer_pending_message', 'email', 1);
				break;
			case 'canceled':
				$notification_subject 	= self::getSubject('customer_canceled_message', 'email', 1);
				$notification_message 	= self::getMessage('customer_canceled_message', 'email', 1);
				$notification_id	 	= self::getID('customer_canceled_message', 'email', 1);
				break;
			case 'rejected':
				$notification_subject 	= self::getSubject('customer_rejected_message', 'email', 1);
				$notification_message 	= self::getMessage('customer_rejected_message', 'email', 1);
				$notification_id	 	= self::getID('customer_rejected_message', 'email', 1);
				break;
		}
		
		if($rescheduled == 'rescheduled'){
			$notification_subject 	= self::getSubject('customer_rescheduled_message', 'email', 1);
			$notification_message 	= self::getMessage('customer_rescheduled_message', 'email', 1);
			$notification_id	 	= self::getID('customer_rescheduled_message', 'email', 1);
		}
		if($scheduled == 'one_day'){
			$notification_subject 	= self::getSubject('customer_reminder_prev_day', 'email', 1);
			$notification_message 	= self::getMessage('customer_reminder_prev_day', 'email', 1);
			$notification_id	 	= self::getID('customer_reminder_prev_day', 'email', 1);
		}
		
		$notification_subject = self::replacePlaceholders($notification_subject, $placeholders);
		$notification_message = self::replacePlaceholders($notification_message, $placeholders);

		self::sendEmailToCustomer($object->customer_email, $notification_subject, $notification_message, $notification_id, $object->userID, $object->appID);
	}
	
	
	
	
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function getSubject($type, $platform, $status){
		global $wpdb; $html = '';
		
		$type 			= esc_sql($type);
		$platform 		= esc_sql($platform);
		$status 		= esc_sql($status);
		$query 			= "SELECT subject FROM {$wpdb->prefix}bmify_notifications WHERE type='".$type."' AND platform='".$platform."' AND status='".$status."'";
		$results 		= $wpdb->get_results( $query, OBJECT );
		
		foreach($results as $result){
			$html .= $result->subject;
		}
		
		return $html;
	}
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function getMessage($type, $platform, $status){
		global $wpdb; $html = '';
		
		$type 			= esc_sql($type);
		$platform 		= esc_sql($platform);
		$status 		= esc_sql($status);
		$query 			= "SELECT message FROM {$wpdb->prefix}bmify_notifications WHERE type='".$type."' AND platform='".$platform."' AND status='".$status."'";
		$results 		= $wpdb->get_results( $query, OBJECT );
		
		foreach($results as $result){
			$html .= $result->message;
		}
		
		return $html;
	}
	
	/**
	 * @since 1.0.0
	 * @access public
	*/
	public static function getID($type, $platform, $status){
		global $wpdb; $html = '';
		
		$type 			= esc_sql($type);
		$platform 		= esc_sql($platform);
		$status 		= esc_sql($status);
		$query 			= "SELECT id FROM {$wpdb->prefix}bmify_notifications WHERE type='".$type."' AND platform='".$platform."' AND status='".$status."'";
		$results 		= $wpdb->get_results( $query, OBJECT );
		
		foreach($results as $result){
			$html .= $result->id;
		}
		
		return $html;
	}



}