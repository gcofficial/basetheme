<header id="masthead" class="site-header centered" role="banner">
	<div class="container">
		<div class="row">
			<div class="site-branding">
				@if($logo != '')
					<img src="{{ $logo }}" alt="Logo" class="logo-img">
				@else
					<h1 class="site-title"><a href="{{ $home_url }}" rel="home">{{ $name }}</a></h1>
					@if ( $description )
						<div class="site-description">{{ $description }}</div>
					@endif
				@endif
			</div>
		</div>
		<div class="row">
			@if($socials_show_header)
				{{ $socials }}
			@endif
		</div>
		<div class="row">
			<div class="clear">
				<div class="main-nav-wrap">
				{{ $main_menu }}
				</div><!-- #site-navigation -->
			</div>
		</div>
	</div>
</header><!-- #masthead -->