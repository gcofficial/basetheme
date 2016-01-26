<?php
/**
 * Comments module file
 *
 * @package photolab
 */

/**
 * Fucking comments_template!!!
 * We need this hack
 * because comments_teamplate function
 * initializing wp_query->have_comments
 * and have_comments() doesn't work without call comments_template()
 */

/**
 * Comments module class
 */
class Comments {

	/**
	 * Custom comments template
	 *
	 * @param [type] $comment comment.
	 * @param [type] $args arguments.
	 * @param [type] $depth depth.
	 */
	public static function comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		echo View::make(
			'blocks/photolab-comment',
			array(
				'comment' => $comment,
				'args'    => $args,
				'depth'   => $depth,
			)
		);
	}
}
