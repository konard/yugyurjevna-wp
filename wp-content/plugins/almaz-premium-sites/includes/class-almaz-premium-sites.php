<?php

/**
 * Файл, определяющий основной класс плагина
 *
 * Определение класса, включающее атрибуты и функции, используемые как в
 * общедоступная часть сайта и админка.
 *
 * @link       https://almazweb.company/
 * @since      1.0.0
 *
 * @package    Almaz_Premium_Sites
 * @subpackage Almaz_Premium_Sites/includes
 */

/**
 * Основной класс плагина.
 *
 * Это используется для определения интернационализации, специфичных для администратора хуков и
 * хуки общедоступных сайтов.
 *
 * Также поддерживает уникальный идентификатор этого плагина, а также текущий
 * версия плагина.
 *
 * @since      1.0.0
 * @package    Almaz_Premium_Sites
 * @subpackage Almaz_Premium_Sites/includes
 * @author     AlmazWeb.Company <almazweb.company@mail.ru>
 */
class Almaz_Premium_Sites {

	/**
	 * Загрузчик, который отвечает за поддержку и регистрацию всех хуков, которые питают
	 * плагин.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Almaz_Premium_Sites_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
     * Уникальный идентификатор этого плагина.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
     * Текущая версия плагина.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    Текущая версия плагина.
	 */
	protected $version;

	/**
	 * Определите основные функции плагина.
	 *
	 * Установите имя плагина и версию плагина, которые можно использовать во всем плагине.
	 * Загрузите зависимости, определите локаль и установите крючки для области администрирования и
   	 * общедоступная часть сайта.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ALMAZ_PREMIUM_SITES_VERSION' ) ) {
			$this->version = ALMAZ_PREMIUM_SITES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'almaz-premium-sites';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();	


	// скрываем Подробнее в описании плагина
	add_filter('plugin_row_meta', 'almaz_premium_sites_hide_view_details', 10, 4);

	function almaz_premium_sites_hide_view_details($plugin_meta, $plugin_file, $plugin_data, $status)
	{
		// Проверяем по имени файла — самый надёжный способ
		if ($plugin_file === 'almaz-premium-sites/almaz-premium-sites.php') {
			if (isset($plugin_meta[2])) {
				unset($plugin_meta[2]);
			}
		}

		return $plugin_meta;
	}


	/**
	 * Подключаем систему лицензирования для плагина Brizy Pro
	 */
	function BrizyAuthorLicenseActivationData() {
		return array(
			'market'   => 'edd',
			'author'   => 'NjM4NDU6',
			'theme_id' => '11'
		);
	}
	add_filter( 'brizy-pro-license-data', 'BrizyAuthorLicenseActivationData' );

