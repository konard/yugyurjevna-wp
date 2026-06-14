<?php
/**
 * Plugin Name:       Каталог готовых сайтов от almazwptemplates.ru
 * Plugin URI:        https://almazwptemplates.ru/partnerskaya-programma-web-studio/ 
 * Description:       Вставьте каталог сайтов на любую страницу с помощью шорткода. Настройте стиль, скины, цвета и шрифты через параметры плагина. Используйте шорткод [almaz_catalog], для категории [almaz_catalog category=avto] .
 * Version:           2.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            AlmazWeb.Company
 * License:           Полный запрет на копирование и распространение
 * Text Domain:       almaz-catalog
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define('ALMAZ_CATALOG_VERSION', '2.0.0');
define('ALMAZ_CATALOG_OPTIONS_NAME', 'almaz_catalog_settings');
define('ALMAZ_API_BASE_URL', 'https://almazwptemplates.ru/wp-json/almaz/v1/templates/');

// --- Значения по умолчанию для настроек ---
function almaz_catalog_get_default_options() {
    return [
        'selected_skin' => 'skin1',
        'link_text' => __('Демо', 'almaz-catalog'),
        'icon_class' => 'fa-solid fa-arrow-right', // Пример иконки Font Awesome (Стрелка вправо)
        'title_font_family' => '', // Пусто = наследовать
        'title_font_color' => '#101010', // Цвет из оригинального CSS
        'title_font_hover_color' => '#101010', // Пример цвета для hover
        'link_font_family' => '', // Пусто = наследовать
        'link_font_color' => '#4361ee', // Цвет из оригинального CSS
        'link_font_hover_color' => '#6478d5', // Пример цвета для hover
    ];
}

// --- Получение текущих настроек ---
function almaz_catalog_get_options() {
    return wp_parse_args(
        get_option(ALMAZ_CATALOG_OPTIONS_NAME, []),
        almaz_catalog_get_default_options()
    );
}

// --- Регистрация страницы настроек ---
add_action('admin_menu', 'almaz_catalog_add_admin_menu');
function almaz_catalog_add_admin_menu() {
    add_options_page(
        __('Настройки Каталога Алмаз', 'almaz-catalog'), // Title страницы
        __('Каталог Алмаз', 'almaz-catalog'),          // Текст в меню
        'manage_options',                              // Права доступа
        'almaz-catalog-settings',                      // Уникальный slug
        'almaz_catalog_settings_page_html'             // Функция рендеринга
    );
}

// --- Регистрация настроек (Settings API) ---
add_action('admin_init', 'almaz_catalog_settings_init');
function almaz_catalog_settings_init() {
    register_setting(
        'almaz_catalog_settings_group',      // Имя группы настроек
        ALMAZ_CATALOG_OPTIONS_NAME,          // Имя опции в БД
        'almaz_catalog_options_validate'     // Функция валидации/санитизации
    );

    // Секция выбора скина
    add_settings_section(
        'almaz_catalog_section_skins',              // ID секции
        __('Выбор скина каталога', 'almaz-catalog'), // Заголовок секции
        'almaz_catalog_section_skins_callback',     // Функция описания секции
        'almaz_catalog_settings_group'              // Страница (группа)
    );

    add_settings_field(
        'selected_skin_field',                      // ID поля
        __('Выберите скин', 'almaz-catalog'),       // Заголовок поля
        'almaz_catalog_field_skin_render',          // Функция рендеринга поля
        'almaz_catalog_settings_group',             // Страница (группа)
        'almaz_catalog_section_skins'               // Секция
    );

    // Секция глобальных настроек
    add_settings_section(
        'almaz_catalog_section_global',             // ID секции
        __('Глобальные настройки', 'almaz-catalog'), // Заголовок секции
        'almaz_catalog_section_global_callback',    // Функция описания секции
        'almaz_catalog_settings_group'              // Страница (группа)
    );

    add_settings_field(
        'link_text_field',
        __('Текст ссылки "Демо"', 'almaz-catalog'),
        'almaz_catalog_field_link_text_render',
        'almaz_catalog_settings_group',
        'almaz_catalog_section_global'
    );

    add_settings_field(
        'icon_class_field',
        __('Иконка Font Awesome', 'almaz-catalog'),
        'almaz_catalog_field_icon_class_render',
        'almaz_catalog_settings_group',
        'almaz_catalog_section_global'
    );

    add_settings_field(
        'title_font_field',
        __('Шрифт названия', 'almaz-catalog'),
        'almaz_catalog_field_title_font_render',
        'almaz_catalog_settings_group',
        'almaz_catalog_section_global'
    );

     add_settings_field(
        'link_font_field',
        __('Шрифт ссылки', 'almaz-catalog'),
        'almaz_catalog_field_link_font_render',
        'almaz_catalog_settings_group',
        'almaz_catalog_section_global'
    );

}

// --- Функции описания секций ---
function almaz_catalog_section_skins_callback() {
    echo '<p>' . __('Выберите внешний вид для карточек каталога. Выбранный скин будет применен ко всем каталогам на сайте.', 'almaz-catalog') . '</p>';
}

function almaz_catalog_section_global_callback() {
    echo '<p>' . __('Эти настройки применяются ко всем скинам, если скин поддерживает соответствующий элемент.', 'almaz-catalog') . '</p>';
}

// --- Функции рендеринга полей ---

// Рендеринг выбора скина
function almaz_catalog_field_skin_render() {
    $options = almaz_catalog_get_options();
    $skins = almaz_catalog_get_available_skins();
    ?>
    <fieldset>
        <legend class="screen-reader-text"><span><?php _e('Выберите скин', 'almaz-catalog'); ?></span></legend>
        <?php foreach ($skins as $key => $skin) : ?>
            <div style="display: inline-block; margin: 10px; padding: 10px; border: 1px solid #ccc; text-align: center; vertical-align: top; min-width: 180px; background: #fff;">
                <label for="skin_<?php echo esc_attr($key); ?>" style="display: block; margin-bottom: 10px;">
                    <input type="radio"
                           id="skin_<?php echo esc_attr($key); ?>"
                           name="<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[selected_skin]"
                           value="<?php echo esc_attr($key); ?>"
                           <?php checked($options['selected_skin'], $key); ?>
                           style="margin-right: 5px;"
                    />
                    <strong><?php echo esc_html($skin['name']); ?></strong>
                </label>
                <div style="margin-top: 10px; border: 1px dashed #eee; padding: 5px; background: #f9f9f9;">
                    <?php if (!empty($skin['preview'])) : ?>
                         <img src="<?php echo esc_url($skin['preview']); ?>" alt="<?php echo esc_attr($skin['name']); ?>" style="max-width: 150px; height: auto; border: 1px solid #ddd;">
                    <?php else : ?>
                         <p><i><?php _e('Превью недоступно', 'almaz-catalog'); ?></i></p>
                         <p style="font-size: smaller;"><?php echo esc_html($skin['description']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </fieldset>
    <?php
}

// Рендеринг текста ссылки
function almaz_catalog_field_link_text_render() {
    $options = almaz_catalog_get_options();
    ?>
    <input type='text'
           name='<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[link_text]'
           value='<?php echo esc_attr($options['link_text']); ?>'
           class='regular-text'>
    <p class="description"><?php _e('Текст для ссылки (в скинах, где она есть, например "Демо", "Подробнее").', 'almaz-catalog'); ?></p>
    <?php
}

// Рендеринг класса иконки
function almaz_catalog_field_icon_class_render() {
    $options = almaz_catalog_get_options();
    ?>
    <input type='text'
           name='<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[icon_class]'
           value='<?php echo esc_attr($options['icon_class']); ?>'
           class='regular-text'>
     <p class="description">
        <?php _e('Введите полный класс иконки Font Awesome (например, <code>fa-solid fa-arrow-right</code> или <code>fa-solid fa-arrow-up-right-from-square</code>). Используется в скинах с иконками.', 'almaz-catalog'); ?>
        <a href="https://fontawesome.com/icons" target="_blank"><?php _e('Найти иконки', 'almaz-catalog'); ?></a>
     </p>
    <?php
}

// Рендеринг настроек шрифта заголовка
function almaz_catalog_field_title_font_render() {
     $options = almaz_catalog_get_options();
     ?>
     <p style="margin-bottom: 15px;">
         <label for="title_font_family" style="display: block; margin-bottom: 5px;"><strong><?php _e('Семейство шрифтов Google Fonts:', 'almaz-catalog'); ?></strong></label>
         <input type='text'
                id='title_font_family'
                name='<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[title_font_family]'
                value='<?php echo esc_attr($options['title_font_family']); ?>'
                class='regular-text'
                placeholder="<?php esc_attr_e('Например: Roboto', 'almaz-catalog'); ?>">
          <span class="description"><?php _e('Оставьте пустым для наследования шрифта темы.', 'almaz-catalog'); ?></span>
     </p>
      <p style="margin-bottom: 15px;">
          <label for="title_font_color" style="display: block; margin-bottom: 5px;"><strong><?php _e('Цвет текста:', 'almaz-catalog'); ?></strong></label>
          <input type='color'
                 id='title_font_color'
                 name='<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[title_font_color]'
                 value='<?php echo esc_attr($options['title_font_color']); ?>'
                 style="vertical-align: middle;">
     </p>
      <p>
          <label for="title_font_hover_color" style="display: block; margin-bottom: 5px;"><strong><?php _e('Цвет текста при наведении:', 'almaz-catalog'); ?></strong></label>
          <input type='color'
                 id='title_font_hover_color'
                 name='<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[title_font_hover_color]'
                 value='<?php echo esc_attr($options['title_font_hover_color']); ?>'
                 style="vertical-align: middle;">
     </p>
     <?php
}

// Рендеринг настроек шрифта ссылки / иконки
function almaz_catalog_field_link_font_render() {
     $options = almaz_catalog_get_options();
     ?>
     <p style="margin-bottom: 15px;">
         <label for="link_font_family" style="display: block; margin-bottom: 5px;"><strong><?php _e('Семейство шрифтов Google Fonts:', 'almaz-catalog'); ?></strong></label>
         <input type='text'
                id='link_font_family'
                name='<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[link_font_family]'
                value='<?php echo esc_attr($options['link_font_family']); ?>'
                class='regular-text'
                 placeholder="<?php esc_attr_e('Например: Open Sans', 'almaz-catalog'); ?>">
          <span class="description"><?php _e('Оставьте пустым для наследования шрифта темы.', 'almaz-catalog'); ?></span>
     </p>
      <p style="margin-bottom: 15px;">
          <label for="link_font_color" style="display: block; margin-bottom: 5px;"><strong><?php _e('Цвет текста/иконки:', 'almaz-catalog'); ?></strong></label>
          <input type='color'
                 id='link_font_color'
                 name='<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[link_font_color]'
                 value='<?php echo esc_attr($options['link_font_color']); ?>'
                 style="vertical-align: middle;">
     </p>
      <p>
          <label for="link_font_hover_color" style="display: block; margin-bottom: 5px;"><strong><?php _e('Цвет текста при наведении:', 'almaz-catalog'); ?></strong></label>
          <input type='color'
                 id='link_font_hover_color'
                 name='<?php echo esc_attr(ALMAZ_CATALOG_OPTIONS_NAME); ?>[link_font_hover_color]'
                 value='<?php echo esc_attr($options['link_font_hover_color']); ?>'
                 style="vertical-align: middle;">
     </p>
     <?php
}


// --- Валидация и санитизация настроек ---
function almaz_catalog_options_validate($input) {
    $defaults = almaz_catalog_get_default_options();
    $output = [];

    // Валидация выбранного скина
    $available_skins = array_keys(almaz_catalog_get_available_skins());
    $output['selected_skin'] = isset($input['selected_skin']) && in_array($input['selected_skin'], $available_skins, true)
        ? sanitize_key($input['selected_skin'])
        : $defaults['selected_skin'];

    // Санитизация текста ссылки
    $output['link_text'] = isset($input['link_text'])
        ? sanitize_text_field($input['link_text'])
        : $defaults['link_text'];

    // Санитизация класса иконки
    $output['icon_class'] = isset($input['icon_class'])
        ? sanitize_text_field(trim($input['icon_class'])) // trim удаляет пробелы по краям
        : $defaults['icon_class'];

    // Функция для проверки цвета
    $validate_color = function($color, $default_color) {
        if (empty($color)) {
            return $default_color;
        }
        // Проверяем на формат #rrggbb или #rgb
        if (preg_match('/^#([a-f0-9]{6}|[a-f0-9]{3})$/i', $color)) {
            return $color;
        }
        // Если не соответствует, возвращаем значение по умолчанию
        return $default_color;
    };

    // Санитизация настроек шрифта заголовка
    $output['title_font_family'] = isset($input['title_font_family'])
        ? sanitize_text_field(trim($input['title_font_family']))
        : $defaults['title_font_family'];
    $output['title_font_color'] = $validate_color($input['title_font_color'] ?? '', $defaults['title_font_color']);
    $output['title_font_hover_color'] = $validate_color($input['title_font_hover_color'] ?? '', $defaults['title_font_hover_color']);

    // Санитизация настроек шрифта ссылки
    $output['link_font_family'] = isset($input['link_font_family'])
        ? sanitize_text_field(trim($input['link_font_family']))
        : $defaults['link_font_family'];
     $output['link_font_color'] = $validate_color($input['link_font_color'] ?? '', $defaults['link_font_color']);
    $output['link_font_hover_color'] = $validate_color($input['link_font_hover_color'] ?? '', $defaults['link_font_hover_color']);

    // Добавление сообщения об успешном сохранении
    add_settings_error(
        'almaz_catalog_messages',
        'almaz_catalog_message',
        __( 'Настройки сохранены.', 'almaz-catalog' ),
        'updated' // Используем класс 'updated' для зелёного уведомления
    );

    return $output;
}

// --- HTML страницы настроек ---
function almaz_catalog_settings_page_html() {
    // Проверка прав доступа
    if (!current_user_can('manage_options')) {
        wp_die(__('У вас нет прав для доступа к этой странице.', 'almaz-catalog'));
    }

    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
         <?php settings_errors( 'almaz_catalog_messages' ); // Вывод уведомлений (включая сообщение об успехе) ?>
        <form action="options.php" method="post">
            <?php
            // Вывод скрытых полей безопасности (nonce, action, option_page)
            settings_fields('almaz_catalog_settings_group');
            // Вывод секций и полей
            do_settings_sections('almaz_catalog_settings_group');
            // Кнопка сохранения
            submit_button(__('Сохранить настройки', 'almaz-catalog'));
            ?>
        </form>
    </div>
    <?php
}

// --- Регистрация и подключение стилей и скриптов ---
add_action('wp_enqueue_scripts', 'almaz_catalog_register_assets');
function almaz_catalog_register_assets() {
    // Регистрируем базовый CSS для каталога (будет создан при активации)
    $css_file_path = plugin_dir_path(__FILE__) . 'css/catalog-style.css';
    $css_file_url = plugin_dir_url(__FILE__) . 'css/catalog-style.css';
    if (file_exists($css_file_path)) {
         wp_register_style(
            'almaz-catalog-style',
            $css_file_url,
            [],
            filemtime($css_file_path) // Версия на основе времени модификации файла
        );
    }


    // Регистрируем Google Fonts (пока не подключаем)
    wp_register_style(
        'almaz-catalog-google-fonts',
        false, // URL будет добавлен динамически
        [],
        null // Версия не нужна, т.к. URL динамический
    );

    // --- Регистрация скрипта Font Awesome Kit ---
    wp_register_script(
        'almaz-fontawesome-kit',                     // Уникальный хэндл
        'https://kit.fontawesome.com/83f08e93c4.js', // URL вашего кита
        [],                                          // Нет зависимостей
        null,                                        // Версия не нужна (или можно указать)
        true                                         // Загружать в футере (рекомендуется)
    );
    
}

// --- Фильтр для добавления crossorigin к скрипту Font Awesome ---
add_filter('script_loader_tag', 'almaz_add_fontawesome_attributes', 10, 3);
function almaz_add_fontawesome_attributes($tag, $handle, $src) {
    // Проверяем, что это наш скрипт по хэндлу
    if ('almaz-fontawesome-kit' === $handle) {
        // Ищем '>' чтобы вставить атрибут перед ним
        $tag_end = strrpos($tag, '>');
        if ($tag_end !== false) {
            // Добавляем атрибут перед закрывающей скобкой тега script
            // Проверяем, нет ли уже crossorigin
            if (false === strpos($tag, 'crossorigin=')) {
                 $tag = substr_replace($tag, ' crossorigin="anonymous"', $tag_end, 0);
            }
        }
    }
    return $tag;
}

// --- Функция для получения списка доступных скинов ---
function almaz_catalog_get_available_skins() {
    // Путь к папке с превью внутри папки плагина
    $preview_path = plugin_dir_url(__FILE__) . 'images/previews/';

    return [
        'skin1' => [
            'name' => __('Скин 1', 'almaz-catalog'),
            'description' => __('Фото, Название, Текстовая ссылка', 'almaz-catalog'),
            'preview' => $preview_path . 'skin1-preview.png', // Создайте этот файл!
            'callback' => 'almaz_catalog_render_skin1' // Имя функции рендеринга
        ],
        'skin2' => [
            'name' => __('Скин 2', 'almaz-catalog'),
            'description' => __('Фото, Название, Иконка', 'almaz-catalog'),
            'preview' => $preview_path . 'skin2-preview.png', // Создайте этот файл!
            'callback' => 'almaz_catalog_render_skin2' // Имя функции рендеринга
        ],
		'skin3' => [
            'name' => __('Скин 3', 'almaz-catalog'),
            'description' => __('Фото, Название, Текстовая ссылка', 'almaz-catalog'),
            'preview' => $preview_path . 'skin3-preview.png', // Создайте этот файл!
            'callback' => 'almaz_catalog_render_skin3' // Имя функции рендеринга
        ],
		'skin4' => [
            'name' => __('Скин 4', 'almaz-catalog'),
            'description' => __('Фото, Название, Текстовая ссылка', 'almaz-catalog'),
            'preview' => $preview_path . 'skin4-preview.png', // Создайте этот файл!
            'callback' => 'almaz_catalog_render_skin4' // Имя функции рендеринга
        ],
		'skin5' => [
            'name' => __('Скин 5', 'almaz-catalog'),
            'description' => __('Длинное фото, Название', 'almaz-catalog'),
            'preview' => $preview_path . 'skin5-preview.png', // Создайте этот файл!
            'callback' => 'almaz_catalog_render_skin5' // Имя функции рендеринга
        ],
		'skin6' => [
            'name' => __('Скин 6', 'almaz-catalog'),
            'description' => __('Фото, Название', 'almaz-catalog'),
            'preview' => $preview_path . 'skin6-preview.png', // Создайте этот файл!
            'callback' => 'almaz_catalog_render_skin6' // Имя функции рендеринга
        ],
		'skin7' => [
            'name' => __('Скин 7', 'almaz-catalog'),
            'description' => __('Фото, Название', 'almaz-catalog'),
            'preview' => $preview_path . 'skin7-preview.png', // Создайте этот файл!
            'callback' => 'almaz_catalog_render_skin7' // Имя функции рендеринга
        ],
        // Добавляйте сюда новые скины по аналогии
    ];
}

// --- Шорткод [almaz_catalog] ---
add_shortcode('almaz_catalog', 'almaz_catalog_shortcode_handler');
function almaz_catalog_shortcode_handler($atts) {
	if ((defined('REST_REQUEST') && REST_REQUEST) || (defined('DOING_AJAX') && DOING_AJAX)) {
    return '';
	}
    // Атрибуты шорткода (например, для категории)
    $atts = shortcode_atts([
        'category' => '',
    ], $atts, 'almaz_catalog'); 

    $options = almaz_catalog_get_options();
    $selected_skin_key = $options['selected_skin'];
    $skins = almaz_catalog_get_available_skins();
    $selected_skin = $skins[$selected_skin_key] ?? $skins[array_key_first($skins)]; // По умолчанию первый скин, если что-то пошло не так

    // Текущая страница пагинации (из GET-параметра ?cpage=...)
    $current_page = isset($_GET['catalog_page']) ? absint($_GET['catalog_page']) : 1;

    // Так как скрипт зарегистрирован, эта функция добавит его в очередь
    // для загрузки в футере только на этой странице.
    wp_enqueue_script('almaz-fontawesome-kit');

    // --- Подключение Google Fonts и динамических стилей ---
    $fonts_to_load = [];
    if (!empty($options['title_font_family'])) {
        $fonts_to_load[] = $options['title_font_family'];
    }
    if (!empty($options['link_font_family'])) {
        $fonts_to_load[] = $options['link_font_family'];
    }
    $fonts_to_load = array_unique($fonts_to_load); // Удаляем дубликаты

    if (!empty($fonts_to_load)) {
        $font_families_param = [];
        foreach ($fonts_to_load as $font) {
            // Добавляем базовые веса 400,500,700
            $font_families_param[] = 'family=' . urlencode(trim($font)) . ':wght@400;500;700';
        }
        $google_fonts_url = 'https://fonts.googleapis.com/css2?' . implode('&', $font_families_param) . '&display=swap';

        // Обновляем URL зарегистрированного стиля и подключаем его
        wp_style_add_data('almaz-catalog-google-fonts', 'src', $google_fonts_url);
        wp_enqueue_style('almaz-catalog-google-fonts');
    }

    // --- Генерация динамических CSS ---
    $dynamic_css = ":root { /* Определяем CSS переменные для удобства */
        --almaz-title-font: " . (!empty($options['title_font_family']) ? "'" . esc_attr(trim($options['title_font_family'])) . "', sans-serif" : 'inherit') . ";
        --almaz-title-color: " . esc_attr($options['title_font_color']) . ";
        --almaz-title-hover-color: " . esc_attr($options['title_font_hover_color']) . ";
        --almaz-link-font: " . (!empty($options['link_font_family']) ? "'" . esc_attr(trim($options['link_font_family'])) . "', sans-serif" : 'inherit') . ";
        --almaz-link-color: " . esc_attr($options['link_font_color']) . ";
        --almaz-link-hover-color: " . esc_attr($options['link_font_hover_color']) . ";
    }";

    // Подключаем базовый CSS (если он зарегистрирован)
    if (wp_style_is('almaz-catalog-style', 'registered')) {
         wp_enqueue_style('almaz-catalog-style');
         // Добавляем инлайновые стили ПОСЛЕ базовых
         wp_add_inline_style('almaz-catalog-style', $dynamic_css);
    } elseif ( ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        // Если базовый CSS не найден И это НЕ AJAX запрос,
        // выводим инлайн стили напрямую (менее предпочтительно).
        // Обертка esc_html добавлена для дополнительной безопасности.
        echo '<style type="text/css">' . esc_html($dynamic_css) . '</style>';
    }


    // --- Получение данных из API ---
    $api_url = ALMAZ_API_BASE_URL . '?page=' . $current_page;
    if (!empty($atts['category'])) {
        $api_url .= '&category=' . urlencode($atts['category']);
    }

    $response = wp_remote_get(esc_url_raw($api_url), ['timeout' => 15]); // Увеличили таймаут
    $catalog_items = [];
    $total_pages = 0;
    $error_message = '';

    if (is_wp_error($response)) {
        $error_message = __('Ошибка при запросе к API:', 'almaz-catalog') . ' ' . $response->get_error_message();
    } else {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
             $error_message = __('Ошибка декодирования ответа API.', 'almaz-catalog');
        } elseif (isset($data['code']) && isset($data['message'])) { // Обработка ошибок от WordPress REST API
             $error_message = __('Ошибка API:', 'almaz-catalog') . ' ' . esc_html($data['message']);
        } elseif (isset($data['items']) && isset($data['total_pages'])) {
            $catalog_items = $data['items'];
            $total_pages = absint($data['total_pages']);
        } else {
            $error_message = __('Некорректный формат ответа от API.', 'almaz-catalog');
            // Debug: log the response
            // error_log('Almaz Catalog API Response: ' . print_r($body, true));
        }
    }

    // --- Рендеринг каталога ---
    ob_start(); // Начинаем буферизацию вывода

    if (!empty($error_message)) {
        echo '<p class="almaz-catalog-error">' . esc_html($error_message) . '</p>';
    }

    echo '<div class="almaz-catalog-container">'; // Общий контейнер
    echo '<div class="almaz-catalog-grid ' . 'grid-' . esc_attr($selected_skin_key) . '">';

    if (!empty($catalog_items)) {
        foreach ($catalog_items as $item) {
            // Валидация данных из API (на всякий случай)
            $item_data = [
                'title'     => isset($item['title']) ? sanitize_text_field($item['title']) : __('Без названия', 'almaz-catalog'),
                'image_url' => isset($item['image']) ? esc_url($item['image']) : plugin_dir_url(__FILE__) . 'images/placeholder.png',
                'link_url'  => isset($item['demo_url']) ? esc_url($item['demo_url']) : '#',
            ];

            // Вызов функции рендеринга для выбранного скина
            if (isset($selected_skin['callback']) && function_exists($selected_skin['callback'])) {
                call_user_func($selected_skin['callback'], $item_data, $options);
            } else {
                // Если функция скина не найдена, используем скин по умолчанию и выводим ошибку
                $default_skin_key = array_key_first($skins);
                 if (isset($skins[$default_skin_key]['callback']) && function_exists($skins[$default_skin_key]['callback'])) {
                     call_user_func($skins[$default_skin_key]['callback'], $item_data, $options);
                 }
                 echo '<p class="almaz-catalog-error">Ошибка: функция рендеринга скина не найдена для ' . esc_html($selected_skin_key) . '</p>';
            }
        }
    } elseif (empty($error_message)) {
        echo '<p>' . __('Карточки не найдены.', 'almaz-catalog') . '</p>';
    }

    echo '</div>'; // .almaz-catalog-grid

    // --- Пагинация ---
    if ($total_pages > 1) {
        echo '<div class="almaz-catalog-pagination">';
        echo paginate_links([
			'base'      => add_query_arg('catalog_page', '%#%'),
			'format'    => '',
			'current'   => $current_page,
			'total'     => $total_pages,
			'mid_size'  => 2,
			'end_size'  => 1,
			'prev_next' => false,
		]);
        echo '</div>'; // .almaz-catalog-pagination
    }
     echo '</div>'; // .almaz-catalog-container
	 
    return ob_get_clean(); // Возвращаем содержимое буфера
}


