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
define('DB_NAME', 'melnikps_psy');

/** Имя пользователя MySQL */
define('DB_USER', 'melnikps_psy');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '*MkyDe.q,#kd');

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
define('AUTH_KEY',         'Y>MPO_}RES.7b0wY)azULudb$ZZGa$JjzaUQ2t&!Yhim8m>@]K$ag,`V}rV)vSz%');
define('SECURE_AUTH_KEY',  'M|@@snCN*fstO_--W8@/rE>*=&hu)XLH ;(M4`uoIr_OS[Em@u7op#PmsP)m[~w=');
define('LOGGED_IN_KEY',    'bT<G/D4P)0&Eia;aX7p$I|kTi9acnZs=x-Nt?[J~e<yZjF; |GWag!>A&>?][T!9');
define('NONCE_KEY',        'Fr8yv(*/zCTx;Xo4qr9-T5^RT%8KCfB}>>Wx-<kW#x$O+i |=)k1%dRGd1q*{*b9');
define('AUTH_SALT',        'T5$g:E.p28Inj1xMnDl&*Pqef:$^rkx2*3U}8._8ThJi>J&4C+S9:M-[o~uC]HsD');
define('SECURE_AUTH_SALT', '!-YF9up1QpRY[h|XH) =W<}/.-3mzOa#<IW^=Y.tUM*shK|4.yr_x}h.J;S4bjZr');
define('LOGGED_IN_SALT',   '!;(#YI1oY4y^rJ_<9Vp^j_VlPWQ5]]VxPOPSEgDN.,xh8r1xozKr@RoD+MMUckJ ');
define('NONCE_SALT',       '!o5b8LHCH-l%*S546OgG2<c41vCW%#OYk6Y(awZmhOuI<1,*u~@SBEI%BX]ws?~W');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'ru_';

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
