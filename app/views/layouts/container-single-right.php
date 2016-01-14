<div class="col-sm-9">
{{ $social_post_code }}
@while ( have_posts() )
	<?php the_post(); ?>
	@include('contents/single')
	@if ( comments_open() || '0' != get_comments_number() )
		<?php comments_template('/app/modules/custom/comments.php'); ?>
	@endif
@endwhile
</div>
@include('layouts/sidebar_right')