<?php
/**
 * Custom template tags for this theme.
 *
 * based on Underscores starter WordPress theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package photolab
 */

/**
 * Custom comments template
 */
function photolab_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'photolab' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'photolab' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-author-thumb">
				<?php echo get_avatar( $comment, 70 ); ?>
			</div><!-- .comment-author -->
			<div class="comment-content">
				<div class="comment-meta">
					<?php printf( '<div class="comment_author">%s</div>', get_comment_author_link() ); ?>
					<time datetime="<?php comment_time( 'c' ); ?>">
						<?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ' . __( 'ago', 'photolab' ); ?>
					</time>
				</div>
				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'photolab' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
				<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<div class="reply">',
						'after'     => '</div>',
					) ) );
				?>
			</div><!-- .comment-content -->
		</article><!-- .comment-body -->

	<?php
	endif;
}

/**
 * Modify comment form default fields
 */
add_filter( 'comment_form_default_fields', 'photolab_comment_form_fields' );
function photolab_comment_form_fields( $fields ) {

	$req       = get_option( 'require_name_email' );
	$html5     = 'html5';
	$commenter = wp_get_current_commenter();
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$fields = array(
		'author' => '<p class="comment-form-author"><input class="comment-form-input" id="author" name="author" type="text" placeholder="' . __( 'Name', 'photolab' ) . ( $req ? '*' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><input class="comment-form-input" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . __( 'Email', 'photolab' ) . ( $req ? '*' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><input class="comment-form-input" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . __( 'Website', 'photolab' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
	);

	return $fields;
}

/**
 * Show welcome message on front page
 */
function photolab_welcome_message() {
	$data = get_option( 'photolab' );
	if ( empty($data) ) {
		return;
	}

	global $wp_query, $allowedtags;
	if ( $wp_query->is_paged && $wp_query->query['paged'] > 1 ) {
		return;
	}

	echo '<div class="container">';
		echo '<div class="welcome_message row">';
			if ( isset($data['welcome_label']) ) {
				echo '<div class="col-md-12"><h3 class="message_label"><span>' . wp_kses( $data['welcome_label'], $allowedtags ) . '</span></h3></div>';
			}
			if ( isset($data['welcome_img']) ) {
				$alt_mess = isset($data['welcome_title']) ? $data['welcome_title'] : get_bloginfo( 'name' );
				echo '<div class="col-md-5"><img src="' . esc_url( $data['welcome_img'] ) . '" alt="' . esc_attr( $alt_mess ) . '"></div>';
			}
			echo '<div class="message_content col-md-7">';
				if ( isset($data['welcome_title']) ) {
					echo '<h2 class="message_title">' . wp_kses( $data['welcome_title'], $allowedtags ) . '</h2>';
				}
				if ( isset($data['welcome_message']) ) {
					echo '<p>' . wp_kses( $data['welcome_message'], $allowedtags ) . '</p>';
				}
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

/**
 * Get image html for featured gallery
 * @param  int $id - image ID
 * @param  string $size - image size
 * @param  string $class - image wrapper class
 * @return string - HTNL markup for gallery tem image
 */
function photolab_get_image_html( $id = null, $size = 'fullwidth-thumbnail', $class = 'fullwidth-item' ) {
	if ( !$id ) {
		return;
	}
	$fullsize_img = wp_get_attachment_url( $id );
	$cropped_image = wp_get_attachment_image( $id, $size );
	if ( $fullsize_img  && $cropped_image  ) {
		$result = '<div class="gall-img-wrap ' . esc_attr( $class ) . '"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></div>';
		return $result;
	} else {
		return false;
	}

}

/**
 * Show featured gllery for gallery post format
 * @return void
 */
function photolab_get_featured_gallery_html( $img_ids = null ) {

	if ( !$img_ids || !is_array($img_ids) ) {
		return;
	}

	$post_id = get_the_id();

	$img_ids_chunks = array_chunk($img_ids, 3);
	$num_items = count($img_ids_chunks);
	$i = 0;

	echo '<div class="post-featured-gallery" id="featured-gallery-' . $post_id . '" data-gall-id="featured-gallery-' . $post_id . '">';

	foreach ($img_ids_chunks as $sub_ids) {
		$item_class = 'item-left';
		if ( 0 == ( ( $i + 1 ) % 2 ) ) {
			$item_class = 'item-right';
		}
		if(++$i === $num_items) {

			// Gallery last row start
			echo '<div class="gall-row last ' . esc_attr( $item_class ) . '">';
			
			$sub_ids_length = count($sub_ids);
			switch ($sub_ids_length) {
				case '1':
					echo photolab_get_image_html($sub_ids[0]);
					break;
				
				case '2':
					foreach ($sub_ids as $img_item) {
						echo photolab_get_image_html($img_item, 'gallery-large', 'half-width-item');
					}
					unset($img_item);
					break;

				case '3':
					$sub_iter = 1;
					foreach ($sub_ids as $img_item) {
						if ( 1 == $sub_iter ) {
							echo photolab_get_image_html($img_item, 'gallery-large', 'large-img-item');
							$sub_iter++;
						} else {
							echo photolab_get_image_html($img_item, 'gallery-small', 'small-img-item');
						}
					}
					unset($img_item);
					unset($sub_iter);
					break;
			}

			// Gallery last row finish
			echo '</div>';

		} else {

			// Gallery row start
			echo '<div class="gall-row ' . esc_attr( $item_class ) . '">';

			$sub_iter = 1;
			foreach ($sub_ids as $img_item) {
				if ( 1 == $sub_iter ) {
					echo photolab_get_image_html($img_item, 'gallery-large', 'large-img-item');
					$sub_iter++;
				} else {
					echo photolab_get_image_html($img_item, 'gallery-small', 'small-img-item');
				}
			}
			unset($img_item);
			unset($sub_iter);
			
			// Gallery last row finish
			echo '</div>';
		}
	}

	echo '</div>';

}

/**
 * Featured gallery for gallery post format
 */
function photolab_featured_gallery( $post_format_only = true ) {

	if ( $post_format_only && 'gallery' != get_post_format() ) {
		return;
	}
	
	$post_id = get_the_id();
	$post_gallery = get_post_gallery( $post_id, false );

	if ( $post_gallery && is_array($post_gallery) && isset($post_gallery['ids']) ) {
		$img_ids = explode(',', $post_gallery['ids']);

		photolab_get_featured_gallery_html( $img_ids );
	} else {

		$attachments = get_children( array(
			'post_parent'    => $post_id,
			'posts_per_page' => 3,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );

		if ( $attachments && is_array($attachments) ) {
			$img_ids = array_keys($attachments);
			photolab_get_featured_gallery_html( $img_ids );
		}

	}

}

/**
 * Get image for image post format
 */
function photolab_image_post() {

	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$fullsize_img = wp_get_attachment_url( $thumb_id );
		$cropped_image = wp_get_attachment_image( $thumb_id , 'fullwidth-thumbnail' );
		echo '<figure class="lightbox-image"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></figure>';
	} else {
		$post_id = get_the_id();
		$attachments = get_children( array(
			'post_parent'    => $post_id,
			'posts_per_page' => 1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );
		if ( $attachments && is_array( $attachments ) ) {
			$img_id = $attachments[0]->ID;
			$fullsize_img = wp_get_attachment_url( $img_id );
			$cropped_image = wp_get_attachment_image( $img_id , 'fullwidth-thumbnail' );
			echo '<figure class="lightbox-image"><a href="' . esc_url( $fullsize_img ) . '" class="lightbox-gallery">' . $cropped_image . '<span class="img-mask"></span></a></figure>';
		}
	}
}

/**
 * Show social links list
 */
function photolab_social_list( $where = 'header', $echo = true ) {

	ob_start();

	$data     = get_option( 'photolab' );
	$position = isset( $data['socials_position'] ) ? esc_attr( $data['socials_position'] ) : 'header';
	
	$photolab_socials_position_header = get_option('photolab_socials_position_header');
	$photolab_socials_position_footer = get_option('photolab_socials_position_footer');

	if($where == 'header' && $photolab_socials_position_header == '') return;
	if($where == 'footer' && $photolab_socials_position_footer == '') return;

	$socials = photolab_allowed_socials();

	$item_format = apply_filters( 
		'photolab_social_list_itemformat', 
		'<li class="social-list_item item-%1$s"><a class="social-list_item_link" href="%2$s"><i class="fa %3$s"></i></a></li>' 
	);

	$list = '';
	foreach ( $socials as $social_id => $social_data ) {
		if ( empty( $data[ $social_id . '_url' ] ) ) {
			continue;
		}
		$url  = esc_url( $data[ $social_id . '_url' ] );
		$icon = isset( $social_data['icon'] ) ? $social_data['icon'] : false;
		
		$list .= sprintf( $item_format, $social_id, $url, $icon );
	}

	if ( ! $list ) {
		return;
	}

	printf( '<ul class="social-list list-%1$s">%2$s</ul>', $where, $list );

	$var = ob_get_contents();
	ob_end_clean();
	if($echo == true)
		echo $var;
	else
		return $var;
}