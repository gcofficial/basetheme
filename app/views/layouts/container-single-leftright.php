@include('layouts/sidebar_left')
<div class="col-sm-6">
{{ $social_post_code }}
@while ( have_posts() )
	<?php the_post(); ?>
	@include('contents/single')
	@if ( comments_open() || '0' != get_comments_number() )
		@include('blocks/comments')
	@endif
@endwhile
</div>
@include('layouts/sidebar_right')