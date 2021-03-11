<?php
define( 'WP_CACHE', true ); // Added by WP Rocket

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'eventos_wp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?B((E$YI)ArA*t#ZXtTP=DH:X#al-dfi|=.he_TaT|P{*PM8(W?<GR SLr[h~mkk' );
define( 'SECURE_AUTH_KEY',  'ZP]%tR0CO3[+r(qA![#ORa/389~>%2[ipUSS.EXpIk0FC_A{{-NY^ MpO84J[Zua' );
define( 'LOGGED_IN_KEY',    ']dL)O56B_0li6BK,Eg$BuR*3D>y[7AH|>@vmS&^h}q.9ckkFfjqcbir}OqJd(;w;' );
define( 'NONCE_KEY',        ')E^>Aom?HH7xMx{yTcnAsc{s+H+ YaL<6XT2FLjD{rsE|8!jJYq]V/3h}mi*|3!B' );
define( 'AUTH_SALT',        'vxgN`ag05VF(+(xb4z#VcHuy@jPEf<wm|8RKy2 ,g9T(G!*!/+}.q jy=,Fl_;Q;' );
define( 'SECURE_AUTH_SALT', 'SHa3?NA;g&?T;%gGGka3ov#oG,=p2;?exCiC1b*+,9kP|+x26aovJ#ScCmh[wK*,' );
define( 'LOGGED_IN_SALT',   'lV|cr`O+U3#Gmh04P(:hF.@zw&ww5Myn]N,$J-z5#vww{Njq5Y@)88K#(=4L9,b3' );
define( 'NONCE_SALT',       ']t(htfr`xr4e=cCjj^ML1N9|7xJ7Am,W9`_H~&3/-FGZnMPB(f`YaP3jSI}b]u/I' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'eupc_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
