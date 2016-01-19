<?php
/**
 * Layouts/Container index left and right sidebars view
 *
 * @package photolab
 */
?>
@include('layouts/sidebar')
<div class="col-sm-6">
@if ( have_posts() )
	@include('layouts/blog-'.$blog_layout_style)
	{{ $paginate_links }}
@else
	@include('contents/none')
@endif
</div>
@include('layouts/sidebar-second')