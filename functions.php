<?php 

function theme_404_content_cat($args = '') {
    $args = wp_parse_args($args, array(
        'error_title' => __('Pàgina no trobada', THEME_NS),
        'error_message' => __('No s\'ha trobat la pàgina que busques. Vols provar a cercar alguna cosa ?', THEME_NS),
        'focus_script' => '<script type="text/javascript">jQuery(\'div.mmb-content input[name="s"]\').focus();</script>'
            )
    );
    extract($args);
    theme_post_wrapper(
            array(
                'title' => $error_title,
                'content' => '<p class="center">' . $error_message . '</p>' . "\n" . theme_get_search() . $focus_script
            )
    );

    if (theme_get_option('theme_show_random_posts_on_404_page')) {
        theme_ob_start();
        echo '<h4 class="box-title">' . theme_get_option('theme_show_random_posts_title_on_404_page') . '</h4>';
        ?>
        <ul>
        <?php
        global $post;
        $rand_posts = get_posts('numberposts=5&orderby=rand');
        foreach ($rand_posts as $post) :
            ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endforeach; ?>
        </ul>
        <?php
        theme_post_wrapper(array('content' => theme_ob_get_clean()));
    }
    if (theme_get_option('theme_show_tags_on_404_page')) {
        theme_ob_start();
        echo '<h4 class="box-title">' . theme_get_option('theme_show_tags_title_on_404_page') . '</h4>';
        wp_tag_cloud('smallest=9&largest=22&unit=pt&number=200&format=flat&orderby=name&order=ASC');
        theme_post_wrapper(array('content' => theme_ob_get_clean()));
    }
}

function theme_get_metadata_icons($icons = '', $class = '') {
    global $post;
    if (!is_string($icons) || theme_strlen($icons) == 0)
        return;
    $icons = explode(",", str_replace(' ', '', $icons));
    if (!is_array($icons) || count($icons) == 0)
        return;
    $result = array();
    for ($i = 0; $i < count($icons); $i++) {
        $icon = $icons[$i];
        switch ($icon) {
            case 'date':
                $result[] = '<span class="mmb-postdateicon">' . sprintf(__('<span class="%1$s"></span> %2$s', THEME_NS),
                                'date',
                                sprintf( '<span class="entry-date" title="%1$s">%2$s</span>',
                                    esc_attr( get_the_time() ),
                                    get_the_date()
                                )
                            ) . '</span>';
            break;
            case 'author':
                $result[] = '<span class="mmb-postauthoricon">' . sprintf(__('<span class="%1$s">By</span> %2$s', THEME_NS),
                                'author',
                                sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                                    get_author_posts_url( get_the_author_meta( 'ID' ) ),
                                    sprintf( esc_attr(__( 'View all posts by %s', THEME_NS )), get_the_author() ),
                                    get_the_author()
                                )
                        ) . '</span>';
                break;
            case 'category':
                $categories = get_the_category_list(', ');
                if (theme_strlen($categories) == 0)
                    break;
                $result[] = '<span class="mmb-postcategoryicon">' . sprintf(__('<span class="%1$s">Posted in</span> %2$s', THEME_NS), 'categories', get_the_category_list(', ')) . '</span>';
                break;
            case 'tag':
                $tags_list = get_the_tag_list('', ', ');
                if (!$tags_list)
                    break;
                $result[] = '<span class="mmb-posttagicon">' . sprintf(__('<span class="%1$s">Tagged</span> %2$s', THEME_NS), 'tags', $tags_list) . '</span>';
                break;
            case 'comments':
                if (!comments_open() || !theme_get_option('theme_allow_comments'))
                    break;
                theme_ob_start();
                comments_popup_link(__('Leave a comment', THEME_NS), __('1 Comment', THEME_NS), __('% Comments', THEME_NS));
                $result[] = '<span class="mmb-postcommentsicon">' . theme_ob_get_clean() . '</span>';
                break;
            case 'edit':
                if (!current_user_can('edit_post', $post->ID))
                    break;
                theme_ob_start();
                edit_post_link(__('Edit', THEME_NS), '');
                $result[] = '<span class="mmb-postediticon">' . theme_ob_get_clean() . '</span>';
                break;
        }
    }
    $result = implode(theme_get_option('theme_metadata_separator'), $result);
    if (theme_is_empty_html($result))
        return;
    return "<div class=\"mmb-post{$class}icons mmb-metadata-icons\">{$result}</div>";
}


//Apply .thumbnail class to WP avatars
add_filter('get_avatar', 'change_avatar_css');

function change_avatar_css($class) {
	//$class = str_replace('class="', 'class="img-circle img-thumbnail ', $class);
    $class = str_replace('class="', 'class="img-responsive ', $class);
	return $class;
}

