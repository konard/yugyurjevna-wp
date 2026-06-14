<?php
function almaz_theme_free_starter_sites(){	
	$uri = 'https://almazwptemplates.online/';
		
        return array(
        'interior-designer-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Дизайнер интерьера',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','interior-designer-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/interior-designer-ru.jpg',
            'preview_url' => $uri . 'interior-designer-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'florist-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Флорист',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','florist-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/florist-ru.jpg',
            'preview_url' => $uri . 'florist-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'realtor-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Риелтор',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','realtor-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/realtor-ru.jpg',
            'preview_url' => $uri . 'realtor-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'copywriter-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Копирайтер',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','copywriter-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/copywriter-ru.jpg',
            'preview_url' => $uri . 'copywriter-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'veterinary-services-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Ветеринарные услуги',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','veterinary-services-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/veterinary-services-ru.jpg',
            'preview_url' => $uri . 'veterinary-services-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'design-loft-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Мебель',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','design-loft-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/design-loft-ru.jpg',
            'preview_url' => $uri . 'design-loft-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'refix-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Ремонт техники',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','refix-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/refix-ru.jpg',
            'preview_url' => $uri . 'refix-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'formstyle-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Создай свою контактную форму',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','formstyle-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/formstyle-ru.jpg',
            'preview_url' => $uri . 'formstyle-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'eladio-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Агентство цифрового маркетинга',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','eladio-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/eladio-ru.jpg',
            'preview_url' => $uri . 'eladio-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),	
		'digital-work-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Веб студия',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','digital-work-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/digital-work-ru.jpg',
            'preview_url' => $uri . 'digital-work-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'bizgo-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Бизнес',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','bizgo-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/bizgo-ru.jpg',
            'preview_url' => $uri . 'bizgo-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'oapee-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Приложение',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','oapee-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/oapee-ru.jpg',
            'preview_url' => $uri . 'oapee-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'resume-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Резюме',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','resume-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/resume-ru.jpg',
            'preview_url' => $uri . 'resume-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'webno-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Вебинар',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','webno-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/webno-ru.jpg',
            'preview_url' => $uri . 'webno-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'ekstra-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Приложение',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','ekstra-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/ekstra-ru.jpg',
            'preview_url' => $uri . 'ekstra-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'birthday-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Вечеринка',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','birthday-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/birthday-ru.jpg',
            'preview_url' => $uri . 'birthday-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'yachter-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Аренда яхт',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','yachter-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/yachter-ru.jpg',
            'preview_url' => $uri . 'yachter-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'wedding-3-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Свадьба',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','wedding-3-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/wedding-3-ru.jpg',
            'preview_url' => $uri . 'wedding-3-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'scooter-rental-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Аренда скутеров',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','scooter-rental-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/scooter-rental-ru.jpg',
            'preview_url' => $uri . 'scooter-rental-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'app-side-1-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Приложение',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','app-side-1-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/app-side-1-ru.jpg',
            'preview_url' => $uri . 'app-side-1-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'spotless-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Уборка помещений',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','spotless-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/spotless-ru.jpg',
            'preview_url' => $uri . 'spotless-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'kaufman-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Юридическая фирма',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','kaufman-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/kaufman-ru.jpg',
            'preview_url' => $uri . 'kaufman-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        ),
		'home-feast-ru' => array( // demo-slug должен соответствовать имени zip-файла «external_url»
            'name' => 'Рецепты',
            'type' => 'free', // 'free' or 'pro'
            'buy_url' => 'https://almazwptemplates.ru/', 
            'external_url' => almaz_get_presigned_url_aws_s3('almaz-demo-2','home-feast-ru.zip'), // zip-файл должен содержать content.xml, customizer.dat, widget.wie, option_name1.json, option_name2.json, revslider.zip (содержимое слайдера, экспортированное из слайдера Revolution) — вы можете пропустить любой из файлов, если он не нужен вашей демонстрации
            'image' => $uri . 'demo-data/home-feast-ru.jpg',
            'preview_url' => $uri . 'home-feast-ru',
            //'options_array' => array('option_name1','option_name2'), // option_name1.json, option_name2.json file should be included in the zip file
            //'menu_array' => array( 
                //'primary' => 'menu 1',
                //'secondary' => 'Secondary Menu'
            //),
            'plugins' => array( 
                'brizy' => array(
                    'name' => 'Brizy', 
                    'source' => 'wordpress', 
                    'file_path' => 'brizy/brizy.php'
                )
            ),
            'home_slug' => 'home',
            'blog_slug' => 'blog',
            'tags' => array(
                'free' => 'Бесплатно'
            )
        )		
    );
}