<?php
/**
 * Sidebar Creator module file
 *
 * @package photolab
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

/**
 * Customize_Sidebar_Creator module class
 */
class Customize_Sidebar_Creator extends WP_Customize_Control {

	/**
	 * Add scripts and styles
	 */
	public function enqueue() {
		wp_enqueue_script(
			'sidebar-creator',
			Utils::core_url().'/customize/assets/js/sidebar-creator.js',
			array( 'jquery', 'underscore' )
		);
		wp_enqueue_style(
			'sidebar-creator',
			Utils::core_url() . '/customize/assets/css/sidebar-creator.css'
		);
	}

	/**
	 * Render content
	 */
	public function render_content() {
		echo View::make(
			dirname( __FILE__ ).'/views/customize-sidebar-creator.php',
			array(
				'id'    => 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id ),
				'class' => 'customize-control customize-control-' . $this->type,
				'label' => esc_html( $this->label ),
				'value' => $this->value(),
				'link'  => $this->get_link(),
			)
		);
	}

	/**
	 * Register widget area.
	 */
	public static function widgets_init() {
		$sidebar_creator = Sidebar_Settings_Model::get_sidebars_options();
		if ( count( $sidebar_creator ) && is_array( $sidebar_creator ) ) {
			foreach ( $sidebar_creator as $sidebar ) {
				register_sidebar( $sidebar );
			}
		}
	}
}

add_action( 'widgets_init', array( 'Customize_Sidebar_Creator', 'widgets_init' ) );
endif;
