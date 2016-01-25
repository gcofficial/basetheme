<?php
/**
 * Plugin Name:  TM Posts Slider Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Posts slider widget
 * Version: 1.1
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_Posts_Slider_Widget
 *
 * @since 1.1
 */

if ( ! class_exists( 'TM_Posts_Slider_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab' );
	}

	/**
	 * Adds register_tm_posts_widget widget.
	 */
	class TM_Posts_Slider_Widget extends WP_Widget {

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
				'TM_Posts_Slider_Widget', // Base ID
				__( 'TM Posts Slider Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'Posts slider widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'			=> __( 'List', PHOTOLAB_BASE_TM_ALIAS ),
				'categories'	=> 0,
				'tags'			=> 0,
				'count'			=> 4,
				'button_is'		=> 'true',
				'button_text'	=> __( 'Button text', PHOTOLAB_BASE_TM_ALIAS ),
				'arrows_is'		=> 'true',
				'bullets_is'	=> 'true',
				'thumbnails_is'	=> 'true',
				'autoplay'		=> 'false',
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
			wp_register_script( 'tm-pposts-slider-script-frontend', Utils::assets_url() . '/js/posts-slider-widget-frontend.min.js', '', '', true );
			wp_localize_script( 'tm-posts-slider-script-frontend', 'TMSliderWidgetParam', array(
						'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
						'autoplay'		=> $instance['autoplay'],
					) );
			wp_enqueue_script( 'tm-posts-slider-script-frontend' );

			// Swiper styles
			wp_register_style( 'swiper', Utils::assets_url() . '/css/swiper.min.css' );
			wp_enqueue_style( 'swiper' );

			// Custom styles
			wp_register_style( 'tm-posts-slider-frontend', Utils::assets_url() . '/css/posts-slider-widget-frontend.min.css' );
			wp_enqueue_style( 'tm-posts-slider-frontend' );

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
					'tag_id'			=> $instance['tags'],
				)
			);

			if ( count( $posts ) ) {
				foreach ( $posts as &$post ) {
					if ( has_post_thumbnail( $post->ID ) ) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						$post->image = $image[0];
					} else {
						$post->image = Utils::assets_url() . '/images/default-image.jpg';
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
		 *
		 * @since 1.1
		 */
		public function widget( $args, $instance ) {

			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			$this->frontend_assets( $instance );

			echo View::make(
				'/widgets/front-end/posts-slider',
				array(
					'before_widget' => $args['before_widget'],
					'before_title'  => $args['before_widget'],
					'after_title'   => $args['after_title'],
					'after_widget'  => $args['after_widget'],
					'title'         => Utils::array_get( $instance, 'title' ),
					'posts'         => $this->get_posts( $instance ),
					'button_is'		=> Utils::array_get( $instance, 'button_is' ),
					'button_text'	=> Utils::array_get( $instance, 'button_text' ),
					'bullets_is'	=> Utils::array_get( $instance, 'bullets_is' ),
					'thumbnails_is'	=> Utils::array_get( $instance, 'thumbnails_is' ),
					'arrows_is'		=> Utils::array_get( $instance, 'arrows_is' ),
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
			wp_register_style( 'tm-post-slider-admin', Utils::assets_url() . '/css/posts-slider-widget-admin.min.css' );
			wp_enqueue_style( 'tm-post-slider-admin' );

			// Custom js
			wp_register_script( 'tm-post-slider-script-admin', Utils::assets_url() . '/js/posts-slider-widget-admin.min.js' );
			wp_localize_script( 'tm-post-slider-script-admin', 'TMWidgetParam', array(
						'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
						'button_is'		=> $this->get_field_id( 'button_is' ),
					)
				);
			wp_enqueue_script( 'tm-post-slider-script-admin' );
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

			$tags_list = get_tags( array( 'hide_empty' => 0 ) );
			$tags_array = array( '0' => 'not selected' );
			foreach ( $tags_list as $tag_item ) {
				$tags_array[ $tag_item->term_id ] = $tag_item->name;
			}

			$tag_field = new UI_Select_Fox(
								array(
									'id'				=> $this->get_field_id( 'tags' ),
									'name'				=> $this->get_field_name( 'tags' ),
									'default'			=> Utils::array_get( $instance, 'tags' ),
									'options'			=> $tags_array,
								)
							);
			$tags_html = $tag_field->output();

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

			$button_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'button_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'button_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'   => Utils::array_get( $instance, 'button_is' ),
							)
					);
			$button_is_html = $button_is_field->output();

			$button_text_field = new UI_Input_Fox(
							array(
								'id'			=> $this->get_field_id( 'button_text' ),
								'name'			=> $this->get_field_name( 'button_text' ),
								'value'			=> Utils::array_get( $instance, 'button_text' ),
								'placeholder'   => __( 'read more...', PHOTOLAB_BASE_TM_ALIAS ),
								'label'         => __( 'Button text', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$button_text_html = $button_text_field->output();

			$arrows_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'arrows_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'arrows_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'   => Utils::array_get( $instance, 'arrows_is' ),
							)
					);
			$arrows_is_html = $arrows_is_field->output();

			$bullets_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'bullets_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'bullets_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'   => Utils::array_get( $instance, 'bullets_is' ),
							)
					);
			$bullets_is_html = $bullets_is_field->output();

			$thumbnails_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'thumbnails_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'thumbnails_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'   => Utils::array_get( $instance, 'thumbnails_is' ),
							)
					);
			$thumbnails_is_html = $thumbnails_is_field->output();

			$autoplay_field = new UI_Switcher_Fox(
								array(
									'id'        => $this->get_field_id( 'autoplay' ),
									'class'		=> 'pull-right',
									'name'      => $this->get_field_name( 'autoplay' ),
									'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
									'default'   => Utils::array_get( $instance, 'autoplay' ),
								)
						);
			$autoplay_html = $autoplay_field->output();

			// Show view
			echo View::make(
				'widgets/back-end/posts-slider',
				array(
					'title_html'			=> $title_html,
					'categories_html'		=> $categories_html,
					'tags_html'				=> $tags_html,
					'count_html'			=> $count_html,
					'button_is_html'		=> $button_is_html,
					'button_is'				=> $this->get_field_name( 'button_is' ),
					'button_text_html'		=> $button_text_html,
					'arrows_is_html'		=> $arrows_is_html,
					'bullets_is_html'		=> $bullets_is_html,
					'thumbnails_is_html'	=> $thumbnails_is_html,
					'autoplay_html'			=> $autoplay_html,
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
