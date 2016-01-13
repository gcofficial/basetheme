<div id="masonry" class="masonry">
@for($i = 0; $i < count($posts); $i++)
	<?php
	$post = $posts[$i];
	setup_postdata( $post );
	?>
	<div class="brick brick-{{ $columns_count }}">
		@include( 'contents/'.BlogSettingsModel::getContentName() )
	</div>
@endfor
</div>