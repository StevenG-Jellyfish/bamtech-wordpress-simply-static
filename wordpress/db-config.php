<?php

/**
 * HyperDB configuration file
 *
 * This file should be installed at ABSPATH/db-config.php
 *
 * $wpdb is an instance of the hyperdb class which extends the wpdb class.
 *
 * See readme.txt for documentation.
 */

/**
 * Introduction to HyperDB configuration
 *
 * HyperDB can manage connections to a large number of databases. Queries are
 * distributed to appropriate servers by mapping table names to datasets.
 *
 * A dataset is defined as a group of tables that are located in the same
 * database. There may be similarly-named databases containing different
 * tables on different servers. There may also be many replicas of a database
 * on different servers. The term "dataset" removes any ambiguity. Consider a
 * dataset as a group of tables that can be mirrored on many servers.
 *
 * Configuring HyperDB involves defining databases and datasets. Defining a
 * database involves specifying the server connection details, the dataset it
 * contains, and its capabilities and priorities for reading and writing.
 * Defining a dataset involves specifying its exact table names or registering
 * one or more callback functions that translate table names to datasets.
 */

/** Variable settings **/

/**
 * save_queries (bool)
 * This is useful for debugging. Queries are saved in $wpdb->queries. It is not
 * a constant because you might want to use it momentarily.
 * Default: false
 */
$wpdb->save_queries = false;

/**
 * persistent (bool)
 * This determines whether to use mysql_connect or mysql_pconnect. The effects
 * of this setting may vary and should be carefully tested.
 * Default: false
 */
$wpdb->persistent = false;

/**
 * max_connections (int)
 * This is the number of mysql connections to keep open. Increase if you expect
 * to reuse a lot of connections to different servers. This is ignored if you
 * enable persistent connections.
 * Default: 10
 */
$wpdb->max_connections = 10;

/**
 * check_tcp_responsiveness
 * Enables checking TCP responsiveness by fsockopen prior to mysql_connect or
 * mysql_pconnect. This was added because PHP's mysql functions do not provide
 * a variable timeout setting. Disabling it may improve average performance by
 * a very tiny margin but lose protection against connections failing slowly.
 * Default: true
 */
$wpdb->check_tcp_responsiveness = true;

/** Configuration Functions **/

/**
 * $wpdb->add_database( $database );
 *
 * $database is an associative array with these parameters:
 * host          (required) Hostname with optional :port. Default port is 3306.
 * user          (required) MySQL user name.
 * password      (required) MySQL user password.
 * name          (required) MySQL database name.
 * read          (optional) Whether server is readable. Default is 1 (readable).
 *						   Also used to assign preference. See "Network topology".
 * write         (optional) Whether server is writable. Default is 1 (writable).
 *                          Also used to assign preference in multi-master mode.
 * dataset       (optional) Name of dataset. Default is 'global'.
 * timeout       (optional) Seconds to wait for TCP responsiveness. Default is 0.2
 * lag_threshold (optional) The minimum lag on a slave in seconds before we consider it lagged. 
 *							Set null to disable. When not set, the value of $wpdb->default_lag_threshold is used.
 */



/** Sample Configuration 1: Using the Default Server **/
/** NOTE: THIS IS ACTIVE BY DEFAULT. COMMENT IT OUT. **/

/**
 * This is the most basic way to add a server to HyperDB using only the
 * required parameters: host, user, password, name.
 * This adds the DB defined in wp-config.php as a read/write server for
 * the 'global' dataset. (Every table is in 'global' by default.)
 */
$wpdb->add_database(array(
	'host'     => DB_HOST,     // If port is other than 3306, use host:port.
	'user'     => DB_USER,
	'password' => DB_PASSWORD,
	'name'     => DB_NAME,
));

/**
 * This adds the same server again, only this time it is configured as a slave.
 * The last three parameters are set to the defaults but are shown for clarity.
 */
$wpdb->add_database(array(
	'host'     => DB_HOST,     // If port is other than 3306, use host:port.
	'user'     => DB_USER,
	'password' => DB_PASSWORD,
	'name'     => DB_NAME,
	'write'    => 0,
	'read'     => 1,
	'dataset'  => 'global',
	'timeout'  => 0.2,
));


// The ending PHP tag is omitted. This is actually safer than including it.