// --- Функции рендеринга для каждого скина ---

/**
 * Рендерит карточку для Скина 1 (Фото, Название, Текстовая ссылка).
 *
 * @param array $item Данные товара (title, image_url, link_url).
 * @param array $options Глобальные настройки плагина.
 */
function almaz_catalog_render_skin1($item, $options) {
    ?>
    <div class="almaz-catalog-card skin-1">
        <?php if (!empty($item['image_url'])) : ?>
            <div class="almaz-card-image">
                <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                    <img src="<?php echo esc_url($item['image_url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                </a>
            </div>
        <?php endif; ?>

        <div class="almaz-card-content">
            <?php if (!empty($item['title'])) : ?>
                <h5 class="almaz-card-title">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($item['title']); ?>
                     </a>
                </h5>
            <?php endif; ?>

             <?php if (!empty($item['link_url']) && !empty($options['link_text'])) : ?>
                 <div class="almaz-card-link">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($options['link_text']); ?>
                     </a>
                 </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Рендерит карточку для Скина 2 (Фото, Название, Иконка).
 *
 * @param array $item Данные товара (title, image_url, link_url).
 * @param array $options Глобальные настройки плагина.
 */
function almaz_catalog_render_skin2($item, $options) {
     ?>
    <div class="almaz-catalog-card skin-2">
         <?php if (!empty($item['image_url'])) : ?>
            <div class="almaz-card-image">
                 <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                    <img src="<?php echo esc_url($item['image_url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                 </a>
            </div>
        <?php endif; ?>

        <div class="almaz-card-content">
             <?php if (!empty($item['title'])) : ?>
                <h5 class="almaz-card-title">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($item['title']); ?>
                     </a>
                </h5>
            <?php endif; ?>

             <?php // Отображаем иконку только если класс указан в настройках
             if (!empty($item['link_url']) && !empty($options['icon_class'])) : ?>
                 <div class="almaz-card-icon">
                    <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow" aria-label="<?php echo esc_attr( sprintf(__('Демо для %s', 'almaz-catalog'), $item['title']) ); ?>">
                         <i class="<?php echo esc_attr($options['icon_class']); ?>" aria-hidden="true"></i>
                         <?php // Можно добавить скрытый текст для доступности, если иконка единственная ссылка
                         // <span class="screen-reader-text"><?php echo esc_html($options['link_text']); ? ></span>
                         ?>
                    </a>
                 </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}


/**
 * Рендерит карточку для Скина 3 (Фото, Название, Текстовая ссылка).
 *
 * @param array $item Данные товара (title, image_url, link_url).
 * @param array $options Глобальные настройки плагина.
 */
function almaz_catalog_render_skin3($item, $options) {
    ?>
    <div class="almaz-catalog-card skin-3">
        <?php if (!empty($item['image_url'])) : ?>
            <div class="almaz-card-image">
                <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                    <img src="<?php echo esc_url($item['image_url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                </a>
            </div>
        <?php endif; ?>

        <div class="almaz-card-content">
            <?php if (!empty($item['title'])) : ?>
                <h5 class="almaz-card-title">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($item['title']); ?>
                     </a>
                </h5>
            <?php endif; ?>

             <?php if (!empty($item['link_url']) && !empty($options['link_text'])) : ?>
                 <div class="almaz-card-link">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($options['link_text']); ?>
                     </a>
                 </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Рендерит карточку для Скина 4 (Фото, Название, Кнопка).
 *
 * @param array $item Данные товара (title, image_url, link_url).
 * @param array $options Глобальные настройки плагина.
 */
function almaz_catalog_render_skin4($item, $options) {
    ?>
    <div class="almaz-catalog-card skin-4">
        <?php if (!empty($item['image_url'])) : ?>
            <div class="almaz-card-image">
                <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                    <img src="<?php echo esc_url($item['image_url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                </a>
            </div>
        <?php endif; ?>

        <div class="almaz-card-content">
            <?php if (!empty($item['title'])) : ?>
                <h5 class="almaz-card-title">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($item['title']); ?>
                     </a>
                </h5>
            <?php endif; ?>

             <?php if (!empty($item['link_url']) && !empty($options['link_text'])) : ?>
                 <div class="almaz-card-link">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($options['link_text']); ?>
                     </a>
                 </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Рендерит карточку для Скина 5 (Длинное фото, Название).
 *
 * @param array $item Данные товара (title, image_url, link_url).
 * @param array $options Глобальные настройки плагина.
 */
function almaz_catalog_render_skin5($item, $options) {
    ?>
    <div class="almaz-catalog-card skin-5">
        <?php if (!empty($item['image_url'])) : ?>
            <div class="almaz-card-image">
                <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                    <img src="<?php echo esc_url($item['image_url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                </a>
            </div>
        <?php endif; ?>

        <div class="almaz-card-content">
            <?php if (!empty($item['title'])) : ?>
                <h5 class="almaz-card-title">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($item['title']); ?>
                     </a>
                </h5>
            <?php endif; ?>

        </div>
    </div>
    <?php
}

/**
 * Рендерит карточку для Скина 6 (Фото, Название).
 *
 * @param array $item Данные товара (title, image_url, link_url).
 * @param array $options Глобальные настройки плагина.
 */
function almaz_catalog_render_skin6($item, $options) {
    ?>
    <div class="almaz-catalog-card skin-6">
        <?php if (!empty($item['image_url'])) : ?>
            <div class="almaz-card-image">
                <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                    <img src="<?php echo esc_url($item['image_url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                </a>
            </div>
        <?php endif; ?>

        <div class="almaz-card-content">
            <?php if (!empty($item['title'])) : ?>
                <h5 class="almaz-card-title">
                     <a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
                         <?php echo esc_html($item['title']); ?>
                     </a>
                </h5>
            <?php endif; ?>

        </div>
    </div>
    <?php
}

/**
 * Рендерит карточку для Скина 7 (Фото, Название).
 *
 * @param array $item Данные товара (title, image_url, link_url).
 * @param array $options Глобальные настройки плагина.
 */
function almaz_catalog_render_skin7($item, $options) {
    ?>
    <div class="almaz-catalog-card skin-7">
		<a href="<?php echo esc_url($item['link_url']); ?>" target="_blank" rel="noopener nofollow">
			<?php if (!empty($item['image_url'])) : ?>
				<div class="almaz-card-image">
					<img src="<?php echo esc_url($item['image_url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
				</div>
			<?php endif; ?>

			<div class="almaz-card-content">
				<?php if (!empty($item['title'])) : ?>
					<h5 class="almaz-card-title">        
						 <?php echo esc_html($item['title']); ?>
					</h5>
				<?php endif; ?>

			</div>
		</a>
    </div>
    <?php
}

// --- Создание необходимых директорий и файлов при активации ---
register_activation_hook(__FILE__, 'almaz_catalog_activate');
function almaz_catalog_activate() {
    // Создаем папку для CSS
    $css_dir = plugin_dir_path(__FILE__) . 'css';
    if (!is_dir($css_dir)) {
        wp_mkdir_p($css_dir);
    }

    // Создаем папку для изображений/превью
    $img_dir = plugin_dir_path(__FILE__) . 'images/previews';
     if (!is_dir($img_dir)) {
        wp_mkdir_p($img_dir);
    }

    // Создаем базовый CSS-файл, если его нет (объединяем стили из шорткода и добавляем базовые)
    $css_file = $css_dir . '/catalog-style.css';
    if (!file_exists($css_file)) {
        $css_content = "/* Almaz Catalog Base Styles */\n\n";
        $css_content .= ".almaz-catalog-error { color: red; border: 1px solid red; padding: 10px; margin-bottom: 20px; }\n";

        file_put_contents($css_file, $css_content);
    }

    // Установка опций по умолчанию при первой активации
    if (false === get_option(ALMAZ_CATALOG_OPTIONS_NAME)) {
        add_option(ALMAZ_CATALOG_OPTIONS_NAME, almaz_catalog_get_default_options());
    }
}

// Добавляем ссылку "Настройки" рядом с плагином на странице Плагины
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'almaz_add_settings_link');

function almaz_add_settings_link($links) {
    $settings_link = '<a href="' . admin_url('options-general.php?page=almaz-catalog-settings') . '">Настройки</a>';
    array_unshift($links, $settings_link);
    return $links;
}

/**
 * Обновление плагина
 *
 */
require plugin_dir_path( __FILE__ ) . 'updater/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://almazwptemplates.ru/download/almaz-catalog/almaz-catalog.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'almaz-wp-templates-catalog'
);

/**
 * Подключаем Google fonts в head
 *
 */

add_action('wp_enqueue_scripts', 'almaz_catalog_enqueue_google_title_fonts');

function almaz_catalog_enqueue_google_title_fonts() {
	$options = get_option('almaz_catalog_settings');

	if (!empty($options['title_font_family'])) {
		// Пример: Roboto или Open+Sans:wght@400;700
		$font_family = trim($options['title_font_family']);

		// Приводим к формату URL для Google Fonts
		$font_url = 'https://fonts.googleapis.com/css2?family=' . urlencode($font_family) . ':wght@400;500;700' . '&display=swap';

		wp_enqueue_style(
			'almaz-catalog-google-title-fonts',
			$font_url,
			[],
			null
		);
	}
}

add_action('wp_enqueue_scripts', 'almaz_catalog_enqueue_google_link_fonts');

function almaz_catalog_enqueue_google_link_fonts() {
	$options = get_option('almaz_catalog_settings');

	if (!empty($options['link_font_family'])) {
		// Пример: Roboto или Open+Sans:wght@400;700
		$font_family = trim($options['link_font_family']);

		// Приводим к формату URL для Google Fonts
		$font_url = 'https://fonts.googleapis.com/css2?family=' . urlencode($font_family) . ':wght@400;500;700' . '&display=swap';

		wp_enqueue_style(
			'almaz-catalog-google-link-fonts',
			$font_url,
			[],
			null
		);
	}
}


// --- Удаление настроек при деактивации (опционально) ---
/*
register_deactivation_hook(__FILE__, 'almaz_catalog_deactivate');
function almaz_catalog_deactivate() {
    // Раскомментируйте, если хотите удалять настройки при деактивации
    // delete_option(ALMAZ_CATALOG_OPTIONS_NAME);
}
*/