<?php
/************************************
* приведенный ниже код является стандартным
* страница опций. Заменить на
* твой собственный.
*************************************/

/**
 * Добавляет страницу лицензии плагина в меню администратора.
 *
 * @return void
  */
add_action('admin_menu', function () {
    add_menu_page(
        __('Лицензия Алмаз', 'almaz-premium-sites'),
        __('Лицензия Алмаз', 'almaz-premium-sites'),
        'manage_options',
        'almaz-premium-sites-wp-menu',
		'',
		get_template_directory_uri( __FILE__ ) .'/includes/img/admin/almaz-theme-icon.png',
		'57.6'
    );
});

 
function almaz_premium_sites_license_menu() {
	add_submenu_page(
		'almaz-premium-sites-wp-menu', 
		esc_html__('Лицензия Алмаз премиум сайты', 'almaz-premium-sites'), 
		esc_html__('Лицензия Алмаз премиум сайты', 'almaz-premium-sites'), 
		'manage_options', 
		'almaz-premium-sites-wp-menu',
		'almaz_premium_sites_license_page'
	);
}
add_action( 'admin_menu', 'almaz_premium_sites_license_menu' );


function almaz_premium_sites_license_page() {
	add_settings_section(
		'almaz_premium_sites_license',
		'',
		'almaz_premium_sites_license_key_settings_section',
		ALMAZ_PREMIUM_SITES_PLUGIN_LICENSE_PAGE
	);
	add_settings_field(
		'almaz_premium_sites_license_key',
		'<label for="almaz_premium_sites_license_key">' . __( 'License Key Almaz Premium sites' , 'almaz-premium-sites' ) . '</label>',
		'almaz_premium_sites_license_key_settings_field',
		ALMAZ_PREMIUM_SITES_PLUGIN_LICENSE_PAGE,
		'almaz_premium_sites_license'
	);
	?>
	<div class="wrap">
		<h2><?php esc_html_e( 'License' , 'almaz-premium-sites' ); ?></h2>
		<form method="post" action="options.php">

			<?php
			do_settings_sections( ALMAZ_PREMIUM_SITES_PLUGIN_LICENSE_PAGE );
			settings_fields( 'almaz_premium_sites_license' );
			submit_button();
			?>

		</form>
	<?php
}

/**
 * Добавляет контент в раздел настроек.
 *
 * @return void
 */
function almaz_premium_sites_license_key_settings_section() {
	//esc_html_e( 'This is where you enter your license key.' );
}

/**
 * Выводит поле настроек лицензионного ключа.
 *
 * @return void
 */
function almaz_premium_sites_license_key_settings_field() {
	$license = get_option( 'almaz_premium_sites_license_key' );
	$status  = get_option( 'almaz_premium_sites_license_status' );

	?>
	<p class="description"><?php esc_html_e( 'Enter your license key.' , 'almaz-premium-sites' ); ?></p>
	<?php
	printf(
		'<input type="text" class="regular-text" id="almaz_premium_sites_license_key" name="almaz_premium_sites_license_key" value="%s" />',
		esc_attr( $license )
	);
	$button = array(
		'name'  => 'edd_license_deactivate',
		'label' => __( 'Deactivate License' , 'almaz-premium-sites' ),
	);
	if ( 'valid' !== $status ) {
		$button = array(
			'name'  => 'edd_license_activate',
			'label' => __( 'Activate License' , 'almaz-premium-sites' ),
		);
	}
	wp_nonce_field( 'almaz_premium_sites_nonce', 'almaz_premium_sites_nonce' );
	?>
	<input type="submit" class="button-secondary" name="<?php echo esc_attr( $button['name'] ); ?>" value="<?php echo esc_attr( $button['label'] ); ?>"/>
	<?php
}

/**
 * Регистрирует параметр лицензионного ключа в таблице параметров.
 *
 * @return void
 */
function almaz_premium_sites_register_option() {
	register_setting( 'almaz_premium_sites_license', 'almaz_premium_sites_license_key', 'edd_sanitize_license' );
}
add_action( 'admin_init', 'almaz_premium_sites_register_option' );

/**
 * Очищает лицензионный ключ.
 *
 * @param string  $new The license key.
 * @return string
 */
function edd_sanitize_license( $new ) {
	$old = get_option( 'almaz_premium_sites_license_key' );
	if ( $old && $old !== $new ) {
		delete_option( 'almaz_premium_sites_license_status' ); // new license has been entered, so must reactivate
	}

	return sanitize_text_field( $new );
}