	//
	function almaz_premium_starter_sites(){
		$uri = 'https://almazwptemplates.online/';
		
			return array(
			'universal-site-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Универсальный сайт',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','universal-site-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/universal-site-ru.jpg',
				'preview_url' => $uri . 'universal-site-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),
			'web-studio-4' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Веб студия 4',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','web-studio-4.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/web-studio-4.jpg',
				'preview_url' => $uri . 'web-studio-4',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					),
					'almaz_wp_templates_catalog' => array(
						'name' => 'Каталог готовых сайтов от almazwptemplates.ru',
						'source' => 'remote',
						'file_path' => 'almaz-wp-templates-catalog/almaz-wp-templates-catalog.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/almaz-wp-templates-catalog.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),
			'universal-landing-page-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Универсальный лендинг',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','universal-landing-page-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/universal-landing-page-ru.jpg',
				'preview_url' => $uri . 'universal-landing-page-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),
			'big-dentistry-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Стоматология Дентал',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','big-dentistry-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/big-dentistry-ru.jpg',
				'preview_url' => $uri . 'big-dentistry-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),
			'school-of-art-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Школа искусств',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','school-of-art-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/school-of-art-ru.jpg',
				'preview_url' => $uri . 'school-of-art-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'language-school-polyglot-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Языковая школа',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','language-school-polyglot-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/language-school-polyglot-ru.jpg',
				'preview_url' => $uri . 'language-school-polyglot-2-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'dancing-school-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Школа танцев',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','dancing-school-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/dancing-school-ru.jpg',
				'preview_url' => $uri . 'dancing-school-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'european-cuisine-cafe-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Кафе Palermo',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','european-cuisine-cafe-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/european-cuisine-cafe-ru.jpg',
				'preview_url' => $uri . 'european-cuisine-cafe-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'itgroup-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'IT компания',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','itgroup-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/itgroup-ru.jpg',
				'preview_url' => $uri . 'itgroup-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'interior-design-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Дизайн интерьера',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','interior-design-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/interior-design-ru.jpg',
				'preview_url' => $uri . 'interior-design-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'car-service-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Автосервис',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','car-service-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/car-service-ru.jpg',
				'preview_url' => $uri . 'car-service-2-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'web-designer-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Веб дизайнер',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','web-designer-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/web-designer-ru.jpg',
				'preview_url' => $uri . 'web-designer-2-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'hotel-almaz-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Отель Алмаз',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','hotel-almaz-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/hotel-almaz-ru.jpg',
				'preview_url' => $uri . 'hotel-almaz-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'spa-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'СПА салон',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','spa-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/spa-ru.jpg',
				'preview_url' => $uri . 'spa-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'coworking-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Коворкинг',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','coworking-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/coworking-ru.jpg',
				'preview_url' => $uri . 'coworking-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'doctor-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Врач',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','doctor-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/doctor-ru.jpg',
				'preview_url' => $uri . 'doctor-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'marketing-and-seo-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Маркетинг и SEO',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','marketing-and-seo-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/marketing-and-seo-ru.jpg',
				'preview_url' => $uri . 'marketing-and-seo-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'app-2-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Приложение 2',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','app-2-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/app-2-ru.jpg',
				'preview_url' => $uri . 'app-2-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'dentistry-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Стоматология',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','dentistry-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/dentistry-ru.jpg',
				'preview_url' => $uri . 'dentistry-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'carwash-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Автомойка',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','carwash-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/carwash-ru.jpg',
				'preview_url' => $uri . 'carwash-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'beauty-saloon-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Салон красоты',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','beauty-saloon-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/beauty-saloon-ru.jpg',
				'preview_url' => $uri . 'beauty-saloon-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'smm-specialist-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'SMM специалист',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','smm-specialist-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/smm-specialist-ru.jpg',
				'preview_url' => $uri . 'smm-specialist-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),		
			'lodiz-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Архитектор',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','lodiz-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/lodiz-ru.jpg',
				'preview_url' => $uri . 'lodiz-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'codesk-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Коворкинг',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','codesk-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/codesk-ru.jpg',
				'preview_url' => $uri . 'codesk-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'seo-agency-2-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'SEO агентство 2',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','seo-agency-2-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/seo-agency-2-ru.jpg',
				'preview_url' => $uri . 'seo-agency-2-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'starter-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Брендинг',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','starter-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/starter-ru.jpg',
				'preview_url' => $uri . 'starter-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'mechanic-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Автомеханик',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','mechanic-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/mechanic-ru.jpg',
				'preview_url' => $uri . 'mechanic-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'consulting-services-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Консалтинговые услуги',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','consulting-services-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/consulting-services-ru.jpg',
				'preview_url' => $uri . 'consulting-services-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'spirit-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Психологический центр',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','spirit-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/spirit-ru.jpg',
				'preview_url' => $uri . 'spirit-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'trainer-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Тренер',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','trainer-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/trainer-ru.jpg',
				'preview_url' => $uri . 'trainer-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'online-webinar-2-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Онлайн вебинар 2',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','online-webinar-2-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/online-webinar-2-ru.jpg',
				'preview_url' => $uri . 'online-webinar-2-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'corpio-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Консалтинг',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','corpio-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/corpio-ru.jpg',
				'preview_url' => $uri . 'corpio-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'online-webinar-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Онлайн вебинар',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','online-webinar-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/online-webinar-ru.jpg',
				'preview_url' => $uri . 'online-webinar-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'floors-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Монтаж полов',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','floors-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/floors-ru.jpg',
				'preview_url' => $uri . 'floors-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'guide-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Гид',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','guide-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/guide-ru.jpg',
				'preview_url' => $uri . 'guide-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'the-farm-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Ферма',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','the-farm-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/the-farm-ru.jpg',
				'preview_url' => $uri . 'the-farm-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'diet-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Диета',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','diet-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/diet-ru.jpg',
				'preview_url' => $uri . 'diet-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'copyright-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Авторское право',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','copyright-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/copyright-ru.jpg',
				'preview_url' => $uri . 'copyright-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'lawer-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Юрист',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','lawer-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/lawer-ru.jpg',
				'preview_url' => $uri . 'lawer-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'orange-photography-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Фотограф',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','orange-photography-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/orange-photography-ru.jpg',
				'preview_url' => $uri . 'orange-photography-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'seo-specialist-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'SEO специалист',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','seo-specialist-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/seo-specialist-ru.jpg',
				'preview_url' => $uri . 'seo-specialist-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'filming-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Видеосъемка',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','filming-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/filming-ru.jpg',
				'preview_url' => $uri . 'filming-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			),	
			'detox-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
				'name' => 'Детокс',
				'type' => 'pro', 
				'buy_url' => 'https://almazwptemplates.ru/', 
				'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','detox-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
				'image' => $uri . 'demo-data/detox-ru.jpg',
				'preview_url' => $uri . 'detox-ru',
				//'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
				'menu_array' => array( 
					'primary' => 'menu 1',
					//'secondary' => 'Secondary Menu'
				),
				'plugins' => array( 
					'brizy' => array(
						'name' => 'Brizy', 
						'source' => 'wordpress', 
						'file_path' => 'brizy/brizy.php'
					),
					'brizy_pro' => array(
						'name' => 'Brizy Pro',
						'source' => 'remote',
						'file_path' => 'brizy-pro/brizy-pro.php',
						'location' => almaz_get_presigned_url_aws_s3('almaz-demo-2','plugins/brizy-pro.zip') 
					)
				),
				'home_slug' => 'home',
				'blog_slug' => 'blog',
				'tags' => array(
					'premium' => 'Премиум'
				)
			)	
		);
	}
}
	/**
	 * Загрузите необходимые зависимости для этого плагина.
	 *
	 * Включите следующие файлы, составляющие плагин:
	 *
	 * - Алмаз_Премиум_Сайты_Загрузчик. Организует хуки плагина.
	 * - Алмаз_Премиум_Сайты_i18n. Определяет функциональность интернационализации.
	 * - Алмаз_Премиум_Сайты_Админ. Определяет все хуки для админки.
	 * - Almaz_Premium_Sites_Public. Определяет все хуки для общедоступной части сайта.
	 *
	 * Создайте экземпляр загрузчика, который будет использоваться для регистрации хуков
	 * с Вордпресс.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Класс, отвечающий за организацию действий и фильтров
		 * Основной плагин.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-almaz-premium-sites-loader.php';

		/**
		 * Класс, отвечающий за определение функциональности интернационализации
		 * плагина.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-almaz-premium-sites-i18n.php';

		/**
		 * Класс, отвечающий за определение всех действий, происходящих в админке.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-almaz-premium-sites-admin.php';

		/**
		 * Класс, отвечающий за определение всех действий, происходящих в общедоступном
		 * Сторона сайта.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-almaz-premium-sites-public.php';

		$this->loader = new Almaz_Premium_Sites_Loader();

	}

	/**
	 * Определите локаль для этого плагина для интернационализации.
	 *
  	 * Использует класс Almaz_Premium_Sites_i18n для установки домена и регистрации хука
	 * с Вордпресс.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Almaz_Premium_Sites_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Зарегистрируйте все хуки, связанные с функциональностью админки
	 * плагина.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Almaz_Premium_Sites_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Зарегистрируйте все хуки, связанные с публичной функциональностью.
	 * плагина.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Almaz_Premium_Sites_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Запустите загрузчик, чтобы выполнить все хуки с WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
 	 * Имя плагина, используемое для его уникальной идентификации в контексте
	 * WordPress и определить функциональность интернационализации.
	 *
	 * @since     1.0.0
	 * @return    string    Название плагина.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Ссылка на класс, который управляет хуками с плагином.
	 *
 	 * @since     1.0.0
	 * @return Almaz_Premium_Sites_Loader Оркестрирует хуки плагина.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Получить номер версии плагина.
	 *
	 * @since     1.0.0
	 * @return    string    Номер версии плагина.
	 */
	public function get_version() {
		return $this->version;
	}

}
