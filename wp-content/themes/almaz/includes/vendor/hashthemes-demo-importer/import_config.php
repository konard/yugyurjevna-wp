<?php

/*
 * Config file with each demo data
 */

$square = array(
    'main' => array(
        'name' => 'Square - Customizer Demo',
        'external_url' => 'https://hashthemes.com/import-files/square/main.zip',
        'image' => 'https://hashthemes.com/import-files/square/screen/square.jpg',
        'preview_url' => 'https://demo.hashthemes.com/square',
        'options_array' => array('sfm_settings'),
        'menu_array' => array(
            'primary' => 'Primary Menu'
        ),
        'home_slug' => 'home-page',
        'blog_slug' => 'blog',
        'plugins' => array(
            'simple-floating-menu' => array(
                'name' => 'Simple Floating Menu',
                'source' => 'wordpress',
                'file_path' => 'simple-floating-menu/simple-floating-menu.php',
            ),
            'contact-form-7' => array(
                'name' => 'Contact Form 7',
                'source' => 'wordpress',
                'file_path' => 'contact-form-7/wp-contact-form-7.php'
            ),
        )
    )
);

$active_theme = str_replace('-', '_', get_option('stylesheet'));

if (isset($$active_theme)) {
    $demo_array = $$active_theme;
} else {
    $demo_array = array();
}

return apply_filters('hdi_import_files', $demo_array);