/**
 * Активирует лицензионный ключ.
 *
 * @return void
 */
function almaz_premium_sites_activate_license() {

	// listen for our activate button to be clicked
	if ( ! isset( $_POST['edd_license_activate'] ) ) {
		return;
	}

	// запустить быструю проверку безопасности
	if ( ! check_admin_referer( 'almaz_premium_sites_nonce', 'almaz_premium_sites_nonce' ) ) {
		return; // выйти, если мы не нажали кнопку Активировать
	}

	// получить лицензию из базы данных
	$license = trim( get_option( 'almaz_premium_sites_license_key' ) );
	if ( ! $license ) {
		$license = ! empty( $_POST['almaz_premium_sites_license_key'] ) ? sanitize_text_field( $_POST['almaz_premium_sites_license_key'] ) : '';
	}
	if ( ! $license ) {
		return;
	}

	// данные для отправки в нашем запросе API
	$api_params = array(
		'edd_action'  => 'activate_license',
		'license'     => $license,
		'item_id'     => ALMAZ_PREMIUM_SITES_ITEM_ID,
		'item_name'   => rawurlencode( ALMAZ_PREMIUM_SITES_ITEM_NAME ), // the name of our product in EDD
		'url'         => home_url(),
		'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
	);

	// Вызов пользовательского API.
	$response = wp_remote_post(
		ALMAZ_PREMIUM_SITES_STORE_URL,
		array(
			'timeout'   => 15,
			'sslverify' => false,
			'body'      => $api_params,
		)
	);

		// убедитесь, что ответ вернулся в порядке
	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

		if ( is_wp_error( $response ) ) {
			$message = $response->get_error_message();
		} else {
			$message = __( 'An error occurred, please try again.' , 'almaz-premium-sites' );
		}
	} else {

		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( false === $license_data->success ) {

			switch ( $license_data->error ) {

				case 'expired':
					$message = sprintf(
						/* переводчики: срок действия лицензионного ключа */
						__( 'Your license key expired on %s.', 'almaz-premium-sites' ),
						date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
					);
					break;

				case 'disabled':
				case 'revoked':
					$message = __( 'Your license key has been disabled.', 'almaz-premium-sites' );
					break;

				case 'missing':
					$message = __( 'Invalid license.', 'almaz-premium-sites' );
					break;

				case 'invalid':
				case 'site_inactive':
					$message = __( 'Your license is not active for this URL.', 'almaz-premium-sites' );
					break;

				case 'item_name_mismatch':
					/* переводчики: имя плагина */
					$message = sprintf( __( 'This appears to be an invalid license key for %s.', 'almaz-premium-sites' ), ALMAZ_PREMIUM_SITES_ITEM_NAME );
					break;

				case 'no_activations_left':
					$message = __( 'Your license key has reached its activation limit.', 'almaz-premium-sites' );
					break;

				default:
					$message = __( 'An error occurred, please try again.', 'almaz-premium-sites' );
					break;
			}
		}
	}

		// Проверяем, передано ли что-нибудь в сообщении, составляющем сбой
	if ( ! empty( $message ) ) {
		$redirect = add_query_arg(
			array(
				'page'          => ALMAZ_PREMIUM_SITES_PLUGIN_LICENSE_PAGE,
				'sl_activation' => 'false',
				'message'       => rawurlencode( $message ),
			),
			admin_url( 'plugins.php' )
		);

		wp_safe_redirect( $redirect );
		exit();
	}

	// $license_data->лицензия будет либо "действительной", либо "недействительной"
	if ( 'valid' === $license_data->license ) {
		update_option( 'almaz_premium_sites_license_key', $license );
	}
	update_option( 'almaz_premium_sites_license_status', $license_data->license );
	wp_safe_redirect( admin_url( 'plugins.php?page=' . ALMAZ_PREMIUM_SITES_PLUGIN_LICENSE_PAGE ) );
	exit();
}
add_action( 'admin_init', 'almaz_premium_sites_activate_license' );

/**
* Деактивирует лицензионный ключ.
  * Это уменьшит количество сайтов.
 *
 * @return void
 */
