<?php

namespace Modules\Custom;

Use \View\View;
Use \Core\Utils;

/**
 * Fucking comments_template!!!
 * We need this hack 
 * because comments_teamplate function 
 * initializing wp_query->have_comments 
 * and have_comments() doesn't work without call comments_template()
 */
echo  View::make('blocks/comments');

class Comments{

	/**
	 * Custom comments template
	 */
	public static function comment( $comment, $args, $depth )
	{
		$GLOBALS['comment'] = $comment;
		echo View::make(
			'blocks/photolab_comment',
			[
				'comment' => $comment,
				'args'    => $args,
				'depth'   => $depth,
			]
		);
	}
}