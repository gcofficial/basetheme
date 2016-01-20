<?php
/**
 * Photolab comment view
 *
 * @package photolab
 */
?>@if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type )
	<li id="comment-{{ get_comment_ID() }}" {{ comment_class( '', null, null, false ) }}>
		<div class="comment-body">
			{{ __( 'Pingback:', 'photolab' ) }} {{ get_comment_author_link() }} <?php edit_comment_link( __( 'Edit', 'photolab' ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	@else
	<li id="comment-{{ get_comment_ID() }}" {{ comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false ) }}>
		<article id="div-comment-{{ get_comment_ID() }}" class="comment-body">
			<div class="comment-author-thumb">
				{{ get_avatar( $comment, 70 ) }}
			</div><!-- .comment-author -->
			<div class="comment-content">
				<div class="comment-meta">
					<div class="comment_author">{{ get_comment_author_link() }}</div>
					<time datetime="{{ get_comment_time( 'c' ) }}">
						{{ human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ' . __( 'ago', 'photolab' ) }}
					</time>
				</div>
				@if ( '0' == $comment->comment_approved )
					<p class="comment-awaiting-moderation">{{ __( 'Your comment is awaiting moderation.', 'photolab' ) }}</p>
				@endif
				<?php comment_text(); ?>
				{{
					get_comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '<div class="reply">',
								'after'     => '</div>',
							)
						)
					)
				}}
			</div><!-- .comment-content -->
		</article><!-- .comment-body -->
@endif
