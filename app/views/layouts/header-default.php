<?php
/**
 * Layouts/Header default view
 *
 * @package photolab
 */
?><header id="masthead" class="site-header" role="banner">
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
					<div class="main-nav-wrap">
					{{ $main_menu }}
					</div><!-- #site-navigation -->
				</div>
			</div>
		</div>
	</div>
</header><!-- #masthead -->