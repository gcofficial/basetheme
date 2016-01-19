<?php
/**
 * Layouts/Container single hide sidebar view
 *
 * @package photolab
 */
?>{{ $social_post_code }}
@while ( have_posts() )
	<?php the_post(); ?>
	@include('contents/single')
	@if ( comments_open() || '0' != get_comments_number() )
		<?php comments_template('/app/modules/custom/comments.php'); ?>
	@endif
@endwhile