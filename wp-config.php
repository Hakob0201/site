<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', "user81735_covid" );


/** Имя пользователя MySQL */
define( 'DB_USER', "user81735_covid" );


/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', "WGrTsNLA2GeKrwsG" );


/** Имя сервера MySQL */
define( 'DB_HOST', "176.126.165.135" );


/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );


/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Qz0u<i=tB=OtgZq5oq}<Rt@3VE7ZO3}]4qh(|)>PJXt[HoVJK%O:q=/P7+rvf%ts' );

define( 'SECURE_AUTH_KEY',  'E@Lb@EluDp@e9#.rR<+(/Fb_$JoO.OW [%^X{zHYtM=fTuqXpfq,_Pl%o7]n?+80' );

define( 'LOGGED_IN_KEY',    'H?kx|Cw=NvT_x@$(/r6=U2*hB4}=B!i+-KaJY*3Y-*K,0qrqUCUC^5*$!QDVP O;' );

define( 'NONCE_KEY',        '4i`I*s;}rjfcav(g%avCum%6xe.ESu1qaFa%}e<o*oWLd@.<1b0|?oF}+Gi>HlCa' );

define( 'AUTH_SALT',        '||uB<7U(/xhRw0pMS!lf_V-]9x(&Z62iO&g7ChYr=[;HiKU%)RQA)^+LfJ]*(SC]' );

define( 'SECURE_AUTH_SALT', 'c0#DKa;R^43H^*l~2ZY[S&.6N<&uPiryg<D)7$bjQgk lYDs61<e`tiQA$L#Nd$M' );

define( 'LOGGED_IN_SALT',   'M-n)nij$9xMr$M*SBV;#x}GEOPzROO+,IvxmTkVsuE6nX` .T3gi[?gHD36 J_LI' );

define( 'NONCE_SALT',       'Y$I4^,WGe[)vtf?H8r}6)ZK*nK3n;6_^#it@6_UXX3Rm`kcf}fvc]cATonuz#B/>' );


/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';


/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
