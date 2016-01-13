@if($footer_style != 'minimal')
	@include('layouts/sidebar-footer')
@endif
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info">
				@include('layouts/footer_'.$footer_style)
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
	<div id="back-top"><a href="#"><div class="dashicons dashicons-arrow-up-alt2"></div></a></div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>