<?php
/**
 * Layouts/Container index left view
 *
 * @package photolab
 */
?><div class="col-sm-9 right-sidebar">
@if ( have_posts() )
	@include('layouts/blog-'.$blog_layout_style)
	{{ $paginate_links }}
@else
	@include('contents/none')
@endif
</div>
@include('layouts/sidebar')