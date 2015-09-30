<?php 
class AuthorProfile extends WP_Widget {
	function AuthorProfile(){
		$widget_ops = array('classname'=>'author_profile hidden-xs', 'description'=>'Descripció del meu perfil');
		$this->WP_Widget('AuthorProfile', 'Perfil d\'usuari', $widget_ops);
	}
	function widget($args, $instance){
	
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		/*if( !empty($title))
			echo $before_title . $title . $after_title;*/
			
		$id = 2; //Usuari de l'Angels
		$user = get_user_by('id',$id);
		$size = $instance['avatar_size'];
		$output = '';
		if( !empty($title)) $output .= '<div class="mmb-blockheader"><h3 class="t">'.$title.'</h3></div>';
		$output .= '<a href="'.get_permalink(761).'" title="qui sóc ?">'.get_avatar($id, $size, 'img-responsive author-img', $user->display_name).'</a>';
		//$output = userphoto($user); //Aquesta funcio es en cas de que s'activi el plugi user photo
		//$output .= '<h3>' . esc_html($user->display_name). '</h3>';
		$output .= '<p class="author-excerpt">'.wp_kses_post($user->user_description);
		
		$output .= '&nbsp;<a class="btn" href="'.get_permalink(761).'" title="llegir més ...">llegir més</a></p>';
		
		echo $output . $after_widget;	
	
	}
	
	function update($new_instance,$old_instance){
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['avatar_size'] = intval($new_instance['avatar_size']);
		return $instance;	
	
	}
	
	function form($instance) {
		$instance=wp_parse_args( (array) $instance, array('title' => 'Perfil d\'usuari', 'avatar_size' => 150));
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $instance['title'];?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e('Mida de la imatge'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('avatar_size'); ?>" name="<?php echo $this->get_field_name('avatar_size');?>" type="text" value="<?php echo esc_attr($instance['avatar_size']);?>" /></p>
		
		
		<?php
	}
}

function author_profile_init(){
	register_widget('AuthorProfile');
}

add_action('widgets_init', 'author_profile_init');