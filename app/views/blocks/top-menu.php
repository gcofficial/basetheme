<?php
/**
 * Blocks/Top menu view
 *
 * @package photolab
 */
?>
<div class="top-menu">
	@if($disclimer != '')
		<span class="disclimer">{{ $disclimer }}</span>
	@endif
	@if($search_box)
		{{ $search_form }}
	@endif
	{{ $top_menu }}
</div>