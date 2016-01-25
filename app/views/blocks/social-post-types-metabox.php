<?php
/**
 * Blocks/Social post types metabox view
 *
 * @package photolab
 */
?><label for="social_post_url"> {{ __( 'Facebook or twitter post url', 'photolab' ) }}: </label>
<textarea name="social_post_code" id="social_post_code" cols="30" rows="10" class="widefat">{{ $value }}</textarea>
