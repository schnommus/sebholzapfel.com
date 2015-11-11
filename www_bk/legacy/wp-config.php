<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'a6875114_db');

/** MySQL database username */
define('DB_USER', 'a6875114_seb');

/** MySQL database password */
define('DB_PASSWORD', 'blan777');

/** MySQL hostname */
define('DB_HOST', 'mysql5.000webhost.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ErYiR(eWV)TXWSOl8cW6T1^4rGzB^7Ii(dy%beygYu#g9pdr@kao13AznuENWaHi');
define('SECURE_AUTH_KEY',  'Uy*iqeSmLl2ZfIkwjqqW3Tv2ciDSmjgolZ0uiyefOpgd6M65J&uL8KK$0ap!%1Y!');
define('LOGGED_IN_KEY',    'G@7D7*Y@4d!B9jV4jDuzytaA$EPfhyEh%JNl!FZPwy2j@mJVbvnxqa$0H9U(BK1*');
define('NONCE_KEY',        '%JKiYrWsc)LsxpeG6dTY!LZSf9U3oWpr^yGcpr71KY!98DZooYIVo1I02%TF%D*O');
define('AUTH_SALT',        'Ua#dv%85YkJsNvjHjVUN)cR!^Rn*XXC$&S9WYh&u2W81UAS5OI*ag&$p)B1J)kW3');
define('SECURE_AUTH_SALT', '#yNwIZlb!XJ6w4u1hYomE*H*!$i^3zl1EPzT$2@mgR@(rIaELKYuwRptEiA@nNvL');
define('LOGGED_IN_SALT',   'Za&ZhfH^Ua5XPyt4q2wbGc@wylTlT@6lUUtn6MkNNiTyOm0vEGhsx9Ft&aN0f1xK');
define('NONCE_SALT',       'I9H6oRh!NL9A07Bf!XZWWO542860@P$J0J1)OjQviZeAg&sPrFqpIt(^2n6M7@7r');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'en_US');

define ('FS_METHOD', 'direct');

define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

?>
