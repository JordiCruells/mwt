<?php 
class CategoriesThumbs extends WP_Widget {
	function CategoriesThumbs(){
		$widget_ops = array('classname'=>'categories-thumbs hidden-xs', 'description'=>'Seccions del web');
		$this->WP_Widget('CategoriesThumbs', 'Seccions', $widget_ops);
	}
	function widget($args, $instance){
	
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if(!empty($title)) echo $before_title . $title . $after_title;
		$output = list_categories_thumbs();
		echo $output . $after_widget;	
	
	}
	
	function update($new_instance,$old_instance){
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['avatar_size'] = intval($new_instance['avatar_size']);
		return $instance;	
	
	}
	
	function form($instance) {
		$instance=wp_parse_args( (array) $instance, array('title' => 'Seccions'));
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $instance['title'];?>" /></p>
		
		<?php
	}
}

//Afegir widget al Wordpress
function categories_thumbs_init(){
	register_widget('CategoriesThumbs');
}
add_action('widgets_init', 'categories_thumbs_init');

//Shortcode per a la llista de categories amb thumbnails
add_image_size('category_thumb', 200, 200, true);


//Afegir un shortcode
add_shortcode('list_categories_thumbs', 'list_categories_thumbs');

function list_categories_thumbs() {
	$list .= "<ul>";
	$categories = get_categories(); 
	foreach ($categories as $category) {
			/*$list .= '<li><ul>';
			$list .= '<li>$category->term_id = ' . $category->term_id . '</li>';
			$list .= '<li>$category->cat_name = ' . $category->cat_name . '</li>';
			$list .= '<li>$category->slug = ' . $category->slug	 . '</li>';
			$list .= '<li>$category->term_group = ' . $category->term_group . '</li>';
			$list .= '<li>$category->term_taxonomy_id = ' . $category->term_taxonomy_id . '</li>';
			$list .= '<li>$category->taxonomy = ' . $category->taxonomy . '</li>';
			$list .= '<li>$category->description = ' . $category->description . '</li>';
			$list .= '<li>$category->parent = ' . $category->parent . '</li>';
			$list .= '<li>$category->count = ' . $category->count . '</li>';
			$list .= '<li>$category->cat_ID = ' . $category->cat_ID . '</li>';
			$list .= '<li>$category->category_count = ' . $category->category_count . '</li>';
			$list .= '<li>$category->category_description = ' . $category->category_description . '</li>';
			$list .= '<li>$category->cat_name = ' . $category->cat_name . '</li>';
			$list .= '<li>$category->category_nicename = ' . $category->category_nicename . '</li>';
			$list .= '<li>$category->category_parent = ' . $category->category_parent . '</li>';
			if (function_exists('get_terms_meta')) {
				$val = get_terms_meta($category->cat_ID, 'thumbnail');
				$val = gettype($val) === 'array' ? array_shift($val) : $val;
				$list .= '<li>thumbnail2 = ' . category_thumb_src($category) . '</li>';
			}
			*/
			//Only show categopries with thumbnail
			if (gettype(get_terms_meta($category->cat_ID, 'thumbnail')) === 'array') {
				$list .= category_item($category);
			}		
		$list .= '</li>';
		
	}
	$list .= "</ul>";
	return $list;

}

function width_x_height($size=false) {
	global $_wp_additional_image_sizes;
	if (empty($size)) {
		$size = 'category_thumb';	
	} 	
	$dimensions[0] = $_wp_additional_image_sizes[$size]['width'];
	$dimensions[1] = $_wp_additional_image_sizes[$size]['height'];	
	return implode('x', $dimensions);
}
function category_item($category) {
	$link = "<a class='category-item' href='".get_category_link($category->cat_ID)."' title=".$category->cat_name.">";
	$link .= "<div class='category-title'>".$category->cat_name."</div>";
	$link .= "<div class='category-overlay'><div class='category-description'>".$category->description."</div><img src='".category_thumb_src($category)."'/></div>";
	$link .= "</a>";
	
	return $link;	
}

function category_thumb_src($category) {
	if (function_exists('get_terms_meta')) {
		$val = get_terms_meta($category->cat_ID, 'thumbnail');
		$val = gettype($val) === 'array' ? array_shift($val) : $val;		
		
		//Separar en nom + extensio
		$dot_pos = strrpos($val , "." );
		$ext = substr($val, $dot_pos);
		$name = substr($val, 0, $dot_pos);
		//Afegir wxh a continuacio nom i concatenar extensio
			
		return $name.'-'.width_x_height('category_thumb').$ext;
	}
	return false;	
}

