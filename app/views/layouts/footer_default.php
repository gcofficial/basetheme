@if(trim($copyright) != '')
	<span class="copyright">{{ $copyright }}</span>
@endif
@if(has_nav_menu('footer'))
	{{ $menu }}
	@if($socials_show_footer)
		{{ $socials }}
	@endif
@endif
