<?php
/**
 * Plugin Name: TM Twitter Timeline Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Show twitter timeline of user
 * Version: 1.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package TM_Twitter_Timeline_Widget
 *
 * @since 1.1
 */

if ( ! class_exists( 'Monster_Twitter_Timeline_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.1
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab' );
	}

	class Monster_Twitter_Timeline_Widget extends WP_Widget{

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				'monster_twitter_timeline_widget',
				__( 'Twitter timeline widget', 'photolab' ),
				array( 'description' => __( 'Twitter timeline Widget', 'photolab' ) )
			);
		}

		/**
		 * Include frontend assets
		 *
		 * @since 1.0
		 */
		public function frontend_assets( $instance ) {

			// twitter widget js
			wp_register_script( 'twitter-widget', Utils::assets_url() . '/js/twitter-widget.js', '', '', true );
			wp_enqueue_script( 'twitter-widget' );

		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 */
		public function widget( $args, $instance ) {

			$this->frontend_assets( $instance );

			echo View::make(
				'widgets/front-end/twitter-timeline',
				array(
					'before_widget'	=> $args['before_widget'],
					'before_title'	=> $args['before_widget'],
					'after_title'	=> $args['after_title'],
					'after_widget'	=> $args['after_widget'],
					'title'			=> Utils::array_get( $instance, 'title' ),
					'widget_id'		=> Utils::array_get( $instance, 'widget_id' ),
					'screen_name'	=> Utils::array_get( $instance, 'screen_name' ),
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

			$widget_id_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'widget_id' ),
						'name'			=> $this->get_field_name( 'widget_id' ),
						'value'			=> Utils::array_get( $instance, 'widget_id' ),
						'placeholder'	=> __( 'Set widget id', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Widget ID', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$widget_id_html = $widget_id_field->output();

			$screen_name_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'screen_name' ),
						'name'			=> $this->get_field_name( 'screen_name' ),
						'value'			=> Utils::array_get( $instance, 'screen_name' ),
						'placeholder'	=> __( 'Input your twitter name', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Twitter name', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$screen_name_html = $screen_name_field->output();

			echo View::make(
				'widgets/back-end/twitter-timeline',
				array(
					'title_html'		=> $title_html,
					'widget_id_html'	=> $widget_id_html,
					'screen_name_html'	=> $screen_name_html,
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
			$instance            = array();
			foreach ( $new_instance['category'] as $key => $category ) {
				if ( ! empty( $category ) ) {
					$instance['categories'][] = array( 'category' => $category, 'image' => $new_instance['image'][ $key ] );
				}
			}

			return $instance;
		}
	}
}
