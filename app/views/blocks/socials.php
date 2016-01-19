<?php
/**
 * Blocks/Socials view
 *
 * @package photolab
 */
?>@if(is_array($socials) && count($socials))
<ul class="social-list list-{{ $where }}">
	@foreach($socials as $key => $properties)
		<li class="social-list_item item-{{ $key }}">
			<a class="social-list_item_link" href="{{ $properties['url'] }}"><i class="fa {{ $properties['icon'] }}"></i></a>
		</li>
	@endforeach
</ul>
@endif