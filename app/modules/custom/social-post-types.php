<?php
/**
 * Sidebars MetaBox module file
 *
 * @package photolab
 */

namespace Modules\Custom;

use \View\View;

Social_Post_Types::init();

/**
 * Social_Post_Types module class
 */
class Social_Post_Types {

	/**
	 * Initialize and add meta box
	 */
	public static function init() {
		if ( is_admin() ) {
			add_action( 'load-post.php', [ '\\Modules\\Custom\\Social_Post_Types', 'get_new_class' ] );
			add_action( 'load-post-new.php', [ '\\Modules\\Custom\\Social_Post_Types', 'get_new_class' ] );
		}
	}

	/**
	 * Get new class object
	 *
	 * @return Social_Post_Types --- object
	 */
	public static function get_new_class() {
		return new Social_Post_Types();
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
				'social_post_types_metabox',
				__( 'Social posts ( you can put the facebook or twitter post url )', 'photolab' ),
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
		if ( ! isset( $_POST['social_post_types_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['social_post_types_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'social_post_types' ) ) {
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
		$social_post_code = $_POST['social_post_code'];

		// Update the meta field.
		update_post_meta( $post_id, 'social_post_code', $social_post_code );
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'social_post_types', 'social_post_types_nonce' );

		echo View::make( 'blocks/social-post-types-metabox', [ 'value' => self::get_social_post_code( $post ) ] );
	}

	/**
	 * Get social post code
	 *
	 * @param  type $post object.
	 * @return string social post code
	 */
	public static function get_social_post_code( $post ) {
		return (string) get_post_meta( $post->ID, 'social_post_code', true );
	}
}
