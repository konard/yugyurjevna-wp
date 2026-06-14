<?php

/**
 * Определить функциональность интернационализации
 *
 * Загружает и определяет файлы интернационализации для этого плагина
 * чтобы он был готов к переводу.
 *
 * @link       https://almazweb.company/
 * @since      1.0.0
 *
 * @package    Almaz_Premium_Sites
 * @subpackage Almaz_Premium_Sites/includes
 */

/**
 * Определите функциональность интернационализации.
 *
 * Загружает и определяет файлы интернационализации для этого плагина
 * чтобы он был готов к переводу.
 *
 * @since      1.0.0
 * @package    Almaz_Premium_Sites
 * @subpackage Almaz_Premium_Sites/includes
 * @author     AlmazWeb.Company <almazweb.company@mail.ru>
 */
class Almaz_Premium_Sites_i18n {


	/**
     * Загрузите текстовый домен плагина для перевода.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'almaz-premium-sites',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
