<?php
/**
 * Layouts/Blog masonry view
 *
 * @package photolab
 */
?><div id="masonry" class="masonry">
@for($i = 0; $i < count($posts); $i++)
	<?php
	$post = $posts[$i];
	setup_postdata( $post );
	?>
	<div class="brick brick-{{ $columns_count }}">
		@include( 'contents/'.Blog_Settings_Model::getContentName() )
	</div>
@endfor
</div>