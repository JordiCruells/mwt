<?php global $wp_locale;
if (isset($wp_locale)) {
	$wp_locale->text_direction = 'ltr';
} ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset') ?>" />
<title>

<?php wp_title( '|', true, 'right' ); ?>

</title>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width" />
<!--[if lt IE 9]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<?php /*<link href='http://fonts.googleapis.com/css?family=Montserrat+Alternates|Istok+Web|Happy+Monkey|Bree+Serif|Bowlby+One|Capriola|Acme|Averia+Sans+Libre|Annie+Use+Your+Telescope|Source+Sans+Pro|Averia+Gruesa+Libre|Noticia+Text|Patua+One|ABeeZee|Walter+Turncoat|Sniglet|Roboto+Condensed|Text+Me+One|Raleway|Purple+Purse|Cherry+Swash|Cabin|Karla|Chelsea+Market|Delius|Questrial|Changa+One|Schoolbell|Wellfleet|Mako|Miltonian|Lilita+One|Inder|Mountains+of+Christmas|Anton|Crete+Round|Kranky|Paytone+One|Fontdiner+Swanky|Arvo|Bentham|Pacifico|Short+Stack|Kite+One|Josefin+Sans|Nova+Slim|Spinnaker|Fresca|Gloria+Hallelujah|Handlee|Love+Ya+Like+A+Sister|Poiret+One|Della+Respira|Autour+One|Unkempt|Imprima' rel='stylesheet' type='text/css'> */ ?>
<?php /*<link href='http://fonts.googleapis.com/css?family=Montserrat:700|Inder' rel='stylesheet' type='text/css'> */ ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
remove_action('wp_head', 'wp_generator');
if (is_singular() && get_option('thread_comments')) {
	wp_enqueue_script('comment-reply');
}
wp_head();
?>
<?php //<script defer="defer" src="/wp-content/themes/mon_de_musica/js/mm.js?ver=3.8.3" type="text/javascript"></script> ?>
<?php /*<script src="http://mondemusica2.local/wp-content/plugins/events-manager/includes/js/events-manager-source.js" type="text/javascript"></script>
<script src="http://mondemusica2.local/wp-content/plugins/events-manager/includes/js/events-manager.js" type="text/javascript"></script>
*/ ?>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-38497486-1', 'auto');
	  ga('send', 'pageview');

	</script>

</head>
<body <?php body_class(); ?>>


<?php /* Facebook & Twitter 

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ca_ES/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

Facebook & Twitter */ ?>



<div id="mmb-main">


<?php if (theme_get_option('theme_use_deafult_menu')) { wp_nav_menu( array('theme_location' => 'primary-menu') );} 

else 

{ ?><nav class="mmb-nav navbar navbar-default">


	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-principal"><span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  
	</div>
	  
	  
	<div class="collapse navbar-collapse" id="menu-principal">
	  
    <?php
	echo theme_get_menu(array(
			'source' => theme_get_option('theme_menu_source'),
			'depth' => theme_get_option('theme_menu_depth'),
			'menu' => 'primary-menu',
			'class' => 'mmb-hmenu'
		)
	);
	get_sidebar('nav'); 
?> 
<a class="mmb-facebook-tag-icon" target="_blank" title="Facebook Món de música" href="https://www.facebook.com/pages/M%c3%b3n-de-M%c3%basica/381756028576254"></a>
<a class="mmb-youtube-tag-icon" target="_blank" title="YoutTube Àngels Casas" href="http://www.youtube.com/user/Lirilitas?feature=watch"></a>


</div>
<?php if ( dynamic_sidebar('submenu') ) : else : endif; ?>
    </nav><?php } ?>



<div class="page-container container">

	<div class="left-container"></div>
	<div class="right-container"></div>

<?php if(theme_has_layout_part("header")) : ?>
<header class="mmb-header<?php echo (theme_get_option('theme_header_clickable') ? ' clickable' : ''); ?>"><?php get_sidebar('header'); ?>

<?php if ( dynamic_sidebar('outline-1') ) : else : endif; ?>	
<?php if ( dynamic_sidebar('outline-2') ) : else : endif; ?>	
</header>
<?php endif; ?>
	

<?php if ( dynamic_sidebar('sections') ) : else : endif; ?>	

	
<div class="mmb-sheet clearfix">


<?php /*
<div class="mmb-pageslider">

     <div class="mmb-shapes">
            </div>
<div class="mmb-slider mmb-slidecontainerpageslider" data-width="980" data-height="250">
    <div class="mmb-slider-inner">
<div class="mmb-slide-item mmb-slidepageslider0">


</div>
<div class="mmb-slide-item mmb-slidepageslider1">


</div>

    </div>
</div>
<div class="mmb-slidenavigator mmb-slidenavigatorpageslider" data-left="1" data-top="1">
<a href="#" class="mmb-slidenavigatoritem"></a><a href="#" class="mmb-slidenavigatoritem"></a>
</div>


</div>

*/?>
<?php 
	/*if (is_home()) {
		echo do_shortcode("[metaslider id=480]"); 
	}*/
	
?>


<div class="mmb-layout-wrapper">
                <div class="mmb-content-layout">
                    <div class="mmb-content-layout-row">
                        <?php 
						get_sidebar(); ?>
                        <div class="mmb-layout-cell mmb-content <?php echo hasSecondarySidebar() ? "col-md-6 col-sm-9 col-xs-12 col-xs-pull-12" : "col-md-9 col-sm-9 col-xs-12 col-xs-pull-12"; ?>">
