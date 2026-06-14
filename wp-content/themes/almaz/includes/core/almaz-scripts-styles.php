<?php
/**
 * Theme Scripts & Styles
 */
if (!function_exists('almaz_theme_scripts_styles')) {
    function almaz_theme_scripts_styles()
    {
        wp_enqueue_style('brizy-starter-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
}
add_action('wp_enqueue_scripts', 'almaz_theme_scripts_styles');