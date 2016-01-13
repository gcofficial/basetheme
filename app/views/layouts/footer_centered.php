<div class="centered">
	@if(has_nav_menu('footer'))
		{{ $logo }}
		{{ $socials }}
		{{ $menu }}
	@endif
	@if(trim($copyright) != '')
		<span class="copyright">{{ $copyright }}</span>
	@endif
	{{ $copyright }}
</div>

