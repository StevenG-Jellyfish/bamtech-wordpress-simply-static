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
define('DB_NAME', getenv('DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('DB_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('DB_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('DB_HOST'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', getenv('DB_CHARSET'));

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', getenv('DB_COLLATE'));

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY'));
define('NONCE_KEY',        getenv('NONCE_KEY'));
define('AUTH_SALT',        getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT'));
define('NONCE_SALT',       getenv('NONCE_SALT'));

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */

$table_prefix  = getenv('TABLE_PREFIX');

define('WP_HOME',getenv('WP_HOME'));
define('WP_SITEURL',getenv('WP_SITEURL'));
define('WP_CONTENT_URL', getenv('WP_CONTENT_URL'));

/* Redis */
define('WP_REDIS_SCHEME', getenv('WP_REDIS_SCHEME'));
define('WP_REDIS_HOST', getenv('WP_REDIS_HOST'));
define('WP_REDIS_PORT', getenv('WP_REDIS_PORT'));


define('WP_REDIS_GLOBAL_GROUPS', [
       'blog-details',
       'blog-id-cache',
       'blog-lookup',
       'global-posts',
       'networks',
       'rss',
       'sites',
       'site-details',
       'site-lookup',
       'site-options',
       'site-transient',
       'users',
       'useremail',
       'userlogins',
       'usermeta',
       'user_meta',
       'userslugs'
]);
define('WP_REDIS_IGNORED_GROUPS', [
      'counts',
      'plugins'
]);
define('WP_CACHE_KEY_SALT', getenv('WP_CACHE_KEY_SALT'));
define('WP_REDIS_MAXTTL', getenv('WP_REDIS_MAXTTL'));
define('WP_REDIS_DISABLED', filter_var(getenv('WP_REDIS_DISABLED'), FILTER_VALIDATE_BOOLEAN));

/* General */
define('DISABLE_WP_CRON', filter_var(getenv('DISABLE_WP_CRON'), FILTER_VALIDATE_BOOLEAN));
define('FORCE_SSL_ADMIN', filter_var(getenv('FORCE_SSL_ADMIN'), FILTER_VALIDATE_BOOLEAN));
define('DISALLOW_FILE_EDIT', getenv('DISALLOW_FILE_EDIT'));

/* Debugging flags */
define('SCRIPT_DEBUG', filter_var(getenv('SCRIPT_DEBUG'), FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG', filter_var(getenv('WP_DEBUG'), FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_DISPLAY', filter_var(getenv('WP_DEBUG_DISPLAY'), FILTER_VALIDATE_BOOLEAN));

/* Memory */
define('WP_MEMORY_LIMIT', getenv('WP_MEMORY_LIMIT'));
define('WP_MAX_MEMORY_LIMIT', getenv('WP_MAX_MEMORY_LIMIT'));

/** ElasticPress */
define( 'EP_HOST', getenv('EP_HOST') );

/** Set max post revisions */
define( 'WP_POST_REVISIONS', 4 );

// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') ){
    define('ABSPATH', dirname(__FILE__) . '/');
}

/*
require-wp-settings.php
*/
require_once(ABSPATH . 'wp-settings.php');
