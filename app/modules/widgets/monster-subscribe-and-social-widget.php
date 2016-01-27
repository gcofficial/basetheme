<?php
/**
 * Plugin Name: Monster Subscribe and Social Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: MailChimp subscribe and social link section widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package Monster_Subscribe_And_Social_Widget
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'Monster_Subscribe_And_Social_Widget' ) ) {

	/**
	 * Set constant text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab' );
	}

	/**
	 * Adds register_tm_subscribe_and_social_widget widget.
	 */
	class Monster_Subscribe_And_Social_Widget extends WP_Widget {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $instance_default = array();

		/**
		 * Socials list
		 *
		 * @var type array
		 */
		private $social_list = array( 'twitter', 'facebook', 'google-plus', 'vk', 'instagram', 'pinterest', 'youtube', 'linkedin' );

		/**
		 * Blocks list
		 *
		 * @var type array
		 */
		private $blocks_list = array( 'subscribe' => 'Subscribe', 'social' => 'Social' );
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'monster_subscribe_and_social_widget', // Base ID
				__( 'Monster Subscribe and Social Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'MailChimp subscribe and social link section widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'first_block'				=> 'subscribe',
				'subscribe_is'				=> 'true',
				'subscribe_title'			=> __( '', PHOTOLAB_BASE_TM_ALIAS ),
				'subscribe_description'		=> __( '', PHOTOLAB_BASE_TM_ALIAS ),
				'api_key'					=> '',
				'list_id'					=> '',
				'success_message'			=> __( 'Success', PHOTOLAB_BASE_TM_ALIAS ),
				'failed_message'			=> __( 'Failed', PHOTOLAB_BASE_TM_ALIAS ),

				'social_is'					=> 'true',
				'social_title'				=> __( '', PHOTOLAB_BASE_TM_ALIAS ),
				'social_description'		=> __( '', PHOTOLAB_BASE_TM_ALIAS ),
				'social_buttons'			=> array(),
			);

			// Need for submit frontend form
			add_action( 'wp_ajax_tm-mailchimp-subscribe', array( &$this, 'subscriber_add' ) );
			add_action( 'wp_ajax_nopriv_tm-mailchimp-subscribe', array( &$this, 'subscriber_add' ) );
		}

		/**
		 * Add new subscriber
		 */
		public function subscriber_add() {

			// simple api class for MailChimp from https://github.com/drewm/mailchimp-api/blob/master/src/Drewm/MailChimp.php
			require_once( Utils::api_path() . 'mailchimp-api.php' );

			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			$return = array(
				'status'	=> 'failed',
				'message'	=> $failed_message,
			);

			$email		= sanitize_email( $_POST['email'] );
			$api_key	= $_POST['api-key'];
			$list_id	= $_POST['list-id'];

			// Create MailChimp API object
			$mailerAPI_obj = new MailChimp( $api_key );

			if ( is_email( $email ) && ! empty( $api_key ) && $mailerAPI_obj->validate_api_key() ) {

				// Call API
				$result = $mailerAPI_obj->call( '/lists/subscribe', array(
					'id'	=> $list_id,
					'email'	=> array(
						'email'    => $email,
						'euid'     => time() . rand( 1, 1000 ),
						'leid'     => time() . rand( 1, 1000 ),
					),
					'double_optin'	=> true,
				), 20);

				if ( ! empty( $result['leid'] ) ) {

					// Success response
					$return = array(
						'status'	=> 'success',
						'message'	=> $success_message,
					);
				} else {
					$return['message'] = $failed_message;
				}

				$return['result'] = $result;

			}

			// Send answer
			wp_send_json( $return );
		}

		/**
		 * Include frontend assets
		 *
		 * @since 1.0
		 */
		public function frontend_assets() {

			// Custom js
			wp_register_script( 'tm-subscribe-and-social-script-frontend', Utils::assets_url() . '/js/subscribe-and-social-widget-frontend.min.js', '', '', true );
			wp_localize_script( 'tm-subscribe-and-social-script-frontend', 'TMSubscribeAndShareWidgetParam', array(
						'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
					)
				);
			wp_enqueue_script( 'tm-subscribe-and-social-script-frontend' );

			// Custom styles
			wp_register_style( 'tm-subscribe-and-social-frontend', Utils::assets_url() . '/css/subscribe-and-social-widget-frontend.min.css' );
			wp_enqueue_style( 'tm-subscribe-and-social-frontend' );

			// Font Awesome
			wp_register_style( 'font-awesome', Utils::assets_url() . '/css/font-awesome.min.css' );
			wp_enqueue_style( 'font-awesome' );

		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 *
		 * @since 1.1
		 */
		public function widget( $args, $instance ) {

			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			$this->frontend_assets();

			$blocks = $this->blocks_list;
			if ( 'social' == Utils::array_get( $instance, 'first_block' ) ) {
				$blocks = array_reverse( $blocks );
			}
			if ( 'false' == Utils::array_get( $instance, 'subscribe_is' ) ) {
				unset( $blocks['subscribe'] );
			}
			if ( 'false' == Utils::array_get( $instance, 'social_is' ) ) {
				unset( $blocks['social'] );
			}

			echo View::make(
				'widgets/front-end/subscribe-and-social',
				array(
					'before_widget'				=> $args['before_widget'],
					'before_title'				=> $args['before_widget'],
					'after_title'				=> $args['after_title'],
					'after_widget'				=> $args['after_widget'],
					'blocks'					=> $blocks,
					'folder_path'				=> 'widgets/front-end/subscribe-and-social',
					'subscribe_is'				=> Utils::array_get( $instance, 'subscribe_is' ),
					'subscribe_title'			=> Utils::array_get( $instance, 'subscribe_title' ),
					'subscribe_description'		=> Utils::array_get( $instance, 'subscribe_description' ),
					'api_key'					=> Utils::array_get( $instance, 'api_key' ),
					'list_id'					=> Utils::array_get( $instance, 'list_id' ),
					'subscribe_submit_src'		=> Utils::assets_url() . '/images/subscribe-submit.png',
					'success_message'			=> Utils::array_get( $instance, 'success_message' ),
					'failed_message'			=> Utils::array_get( $instance, 'failed_message' ),
					'social_is'					=> Utils::array_get( $instance, 'social_is' ),
					'social_title'				=> Utils::array_get( $instance, 'social_title' ),
					'social_description'		=> Utils::array_get( $instance, 'social_description' ),
					'social_buttons'			=> Utils::array_get( $instance, 'social_buttons' ),
				)
			);

		}

		/**
		 * Include admin assets
		 *
		 * @since 1.0
		 */
		public function admin_assets() {

			// Custom styles
			wp_register_style( 'tm-image-grid-admin', Utils::assets_url() . '/css/image-grid-widget-admin.min.css' );
			wp_enqueue_style( 'tm-image-grid-admin' );

			// Custom js
			wp_register_script( 'tm-subscribe-and-social-script-admin', Utils::assets_url() . '/js/subscribe-and-social-widget-admin.min.js' );
			wp_localize_script( 'tm-subscribe-and-social-script-admin', 'TMWidgetParam', array(
						'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
					)
				);
			wp_enqueue_script( 'tm-subscribe-and-social-script-admin' );

			// Custom styles
			wp_register_style( 'tm-subscribe-and-social-admin', Utils::assets_url() . '/css/subscribe-and-social-widget-admin.min.css' );
			wp_enqueue_style( 'tm-subscribe-and-social-admin' );
		}

		/**
		 * Create admin form for widget
		 *
		 * @param type $instance array.
		 *
		 * @since 1.1
		 */
		public function form( $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			$this->admin_assets();

			$first_block_field = new UI_Select_Fox(
							array(
								'id'				=> $this->get_field_id( 'first_block' ),
								'name'				=> $this->get_field_name( 'first_block' ),
								'default'			=> Utils::array_get( $instance, 'first_block' ),
								'options'			=> $this->blocks_list,
							)
						);
			$first_block_html = $first_block_field->output();

			$subscribe_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'subscribe_is' ) . ' subscribe_is',
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'subscribe_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'    => Utils::array_get( $instance, 'subscribe_is' ),
							)
					);
			$subscribe_is_html = $subscribe_is_field->output();

			$subscribe_title_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'subscribe_title' ),
						'name'			=> $this->get_field_name( 'subscribe_title' ),
						'value'			=> Utils::array_get( $instance, 'subscribe_title' ),
						'label'			=> __( 'Subscribe title', PHOTOLAB_BASE_TM_ALIAS ),
						'placeholder'	=> __( 'Subscribe title', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$subscribe_title_html = $subscribe_title_field->output();

			$subscribe_description_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'subscribe_description' ),
						'name'			=> $this->get_field_name( 'subscribe_description' ),
						'value'			=> Utils::array_get( $instance, 'subscribe_description' ),
						'label'			=> __( 'Subscribe description', PHOTOLAB_BASE_TM_ALIAS ),
						'placeholder'	=> __( 'Subscribe description', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$subscribe_description_html = $subscribe_description_field->output();

			$api_key_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'api_key' ),
						'name'			=> $this->get_field_name( 'api_key' ),
						'value'			=> Utils::array_get( $instance, 'api_key' ),
						'label'			=> __( 'MailChimp ApiKey', PHOTOLAB_BASE_TM_ALIAS ),
						'placeholder'	=> __( 'MailChimp ApiKey', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$api_key_html = $api_key_field->output();

			$list_id_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'list_id' ),
						'name'			=> $this->get_field_name( 'list_id' ),
						'value'			=> Utils::array_get( $instance, 'list_id' ),
						'label'			=> __( 'MailChimp list id', PHOTOLAB_BASE_TM_ALIAS ),
						'placeholder'	=> __( 'MailChimp list id', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$list_id_html = $list_id_field->output();

			$success_message_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'success_message' ),
						'name'			=> $this->get_field_name( 'success_message' ),
						'value'			=> Utils::array_get( $instance, 'success_message' ),
						'label'			=> __( 'Success message', PHOTOLAB_BASE_TM_ALIAS ),
						'placeholder'	=> __( 'Success', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$success_message_html = $success_message_field->output();

			$failed_message_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'failed_message' ),
						'name'			=> $this->get_field_name( 'failed_message' ),
						'value'			=> Utils::array_get( $instance, 'failed_message' ),
						'label'			=> __( 'Failed message', PHOTOLAB_BASE_TM_ALIAS ),
						'placeholder'	=> __( 'Failed', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$failed_message_html = $failed_message_field->output();

			$social_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'social_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'social_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'    => Utils::array_get( $instance, 'social_is' ),
							)
					);
			$social_is_html = $social_is_field->output();

			$social_title_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'social_title' ),
						'name'			=> $this->get_field_name( 'social_title' ),
						'value'			=> Utils::array_get( $instance, 'social_title' ),
						'label'			=> __( 'Social title', PHOTOLAB_BASE_TM_ALIAS ),
						'placeholder'	=> __( 'Social title', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$social_title_html = $social_title_field->output();

			$social_description_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'social_description' ),
						'name'			=> $this->get_field_name( 'social_description' ),
						'value'			=> Utils::array_get( $instance, 'social_description' ),
						'label'			=> __( 'Social description', PHOTOLAB_BASE_TM_ALIAS ),
						'placeholder'	=> __( 'social description', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$social_description_html = $social_description_field->output();

			$social_items = array();
			$social_buttons = Utils::array_get( $instance, 'social_buttons' );
			if ( is_array( $social_buttons ) && count( $social_buttons ) > 0 ) {
				foreach ( $social_buttons as $key => $button ) {
					$service_field = new UI_Input_Fox(
								array(
									'id'				=> $this->get_field_id( 'service_' . $key ),
									'name'				=> $this->get_field_name( 'service[]' ),
									'value'				=> $button['service'],
									'datalist'			=> $this->social_list,
									'placeholder'	=> __( 'choose or input social media', PHOTOLAB_BASE_TM_ALIAS ),
								)
							);
					$url_field = new UI_Input_Fox(
								array(
									'id'			=> $this->get_field_id( 'url_' . $key ),
									'name'			=> $this->get_field_name( 'url[]' ),
									'value'			=> $button['url'],
									'placeholder'	=> __( 'input url to your page', PHOTOLAB_BASE_TM_ALIAS ),
								)
							);
					$social_items[] = array( 'service' => $service_field->output(),'url' => $url_field->output() );
				}
			}

			$service_field = new UI_Input_Fox(
								array(
									'id'				=> $this->get_field_id( 'service_new' ),
									'name'				=> $this->get_field_name( 'service_new[]' ),
									'value'				=> '',
									'datalist'			=> $this->social_list,
									'placeholder'	=> __( 'choose or input social media', PHOTOLAB_BASE_TM_ALIAS ),
								)
							);
			$url_field = new UI_Input_Fox(
								array(
									'id'			=> $this->get_field_id( 'url_new' ),
									'name'			=> $this->get_field_name( 'ur_newl[]' ),
									'value'			=> '',
									'placeholder'	=> __( 'input url to your page', PHOTOLAB_BASE_TM_ALIAS ),
								)
							);
			$social_new = array( 'service' => $service_field->output(),'url' => $url_field->output() );

			// Show view
			echo View::make(
				'widgets/back-end/subscribe-and-social',
				array(
					'first_block_html'				=> $first_block_html,
					'subscribe_is_html'				=> $subscribe_is_html,
					'subscribe_title_html'			=> $subscribe_title_html,
					'subscribe_description_html'	=> $subscribe_description_html,
					'api_key_html'					=> $api_key_html,
					'list_id_html'					=> $list_id_html,
					'success_message_html'			=> $success_message_html,
					'failed_message_html'			=> $failed_message_html,
					'social_is_html'				=> $social_is_html,
					'social_title_html'				=> $social_title_html,
					'social_description_html'		=> $social_description_html,
					'social_items'					=> $social_items,
					'social_new'					=> $social_new,
				)
			);
		}

		/**
		 * Update settings
		 *
		 * @param type $new_instance array.
		 * @param type $old_instance array.
		 * @return type array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $new_instance[ $key ] ) ? $new_instance[ $key ] : $value;
			}

			foreach ( $new_instance['service'] as $key => $social_item ) {
				$instance['social_buttons'][] = array( 'service' => $social_item, 'url' => $new_instance['url'][ $key ] );
			}

			return $instance;
		}
	}
}
