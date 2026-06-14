<?php
/**
 * Almaz Theme functions and definitions
 *
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!isset($content_width)) {
    $content_width = 1920; // pixels
}

/**
 * Define Constants
 */
define('ALMAZ_THEME_DIR', get_template_directory());
define('ALMAZ_THEME_URI', get_template_directory_uri());

/**
 * Set up theme support
 */
require_once ALMAZ_THEME_DIR . '/includes/core/almaz-add-theme-support.php';
require_once ALMAZ_THEME_DIR . '/includes/core/almaz-register-sidebar.php';

/**
 * Theme Scripts & Styles
 */
require_once ALMAZ_THEME_DIR . '/includes/core/almaz-scripts-styles.php';

/**
 * Default blog functions
 */
require_once ALMAZ_THEME_DIR . '/includes/core/blog/almaz-post-thumbnail.php';
require_once ALMAZ_THEME_DIR . '/includes/core/blog/almaz-entry-footer.php';
require_once ALMAZ_THEME_DIR . '/includes/core/blog/almaz-posted-by.php';
require_once ALMAZ_THEME_DIR . '/includes/core/blog/almaz-posted-on.php';
require_once ALMAZ_THEME_DIR . '/includes/core/blog/almaz-comment-count.php';

/**
 * Create almaz theme admin menu
 */
require_once ALMAZ_THEME_DIR . '/includes/core/almaz-admin-menu.php';

/**
 * Load to the admin panel the WordPress widget almaz
 */
require_once ALMAZ_THEME_DIR . '/includes/core/almaz-welcome-wp-dashboard-widgets.php';

/**
 * AWS AMAZON autoloader + demo-data
 */
require ALMAZ_THEME_DIR . '/includes/core/almaz-aws-demo-data.php';

/**
 * Интегрируем в тему import
 */
require_once ALMAZ_THEME_DIR . '/includes/vendor/hashthemes-demo-importer/hashthemes-demo-importer.php';

require_once ALMAZ_THEME_DIR . '/includes/core/almaz-demo-import.php';

require_once ALMAZ_THEME_DIR . '/includes/core/almaz-free-starter-sites.php';


/**
 * Объявляем поддержку woocommerce
 */
if ( class_exists( 'WooCommerce' ) ) {
function almaz_theme_add_woocommerce_support () {
    add_theme_support( 'woocommerce', array(
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 3,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ) );

    add_theme_support ('wc-product-gallery-zoom');
    add_theme_support ('wc-product-gallery-lightbox');
    add_theme_support ('wc-product-gallery-slider');
}
add_action ('after_setup_theme', 'almaz_theme_add_woocommerce_support');

/**
 * Подключаем свой файл стилей css для woocommerce
 */
function almaz_theme_woocommerce_scripts_styles()
{
    wp_enqueue_style( 'almaz-theme-woocommerce-style', get_template_directory_uri() . '/includes/compatibility/woocommerce/css/almaz-woocommerce-style.css', '' );
}
add_action('wp_enqueue_scripts', 'almaz_theme_woocommerce_scripts_styles');
}

/**
 * Подключаем свой файл стилей css для админки wp
 */
function almaz_theme_load_admin_style() 
{
wp_enqueue_style( 'almaz-theme-admin-css', get_template_directory_uri() . '/includes/css/admin.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'almaz_theme_load_admin_style' );

/**
 * Load theme updater functions
 */
require ALMAZ_THEME_DIR . '/includes/core/updater/update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://almazwptemplates.ru/download/almaz-theme.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'almaz-theme'
);

//
if( ! class_exists( 'Plugin_Usage_Tracker') ) {
	require_once ALMAZ_THEME_DIR . '/includes/core/updater/class-plugin-usage-tracker.php';
}
if( ! function_exists( 'Almaz_start_plugin_tracking' ) ) {
	function Almaz_start_plugin_tracking() {
		$wisdom = new Plugin_Usage_Tracker(
			__FILE__,
			'https://almazweb.company/',
			array(),
			false,
			false,
			1
		);
	}
	Almaz_start_plugin_tracking();
}

function BrizyAuthorSupportURL() {
	return 'https://almazweb.company/support/';
}
add_filter( 'brizy_support_url', 'BrizyAuthorSupportURL' );


function BrizyAuthorUpgradeToProAff() {
	return 'https://www.brizy.io/account/aff/go/timur_taveev';
}
add_filter( 'brizy_upgrade_to_pro_url', 'BrizyAuthorUpgradeToProAff' );