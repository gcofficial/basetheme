<?php
/**
 * Plugin Name:  TM Posts Carousel Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Posts carousel widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_Posts_Widget
 *
 * @since 1.1
 */

if ( ! class_exists( 'TM_Posts_Carousel_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.1
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab' );
	}

	/**
	 * Adds register_tm_posts_widget widget.
	 */
	class TM_Posts_Carousel_Widget extends WP_Widget {

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
				'TM_Posts_Carousel_Widget', // Base ID
				__( 'TM Posts Carousel Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'Posts carousel widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'				=> __( 'List', PHOTOLAB_BASE_TM_ALIAS ),
				'categories'		=> 0,
				'count'				=> 4,
				'slides_per_view'	=> 2,
				'length'			=> 15,
			);
		}

		/**
		 * Include frontend assets
		 *
		 * @since 1.0
		 */
		public function frontend_assets( $instance ) {

			// Swiper js
			wp_register_script( 'swiper', Utils::assets_url() . '/js/swiper.min.js', '', '', true );
			wp_enqueue_script( 'swiper' );

			// Custom js
			wp_register_script( 'tm-post-carousel-script-frontend', Utils::assets_url() . '/js/posts-carousel-widget-frontend.min.js', '', '', true );
			wp_localize_script( 'tm-post-carousel-script-frontend', 'TMWidgetParam', array( 'slidesPerView' => $instance['slides_per_view'] ) );
			wp_enqueue_script( 'tm-post-carousel-script-frontend' );

			// Swiper styles
			wp_register_style( 'wiper', Utils::assets_url() . '/css/swiper.min.css' );
			wp_enqueue_style( 'swiper' );

			// Custom styles
			wp_register_style( 'tm-post-carousel-frontend', Utils::assets_url() . '/css/posts-carousel-widget-frontend.min.css' );
			wp_enqueue_style( 'tm-post-carousel-frontend' );

		}

		/**
		 * Get posts by parameter
		 *
		 * @since 1.0
		 */
		private function get_posts( $instance ) {
			$posts = get_posts(
				array(
					'posts_per_page'	=> $instance['count'],
					'cat'				=> $instance['categories'],
				)
			);

			if ( count( $posts ) ) {
				foreach ( $posts as &$post ) {
					if ( has_post_thumbnail( $post->ID ) ) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
						$post->image = $image[0];
					} else {
						$post->image = Utils::assets_url() . '/images/default-image.jpg';
					}

					if ( $instance['length'] < mb_strlen( $post->post_excerpt, 'UTF-8' ) ) {
						$post->post_excerpt = substr( esc_attr( $post->post_excerpt ), 0, $instance['length'] ) . '...';
					}
				}
			}
			return $posts;
		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 */
		public function widget( $args, $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			// Include assets
			$this->frontend_assets( $instance );

			echo View::make(
				'/widgets/front-end/posts-carousel',
				array(
					'before_widget' => $args['before_widget'],
					'before_title'  => $args['before_widget'],
					'after_title'   => $args['after_title'],
					'after_widget'  => $args['after_widget'],
					'title'         => Utils::array_get( $instance, 'title' ),
					'posts'         => $this->get_posts( $instance ),
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
			wp_register_style( 'tm-post-carousel-admin', Utils::assets_url() . '/css/posts-carousel-widget-admin.min.css' );
			wp_enqueue_style( 'tm-post-carousel-admin' );
		}


		/**
		 * Create admin form for widget
		 *
		 * @param type $instance array.
		 */
		public function form( $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

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

			$count_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'count' ),
						'name'			=> $this->get_field_name( 'count' ),
						'value'			=> Utils::array_get( $instance, 'count' ),
						'placeholder'   => __( 'posts count', PHOTOLAB_BASE_TM_ALIAS ),
						'label'         => __( 'Count of posts', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$count_html = $count_field->output();

			$slides_per_view_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'slides_per_view' ),
						'name'			=> $this->get_field_name( 'slides_per_view' ),
						'value'			=> Utils::array_get( $instance, 'slides_per_view' ),
						'placeholder'	=> __( 'slides per view', PHOTOLAB_BASE_TM_ALIAS ),
						'label'         => __( 'Items per view', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$slides_per_view_html = $slides_per_view_field->output();

			$length_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'length' ),
						'name'			=> $this->get_field_name( 'length' ),
						'value'			=> Utils::array_get( $instance, 'length' ),
						'placeholder'	=> __( 'symbols length', PHOTOLAB_BASE_TM_ALIAS ),
						'label'			=> __( 'Symbols length', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$length_html = $length_field->output();

			// Show view
			echo View::make(
				'widgets/back-end/posts-carousel',
				array(
					'title_html'			=> $title_html,
					'categories_html'		=> $categories_html,
					'count_html'			=> $count_html,
					'slides_per_view_html'	=> $slides_per_view_html,
					'length_html'			=> $length_html,
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
