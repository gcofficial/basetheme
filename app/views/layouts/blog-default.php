<?php
/**
 * Layouts/Blog default view
 *
 * @package photolab
 */
?>@for($i = 0; $i < count($posts); $i++)
	<?php $post = $posts[ $i ]; ?>
	<?php setup_postdata( $post ); ?>
	@include( 'contents/'.Blog_Settings_Model::get_content_name() )
@endfor
