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
define( 'DB_NAME', 'objctv' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'mariadb' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'OH-+4#cSH4r7q@Vg+)#/fkv#pJWgQ@B5+|dpRJCTN)pDz{*$VM!7n|{0-nvrhM7A');
define('SECURE_AUTH_KEY',  'q]hIoo_NJDVEJ/<Gl8_Wqc|^w8(`{PXx=<~ZnHtivNZ/|]rQFpuir4NP.Y,<2ku_');
define('LOGGED_IN_KEY',    '=jBCtT@lOjy: j92-Cc?+q)Ix[=3~67a}lCkAltm9n>-ayCg-~N-Jrd z+oj((UZ');
define('NONCE_KEY',        'cXz|Nf@v%|F1~XO=l1Raytxw!bh`L8MRSF0[3szIb!`]r3i @x.[3979,ji$ <^,');
define('AUTH_SALT',        'QSm{S+%]= !]fD>0T}J#|;ho6D%+VELcqhLX|iVDU<c|rof71:0-|}YZi|f$W|la');
define('SECURE_AUTH_SALT', ' wcPsVd)R],zaIBDH`CeDnm3{|U9F6<Y|a<NZ*4Q^dPg5>v92vA_wEZ#bE&2b>9|');
define('LOGGED_IN_SALT',   'pIAL1nXnBLA+Pz!BMA;o_.**&0YjYs#+o/`ZWV$u-I-?oia]+aKWHd-fQ6tSYr}z');
define('NONCE_SALT',       'B.9Ig9QFiTSTHS|.UpH_O2d?:b{F[|m4c|bfv,ja7=J@VTjvj|K2<K.hSDtO_d]%');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'objctv_site_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
