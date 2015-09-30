<?php 
class FacebookLikeBox extends WP_Widget {
	function FacebookLikeBox(){
		$widget_ops = array('classname'=>'fb_like_box', 'description'=>'Facebook');
		$this->WP_Widget('FacebookLikeBox', 'Facebook', $widget_ops);
	}
	function widget($args, $instance){
	
		/*echo $before_widget;
		$output = '<div id="fb_like_box" class="mmb-block xs-invisible hidden-xs hidden-sm widget fb_like_box clearfix"><div class="mmb-blockheader"><h3 class="t">Facebook</h3></div><div id="fbHolder" class="mmb-blockcontent"><p>Carregant...</p></div></div>';
		echo $output . $after_widget;		*/
		
		$output = '<div id="fb_like_box" class="xs-invisible hidden-xs hidden-sm widget fb_like_box clearfix"><div class="mmb-vmenublockheader"><h3 class="t">facebook</h3></div><div id="fbHolder" class="mmb-blockcontent"><p>Carregant...</p></div></div>';
		echo $args['before_widget'].$output.$args['after_widget'];
	}
	
	function update($new_instance,$old_instance){
		
		return $old_instance;
	}
	
	function form($instance) {
		$instance=wp_parse_args( (array) $instance, array('title' => 'Facebook'));
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $instance['title'];?>" /></p>
		<?php
	}
}

function fb_like_box_init(){
	register_widget('FacebookLikeBox');
}

add_action('widgets_init', 'fb_like_box_init');