<?php
/**
 *
 * content*.php
 *
 * The post format template. You can change the structure of your posts or add/remove post elements here.
 * 
 * 'id' - post id
 * 'class' - post class
 * 'thumbnail' - post icon
 * 'title' - post title
 * 'before' - post header metadata
 * 'content' - post content
 * 'after' - post footer metadata
 * 
 * To create a new custom post format template you must create a file "content-YourTemplateName.php"
 * Then copy the contents of the existing content.php into your file and edit it the way you want.
 * 
 * Change an existing get_template_part() function as follows:
 * get_template_part('content', 'YourTemplateName');
 *
 */
global $post;
/*theme_post_wrapper(
		array(
			'id' => theme_get_post_id(),
			'class' => theme_get_post_class(),
			'thumbnail' => theme_get_post_thumbnail(),
			'title' => '<a href="' . get_permalink($post->ID) . '" rel="bookmark" title="' . strip_tags(get_the_title()) . '">' . get_the_title() . '</a>',
			'heading' => theme_get_option('theme_' . (is_home() ? 'posts' : 'single') . '_article_title_tag'),
			'before' => theme_get_metadata_icons('date,author,edit', 'header'),
			'content' => theme_get_excerpt(),
			'after' => theme_get_metadata_icons('', 'footer')
		)
);*/
echo '<div class="song_thumb_link" title="Escoltar \''.get_the_title().'\'">';
	echo '<label>';the_title();echo '</label>';
	echo '<a class="open_song">'; 
		echo '<div class="button_overlay"><img src="'.get_stylesheet_directory_uri().'/img/play_icon.png"/></div>';
		/*if (get_the_post_thumbnail(array('medium')) == '') {
			the_post_thumbnail();
		} else {
			the_post_thumbnail(array('medium'));
		}*/
			
		//the_post_thumbnail(array('thumbnail'));
		//the_post_thumbnail( array(300,300) );
		the_post_thumbnail(array('medium'));
		
		//$default = '<img class="attachment-medium wp-post-image" width="300" height="300" alt="el-ren-i-el-trineu" src="http://mondemusica2.local/wp-content/uploads/2014/01/el-ren-i-el-trineu-300x300.jpg">';
		
		/*echo get_the_title();
		
		if (get_the_title() == "L\'hivern") {
			echo $default;
		} else {
			the_post_thumbnail(array('medium'));
		}*/
		
		
		
	echo '</a>';	
	echo '<div class="song_data">';
		the_content();
	echo '</div>';
echo '</div>';

?>
