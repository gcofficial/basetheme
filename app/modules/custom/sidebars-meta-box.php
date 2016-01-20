<?php
/**
 * Sidebars MetaBox module file
 *
 * @package photolab
 */

Sidebars_Meta_Box::init();

/**
 * Sidebars_Meta_box module class
 */
class Sidebars_Meta_Box {

	/**
	 * Initialize and add meta box
	 */
	public static function init() {
		if ( is_admin() ) {
			add_action( 'load-post.php', array( 'Sidebars_Meta_Box', 'get_new_class' ) );
			add_action( 'load-post-new.php', array( 'Sidebars_Meta_Box', 'get_new_class' ) );
		}
	}

	/**
	 * Get new class object
	 *
	 * @return Sidebars_Meta_Box --- object
	 */
	public static function get_new_class() {
		return new Sidebars_Meta_Box();
	}

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array( 'post', 'page' );
		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'sidebars_metabox',
				__( 'Sidebars ( you can choose your own sidebar for this page )', 'photolab' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'advanced',
				'high'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['sidebars_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['sidebars_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'sidebars' ) ) {
			return $post_id;
		}

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, its safe for us to save the data now. */
		$sidebar_left  = $_POST['sidebar_left'];
		$sidebar_right = $_POST['sidebar_right'];
		// Update the meta field.
		update_post_meta( $post_id, 'sidebar_left', $sidebar_left );
		update_post_meta( $post_id, 'sidebar_right', $sidebar_right );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'sidebars', 'sidebars_nonce' );

		echo View::make(
			'blocks/sidebars-metabox',
			array(
				'left_select' => View::make(
					'blocks/select',
					array(
						'current_value' => self::get_sidebar_left( $post->ID ),
						'attributes'    => Utils::array_join(
							array(
								'name'  => 'sidebar_left',
								'id'    => 'sidebar_left',
							)
						),
						'values'        => \Sidebar_Settings_Model::getSidebarsForSelect(),
					)
				),
				'right_select' => View::make(
					'blocks/select',
					array(
						'current_value' => self::get_sidebar_right( $post->ID ),
						'attributes'    => Utils::array_join(
							array(
								'name'  => 'sidebar_right',
								'id'    => 'sidebar_right',
							)
						),
						'values'        => \Sidebar_Settings_Model::getSidebarsForSelect(),
					)
				),
			)
		);
	}

	/**
	 * Get sidebar left
	 *
	 * @param  object $post_id post.
	 * @return string       --- sidebar left
	 */
	public static function get_sidebar_left( $post_id ) {
		return (string) get_post_meta(
			$post_id,
			'sidebar_left',
			true
		);
	}

	/**
	 * Get sidebar right
	 *
	 * @param  object $post_id post.
	 * @return string       --- sidebar right
	 */
	public static function get_sidebar_right( $post_id ) {
		return (string) get_post_meta(
			$post_id,
			'sidebar_right',
			true
		);
	}
}
