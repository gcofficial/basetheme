<?php
/**
 * Layouts/Container index hide view
 *
 * @package photolab
 */
?>@if ( have_posts() )
	@include('layouts/blog-'.$blog_layout_style)
	{{ $paginate_links }}
@else
	@include('contents/none')
@endif
