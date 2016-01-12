<div id="masonry" class="masonry">
@for($i = 0; $i < count($posts); $i++)
	<?php
	$post = $posts[$i];
	setup_postdata( $post );
	?>
	<div class="brick {{ get_post_format() }}">
		@include( 'contents/'.BlogSettingsModel::getContentName() )
	</div>
@endfor
</div>