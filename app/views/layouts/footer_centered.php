<div class="centered">
	@if(has_nav_menu('footer'))
		@if($logo != '')
			<img src="{{ $logo }}" alt="Logo" class="logo-img">
		@endif
		{{ $socials }}
		{{ $menu }}
	@endif
	@if(trim($copyright) != '')
		<span class="copyright">{{ $copyright }}</span>
	@endif
	{{ $copyright }}
</div>

