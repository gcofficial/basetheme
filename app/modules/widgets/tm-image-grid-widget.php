<?php
/**
 * Plugin Name: TM Image Grid Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Image grid widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_Image_Grid_Widget
 *
 * @since 1.1
 */

if ( ! class_exists( 'TM_Image_Grid_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.1
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab' );
	}

	/**
	 * Adds register_tm_image_grid widget.
	 */
	class TM_Image_Grid_Widget extends WP_Widget {

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
				'TM_Image_Grid_Widget', // Base ID
				__( 'TM Image Grid Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'Image grid widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'				=> __( 'List', PHOTOLAB_BASE_TM_ALIAS ),
				'categories'		=> 0,
				'cols_count'		=> 3,
				'posts_count'		=> 6,
				'posts_offset'		=> 0,
				'title_length'		=> 20,
				'padding'			=> 0,
			);
		}

		/**
		 * Include frontend assets
		 *
		 * @since 1.0
		 */
		public function frontend_assets() {
			// Custom styles
			wp_register_style( 'tm-image-grid-frontend', Utils::assets_url() . '/css/image-grid-widget-frontend.min.css' );
			wp_enqueue_style( 'tm-image-grid-frontend' );
		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 */
		public function widget( $args, $instance ) {

			// Include assets
			$this->frontend_assets();

			$query = new WP_Query(
						array(
							'posts_per_page'	=> $instance['posts_count'],
							'offset'			=> $instance['posts_offset'],
							'cat'				=> $instance['categories'],
						)
					);

			if ( $query->have_posts() ) {
				echo View::make(
					'/widgets/front-end/image-grid',
					array(
						'before_widget' => $args['before_widget'],
						'before_title'  => $args['before_widget'],
						'after_title'   => $args['after_title'],
						'after_widget'  => $args['after_widget'],
						'title'         => Utils::array_get( $instance, 'title' ),
						'cols_count'    => $instance['cols_count'],
						'title_length'  => $instance['title_length'],
						'padding'		=> $instance['padding'],
						'index'			=> 0,
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
			// Custom styles
			wp_register_style( 'tm-image-grid-admin', Utils::assets_url() . '/css/image-grid-widget-admin.min.css' );
			wp_enqueue_style( 'tm-image-grid-admin' );
		}

		/**
		 * Create admin form for widget
		 *
		 * @param type $instance array.
		 */
		public function form( $instance ) {

			// Include assets
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

			$categories_list = get_categories( array( 'hide_empty' => 0 ) );
			$categories_array = array( '0' => 'not selected' );
			foreach ( $categories_list as $category_item ) {
				$categories_array[ $category_item->term_id ] = $category_item->name;
			}

			$category_field = new UI_Select_Fox(
							array(
								'id'				=> $this->get_field_id( 'categories' ),
								'name'				=> $this->get_field_name( 'categories' ),
								'default'			=> Utils::array_get( $instance, 'categories' ),
								'options'			=> $categories_array,
							)
						);
			$categories_html = $category_field->output();

			$cols_count_field = new UI_Select_Fox(
							array(
								'id'				=> $this->get_field_id( 'cols_count' ),
								'name'				=> $this->get_field_name( 'cols_count' ),
								'default'			=> Utils::array_get( $instance, 'cols_count' ),
								'options'			=> array( 2 => 2, 3 => 3 ),
							)
						);
			$cols_count_html = $cols_count_field->output();

			$posts_count_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'posts_count' ),
						'name'			=> $this->get_field_name( 'posts_count' ),
						'value'			=> Utils::array_get( $instance, 'posts_count' ),
						'placeholder'	=> __( 'posts count', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Count of posts', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$posts_count_html = $posts_count_field->output();

			$posts_offset_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'posts_offset' ),
						'name'			=> $this->get_field_name( 'posts_offset' ),
						'value'			=> Utils::array_get( $instance, 'posts_offset' ),
						'placeholder'	=> __( 'posts offset', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Offset', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$posts_offset_html = $posts_offset_field->output();

			$title_length_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'title_length' ),
						'name'			=> $this->get_field_name( 'title_length' ),
						'value'			=> Utils::array_get( $instance, 'title_length' ),
						'placeholder'	=> __( 'title length', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Title length', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$title_length_html = $title_length_field->output();

			$padding_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'padding' ),
						'name'			=> $this->get_field_name( 'padding' ),
						'value'			=> Utils::array_get( $instance, 'padding' ),
						'placeholder'	=> __( 'padding', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Padding', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$padding_html = $padding_field->output();

			// Show view
			echo View::make(
				'widgets/back-end/image-grid',
				array(
					'title_html'			=> $title_html,
					'categories_html'		=> $categories_html,
					'cols_count_html'		=> $cols_count_html,
					'posts_count_html'		=> $posts_count_html,
					'posts_offset_html'		=> $posts_offset_html,
					'title_length_html'		=> $title_length_html,
					'padding_html'			=> $padding_html,
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
}
