<?php
/**
 *
 * archive.php
 *
 * The archive template. Used when a category, author, or date is queried.
 * Note that this template will be overridden by category.php, author.php, and date.php for their respective query types. 
 *
 * More detailed information about template’s hierarchy: http://codex.wordpress.org/Template_Hierarchy
 *
 */
get_header(); ?>


			<?php get_sidebar('top'); ?>
			<?php
			if (have_posts()) {
				global $posts;
				$post = $posts[0];
				theme_ob_start();

				if (is_category()) {
					echo '<h1 class="page-title">' . single_cat_title('', false) . '</h1>';
					echo category_description();
				} 
				theme_post_wrapper(array('content' => theme_ob_get_clean(), 'class' => 'breadcrumbs'));

				/* Display navigation to next/previous pages when applicable */
				if (theme_get_option('theme_top_posts_navigation')) {
					theme_page_navigation();
				}

				/* Start the Loop */
				while (have_posts()) {
					the_post();
					get_template_part('content', 'canco');
				}

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

<div class="modal fade" id="modal_player" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h1 class="modal-title" id="myModalLabel">Modal title</h1>
      </div>
      <div class="modal-body">
      </div>
      <?php /*<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tanca</button>
      </div>
	  */ ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
