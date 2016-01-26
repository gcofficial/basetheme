<?php
/**
 * Layouts/Container single hide sidebar view
 *
 * @package photolab
 */
?>{{ $social_post_code }}
@while ( have_posts() )
	<?php the_post(); ?>
	@include( 'contents/single' )
	@if ( comments_open() || get_comments_number() != '0' )
		<?php comments_template(); ?>
	@endif
@endwhile
