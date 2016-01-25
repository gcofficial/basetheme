<?php
/**
 * Layouts/Container single right sidebar view
 *
 * @package photolab
 */
?><div class="col-sm-9">
{{ $social_post_code }}
@while ( have_posts() )
	<?php the_post(); ?>
	@include( 'contents/single' )
	@if ( comments_open() || get_comments_number() != '0' )
		<?php comments_template( '/app/modules/custom/comments.php' ); ?>
	@endif
@endwhile
</div>
@include( 'layouts/sidebar-right' )
