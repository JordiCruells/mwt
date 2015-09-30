<?php
global $theme_sidebars;
$i = 0;
foreach ($theme_sidebars as $sidebar){
    if ($sidebar['group'] !== 'nav')
        continue;
    $i++;
    
	
	
	$widgets = theme_get_dynamic_sidebar_data($sidebar['id']);
    if (!is_array($widgets) || count($widgets) < 1)
        return false;
    echo "<div class=\"mmb-hmenu-extra$i\">";
    foreach ($widgets as $widget) {
        theme_print_widget($widget);
    }
	
	
	echo "<a class=\"mmb-youtube-tag-icon\" target=\"_blank\" href=\"http://www.youtube.com/user/Lirilitas?feature=watch\"></a>";
	
    echo '</div>';
    return true;
}
