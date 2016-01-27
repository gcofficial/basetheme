<?php
/**
 * Advertisement widget module file
 *
 * @package photolab
 */

/**
 * Advertisement widget module class
 */
class Monster_Advertisement extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'monster_advertisement_widget',
			__( 'Advertisement widget', 'photolab' ),
			array( 'description' => __( 'Advertisement Widget', 'photolab' ) )
		);

		// ==============================================================
		// Actions
		// ==============================================================
		add_action( 'admin_enqueue_scripts', array( $this, 'uploadScripts' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'uploadScripts' ) );
	}

	/**
	 * Upload some scripts to admin and customize
	 */
	public function uploadScripts() {
		wp_enqueue_media();
		wp_enqueue_script(
			'upload_media_widget',
			Utils::assets_url().'/js/advertisement.js',
			array( 'jquery' )
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
			'widgets/front-end/advertisement',
			array(
				'image' => Utils::array_get( $instance, 'image' ),
				'before_widget' => $args['before_widget'],
				'before_title'  => $args['before_widget'],
				'after_title'   => $args['after_title'],
				'after_widget'  => $args['after_widget'],
				'title'         => Utils::array_get( $instance, 'title' ),
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
			'widgets/back-end/advertisement',
			array(
				'title' 			  => Utils::array_get( $instance, 'title', __( 'Widget Image', 'photolab' ) ),
				'image' 			  => Utils::array_get( $instance, 'image' ),
				'field_id_title'      => $this->get_field_id( 'title' ),
				'field_name_title'    => $this->get_field_name( 'title' ),
				'field_id_image'      => $this->get_field_id( 'image' ),
				'field_name_image'    => $this->get_field_name( 'image' ),
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
		$instance            = array();
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['image'] = $new_instance['image'];

		return $instance;
	}
}
