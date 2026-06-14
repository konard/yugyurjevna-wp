<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        ['parent-style']
    );
});


add_action('wp_enqueue_scripts', function () {
    $path = get_stylesheet_directory() . '/assets/js/app.js';

    wp_enqueue_script(
        'child-theme-script',
        get_stylesheet_directory_uri() . '/assets/js/app.js',
        [], // зависимости (например ['jquery'])
        filemtime($path),
        true // в footer
    );
});


add_action('after_setup_theme', function () {
    register_nav_menus([
        'mobile_menu' => 'Mobile Menu',
    ]);
});


add_shortcode('my_shortcode', function ($atts, $content = null) {
    $atts = shortcode_atts([
        'title' => 'Default title',
    ], $atts);

    
    ob_start();
?>


    <!-- Header Mobile -->
    <header id="MobileHeader" class="header-mobile">
        <div class="header-mobile-container">
            <nav class="mobile-menu-container">
                <?php
                wp_nav_menu([
                    'theme_location' => 'mobile_menu',
                    'container' => false,
                    'menu_class' => 'menu mobile-menu',
                    'menu_id' => 'desktop_menu',
                    'walker' => new Mobile_Menu_Walker()
                ]);
                ?>
            </nav>

            
        </div>
    </header>

<?php

    return ob_get_clean();
});






class Mobile_Menu_Walker extends Walker_Nav_Menu
{
  private $parent_titles = [];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $indent = str_repeat("\t", $depth);
    $parent_title = end($this->parent_titles);

    $output .= "\n$indent<div class=\"mobile-submenu-container\">\n";
    $output .= "$indent\t<ul class=\"sub-menu mobile-submenu\">\n";
    if ($parent_title) {
      $output .= "$indent\t\t<li class=\"submenu-header\"><a href=\"#\" class=\"back-link\">$parent_title</a></li>\n";
    }
  }

  function end_lvl(&$output, $depth = 0, $args = null)
  {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent\t</ul>\n$indent</div>\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $indent = ($depth) ? str_repeat("\t", $depth) : '';
    $classes = empty($item->classes) ? [] : (array)$item->classes;
    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
    $class_names = ' class="' . esc_attr($class_names) . '"';

    $output .= $indent . '<li' . $class_names . '>';

    $atts = [];
    $atts['href'] = !empty($item->url) ? $item->url : '';
    $attributes = '';
    foreach ($atts as $attr => $value) {
      $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
    }

    $title = apply_filters('the_title', $item->title, $item->ID);

    if (in_array('menu-item-has-children', $classes)) {
      $this->parent_titles[] = $title;
      $output .= '<a' . $attributes . ' class="has-submenu">' . $title . '</a>';
    } else {
      $output .= '<a' . $attributes . '>' . $title . '</a>';
    }
  }

  function end_el(&$output, $item, $depth = 0, $args = null)
  {
    $output .= "</li>\n";
    $classes = empty($item->classes) ? [] : (array)$item->classes;
    if (in_array('menu-item-has-children', $classes)) {
      array_pop($this->parent_titles);
    }
  }
}


add_shortcode('mobile_menu_trigger', function () {
    return '<div id="MobileMenuTrigger" class="mobile-menu-trigger">
                <div></div>
            </div>';
});


opcache_reset();