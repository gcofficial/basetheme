<?php
/**
 * Layouts/Header minimal view
 *
 * @package photolab
 */
?>
<header id="masthead" class="site-header minimal" role="banner">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
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
			<div class="col-md-8">
				<div class="clear">
					@if($socials_show_header)
						{{ $socials }}
					@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="main-nav-wrap">
			{{ $main_menu }}
			</div><!-- #site-navigation -->
		</div>
	</div>
</header><!-- #masthead -->