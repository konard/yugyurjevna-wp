<?php
/**
 * Set up theme support
 */
if (!function_exists('almaz_theme_setup')) {
    function almaz_theme_setup()
    {
        /**
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
        load_theme_textdomain('almaz-theme', get_template_directory() . '/languages');

        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Enable support for Post Thumbnails on posts and pages.
         */
        add_theme_support('post-thumbnails');

        /**
         * No need for default images as Brizy generates its own.
         */
        remove_image_size('medium_large');
        add_image_size('medium_large', 150, 150, true);
        remove_image_size('medium');
        add_image_size('medium', 150, 150, true);
        remove_image_size('large');
        add_image_size('large', 150, 150, true);

        /**
         * Registers multiple custom navigation menus in the new custom menu
         * editor of WordPress. This allows for the creation of custom menus
         * in the dashboard for use in your theme.
         */
        register_nav_menus(
            array(
                'primary' => __('Primary Menu', 'almaz-theme'),
                'secondary' => __('Secondary Menu', 'almaz-theme'),
                'footer' => __('Footer Menu', 'almaz-theme')
            )
        );

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        /**
         * Add support for core custom logo.
         */
        add_theme_support(
            'custom-logo',
            array(
                'height' => 150,
                'width' => 150,
                'flex-width' => true,
                'flex-height' => true,
            )
        );
    }
}
add_action('after_setup_theme', 'almaz_theme_setup');