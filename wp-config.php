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
define( 'DB_NAME', 'ecommerce-wp_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         ';kxi%|idcGkQ6$o~)HI1^QCM2b< j{OO,rrAxTXb2dxL9|F3IadJe:6.rSY@}#4j' );
define( 'SECURE_AUTH_KEY',  'RAu`I}uL5Bv>R6n]#pkCgN6@P2N88|sjxPGSCJyjw+pIETwJ:p614o>uT69K_8:/' );
define( 'LOGGED_IN_KEY',    '-|mTZYJ;xZr`eIrh1sOX-j$p1).v6[p_45?5u8^X0iLj<KaBQiMOV)$eSQi:UqTB' );
define( 'NONCE_KEY',        '4p)ig98 3 >/h|B1NQH_UNG@}`2WQ9HOxD9RV*4JO>!U9q$WZntYtj_tk){>VND.' );
define( 'AUTH_SALT',        '{&gNf^/4vI)ulnDCG9or5{`3K=<bk5#Iq|K_.]O5|c,:9<_k3& q,s@~TY-=L/j5' );
define( 'SECURE_AUTH_SALT', 'khJgi34b{?3QodMrhE.f!)H!Wy$T,>}Q(LEpTcv]H1$[KGlT,PPI},41VsH=u(mF' );
define( 'LOGGED_IN_SALT',   '!!^5#X+~I}:*T:,b)m7|N6h2fFuKKSCC;D}NghF!8IAul{<qh3dfe-njR:d6#w54' );
define( 'NONCE_SALT',       '{%e3f]h*u(@6}$Kew6+&7qnP-Dj;#cf6,HdQG^7s@M!KUD|2wpCcqnqWb$P~MzzR' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
