<?php
/**
 * Create almaz theme wp admin menu
 */
add_action('admin_menu', function () {

    add_menu_page(
        __('Almaz', 'almaz-theme'),
        __('Almaz', 'almaz-theme'),
        'manage_options',
        'almaz-theme-wp-menu',
		'',
		get_template_directory_uri( __FILE__ ) .'/includes/img/admin/almaz-theme-icon.png',
		'57.5'
    );
});


/**
 * Create almaz theme wp admin welcome page
 */
 
add_action('admin_menu', function () {
    add_submenu_page(
        'almaz-theme-wp-menu',
        __('Welcome', 'almaz-theme'),
		__('Welcome', 'almaz-theme'),
        'manage_options',
		'almaz-theme-wp-menu',
        'almaz_theme_welcome',
        1
    );
});
//Весь текст страницы вставить в функцию __()
function almaz_theme_welcome()
{
    ?>
    <div class="wrap-almaz-theme-admin-page">
	
	
		<h2>WordPress тема Алмаз</h2>
		
		<p>
            Тема для WordPress Алмаз, это конструктор сайтов разработанный на основе самых современных веб технологий, в тему встроен один из лучших бесплатных конструкторов сайтов Brizy Free. Вместе с темой Алмаз вы бесплатно получите 23 шаблона для создания сайта. Дополнительно вы можете приобрести наши премиальные шаблоны сайтов, разработанные нашими интернет маркетологами и веб специалистами, специально для Российского бизнеса. В премиум сайты встроен конструктор сайтов Brizy Pro, который позволит воспользоваться всеми профессиональными функциями конструктора страниц Brizy.
        </p>
		
		<hr>

		<h3>Премиум шаблоны Алмаз</h3>
				
		<p><a href="https://almazwptemplates.ru/">Премиум шаблоны ></a></p>
		
		<hr>

		<h3>Написать в службу поддержки</h3>
				
		<p><a href="https://almazweb.company/support/">Написать ></a></p>
		
		<hr>

		<h3>Лицензионный договор-оферта</h3>
				
		<p><a href="https://almazweb.company/license/">Читать ></a></p>

    </div>
    <?php
}

/**
 * Create almaz theme wp admin welcome page
 */
add_action('admin_menu', function () {
	add_submenu_page(
		'almaz-theme-wp-menu',
		__('Documentation', 'almaz-theme'),
		__('Documentation', 'almaz-theme'),
		'manage_options',
		'https://almazwptemplates.ru/tutorials/almaz-wordpress-theme/',
		'',
		1
	);
});
