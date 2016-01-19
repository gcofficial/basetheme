<?php
/**
 * Blocks/Read more button view
 *
 * @package photolab
 */
?>
@if($read_more_button != '')
<a href="{{ esc_url( get_permalink() ) }}" class="btn btn-animated">{{ esc_attr( $read_more_button ) }}</a>
@endif