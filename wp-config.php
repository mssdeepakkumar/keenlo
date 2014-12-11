<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('DB_NAME', 'admin_keenlo_com');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}1$`.5EL*%.H/iJC69:1/+Q^3faQ^:8.g]~Mn;P5(N&CW6?`0,*{(+^10^9|z.5B');
define('SECURE_AUTH_KEY',  'K6fUG|%^Wu_V.H3f(7+,Fr&-|f%f%R&~!bP+qE);|$xwRtj63~Zi+IE!r-jpkF+|');
define('LOGGED_IN_KEY',    'We]VH+77CP3Sk}{IF]L-@;C hZAL|f*:[gmG%wzX-fAUf*4inzycSUzI;UX.0w(o');
define('NONCE_KEY',        'EO[GWC*([1|g`:(hSzb`3CI|BgnOjYs1y0]jx<S:y]_r0.,ONr&s00KL?7)gx R=');
define('AUTH_SALT',        'zINE,Rm|MR=;_1+dS|b0bwZfl!imXkA[*lb|s~w*&jrq(]zxF:0{|MExxE^(89cA');
define('SECURE_AUTH_SALT', '2*+[9dNXNq~?Y|/Fr?+^mYF29-Llty0>-p{3vHdB;Es`IuP:z|<xyn:DHc?)V71:');
define('LOGGED_IN_SALT',   '%v|4[M;&)A*D!pC%(0<z2)=W_uB,_euYBf$p0Z62>uz*4Fu{ce4{}iNjL1(^493s');
define('NONCE_SALT',       'd1?jW.5ZF;@UV}5mOG(KGvlJ1_v) J_{7:aKBXI>I#q,N7UX8WC-P82E5w9P/Dxf');

define('RELOCATE',true);
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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
