<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pbdigitalTalentstacker_1691570120' );

/** Database username */
define( 'DB_USER', 'pbdigitalTalentstacker_1691570120' );

/** Database password */
define( 'DB_PASSWORD', 'Rx6LlrMfDinHQg697DExSHQAWcasPmejHsYY5P95R4VV5SkDvX66v' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'dWNQsv_/fy|/!v{yFpU9/8Sjl2efV<{6Dv9Nl[QuKl2HMASQp*`}_l7M (|)XDJF' );
define( 'SECURE_AUTH_KEY',   '&I;MSfd84Ba T{|V?$CYj=jL@p|)F=S97YLL)%ruNlTI=8]xN@i #a[&!k`e2^$d' );
define( 'LOGGED_IN_KEY',     '7u0F&bz_:e6eAWb4#._}5AFZ,1p.X@;l<cn{(Gla1Y2l9FiYX2n<//K<}!31PX7v' );
define( 'NONCE_KEY',         'Zvaou-6+o9D%TA{t5Un<F}QY4c0U^[$sUFyd#OFCOrQ6p g/Mm3WF+1r7j$e.D9n' );
define( 'AUTH_SALT',         '<<AE9#g/(Qx+/dkdjiVk6}qSxuKZP.mj$gAB=PXt:8.[*Rp9Nu:qG)g42ea?<GBx' );
define( 'SECURE_AUTH_SALT',  '<_$VAWV{1*NK_)qia->A=LFD=P$a2!_!Yc|(hDLe$W4_alTDM*^ SL,Wm)}=zngA' );
define( 'LOGGED_IN_SALT',    'K#)E_V|rt=E]uYL.U@3T+Xjvf7DBMFSO?wy_Xzd[W[#jR8aegdk?i:#W,xK(l0ab' );
define( 'NONCE_SALT',        '0Lf!4vEM:vl>szd3 6$R1PO-:~yE6|8h hoG!,,jIFL-UD?CK+I&WZXKTG?Hb[_3' );
define( 'WP_CACHE_KEY_SALT', 'QM$&Z:WH^6Gbq.>))7Vk -;{QT320*(~-e7JJf4Mkpi^m7zN 5Bn~9W$19MOAz}f' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
