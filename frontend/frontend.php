<?php
namespace Bookmify;

use Bookmify\Helper;


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {exit; }



class Frontend{

	
    public function __construct(){
		
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		
		add_action( 'init', [$this, 'includes'] );
    }
	
	
	/**
	 * @since 1.0.0
     */
	public function includes(){
		// payment
		// shortcodes
		require( BOOKMIFY_PATH . 'frontend/shortcodes/shortcode-alpha.php' );
		
		// helpers
		require( BOOKMIFY_PATH . 'frontend/helpers/helper-service.php' );
		require( BOOKMIFY_PATH . 'frontend/helpers/helper-frontend.php' );
	}
	

	/**
     * Frontend Scripts.
	 * @since 1.0.0
     */
	public function enqueue_scripts() {
		// register
		
		// paypal checkout
		$sandboxMode 				= get_option('bookmify_be_paypal_sendbox_mode', 'on');
		$cuurencyFormat				= get_option('bookmify_be_currency_format', 'USD');
		$paypalClientID				= '';
		if($sandboxMode == 'on'){
			$paypalClientID 		= get_option('bookmify_be_paypal_client_id', '');
		}else{
			$paypalClientID 		= get_option('bookmify_be_paypal_client_id_live', '');
		}
		$paypalCheckout				= Helper::bookmifyBePaypalCheckout();
		// stripe checkout
		$stripeCheckout				= Helper::bookmifyBeStripeCheckout('');
		
			
		// AYGHOajW_KDqa2J2C-VGRr_ub28cGsyL6RSfR44dCAN7xU21K_OUKTKXSyf_Fj44eXa8kZ_xRLBI4E_v
		if($stripeCheckout == 'on'){
			wp_register_script('bookmify-stripe-checkout', 'https://checkout.stripe.com/checkout.js', [], null, true);
		}
		if($paypalCheckout == 'on'){
			wp_register_script('bookmify-paypal-checkout', 'https://www.paypal.com/sdk/js?client-id='.$paypalClientID.'&currency='.$cuurencyFormat.'&disable-funding=credit,card', [], null, true);
		}
		wp_register_script('bookmify-datepicker', BOOKMIFY_FE_ASSETS_URL . 'js/jquery-ui.min.js',['jquery',], BOOKMIFY_VERSION, true);
		wp_register_script('bookmify-app', BOOKMIFY_FE_ASSETS_URL . 'js/init.js',['jquery',], BOOKMIFY_VERSION, true);
		
		
		if($stripeCheckout == 'on'){
			wp_enqueue_script( 'bookmify-stripe-checkout' );
		}
		if($paypalCheckout == 'on'){
			wp_enqueue_script( 'bookmify-paypal-checkout' );
		}
		wp_enqueue_script( 'bookmify-datepicker' );
		wp_enqueue_script( 'bookmify-app' );
		
		wp_localize_script(
			'bookmify-app',
			'bookmifyConfig',
			[
				'ajaxUrl' 				=> admin_url( 'admin-ajax.php' ),
				'deleteConfirmMessage' 	=> esc_html__( 'Are you sure?', 'bookmify' ),
				'updatedCategory' 		=> esc_html__( 'A category has been updated!', 'bookmify' ),
				'updateWarningCategory' => esc_html__( 'Please enter at least one character!', 'bookmify' ),
				'addedService' 			=> esc_html__( 'A service has been added!', 'bookmify' ),
				'addedCategory' 		=> esc_html__( 'A category has been added!', 'bookmify' ),
				'orderedCategory' 		=> esc_html__( 'Categories\' order have been changed!', 'bookmify' ),
				'deletedCategory' 		=> esc_html__( 'A category has been deleted!', 'bookmify' ),
				'updatedService' 		=> esc_html__( 'A service has been updated!', 'bookmify' ),
				'orderedExtra' 			=> esc_html__( 'Extra Services\' order have been changed!', 'bookmify' ),
				'deletedService' 		=> esc_html__( 'A service has been deleted!', 'bookmify' ),
				'errorField' 			=> esc_html__( 'Please fill out fields:', 'bookmify' ),
				'invalidEmail' 			=> esc_html__( 'Invalid Email', 'bookmify' ),
				'invalidPhone' 			=> esc_html__( 'Invalid Phone', 'bookmify' ),
				'invalidEmailPhone'		=> esc_html__( 'Invalid Email & Phone', 'bookmify' ),
				'noExtras'				=> esc_html__( 'None', 'bookmify' ),
				'extras'				=> esc_html__( 'Extras', 'bookmify' ),
				'durationText'			=> esc_html__( 'Duration', 'bookmify' ),
				'nextText'				=> esc_html__( 'Next', 'bookmify' ),
				'paypalText'			=> esc_html__( 'PayPal', 'bookmify' ),
				'stripeText'			=> esc_html__( 'Stripe', 'bookmify' ),
				'onSiteText'			=> esc_html__( 'On-site', 'bookmify' ),
				'assetsURL'				=> BOOKMIFY_ASSETS_URL,
				'stripePKey'			=> Helper::bookmifyBeStripeCheckout('p'),
				'stripeON'				=> Helper::bookmifyBeStripeCheckout(''),
				'paypalON'				=> Helper::bookmifyBePaypalCheckout(),
				'timezone'				=> get_option('bookmify_be_client_timezone', ''),
			]
		);
	}
	
	
	/**
     * Frontend Styles.
	 * @since 1.0.0
     */
	public function enqueue_styles() {
		// register
		wp_register_style( 'bookmify-font', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i|Quicksand:300,400,500,700', '', '' );
		wp_register_style( 'bookmify-datepicker', BOOKMIFY_FE_ASSETS_URL . 'css/jquery-ui.min.css', '', BOOKMIFY_VERSION );
		wp_register_style( 'bookmify-app', BOOKMIFY_FE_ASSETS_URL . 'css/style.css', '', BOOKMIFY_VERSION );
		
		// set
		wp_enqueue_style( 'bookmify-font' );
		wp_enqueue_style( 'bookmify-datepicker' );
		wp_enqueue_style( 'bookmify-app' );
		
	}
}
