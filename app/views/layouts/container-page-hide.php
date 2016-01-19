<?php
/**
 * Layouts/Container page hide sidebar view
 *
 * @package photolab
 */
?>@while ( have_posts() )
	<?php the_post(); ?>
	@include('contents/page')
	@if ( comments_open() || '0' != get_comments_number() )
		<?php comments_template( '/app/modules/custom/comments.php' ); ?>
	@endif
@endwhile
