@for($i = 0; $i < count($posts); $i++)
	<?php $post = $posts[$i]; ?>
	<?php setup_postdata( $post ); ?>
	@include( 'contents/'.BlogSettingsModel::getContentName() )
@endfor
