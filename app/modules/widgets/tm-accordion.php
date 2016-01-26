<?php
/**
 * Accordion widget module file
 *
 * @package photolab
 */

/**
 * Accordion widget class
 */
class TM_Accordion extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'tm_accordion_widget',
			__( 'Accordion widget', 'photolab' ),
			array( 'description' => __( 'Accordion Widget', 'photolab' ) )
		);

		// ==============================================================
		// Actions
		// ==============================================================
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_and_styles' ) );
	}

	/**
	 * Add scripts and styles
	 */
	public function scripts_and_styles() {
		/**
		 * Add scripts
		 */
		wp_enqueue_script(
			'accordion-widget',
			Utils::assets_url().'/js/accordion-widget.js',
			array( 'jquery' )
		);

		/**
		 * Add styles
		 */
		wp_enqueue_style(
			'accordion',
			Utils::assets_url().'/css/accordion.css'
		);
	}

	/**
	 * Get posts with thumbnails
	 *
	 * @param  type $post_ids - include post ids.
	 * @param  type $category - category id.
	 * @return array --- posts with thumbnails $post->image
	 */
	public function getPosts( $post_ids, $category ) {
		return get_posts(
			array(
				'numberposts'     => -1,
				'include'         => $post_ids,
				'category'        => $category,
				'post_type'       => 'post',
				'post_status'     => 'publish',
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo View::make(
			'widgets/front-end/accordion',
			array(
				'before_widget' => $args['before_widget'],
				'before_title'  => $args['before_widget'],
				'after_title'   => $args['after_title'],
				'after_widget'  => $args['after_widget'],
				'title'         => Utils::array_get( $instance, 'title' ),
				'posts'         => $this->getPosts(
					Utils::array_get( $instance, 'post_ids' ),
					Utils::array_get( $instance, 'category' )
				),
			)
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		echo View::make(
			'widgets/back-end/accordion',
			array(
				'title'               => Utils::array_get( $instance, 'title' ),
				'post_ids'            => Utils::array_get( $instance, 'post_ids' ),
				'category'            => Utils::array_get( $instance, 'category' ),
				'field_id_title'      => $this->get_field_id( 'title' ),
				'field_name_title'    => $this->get_field_name( 'title' ),
				'field_id_post_ids'   => $this->get_field_id( 'post_ids' ),
				'field_name_post_ids' => $this->get_field_name( 'post_ids' ),
				'field_id_category'   => $this->get_field_id( 'category' ),
				'field_name_category' => $this->get_field_name( 'category' ),
				'dropdown_categories' => wp_dropdown_categories(
					array(
						'show_option_all'    => '',
						'show_option_none'   => 'All',
						'option_none_value'  => '',
						'orderby'            => 'ID',
						'order'              => 'ASC',
						'show_count'         => 0,
						'hide_empty'         => 1,
						'child_of'           => 0,
						'exclude'            => '',
						'echo'               => false,
						'selected'           => 0,
						'hierarchical'       => 0,
						'name'               => $this->get_field_name( 'category' ),
						'id'                 => $this->get_field_id( 'category' ),
						'class'              => 'postform',
						'depth'              => 0,
						'tab_index'          => 0,
						'taxonomy'           => 'category',
						'hide_if_empty'      => false,
						'value_field'	     => 'term_id',
					)
				),
			)
		);
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['post_ids'] = esc_attr( $new_instance['post_ids'] );
		$instance['category'] = esc_attr( $new_instance['category'] );

		return $instance;
	}
}
