<?php
/**
 * Layouts/Footer centered view
 *
 * @package photolab
 */
?>
<div class="centered">
	@if(has_nav_menu('footer'))
		@if($logo != '')
			<img src="{{ $logo }}" alt="Logo" class="logo-img">
		@endif
		@if($socials_show_footer)
			{{ $socials }}
		@endif
		{{ $menu }}
	@endif
	@if(trim($copyright) != '')
		<span class="copyright">{{ $copyright }}</span>
	@endif
	{{ $copyright }}
</div>