function almaz_premium_sites_deactivate_license() {

	// слушайте нашу кнопку активации, которая будет нажата
	if ( isset( $_POST['edd_license_deactivate'] ) ) {

		// запустить быструю проверку безопасности
		if ( ! check_admin_referer( 'almaz_premium_sites_nonce', 'almaz_premium_sites_nonce' ) ) {
			return; // выйти, если мы не нажали кнопку Активировать
		}

		// получить лицензию из базы данных
		$license = trim( get_option( 'almaz_premium_sites_license_key' ) );

		// данные для отправки в нашем запросе API
		$api_params = array(
			'edd_action'  => 'deactivate_license',
			'license'     => $license,
			'item_id'     => ALMAZ_PREMIUM_SITES_ITEM_ID,
			'item_name'   => rawurlencode( ALMAZ_PREMIUM_SITES_ITEM_NAME ), // название нашего продукта в EDD
			'url'         => home_url(),
			'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
		);

		// Вызов пользовательского API.
		$response = wp_remote_post(
			ALMAZ_PREMIUM_SITES_STORE_URL,
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params,
			)
		);

		// убедитесь, что ответ вернулся в порядке
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.' , 'almaz-premium-sites' );
			}

			$redirect = add_query_arg(
				array(
					'page'          => ALMAZ_PREMIUM_SITES_PLUGIN_LICENSE_PAGE,
					'sl_activation' => 'false',
					'message'       => rawurlencode( $message ),
				),
				admin_url( 'plugins.php' )
			);

			wp_safe_redirect( $redirect );
			exit();
		}

		// расшифровать данные лицензии
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->лицензия будет либо "деактивирована", либо "сбой"
		if ( 'deactivated' === $license_data->license ) {
			delete_option( 'almaz_premium_sites_license_status' );
		}

		wp_safe_redirect( admin_url( 'plugins.php?page=' . ALMAZ_PREMIUM_SITES_PLUGIN_LICENSE_PAGE ) );
		exit();

	}
}
add_action( 'admin_init', 'almaz_premium_sites_deactivate_license' );

/**
* Проверяет, действителен ли лицензионный ключ.
  * Программа обновления делает это за вас, так что это нужно только в том случае, если вы хотите
  * делать что-то на заказ.
 *
 * @return void
 */
function almaz_premium_sites_check_license() {

	$license = trim( get_option( 'almaz_premium_sites_license_key' ) );

	$api_params = array(
		'edd_action'  => 'check_license',
		'license'     => $license,
		'item_id'     => ALMAZ_PREMIUM_SITES_ITEM_ID,
		'item_name'   => rawurlencode( ALMAZ_PREMIUM_SITES_ITEM_NAME ),
		'url'         => home_url(),
		'environment' => function_exists( 'wp_get_environment_type' ) ? wp_get_environment_type() : 'production',
	);

	// Вызов пользовательского API.
	$response = wp_remote_post(
		ALMAZ_PREMIUM_SITES_STORE_URL,
		array(
			'timeout'   => 15,
			'sslverify' => false,
			'body'      => $api_params,
		)
	);

	if ( is_wp_error( $response ) ) {
		return false;
	}

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if ( 'valid' === $license_data->license ) {
		echo 'valid';
		exit;
		// эта лицензия все еще действительна
	} else {
		echo 'invalid';
		exit;
		// эта лицензия больше не действительна
	}
}

/**
 * Это средство обнаружения ошибок из приведенного выше метода активации и отображения их клиенту.
 */
function almaz_premium_sites_admin_notices() {
	if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {

		switch ( $_GET['sl_activation'] ) {

			case 'false':
				$message = urldecode( $_GET['message'] );
				?>
				<div class="error">
					<p><?php echo wp_kses_post( $message ); ?></p>
				</div>
				<?php
				break;

			case 'true':
			default:
				// Разработчики могут разместить здесь собственное сообщение об успешном завершении активации, если они этого хотят.
				break;

		}
	}
}
add_action( 'admin_notices', 'almaz_premium_sites_admin_notices' );

/**
 * Almaz premium sites: Введите лицензионный ключ, чтобы получать обновления, расширенную поддержку, доступ к премиум шаблонам.
 * 
 */
if (get_option('almaz_premium_sites_license_status') !== 'valid') {
	function almaz_premium_sites_error_notice_no_license_key(){
		$message = __( 'Премиум сайты Алмаз: Введите лицензионный ключ, чтобы получать обновления, расширенную поддержку, доступ к премиум шаблонам.' , 'almaz-premium-sites' );
		echo '<div class="notice notice-info is-dismissible"> <p>'. $message .'</p></div>';
	}

	add_action('admin_notices', 'almaz_premium_sites_error_notice_no_license_key');
}