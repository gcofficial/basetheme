<?php
/**
 * Plugin Name:  TM Categories Tiles Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Categories tiles widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_Categories_Tiles_Widget
 *
 * @since 1.1
 */

if ( ! class_exists( 'TM_Categories_Tiles_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.1
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab' );
	}

	/**
	 * Adds Monster_Categories_Tiles_Widget widget.
	 */
	class Monster_Categories_Tiles_Widget extends WP_Widget {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $instance_default = array();
		/**
		 * Default themes
		 *
		 * @var type array
		 */
		private $themes = array();
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'Monster_Categories_Tiles_Widget', // Base ID
				__( 'Monster Categories Tiles Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'Categories Tiles widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'			=> __( 'Tiles', PHOTOLAB_BASE_TM_ALIAS ),
				'theme'			=> 0,
				'show_count'	=> 'false',
				'sort_is'		=> '1',
				'categories'	=> array(),
			);

			$this->themes = array( 'grid-1-2', 'grid-1-5', 'line-3' );
		}

		/**
		 * Include frontend assets
		 *
		 * @since 1.0
		 */
		public function frontend_assets() {
			// Custom js
			wp_register_script( 'tm-categories-tiles-script-frontend', Utils::assets_url() . '/js/categories-tiles-widget-frontend.min.js', '', '', true );
			wp_enqueue_script( 'tm-categories-tiles-script-frontend' );

			// Custom styles
			wp_register_style( 'tm-categories-tiles-frontend', Utils::assets_url() . '/css/categories-tiles-widget-frontend.min.css' );
			wp_enqueue_style( 'tm-categories-tiles-frontend' );
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

			if ( ! empty( $instance['categories'] ) ) {
				foreach ( $instance['categories'] as &$category_item ) {
					$category_data = get_category( $category_item['category'] );
					$category_item['count'] = $category_data->category_count;
					$category_item['name'] = $category_data->name;
					$category_item['url'] = get_category_link( $category_data->term_id );
				}
			}

			$view = '/widgets/front-end/categories-tiles/' . $this->themes[ Utils::array_get( $instance, 'theme' ) ];

			echo View::make(
				$view,
				array(
					'before_widget' => $args['before_widget'],
					'before_title'  => $args['before_widget'],
					'after_title'   => $args['after_title'],
					'after_widget'  => $args['after_widget'],
					'title'         => Utils::array_get( $instance, 'title' ),
					'categories'    => Utils::array_get( $instance, 'categories' ),
					'show_count'    => Utils::array_get( $instance, 'show_count' ),
				)
			);

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
			wp_register_style( 'tm-categories-tiles-admin', Utils::assets_url() . '/css/categories-tiles-widget-admin.min.css' );
			wp_enqueue_style( 'tm-categories-tiles-admin' );

			wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );

			// Custom script
			wp_register_script( 'tm-categories-tiles-admin', Utils::assets_url() . '/js/categories-tiles-widget-admin.min.js', array( 'jquery' ) );
			wp_localize_script( 'tm-categories-tiles-admin', 'TMAboutAuthorWidgetParam', array( 'image' => $this->get_field_id( 'image' ), 'avatar' => $this->get_field_id( 'avatar' ) ) );
			wp_enqueue_script( 'tm-categories-tiles-admin' );

			wp_enqueue_style( 'thickbox' );
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
						'class'			=> 'title',
						'name'			=> $this->get_field_name( 'title' ),
						'value'			=> Utils::array_get( $instance, 'title' ),
						'placeholder'	=> __( 'New title', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$title_html = $title_field->output();

			$theme_field = new UI_Select_Fox(
						array(
							'id'				=> $this->get_field_id( 'theme' ),
							'name'				=> $this->get_field_name( 'theme' ),
							'default'			=> Utils::array_get( $instance, 'theme' ),
							'options'			=> $this->themes,
						)
					);
			$theme_html = $theme_field->output();

			$switcher = new UI_Switcher_Fox(
					array(
						'id'        => $this->get_field_id( 'show_count' ),
						'class'     => 'pull-right',
						'name'      => $this->get_field_name( 'show_count' ),
						'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
						'default'   => Utils::array_get( $instance, 'show_count' ),
					)
			);
			$show_count_html = $switcher->output();

			$categories_list = get_categories( array( 'hide_empty' => 0 ) );
			$categories_array = array( '1' => 'default' );
			foreach ( $categories_list as $category_item ) {
				$categories_array[ $category_item->term_id ] = $category_item->name;
			}

			// Universal
			$default_image = Utils::assets_url() . '/images/default-image.jpg';

			$categories = Utils::array_get( $instance, 'categories' );
			$tiles_items = array();
			if ( is_array( $categories ) && count( $categories ) > 0 ) {
				foreach ( $categories as $key => $category_item ) {
					$category_field = new UI_Select_Fox(
								array(
									'id'				=> $this->get_field_id( 'category_' . $key ),
									'name'				=> $this->get_field_name( 'category[]' ),
									'default'			=> $category_item['category'],
									'options'			=> $categories_array,
								)
							);
					$image_field = new UI_Input_Fox(
								array(
									'id'			=> $this->get_field_id( 'image_' . $key ),
									'class'			=> 'custom-image-url',
									'type'			=> 'hidden',
									'name'			=> $this->get_field_name( 'image[]' ),
									'value'			=> $categories[ $key ]['image'],
								)
							);
					$tiles_items[] = array( 'src' => $categories[ $key ]['image'], 'image' => $image_field->output(), 'category' => $category_field->output() );
				}
			}

			$category_field = new UI_Select_Fox(
								array(
									'id'				=> $this->get_field_id( 'category_new' ),
									'name'				=> $this->get_field_name( 'category_new[]' ),
									'default'			=> 0,
									'options'			=> $categories_array,
								)
							);
			$image_field = new UI_Input_Fox(
								array(
									'id'			=> $this->get_field_id( 'image_new' ),
									'class'			=> 'custom-image-url',
									'type'			=> 'hidden',
									'name'			=> $this->get_field_name( 'image_new[]' ),
									'value'			=> '',
								)
							);
			$tile_new = array( 'image' => $image_field->output(), 'category' => $category_field->output() );

			// show view
			echo View::make(
				'widgets/back-end/categories-tiles',
				array(
					'title_html'		=> $title_html,
					'theme_html'		=> $theme_html,
					'show_count_html'	=> $show_count_html,
					'tiles_items'		=> $tiles_items,
					'default_image'		=> $default_image,
					'tile_new'			=> $tile_new,
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
			$instance['title'] = ! empty( $new_instance['title'] ) ? $new_instance['title'] : $this->instance_default['title'];
			$instance['theme'] = ( ! empty( $new_instance['theme'] ) || 0 == $new_instance['theme'] ) ? $new_instance['theme'] : $this->instance_default['theme'];
			$instance['show_count'] = ! empty( $new_instance['show_count'] ) ? $new_instance['show_count'] : $this->instance_default['show_count'];
			$instance['sort_is'] = ! empty( $new_instance['sort_is'] ) ? $new_instance['sort_is'] : $this->instance_default['sort_is'];

			foreach ( $new_instance['category'] as $key => $category ) {
				if ( ! empty( $category ) ) {
					$instance['categories'][] = array( 'category' => $category, 'image' => $new_instance['image'][ $key ] );
				}
			}

			return $instance;
		}
	}
}
