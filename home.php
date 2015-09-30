<?php get_header(); ?>

			<?php get_sidebar('top'); ?>
			<?php
			
				
			// Jordi: Filtratge de posts amb categoria 'Portada'
			global $wp_query;
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$query = array(
				//'category_name' => "Portada",
				'cat'=> 20,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'paged'=> $paged,
				//'posts_per_page' => ($paged == 1) ? 5 : 6
				'posts_per_page' => 4
			);
			
			
			$wp_query = new WP_Query($query);
			
			///       
			/*if ($paged == 1) {
				echo do_shortcode("[metaslider id=480]"); 
			}*/
			
			
			if (have_posts()) {
				/* Display navigation to next/previous pages when applicable */
				
				if ($paged > 1) {
					if (theme_get_option('theme_' . (theme_is_home() ? 'home_' : '') . 'top_posts_navigation')) {
						theme_page_navigation();
					}
				}
				
				?>
				


				<div class="mmb-content-layout-wrapper post-layout-item-0">
					<div class="mmb-content-layout">
					  
					   		<?php 
								//theme_get_next_post(); 
								theme_get_next_excerpt()
								?>
						
								<?php 
								theme_get_next_excerpt()
								?>
						
								<?php 
								//theme_get_next_post(); 
								theme_get_next_excerpt()
								?>
								<?php 
								//theme_get_next_post(); 
								theme_get_next_excerpt()
								?>
											  
					 			<?php 
								//theme_get_next_post(); 
								//theme_get_next_excerpt()
								?>
						
								<?php 
								//theme_get_next_post(); 
								//theme_get_next_excerpt()
								?>
						
						
					</div>
				</div>



				<?php
				/* Display navigation to next/previous pages when applicable */
				if (theme_get_option('theme_bottom_posts_navigation')) {
					theme_page_navigation();
				}
			} else {
				theme_404_content();
			}
			?>
			<?php get_sidebar('bottom'); ?>
			

<?php get_footer(); ?>