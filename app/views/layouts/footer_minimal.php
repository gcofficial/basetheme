@if(trim($copyright) != '')
	<span class="copyright">{{ $copyright }}</span>
@endif
@if(has_nav_menu('footer'))
	{{ $menu }}
	{{ $socials }}
@endif