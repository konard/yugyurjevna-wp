<?php
/**
  * загрузите наш пользовательский апдейтер
  * 
  * 
 */
if ( ! class_exists( 'Almaz_Premium_Sites_Plugin_Updater' ) ) {
	include dirname( ALMAZ_PREMIUM_SITES_PLUGIN_FILE ) . '/admin/updater/class-almaz-premium-sites-updater.php';
}

/**
  * Инициализировать программу обновления. Подключен к `init` для работы с
  * Задание cron wp_version_check, разрешающее автообновления.
  *
 */
function almaz_premium_sites_plugin_updater() {
	// Для поддержки автоматических обновлений это должно выполняться во время задания cron wp_version_check для привилегированных пользователей.
	$doing_cron = defined( 'DOING_CRON' ) && DOING_CRON;
	if ( ! current_user_can( 'manage_options' ) && ! $doing_cron ) {
		return;
	}

	// получить наш лицензионный ключ из БД
	$license_key = trim( get_option( 'almaz_premium_sites_license_key' ) );

	// настроить программу обновления
	$edd_updater = new Almaz_Premium_Sites_Plugin_Updater(
		ALMAZ_PREMIUM_SITES_STORE_URL,
		ALMAZ_PREMIUM_SITES_PLUGIN_FILE,
		array(
			'version' => ALMAZ_PREMIUM_SITES_VERSION,   // текущий номер версии
			'license' => $license_key,             		// лицензионный ключ (использовал get_option выше для извлечения из БД)
			//'item_name'     => ALMAZ_PREMIUM_SITES_ITEM_NAME, 	// name of this plugin
			'item_id' => ALMAZ_PREMIUM_SITES_ITEM_ID,   // ID продукта
			'author'  => 'AlmazWeb.Company',      		// автор этого плагина
			'beta'    => false,
		)
	);
}
add_action( 'init', 'almaz_premium_sites_plugin_updater' );