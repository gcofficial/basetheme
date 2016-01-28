<?php
/**
 * Frontend view
 *
 * @package TM_Subscribe_And_Share_Widget
 */
?>
<!-- Widget -->
<div class="tm-subscribe-and-share-widget">
	@foreach( $blocks as $file => $name )
		@include( $folder_path .'/' . $file )
	@endforeach
</div>
<!-- End widget -->
