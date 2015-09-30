<?php 
class Outline extends WP_Widget {
	function Outline(){
		$widget_ops = array('classname'=>'outline hidden-xs', 'description'=>'Destacat');
		$this->WP_Widget('Outline', 'Destacat', $widget_ops);
	}
	function widget($args, $instance){
	
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if(!empty($title)) echo $before_title . $title . $after_title;
		$output = outputHtml();
		echo $output . $after_widget;	
	
	}
	
	function update($new_instance,$old_instance){
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;	
	
	}
	
	function form($instance) {
		$instance=wp_parse_args( (array) $instance, array('title' => 'Destacat'));
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?> </label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $instance['title'];?>" /></p>
		<textarea id="intro"></textarea>
		<?php

		$settings = array(
		    'textarea_name' => 'content',
		    'media_buttons' => false,
		    'tinymce' => array(
		        'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
		            'bullist,blockquote,|,justifyleft,justifycenter' .
		            ',justifyright,justifyfull,|,link,unlink,|' .
		            ',spellchecker,wp_fullscreen,wp_adv'
		    )
		);
		//wp_editor( '', 'content');
		wp_editor( 'content', 'content', array( 'textarea_name' => $this->get_field_id( 'content' ), ) );

		/*$editor_settings =  array (
            'textarea_rows' => 15
        ,   'media_buttons' => TRUE
        ,   'teeny'         => FALSE
        ,   'tinymce'       => TRUE
        );
		 
		wp_editor( 'This is the default text!', 'editor', $editor_settings );
		submit_button( 'Save content' );*/

		/*$content = '';
		$editor_id = 'outline-editor';
		wp_editor( $content, $editor_id );*/

		/*$quicktags_settings = array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close' );
		$editor_args = array(
			'textarea_name' => 'content',
			'textarea_rows' => 10,
			'media_buttons' => true,
			'tinymce' => false,
			'quicktags' => $quicktags_settings,
		);
		wp_editor( 'This is the default text!', 'editor', $editor_args );*/
	}
}

//Afegir widget al Wordpress
function outline_init(){
	register_widget('Outline');
}
add_action('widgets_init', 'outline_init');


function outputHtml() {
	return "<p>Destacat</p>";
}

/*add_action('admin_print_scripts', 'do_jslibs' );
add_action('admin_print_styles', 'do_css' );

function do_css()
{
    wp_enqueue_style('thickbox');
}

function do_jslibs()
{
    wp_enqueue_script('editor');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('media-upload');
	add_action( 'admin_head', 'wp_tiny_mce' );
}*/

/*add_filter('admin_head','ShowTinyMCE');
function ShowTinyMCE() {
	// conditions here
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}*/

/*add_action("admin_head","load_custom_wp_tiny_mce");
function load_custom_wp_tiny_mce() {

	if (function_exists('wp_tiny_mce')) {

	  add_filter('teeny_mce_before_init', create_function('$a', '
	    $a["theme"] = "advanced";
	    $a["skin"] = "wp_theme";
	    $a["height"] = "200";
	    $a["width"] = "200";
	    $a["onpageload"] = "";
	    $a["mode"] = "exact";
	    $a["elements"] = "intro";
	    $a["editor_selector"] = "mceEditor";
	    $a["plugins"] = "safari,inlinepopups,spellchecker";

	    $a["forced_root_block"] = false;
	    $a["force_br_newlines"] = true;
	    $a["force_p_newlines"] = false;
	    $a["convert_newlines_to_brs"] = true;

	    return $a;'));

	 wp_tiny_mce(true);
	}
}*/

