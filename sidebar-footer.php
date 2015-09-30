<?php
global $theme_sidebars;
$places = array();
foreach ($theme_sidebars as $sidebar){
    if ($sidebar['group'] !== 'footer')
        continue;
    $widgets = theme_get_dynamic_sidebar_data($sidebar['id']);
    if (!is_array($widgets) || count($widgets) < 1)
        continue;
    $places[$sidebar['id']] = $widgets;
}
$place_count = count($places);
$needLayout = ($place_count > 1);
if (theme_get_option('theme_override_default_footer_content')) {
    if ($place_count > 0) {
        $centred_begin = '<div class="mmb-center-wrapper"><div class="mmb-center-inner">';
        $centred_end = '</div></div><div class="clearfix"> </div>';
        if ($needLayout) { ?>
<div class="mmb-content-layout">
    <div class="mmb-content-layout-row">
        <?php 
        }
        foreach ($places as $widgets) { 
            if ($needLayout) { ?>
            <div class="mmb-layout-cell mmb-layout-cell-size<?php echo $place_count; ?>">
            <?php 
            }
            $centred = false;
            foreach ($widgets as $widget) {
                 $is_simple = ('simple' == $widget['style']);
                 if ($is_simple) {
                     $widget['class'] = implode(' ', array_merge(explode(' ', theme_get_array_value($widget, 'class', '')), array('mmb-footer-text')));
                 }
                 if (false === $centred && $is_simple) {
                     $centred = true;
                     echo $centred_begin;
                 }
                 if (true === $centred && !$is_simple) {
                     $centred = false;
                     echo $centred_end;
                 }
                 theme_print_widget($widget);
            } 
            if (true === $centred) {
                echo $centred_end;
            }
            if ($needLayout) {
           ?>
            </div>
        <?php 
            }
        } 
        if ($needLayout) { ?>
    </div>
</div>
        <?php 
        }
    }
?>
<div class="mmb-footer-text">
<?php
global $theme_default_options;
echo do_shortcode(theme_get_option('theme_override_default_footer_content') ? theme_get_option('theme_footer_content') : theme_get_array_value($theme_default_options, 'theme_footer_content'));
} else { 
?>
<div class="mmb-footer-text">
<?php theme_ob_start() ?>
  
<p><a class="footer-link" href="#">Crèdits</a> | <a class="footer-link" href="#">Contacte</a></p>
<div id="foot_link_contents">
	<div>
		<address>
			<label>Disseny i desenvolupament</label>
			<p>Jordi Cruells Cullell</p>
		</address>
		<address>
			<label>Il·lustració logo</label>
			<p>Marcos Ferré Blanco</p>
		</address>
        <address>
			<label>Altres dibuixos</label>
			<p>Àngels Casas Serrano</p>
		</address>
	</div>
	<div>
		<address>
			<label>Email</label>
			<p><a href="mailto:contacte@mondemusica.com">contacte@mondemusica.com</a></p>
			<label>Telèfon</label>
			<p><a href="tel:34659821913">659.82.19.13</a></p>
		</address>
	</div>
</div>

<?php //<p>Copyright © 2014. All Rights Reserved.</p> ?>

<?php echo do_shortcode(theme_ob_get_clean()) ?>
<?php } ?>

</div>
