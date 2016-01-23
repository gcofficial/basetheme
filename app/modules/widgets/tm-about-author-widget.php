<?php
/**
 * Plugin Name:  TM About Author Widget
 * Widget URI: https://github.com/RDSergij/tm-about-author-widget
 * Description: About author widget
 * Version: 1.1
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_About_Author_Widget
 *
 * @since 1.1
 */

if ( ! class_exists( 'TM_About_Author_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab' );
	}

	/**
	 * Set constant path of text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_PATH' ) ) {
		define( 'PHOTOLAB_BASE_TM_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Adds TM_About_Author_Widget widget.
	 */
	class TM_About_Author_Widget extends WP_Widget {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $instance_default = array();
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'tm_about_author_widget', // Base ID
				__( 'TM About Author Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'About author widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'		=> __( '', PHOTOLAB_BASE_TM_ALIAS ),
				'user_id'	=> 1,
				'image'		=> '',
				'text_link'	=> __( 'Read more', PHOTOLAB_BASE_TM_ALIAS ),
				'url'		=> '',
			);

			// disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
			remove_filter( 'pre_user_description', 'wp_filter_kses' );
			// add sanitization for WordPress posts
			add_filter( 'pre_user_description', 'wp_filter_post_kses' );
		}

		/**
		 * Include frontend assets
		 * 
		 * @since 1.0
		 */
		public function frontend_assets() {
			// Custom js
			wp_register_script( 'tm-about-author-script-frontend', Utils::assets_url() . '/js/about-author-widget-frontend.min.js', '', '', true );
			wp_enqueue_script( 'tm-about-author-script-frontend' );

			// Custom styles
			wp_register_style( 'tm-about-author-frontend', Utils::assets_url() . '/css/about-author-widget-frontend.min.css' );
			wp_enqueue_style( 'tm-about-author-frontend' );
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

			// Include assets
			$this->frontend_assets();

			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			$user_info = get_userdata( $instance['user_id'] );

			if ( ! empty( $user_info->user_email ) ) {
				$gravatar_url = get_avatar_url( $user_info->user_email, array( 'size' => 512 ) );

				if ( ! empty( $instance['image'] ) ) {
					$main_avatar = $instance['image'];
				} elseif ( ! empty( $gravatar_url ) ) {
					$main_avatar = $gravatar_url;
				}

				echo View::make(
					'widgets/front-end/about-author',
					array(
						'before_widget' => $args['before_widget'],
						'before_title'  => $args['before_widget'],
						'after_title'   => $args['after_title'],
						'after_widget'  => $args['after_widget'],
						'title'         => Utils::array_get( $instance, 'title' ),
						'avatar'		=> $main_avatar,
						'name'          => $user_info->display_name,
						'description'   => $user_info->description,
						'url'           => Utils::array_get( $instance, 'url' ),
						'text_link'     => Utils::array_get( $instance, 'text_link' ),
					)
				);
			}
		}

		/**
		 * Include admin assets
		 * 
		 * @since 1.0
		 */
		public function admin_assets() {
			wp_enqueue_media();

			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );

			// Custom styles
			wp_register_style( 'tm-about-author-admin', Utils::assets_url() . '/css/about-author-widget-admin.min.css' );
			wp_enqueue_style( 'tm-about-author-admin' );

			// Custom script
			wp_register_script( 'tm-about-author-admin', Utils::assets_url() . '/js/about-author-widget-admin.min.js', array( 'jquery' ) );
			wp_localize_script( 'tm-about-author-admin', 'TMAboutAuthorWidgetParam', array( 'image' => $this->get_field_id( 'image' ), 'avatar' => $this->get_field_id( 'avatar' ) ) );
			wp_enqueue_script( 'tm-about-author-admin' );

			wp_enqueue_style( 'thickbox' );
		}

		/**
		 * Create admin form for widget
		 *
		 * @param type $instance array.
		 * @since 1.1
		 */
		public function form( $instance ) {

			$this->admin_assets();

			$title_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'title' ),
						'name'			=> $this->get_field_name( 'title' ),
						'value'			=> Utils::array_get( $instance, 'title' ),
						'placeholder'	=> __( 'New title', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Title widget', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$title_html = $title_field->output();

			$users_list = get_users();
			foreach ( $users_list as $user ) {
				$users[ $user->ID ] = $user->display_name;
			}

			$users_field = new UI_Select_Fox(
						array(
							'id'				=> $this->get_field_id( 'user_id' ),
							'name'				=> $this->get_field_name( 'user_id' ),
							'default'			=> Utils::array_get( $instance, 'user_id' ),
							'options'			=> $users,
						)
					);
			$users_html = $users_field->output();

			$url_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'url' ),
						'name'			=> $this->get_field_name( 'url' ),
						'value'			=> Utils::array_get( $instance, 'url' ),
						'placeholder'	=> __( 'detail url', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Detail url', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$url_html = $url_field->output();

			$text_link_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'text_link' ),
						'name'			=> $this->get_field_name( 'text_link' ),
						'value'			=> Utils::array_get( $instance, 'text_link' ),
						'placeholder'	=> __( 'link text', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Link text', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$text_link_html = $text_link_field->output();

			$upload_file_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'upload_image_button' ),
						'class'			=> 'upload_image_button button-image',
						'type'			=> 'button',
						'name'			=> $this->get_field_name( 'upload_image_button' ),
						'value'			=> __( 'Upload image', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$upload_html = $upload_file_field->output();

			$image_url_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'image' ),
						'class'			=> ' custom-image-url',
						'type'			=> 'hidden',
						'name'			=> $this->get_field_name( 'image' ),
						'value'			=> Utils::array_get( $instance, 'image' ),
					)
			);
			$image_html = $image_url_field->output();

			$delete_image_url_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'delete_image' ),
						'class'			=> 'delete_image_url button-image',
						'type'			=> 'button',
						'name'			=> $this->get_field_name( 'delete_image' ),
						'value'			=> __( 'Delete image', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$delete_image_html = $delete_image_url_field->output();

			$user_info = get_userdata( Utils::array_get( $instance, 'user_id' ) );

			$default_avatar = Utils::assets_url() . '/images/default-avatar.png';
			if ( ! empty( $image ) ) {
				$main_avatar = $image;
			} else {
				$main_avatar = $default_avatar;
			}

			echo View::make(
				'widgets/back-end/about-author',
				array(
					'title_html'		=> $title_html,
					'users_html'		=> $users_html,
					'url_html'			=> $url_html,
					'text_link_html'	=> $text_link_html,
					'upload_html'		=> $upload_html,
					'delete_image_html'	=> $delete_image_html,
					'image_html'		=> $image_html,
					'avatar_id'			=> $this->get_field_id( 'avatar' ),
					'default_image'		=> $default_avatar,
					'avatar'			=> $main_avatar,
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

			return $instance;
		}
	}

	/**
	 * Register widget
	 */
	function register_tm_about_author_widget() {
		register_widget( 'TM_About_Author_Widget' );
	}
	add_action( 'widgets_init', 'register_tm_about_author_widget' );

}
