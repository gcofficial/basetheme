<?php
/**
 * Comments view
 *
 * @package photolab
 */
?>@if ( !post_password_required() ) 

<div id="comments" class="comments-area">
	@if ( have_comments() ) 
		<h3 class="post-meta-title"><span>{{ __( 'Comments on', 'photolab' ) }} {{ the_title( '"', '"', false ) }}</span></h3>

		@if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) )
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<div class="nav-previous">{{ get_previous_comments_link( __( '&larr; Older Comments', 'photolab' ) ) }}</div>
			<div class="nav-next">{{ get_next_comments_link( __( 'Newer Comments &rarr;', 'photolab' ) ) }}</div>
		</nav><!-- #comment-nav-above -->
		@endif

		<ol class="comment-list">
			{{
				wp_list_comments( 
					array(
						'style'      => 'ol',
						'short_ping' => true,
						'callback'   => array('Comments', 'comment'),
						'echo'       => false
					)
				)
			}}
		</ol><!-- .comment-list -->

		@if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) )
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<div class="nav-previous">{{ get_previous_comments_link( __( '&larr; Older Comments', 'photolab' ) ) }}</div>
			<div class="nav-next">{{ get_next_comments_link( __( 'Newer Comments &rarr;', 'photolab' ) ) }}</div>
		</nav><!-- #comment-nav-below -->
		@endif
	@endif

	@if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) 
		<p class="no-comments">{{ __( 'Comments are closed.', 'photolab' ) }}</p>
	@endif

	<?php
		comment_form(
			array(
				'comment_field'  => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . __( 'Comment*', 'photolab' ) . '" aria-required="true"></textarea></p>',
				'title_reply'    => '<span>' . __( 'Leave a Reply', 'photolab' ) . '</span>',
				'title_reply_to' => '<span>' . __( 'Leave a Reply to %s', 'photolab' ) . '</span>',
			)
		);
	?>

</div><!-- #comments -->
@endif
