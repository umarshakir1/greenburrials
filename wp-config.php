<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'green-burials' );

/** Database username */
define( 'DB_USER', 'umar' );

/** Database password */
define( 'DB_PASSWORD', 'Admin123!!!' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}}~<Gp8I%1Pb EpN-V1:r-:YTw6=v*^+qGBtx HW8eC|dSogpP!!ts/neaLgwPD`');
define('SECURE_AUTH_KEY',  '>=[1V!T*`+sdJ/_-<V#Mh}/CNdZlPV4V}<xd&$/+&i-Hj/</7TwrF+.v:T/<(c@*');
define('LOGGED_IN_KEY',    'P~1dhZ(-{W$ePPeZEzE}T9?o8Tz`|42rUZp&y3? T6-J(ktgKX1><T_Nv6dm10U<');
define('NONCE_KEY',        'e1Mcf@Hv4?W@nG|_@o3,Awjk&Sv?|  t`I>OHA)6r$-/;ot|hA+KN_jq-Q}vX,*+');
define('AUTH_SALT',        'y8Ia*V-DJ%`<w$Q^mM2Gf$F<O$_Y=0Xw+|$!VZ(/3kE$RwAVp&Q!Iv=[.Y07{>zq');
define('SECURE_AUTH_SALT', '+|dc] RKriNs-QZ:++9r@ D4kga.Fb|e=wUtaYPPJEcI@%2N C3tgk/*Ul$NR0r1');
define('LOGGED_IN_SALT',   'U)K3_WkLNEUQh+(-jB>zpO>5D{e]g1*v~|$=@)JIFL[/GBO^?2nnU%0-zh%g]AA[');
define('NONCE_SALT',       's88^|]OG~;@Zsx6GhLGf+;iZ]xQ+<,M[l,hJHw+x~#NO#/~g8zG}w]--;1||Lk6p');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

define( 'WP_HOME', 'http://localhost/green-burials' );
define( 'WP_SITEURL', 'http://localhost/green-burials' );
define( 'FS_METHOD', 'direct' );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
