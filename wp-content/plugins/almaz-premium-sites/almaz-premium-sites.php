<?php

/**
 * Загрузочный файл плагина
 *
 * Этот файл читается WordPress для создания информации о плагине в плагине.
 * административная зона. Этот файл также включает в себя все зависимости, используемые плагином,
 * регистрирует функции активации и деактивации и определяет функцию
 * который запускает плагин.
 *
 * @link              https://almazweb.company/
 * @since             1.3
 * @package           Almaz_Premium_Sites
 *
 * @wordpress-plugin
 * Plugin Name:       Almaz premium sites
 * Plugin URI:        https://almazwptemplates.ru/
 * Description:       Премиум стартовые шаблоны сайтов от команды Almazweb.Company
 * Version:           1.3
 * Author:            AlmazWeb.Company
 * Author URI:        https://almazweb.company/
 * License URI:       https://almazweb.company/license/
 * Requires PHP:      7.4
 * Text Domain:       almaz-premium-sites
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
  * 
  * 
 */ 
define( 'ALMAZ_PREMIUM_SITES_PLUGIN_FILE' , __FILE__ );

/**
  * Текущая версия плагина.
  * Начните с версии 1.0.0 и используйте SemVer - https://semver.org
  * Переименуйте это для вашего плагина и обновляйте его по мере выпуска новых версий.
 */ 
define( 'ALMAZ_PREMIUM_SITES_VERSION', '1.3' );

/**
  * Это URL-адрес, который пингует наше средство обновления/проверки лицензий. 
  * Это должен быть URL-адрес сайта с установленным EDD.
  * 
 */
define( 'ALMAZ_PREMIUM_SITES_STORE_URL', 'https://almazweb.company' ); // ВАЖНО: измените имя этой константы на уникальное, чтобы предотвратить конфликты с другими плагинами, использующими эту систему

/**
  * Идентификатор загрузки. Это идентификатор вашего продукта в EDD, который должен совпадать с идентификатором загрузки, 
  * видимым в вашем списке загрузок (см. пример ниже).
  * 
 */
define( 'ALMAZ_PREMIUM_SITES_ITEM_ID', 11 ); // ВАЖНО: измените имя этой константы на уникальное, чтобы предотвратить конфликты с другими плагинами, использующими эту систему

/**
  * название продукта в Easy Digital Downloads
  * 
  * 
 */
define( 'ALMAZ_PREMIUM_SITES_ITEM_NAME', 'Almaz premium sites' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

/**
  * название страницы настроек для отображения ввода лицензии
  * 
  * 
 */
define( 'ALMAZ_PREMIUM_SITES_PLUGIN_LICENSE_PAGE', 'almaz-premium-sites-wp-menu' );

/**
  * Код, который запускается при активации плагина.
  * Это действие задокументировано в файле include/class-almaz-premium-sites-activator.php.
  */
function activate_almaz_premium_sites() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-almaz-premium-sites-activator.php';
	Almaz_Premium_Sites_Activator::activate();
}

/**
  * Код, который запускается при деактивации плагина.
  * Это действие задокументировано в файле include/class-almaz-premium-sites-deactivator.php.
  */
function deactivate_almaz_premium_sites() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-almaz-premium-sites-deactivator.php';
	Almaz_Premium_Sites_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_almaz_premium_sites' );
register_deactivation_hook( __FILE__, 'deactivate_almaz_premium_sites' );

/**
  * Основной класс подключаемого модуля, который используется для определения интернационализации,
  * крючки для администратора и общедоступные сайты.
  */
require plugin_dir_path( __FILE__ ) . 'includes/class-almaz-premium-sites.php';

/**
  * Начинает выполнение плагина.
  *
  * Так как все внутри плагина регистрируется через хуки,
  * то запуск плагина с этого места в файле делает
  * не влияет на жизненный цикл страницы.
  *
  * @since    1.0.0
  */
function run_almaz_premium_sites() {

	$plugin = new Almaz_Premium_Sites();
	$plugin->run();

}
run_almaz_premium_sites();

/**
  * Подключаем обновление плагина
  * 
  * 
 */
require plugin_dir_path( __FILE__ ) . 'admin/updater/plugin-updater.php';
require plugin_dir_path( __FILE__ ) . 'admin/updater/plugin-updater-admin.php';

/**
  * Добавляем ссылки на страницу настроек плагина
  * 
  * 
 */
 
 // Лицензия
function almaz_premium_sites_action_links_2( $actions, $plugin_file ){
	if( false === strpos( $plugin_file, basename(__FILE__) ) )
		return $actions;

	$settings_link = '<a href="admin.php?page=almaz-premium-sites-wp-menu">' . __( 'License' , 'almaz-premium-sites' ) . '</a>'; 
	array_unshift( $actions, $settings_link ); 
	return $actions; 
}
add_filter( 'plugin_action_links', 'almaz_premium_sites_action_links_2', 10, 2 );
 
// Премиум сайты 
	function almaz_premium_sites_action_links_1( $actions, $plugin_file ){
		if( false === strpos( $plugin_file, basename(__FILE__) ) )
			return $actions;

		$settings_link = '<a href="admin.php?page=hdi-demo-importer">' . __( 'Premium sites' , 'almaz-premium-sites' ) . '</a>'; 
		array_unshift( $actions, $settings_link ); 
		return $actions; 
	}

	add_filter( 'plugin_action_links', 'almaz_premium_sites_action_links_1', 10, 2 );