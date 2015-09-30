<?php get_header(); ?>
	<div id="container" class="site-content">
		<div id="content" class="hentry">
			<?php 
			global $post, $wp_query;
			$args = array(
				'post_type'					=> 'gallery',
				'post_status'				=> 'publish',
				'name'						=> $wp_query->query_vars['name'],
				'posts_per_page'			=> 1
			);	
			$second_query = new WP_Query( $args ); 
			$gllrprfssnl_options = get_option( 'gllrprfssnl_options' );
			$gllrprfssnl_download_link_title = addslashes( __( 'Download high resolution image', 'gallery_pro' ) );
			if ( $second_query->have_posts() ) : while ($second_query->have_posts()) : $second_query->the_post(); ?>
				<h1 class="home_page_title entry-header"><?php the_title(); ?></h1>
				<div class="gallery_box_single entry-content">
					<?php the_content(); 
					$posts = get_posts(array(
						"showposts"			=> -1,
						"what_to_show"		=> "posts",
						"post_status"		=> "inherit",
						"post_type"			=> "attachment",
						"orderby"			=> $gllrprfssnl_options['order_by'],
						"order"				=> $gllrprfssnl_options['order'],
						"post_mime_type"	=> "image/jpeg,image/gif,image/jpg,image/png",
						"post_parent"		=> $post->ID
					));
					if ( count( $posts ) > 0 ) {
						$count_image_block = 0; ?>
						<div class="gallery clearfix">
							<?php foreach( $posts as $attachment ) { 
								$key = "gllr_image_text";
								$alt_tag_key = "gllr_image_alt_tag";
								$link_key = "gllr_link_url";
								$target = "gllr_link_target"; 
								$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'photo-thumb' );
								$image_attributes_large = wp_get_attachment_image_src( $attachment->ID, 'full-photo' );
								if ( !preg_match( "~(.*)-[0-9]{1,4}x[0-9]{1,4}.(.*)~i", $image_attributes_large[0] ) ) {
									$image_attributes_large = wp_get_attachment_image_src( $attachment->ID, 'large' );
								}
								$image_attributes_full = wp_get_attachment_image_src( $attachment->ID, 'full' );
								if( 1 == $gllrprfssnl_options['border_images'] ){
									$gllrprfssnl_border = 'border-width: '.$gllrprfssnl_options['border_images_width'].'px; border-color:'.$gllrprfssnl_options['border_images_color'].'';
									$gllrprfssnl_border_images = $gllrprfssnl_options['border_images_width'] * 2;
								}
								else{
									$gllrprfssnl_border = '';
									$gllrprfssnl_border_images = 0;
								}
								if( $count_image_block % $gllrprfssnl_options['custom_image_row_count'] == 0 ) { ?>
								<div class="gllrprfssnl_image_row">
								<?php } ?>
									<div class="gllrprfssnl_image_block">
										<p style="width:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][0]+$gllrprfssnl_border_images; ?>px;height:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][1]+$gllrprfssnl_border_images; ?>px;">
											<?php if( ( $url_for_link = get_post_meta( $attachment->ID, $link_key, true ) ) != "" ) { ?>
												<a href="<?php echo $url_for_link; ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" target="<?php echo get_post_meta( $attachment->ID, $target, true ); ?>">
													<img style="width:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][0]; ?>px;height:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][1]; ?>px; <?php echo $gllrprfssnl_border; ?>" alt="<?php echo get_post_meta( $attachment->ID, $alt_tag_key, true ); ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo $image_attributes[0]; ?>" />
												</a>
											<?php } else { 
												if ( '1' == $gllrprfssnl_options["size_photo_full"] ) { ?>
													<a rel="gallery_fancybox<?php if ( 0 == $gllrprfssnl_options['single_lightbox_for_multiple_galleries'] ) echo '_' . $post->ID; ?>" href="<?php echo $image_attributes_full[0]; ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>">
														<img style="width:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][0]; ?>px;height:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][1]; ?>px; <?php echo $gllrprfssnl_border; ?>" alt="<?php echo get_post_meta( $attachment->ID, $alt_tag_key, true ); ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
													</a>
												<?php } else { ?>
													<a rel="gallery_fancybox<?php if ( 0 == $gllrprfssnl_options['single_lightbox_for_multiple_galleries'] ) echo '_' . $post->ID; ?>" href="<?php echo $image_attributes_large[0]; ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>">
														<img style="width:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][0]; ?>px;height:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][1]; ?>px; <?php echo $gllrprfssnl_border; ?>" alt="<?php echo get_post_meta( $attachment->ID, $alt_tag_key, true ); ?>" title="<?php echo get_post_meta( $attachment->ID, $key, true ); ?>" src="<?php echo $image_attributes[0]; ?>" rel="<?php echo $image_attributes_full[0]; ?>" />
													</a>
												<?php }
											} ?>											
										</p>
										<div  style="width:<?php echo $gllrprfssnl_options['gllrprfssnl_custom_size_px'][1][0]+$gllrprfssnl_border_images; ?>px; <?php if( 0 == $gllrprfssnl_options["image_text"] ) echo "visibility:hidden;"; ?>" class="gllrprfssnl_single_image_text"><?php echo get_post_meta( $attachment->ID, $key, true ); ?>&nbsp;</div>
									</div>
								<?php if ( $count_image_block%$gllrprfssnl_options['custom_image_row_count'] == $gllrprfssnl_options['custom_image_row_count']-1 ) { ?>
								</div>
								<?php } 
								$count_image_block++; 
							} 
							if ( $count_image_block > 0 && $count_image_block%$gllrprfssnl_options['custom_image_row_count'] != 0) { ?>
								</div>
							<?php } ?>
							</div>
						<?php } ?>
					</div>
					<div class="clear"></div>
				<?php endwhile; else: ?>
				<div class="gallery_box_single">
					<p class="not_found"><?php _e( 'Sorry, nothing found.', 'gallery' ); ?></p>
				</div>
				<?php endif; ?>
				<?php if ( 1 == $gllrprfssnl_options['return_link'] ) {
					if ( 'gallery_template_url' == $gllrprfssnl_options["return_link_page"] ){
						global $wpdb;
						$parent = $wpdb->get_var( "SELECT $wpdb->posts.ID FROM $wpdb->posts, $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value = 'gallery-template.php' AND (post_status = 'publish' OR post_status = 'private') AND $wpdb->posts.ID = $wpdb->postmeta.post_id" );	?>
						<div class="return_link"><a href="<?php echo ( !empty( $parent ) ? get_permalink( $parent ) : '' ); ?>"><?php echo $gllrprfssnl_options['return_link_text']; ?></a></div>
					<?php } else { ?>
						<div class="return_link"><a href="<?php echo $gllrprfssnl_options["return_link_url"]; ?>"><?php echo $gllrprfssnl_options['return_link_text']; ?></a></div>
					<?php }
				} ?>
				<?php comments_template(); ?>
			</div>
		</div>
	<?php get_sidebar(); ?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				$("a[rel=gallery_fancybox<?php if ( 0 == $gllrprfssnl_options['single_lightbox_for_multiple_galleries'] ) echo '_' . $post->ID; ?>]").fancybox({
					'transitionIn'		: 'elastic',
					'transitionOut'		: 'elastic',
					'titlePosition' 	: 'inside',
					'speedIn'			:	500, 
					'speedOut'			:	300,
					'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
						var str = '<span id="fancybox-title-inside">' + (title.length ? title + '<br />' : '') + '<?php _e( "Image ", "gallery"); ?>' + (currentIndex + 1) + ' / ' + currentArray.length + '</span><?php if( get_post_meta( $post->ID, 'gllr_download_link', true ) != '' ){?><br /><a href="'+$(currentOpts.orig).attr('rel')+'" target="_blank"><?php echo $gllrprfssnl_download_link_title; ?></a><?php } ?>';
						str = str+'<div id="gllrprfssnl_like_button">';
						<?php if ( 1 == $gllrprfssnl_options['like_button_fb'] ) { ?>
							str = str+'<div class="fcbk_like"><iframe src="//www.facebook.com/plugins/like.php?href='+$(currentOpts.orig).attr('rel')+'&locale=en_US&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></div>';
						<?php }
						if ( 1 == $gllrprfssnl_options['like_button_twit'] ) { ?>
							str = str+'<div class="twttr_like"><iframe allowtransparency="true" frameborder="0" scrolling="no" src="https://platform.twitter.com/widgets/tweet_button.html?url='+$(currentOpts.orig).attr('rel')+'&count=none" style="width:130px; height:20px;"></iframe></div>';
						<?php }
						if ( 1 == $gllrprfssnl_options['like_button_pint'] ) { ?>
							str = str+'<div class="pntrst_like"><a href="//pinterest.com/pin/create/button/?url='+$(currentOpts.orig).attr('rel')+'&media='+$(currentOpts.orig).attr('rel')+'&description=' + title + '" data-pin-do="buttonPin" data-pin-config="beside" target="_blank"><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a></div>';
						<?php } 
						if ( 1 == $gllrprfssnl_options['like_button_g_plusone'] ) { ?>
							str = str+'<div class="gglplsn"><iframe src="https://plusone.google.com/_/+1/fastbutton?bsv&amp;size=medium&amp;hl=en-US&amp;url='+$(currentOpts.orig).attr('rel')+'&amp;parent='+$(currentOpts.orig).attr('rel')+'" allowtransparency="true" frameborder="0" scrolling="no" title="+1"></iframe></div>'
						<?php } ?>
						str = str+'</div><div style="clear:both;"></div>';
						return str;
					}<?php if( $gllrprfssnl_options['start_slideshow'] == 1 ) { ?>,
					'onComplete':	function() {
						clearTimeout(jQuery.fancybox.slider);
						jQuery.fancybox.slider=setTimeout("jQuery.fancybox.next()",<?php echo empty( $gllrprfssnl_options['slideshow_interval'] )? 2000 : $gllrprfssnl_options['slideshow_interval'] ; ?>);
					}<?php } ?>
				});
			});
		})(jQuery);
	</script>
<?php get_footer(); ?>