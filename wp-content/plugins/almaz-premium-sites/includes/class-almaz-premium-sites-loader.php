<?php

/**
 * Прописать все действия и фильтры для плагина
 *
 * @link       https://almazweb.company/
 * @since      1.0.0
 *
 * @package    Almaz_Premium_Sites
 * @subpackage Almaz_Premium_Sites/includes
 */

/**
 * Прописать все действия и фильтры для плагина.
 *
 * Ведите список всех хуков, которые зарегистрированы повсюду
 * плагин и зарегистрируйте их с помощью WordPress API. Позвоните
 * запустить функцию для выполнения списка действий и фильтров.
 *
 * @package    Almaz_Premium_Sites
 * @subpackage Almaz_Premium_Sites/includes
 * @author     AlmazWeb.Company <almazweb.company@mail.ru>
 */
class Almaz_Premium_Sites_Loader {

	/**
     * Массив действий, зарегистрированных в WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    Действия, зарегистрированные в WordPress для запуска при загрузке плагина.
	 */
	protected $actions;

	/**
	 * Массив фильтров, зарегистрированных в WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    Фильтры, зарегистрированные в WordPress, срабатывают при загрузке плагина.
	 */
	protected $filters;

	/**
	 * Инициализируйте коллекции, используемые для обслуживания действий и фильтров.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Добавьте новое действие в коллекцию для регистрации в WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             Имя действия WordPress, которое регистрируется.
	 * @param    object               $component        Ссылка на экземпляр объекта, для которого определено действие.
	 * @param    string               $callback         Имя определения функции в $component.
	 * @param    int                  $priority         Необязательный. Приоритет, при котором должна запускаться функция. По умолчанию 10.
	 * @param    int                  $accepted_args    Необязательный. Количество аргументов, которые должны быть переданы в $callback. По умолчанию 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Добавьте новый фильтр в коллекцию для регистрации в WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             Имя регистрируемого фильтра WordPress.
	 * @param    object               $component        Ссылка на экземпляр объекта, для которого определен фильтр.
	 * @param    string               $callback         Имя определения функции в $component.
	 * @param    int                  $priority         Необязательный. Приоритет, при котором должна запускаться функция. По умолчанию 10.
	 * @param    int                  $accepted_args    Необязательный. Количество аргументов, которые должны быть переданы в $callback. По умолчанию 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Вспомогательная функция, которая используется для регистрации действий и перехватов в одном
	 * коллекция.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            Набор регистрируемых хуков (то есть действий или фильтров).
	 * @param    string               $hook             Имя регистрируемого фильтра WordPress.
	 * @param    object               $component        Ссылка на экземпляр объекта, для которого определен фильтр.
	 * @param    string               $callback         Имя определения функции в $component.
	 * @param    int                  $priority         Приоритет, при котором должна запускаться функция.
	 * @param    int                  $accepted_args    Количество аргументов, которые должны быть переданы в $callback.
	 * @return   array                                  Набор действий и фильтров, зарегистрированных в WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;

	}

	/**
     * Зарегистрируйте фильтры и действия в WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

}
