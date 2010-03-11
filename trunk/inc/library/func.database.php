<?php if (!defined("IN_SYS")) die("Access Denied.");
/**
 * 数据库组件
 * 为系统提供数据库访问
 * 依赖于cache库
 * 源自 CodeIgniter框架
 * 版权 Copyright (c) 2008 - 2009, EllisLab, Inc.
 * 作者 ExpressionEngine Dev Team
 * 主页 http://codeigniter.com/user_guide/database/
 */

/**
 * 初始化数据库
 */
function &load_db($params = '') {
	// Load the DB config file if a DSN string wasn't passed
	if (is_string($params) AND strpos($params, '://') === FALSE) {
		include(DIR_ROOT.'config/database.php');
		if (!isset($db) || count($db) == 0) {
			die('No database connection settings were found in the database config file.');
		}
		if ($params != '') {
			$active_group = $params;
		}
		if (!isset($active_group) || !isset($db[$active_group])) {
			die('You have specified an invalid database connection group.');
		}
		$params = $db[$active_group];
	}elseif (is_string($params)){
		/* parse the URL from the DSN string
		*  Database settings can be passed as discreet
	 	*  parameters or as a data source name in the first
	 	*  parameter. DSNs must have this prototype:
	 	*  $dsn = 'driver://username:password@hostname/database';
		*/
		if (($dns = @parse_url($params)) === FALSE) {
			die('Invalid DB Connection String');
		}
		$params = array(
				'dbdriver'	=> $dns['scheme'],
				'hostname'	=> (isset($dns['host'])) ? rawurldecode($dns['host']) : '',
				'username'	=> (isset($dns['user'])) ? rawurldecode($dns['user']) : '',
				'password'	=> (isset($dns['pass'])) ? rawurldecode($dns['pass']) : '',
				'database'	=> (isset($dns['path'])) ? rawurldecode(substr($dns['path'], 1)) : ''
		);
		// were additional config items set?
		if (isset($dns['query'])) {
			parse_str($dns['query'], $extra);
			foreach($extra as $key => $val) {
				// booleans please
				if (strtoupper($val) == "TRUE") {
					$val = TRUE;
				}elseif (strtoupper($val) == "FALSE"){
					$val = FALSE;
				}
				$params[$key] = $val;
			}
		}
	}

	// No DB specified yet?  Beat them senseless...
	if (!isset($params['dbdriver']) || $params['dbdriver'] == '') {
		die('You have not selected a database type to connect to.');
	}

	// Load the DB classes.  Note: Since the active record class is optional
	// we need to dynamically create a class that extends proper parent class
	// based on whether we're using the active record class or not.
	// Kudos to Paul for discovering this clever use of eval()

	require_once(DIR_INC.'library/database/driver.php');
	require_once(DIR_INC.'library/database/active_rec.php');
	require_once(DIR_INC.'library/database/drivers/'.$params['dbdriver'].'/'.$params['dbdriver'].'_driver.php');

	// Instantiate the DB adapter
	$driver = 'db_'.$params['dbdriver'].'_driver';
	$DB =& instantiate_class(new $driver($params));

	if ($DB->autoinit == TRUE) {
		$DB->initialize();
	}

	return $DB;
}	

/* End of the file */