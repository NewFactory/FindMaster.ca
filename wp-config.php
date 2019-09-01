<?php
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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dbs155346' );

/** MySQL database username */
define( 'DB_USER', 'dbu181450' );

/** MySQL database password */
define( 'DB_PASSWORD', '10051qazXSW@' );

/** MySQL hostname */
define( 'DB_HOST', 'db5000160233.hosting-data.io' );

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
define( 'AUTH_KEY',         '9.xFL7>w8JIu,9 0X^whK +*}eW7qv]7h 6521/ryAB11Z$P@BQUY/Lp?@(,yDPX' );
define( 'SECURE_AUTH_KEY',  'MLFpaE5U!WI5US>S?e=#xJZSiumbjXuJ0n FqW|<b@v^!]o^0R}3;O.xWHjom$Ly' );
define( 'LOGGED_IN_KEY',    '+Nc]~y!b0dFoQ8gYJDR]#HJ!tv5>)=1Zjm iBNJX_`r>+C1/fzeeH@wxEWF7l,8/' );
define( 'NONCE_KEY',        'D[<ap>>kT jxkOj<0p9;:%T83?)J^(|^`UNO>)WNm=eD@}E1Sb|05fHH[D<956sm' );
define( 'AUTH_SALT',        'e:,GQ[`B|]@jC,lr:2vwJ< gOA|@=x})uX0OMhIX|%Kk1jQytXB+)uWE.~#OQd2R' );
define( 'SECURE_AUTH_SALT', 'AbwOT%{l;mRC)shq&XosvV~ek,j#79=*&;scjP=Avv^37FhXoSD.D%K!ve)D#6dc' );
define( 'LOGGED_IN_SALT',   ')L):BGN:SpxbR(V&2kUZ.=-[E(an)dyK3QO)4J~z,X3B1]ER}hq&v&pS=](as&4:' );
define( 'NONCE_SALT',       'PL`zvOFd?]Qh!uKDwan|23y%USiOGVHcDJ83)1~b6nsEQ s&4i:R8)Usi?aN:J%*' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
