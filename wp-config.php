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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'smarttech');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ']pNHj0VS62t`T!lCn~J~Qv.AzJF%SvEc_lOz3Ra6Ks;-=alaw >YLNz6)2|^oAwr');
define('SECURE_AUTH_KEY',  'HBsKp-z<ZXcmC}j{FA)jD*lRC}x4]CYbQ=N,`HD!%CctAU62:l^L>@Q*MWBUihg&');
define('LOGGED_IN_KEY',    'g+xJe|U/@xwQKu*1`&LW!X6f/I?O :v(/CojVs&wNDXn*8hF?I1;g.c_]bY{spOj');
define('NONCE_KEY',        '>f2yyaRP|~P]pMBY%d}G>d$K^P!_sy&&`0XF+b9x&2)C}4=[g:`f,h^ghHJ;iEiU');
define('AUTH_SALT',        '4=tl,QD#=B,_;dg.x}*bby U60JEQ:S=fOiJa;ol8^2U`SN_=k(lb:!N!ktq-_5u');
define('SECURE_AUTH_SALT', 's*z4He$p?VuyOc_1s8TTYNLfW@4y;@KHS!]DgcA0#c(19W9NWXf_@n)EjU 7f.0e');
define('LOGGED_IN_SALT',   '5Evqw};Wdk_EKqqE=grz-^q!c`Gn[Y%@YS0~.533~ksUo2]C,C4b%Y&c5vs0=VyW');
define('NONCE_SALT',       'y_K},up]_V&Ku-!r[WMm/Ip00)opxJ@g`P.-LSl]ZcGpP.JO1gMA*e-Is7N)W;[0');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
