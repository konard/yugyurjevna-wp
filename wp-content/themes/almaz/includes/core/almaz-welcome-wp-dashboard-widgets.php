<?php
/**
 * Load to the admin panel the WordPress widget almaz
 */
 
 /**
function almaz_theme_info_welcome_dashboard_widgets()
{
    echo __('Hello', 'almaz-theme');
}

function almaz_theme_add_welcome_dashboard_widgets()
{
    add_meta_box('almaz_theme_welcome_dashboard_widgets', __('Almaz theme', 'almaz-theme'), 'almaz_theme_info_welcome_dashboard_widgets', 'dashboard', 'normal', 'high');
}

add_action('wp_dashboard_setup', 'almaz_theme_add_welcome_dashboard_widgets');
 */