function hasSecondarySidebar() {

	//Determino si s'ha de mostrar el 2on sidebar a la variable secondary
	global $post;;
	
	// Pagina home 2 barres laterals
	if (is_home()) return true;
	
	//Pagines que explicitament no han de mostrar segona barra
	$only_primary_sidebar_posts = array(73 /*Categoria cançons */); 
	if (in_array($post->ID, $only_primary_sidebar_posts)) return false;
	
	// Resta de casos:
	// es mostra la barra secundaria per defecte sempre excepte per $secondary = 0 (es a dir si esta deshabilitada al template de la pagina)
	$secondary  = get_post_meta($post->ID, '_theme_layout_template_secondary_sidebar', $single = true);
	$secondary = ($secondary == "0") ? false : true; 
	return $secondary;
}


//Cridant aquesta funcio en comptes de theme_get_next_post, si el tema te un thumbnail nomes mostrarem un extracte
function theme_get_next_excerpt() {
    static $ended = false;
    if (!$ended) {
        if (have_posts()) {

			the_post();
			if (has_post_thumbnail()) {
				get_template_part('excerpt', get_post_format());
			} else {
				get_template_part('content', get_post_format());
			}
        } else {
            $ended = true;
        }
    }
}

function mm_custom_scripts() {

	wp_deregister_script('jquery');
	wp_deregister_script('jquery-ui');
	wp_deregister_script('jquery-ui-core');
	wp_deregister_script('jquery-ui-widget');
	wp_deregister_script('jquery-ui-position');
	wp_deregister_script('jquery-ui-mouse');
	wp_deregister_script('jquery-ui-sortable');
	wp_deregister_script('jquery-ui-datepicker');
	wp_deregister_script('jquery-ui-menu');
	wp_deregister_script('jquery-ui-autocomplete');
	wp_deregister_script('jquery-ui-ui.resizable');
	wp_deregister_script('jquery-ui-ui.draggable');
	wp_deregister_script('jquery-ui-ui.button');
	wp_deregister_script('jquery-ui-dialog');	
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js');
	
	//<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	
	wp_enqueue_script('jqueryui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js');
	//wp_enqueue_script('jqueryui', get_stylesheet_directory_uri().'/js/jquery-ui-1.10.4.custom.min.js');

	
	// Loads Bootstrap minified JavaScript file.
	wp_enqueue_script('bootstrapjs', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js', array('jquery'),'3.0.0');
	
	
	//wp_enqueue_script('events', 'http://mondemusica2.local/wp-content/plugins/events-manager/includes/js/events-manager.js', array('jquery','jqueryui'),'5.52');
	
	// Loads Bootstrap minified CSS file.
	wp_enqueue_style('bootstrapwp', '//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css', false ,'3.0.0');
	// Loads our main stylesheet.
	wp_enqueue_script('mm', get_stylesheet_directory_uri().'/js/mm.js', array('jquery','bootstrapjs'));	
}

add_action('wp_enqueue_scripts', 'mm_custom_scripts');


/* Botons Google plus, Twitter i Facebook */
//add_action ('wp_enqueue_scripts','google_plus_script');
function google_plus_script() {
	wp_enqueue_script('google-plus', 'https://apis.google.com/js/plusone.js', array(), null);
}

function social_buttons ($content) {
//if (is_single()) {
$content .= '<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>';
$content .= '<g:plusone size="tall" href="'.get_permalink().'"></g:plusone>';
$content .= '<a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-lang="ca">Tweet</a>';
//}
  return $content;
}
//add_filter("the_content", "social_buttons");

function facebook_meta_tags_posts() {
	if(is_single()) {
		global $post;
		$content = $post->post_content;
		$images = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
		$image = $matches [1] [0];
		if (!$image)
		  $image = 'HTTP://YOUR DEFAULT IMAGE LOCATION HERE';
		?>
		<meta property="og:title" content="<?php the_title(); ?>"/>
		<meta property="og:description" content="<?php echo get_post_meta($post->ID, 'thesis_description', true) ?>"/>
		<meta property="og:url" content="<?php the_permalink(); ?>"/>
		<meta property="og:image" content="<?php echo $image; ?>"/>
		<meta property="og:type" content="article"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
<?php }
}
add_action('wp_head', 'facebook_meta_tags_posts');


/*Filtrar els posst de la categoria Cançons de l'arxiu */
add_filter( 'getarchives_where', 'customarchives_where' );
add_filter( 'getarchives_join', 'customarchives_join' );
function customarchives_join( $x ) {
	global $wpdb;
	return $x . " INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)";
}
function customarchives_where( $x ) {
	global $wpdb;
	$exclude = '3'; // category id to exclude
	return $x . " AND $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.term_id NOT IN ($exclude)";
}
/* Fi filtre */


include "widgets/AuthorProfile.php";
include "widgets/FacebookLikeBox.php";
include "widgets/CategoriesThumbs.php";
//include "widgets/Outline.php";


function hidden_submenu_init() {

    register_sidebar( array(
		'name' => 'Hidden Submenu Area',
		'id' => 'submenu',
		'before_widget' => '<div class="hidden-submenu">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="t" style="margin-bottom: 10px;">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'hidden_submenu_init' );


/* Afegir area de widget a sota del header */
function below_header_init() {

    register_sidebar( array(
		'name' => 'After Header Widget Area',
		'id' => 'sections',
		'before_widget' => '<div class="seccions">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="t" style="margin-bottom: 10px;">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'below_header_init' );

/* Afegir area de widget a la zona central de la capçalera */
function outline1_init() {

    register_sidebar( array(
        'name' => 'Header Outline Widget Area 1',
        'id' => 'outline-1',
        'before_widget' => '<div class="destacat-1">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ) );
}
/* Afegir area de widget a la zona central de la capçalera */
function outline2_init() {

    register_sidebar( array(
        'name' => 'Header Outline Widget Area 2',
        'id' => 'outline-2',
        'before_widget' => '<div class="destacat-2">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ) );
}

add_action( 'widgets_init', 'outline1_init' );
add_action( 'widgets_init', 'outline2_init' );


/* Totes les imatges del contingut responsives */
function add_image_responsive_class($content) {
   global $post;
   $pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
   $replacement = '<img$1class="$2 img-responsive"$3>';
   $content = preg_replace($pattern, $replacement, $content);
   return $content;
}
add_filter('the_content', 'add_image_responsive_class');


/*Mostrar thumbs ajustats a ample de contenidor */
add_filter('post_thumbnail_html','add_img_thumbnail_class');
function add_img_thumbnail_class($thumb) {
	//if( is_single() ) 
	$thumb = str_replace('class="', 'class="img-thumbnail ', $thumb);
	return $thumb;
}

//Elimina els <p> que afegeix el WP automaticament en els posts i pagines
remove_filter( 'the_content', 'wpautop' );

function html_widget_title( $title ) {
    /*
    //HTML tag opening/closing brackets
    $title = str_replace( '[', '<', $title );
    $title = str_replace( '[/', '</', $title );
    // bold -- changed from 's' to 'strong' because of strikethrough code
    $title = str_replace( 'strong]', 'strong>', $title );
    $title = str_replace( 'b]', 'b>', $title );
    // italic
    $title = str_replace( 'em]', 'em>', $title );
    $title = str_replace( 'i]', 'i>', $title );
    // underline
    // $title = str_replace( 'u]', 'u>', $title ); // could use this, but it is deprecated so use the following instead
    $title = str_replace( '<u]', '<span style="text-decoration:underline;">', $title );
    $title = str_replace( '</u]', '</span>', $title );
    // superscript
    $title = str_replace( 'sup]', 'sup>', $title );
    // subscript
    $title = str_replace( 'sub]', 'sub>', $title );
    // del
    $title = str_replace( 'del]', 'del>', $title ); // del is like strike except it is not deprecated, but strike has wider browser support -- you might want to replace the following 'strike' section to replace all with 'del' instead
    // strikethrough or <s></s>
    $title = str_replace( 'strike]', 'strike>', $title );
    $title = str_replace( 's]', 'strike>', $title ); // <s></s> was deprecated earlier than so we will convert it
    $title = str_replace( 'strikethrough]', 'strike>', $title ); // just in case you forget that it is 'strike', not 'strikethrough'
    // tt
    $title = str_replace( 'tt]', 'tt>', $title ); // Will not look different in some themes, like Twenty Eleven -- FYI: http://reference.sitepoint.com/html/tt
    // marquee
    $title = str_replace( 'marquee]', 'marquee>', $title );
    // blink
    $title = str_replace( 'blink]', 'blink>', $title ); // only Firefox and Opera support this tag

    */
    // wtitle1 (to be styled in style.css using .wtitle1 class)
    $title = str_replace( '[wtitle1]', '<span class="wtitle1">', $title );
    $title = str_replace( '[/wtitle1]', '</span>', $title );
    // wtitle2 (to be styled in style.css using .wtitle2 class)
    $title = str_replace( '[wtitle2]', '<span class="wtitle2">', $title );
    $title = str_replace( '[/wtitle2]', '</span>', $title );

    return $title;
}

add_filter( 'widget_title', 'html_widget_title' );

?>
