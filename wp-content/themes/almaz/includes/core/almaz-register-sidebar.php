<?php
/**
 * Register theme sidebars
 */
if (!function_exists('almaz_theme_register_sidebar')) :
    function almaz_theme_register_sidebar()
    {
        register_sidebars(2, array('name' => 'Sidebar %d', 'almaz-theme'));
        register_sidebars(4, array('name' => 'Footer %d', 'almaz-theme'));
    }

    add_action('widgets_init', 'almaz_theme_register_sidebar');
endif;