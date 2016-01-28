<?php
/**
 * Plugin Name: TM Youtube Subscribe Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Show twitter timeline of user
 * Version: 1.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package Monster_Youtube_Subscribe_Widget
 *
 * @since 1.1
 */

if ( ! class_exists( 'Monster_Youtube_Subscribe_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.1
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab' );
	}

	/**
	 * Adds Monster_Youtube_Subscribe_Widget widget.
	 */
	class Monster_Youtube_Subscribe_Widget extends WP_Widget{

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				'monster_youtube_subscribe_widget',
				__( 'Monster Youtube subscribe widget', 'photolab' ),
				array( 'description' => __( 'Youtube subscribe Widget', 'photolab' ) )
			);
		}

		/**
		 * Include frontend assets
		 *
		 * @since 1.0
		 */
		public function frontend_assets() {

			// Custom styles
			wp_register_style( 'tm-youtube-subscribe-frontend', Utils::assets_url() . '/css/youtube-subscribe-widget-frontend.min.css' );
			wp_enqueue_style( 'tm-youtube-subscribe-frontend' );

		}

		/**
		 * Get data about channel from YoutubeAPI
		 *
		 * @return array
		 */
		private function get_channel_data( $channel, $app_key ) {

			$url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=' . $channel . '&key=' . $app_key;

			if ( function_exists( 'curl_init' ) && function_exists( 'curl_setopt' ) ) {
				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
				curl_setopt( $ch, CURLOPT_POST, false );
				$result = curl_exec( $ch );
				curl_close( $ch );
			} else {
				$result = file_get_contents( $url );
			}

			return $result ? json_decode( $result, true ) : false;
		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 */
		public function widget( $args, $instance ) {

			$this->frontend_assets();

			$channel_data = $this->get_channel_data( Utils::array_get( $instance, 'channel_name' ), Utils::array_get( $instance, 'app_key' ) );

			echo View::make(
				'widgets/front-end/youtube-subscribe',
				array(
					'before_widget'	=> $args['before_widget'],
					'before_title'	=> $args['before_widget'],
					'after_title'	=> $args['after_title'],
					'after_widget'	=> $args['after_widget'],
					'title'			=> Utils::array_get( $instance, 'title' ),
					'app_key'		=> Utils::array_get( $instance, 'app_key' ),
					'channel_name'	=> Utils::array_get( $instance, 'channel_name' ),
					'channel_url'	=> Utils::array_get( $instance, 'channel_url' ),
					'subscriber_count'	=> Utils::array_get( $channel_data['items'][0]['statistics'], 'subscriberCount' ),
					'video_count'	=> Utils::array_get( $channel_data['items'][0]['statistics'], 'videoCount' ),
				)
			);
		}

		/**
		 * Admin view
		 *
		 * @param type $instance array.
		 */
		public function form( $instance ) {

			$title_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'title' ),
						'name'			=> $this->get_field_name( 'title' ),
						'value'			=> Utils::array_get( $instance, 'title' ),
						'placeholder'	=> __( 'Widget title', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Title', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$title_html = $title_field->output();

			$app_key_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'app_key' ),
						'name'			=> $this->get_field_name( 'app_key' ),
						'value'			=> Utils::array_get( $instance, 'app_key' ),
						'placeholder'	=> __( 'api key', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Youtube API key', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$app_key_html = $app_key_field->output();

			$channel_name_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'channel_name' ),
						'name'			=> $this->get_field_name( 'channel_name' ),
						'value'			=> Utils::array_get( $instance, 'channel_name' ),
						'placeholder'	=> __( 'channel name', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Channel name', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$channel_name_html = $channel_name_field->output();

			$channel_url_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'channel_url' ),
						'name'			=> $this->get_field_name( 'channel_url' ),
						'value'			=> Utils::array_get( $instance, 'channel_url' ),
						'placeholder'	=> __( 'channel url', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Channel url', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$channel_url_html = $channel_url_field->output();

			echo View::make(
				'widgets/back-end/youtube-subscribe',
				array(
					'title_html'		=> $title_html,
					'app_key_html'		=> $app_key_html,
					'channel_name_html'	=> $channel_name_html,
					'channel_url_html'	=> $channel_url_html,
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
			$instance					= array();
			$instance['title']			= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['app_key']		= esc_attr( $new_instance['app_key'] );
			$instance['channel_name']	= esc_attr( $new_instance['channel_name'] );
			$instance['channel_url']	= esc_attr( $new_instance['channel_url'] );

			return $instance;
		}
	}
}
