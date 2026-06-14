<?php

/**
 * Административный функционал плагина.
 *
 * @link       https://almazweb.company/
 * @since      1.0.0
 *
 * @package    Almaz_Premium_Sites
 * @subpackage Almaz_Premium_Sites/admin
 */

/**
 * Функциональность плагина, специфичная для администратора.
 *
 * Определяет имя плагина, версию и два примера хуков для того, как
 * поставить в очередь специфичную для администратора таблицу стилей и JavaScript.
 *
 * @package    Almaz_Premium_Sites
 * @subpackage Almaz_Premium_Sites/admin
 * @author     AlmazWeb.Company <almazweb.company@mail.ru>
 */
class Almaz_Premium_Sites_Admin {

	/**
	 * ID этого плагина.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Версия этого плагина.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Инициализируйте класс и установите его свойства.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
	}

	/**
	 * Зарегистрируйте таблицы стилей для административной области.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * Эта функция предназначена только для демонстрационных целей.
		 *
	 	 * Экземпляр этого класса должен быть передан в функцию run()
		 * определено в Almaz_Premium_Sites_Loader, так как определены все хуки
		 * в этом конкретном классе.
		 *
		 * Затем Almaz_Premium_Sites_Loader создаст связь
		 * между определенными хуками и функциями, определенными в этом
		 * сорт.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/almaz-premium-sites-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Зарегистрируйте JavaScript для админки.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * Эта функция предназначена только для демонстрационных целей.
		 *
		 * Экземпляр этого класса должен быть передан в функцию run()
		 * определено в Almaz_Premium_Sites_Loader, так как определены все хуки
		 * в этом конкретном классе.
		 *
		 * Затем Almaz_Premium_Sites_Loader создаст связь
		 * между определенными хуками и функциями, определенными в этом
		 * сорт.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/almaz-premium-sites-admin.js', array( 'jquery' ), $this->version, false );

	}

}
