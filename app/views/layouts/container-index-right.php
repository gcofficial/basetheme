<?php
/**
 * Layouts/Container index right sidebars view
 *
 * @package photolab
 */
?><div class="col-sm-9">
@if ( have_posts() )
	@include('layouts/blog-'.$blog_layout_style)
	{{ $paginate_links }}
@else
	@include('contents/none')
@endif
</div>
@include('layouts/sidebar')