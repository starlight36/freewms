<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-----------------------------------------------*/

/*-------------------------------------------------
 | Mysql数据库驱动类
 *-----------------------------------------------*/

class DB_DRIVER {

	public static $conn = NULL;
	public static $querynum = 0;

	/**
	 * 连接数据库
	 */
	public function connect($dbhost, $dbuser, $dbpass, $dbname = NULL, $pconnect = 0) {
		if(self::$conn != NULL) {
			return;
		}

		if($pconnect==1) {
			self::$conn = @mysql_pconnect($dbhost, $dbuser, $dbpass);
		}else{
			self::$conn = @mysql_connect($dbhost, $dbuser, $dbpass);
		}
		if(!self::$conn) {
			DB::halt('Can not connect to MySQL server');
		}

		if($dbname != NULL) {
			$this->select_db($dbname);
		}
	}

	/**
	 * 选择数据库
	 */
	public function select_db($db) {
		$rst = mysql_select_db($db);
		if($rst) {
			if(mysql_get_server_info() >= '4.1.0') mysql_query("SET NAMES 'utf8'");
		}
		return $rst;
	}

	/**
	 * 执行一条SQL查询
	 * @param string $sql
	 * @param int $silence 是否打开安静模式
	 * @return resources
	 */
	public function query($sql, $silence = 0) {
		$query = mysql_query($sql);
		if(!$query && !$silence) {
			DB::halt('MySQL Query Error', $sql);
		}
		self::$querynum++;
		return $query;
	}

	/**
	 * 读取一条记录并向下移动游标
	 */
	public function fetch($query, $result_type = MYSQL_ASSOC) {
		if($result_type == 'object') {
			return mysql_fetch_object($query, $result_type);
		}else{
			return mysql_fetch_array($query, $result_type);
		}
	}

	/**
	 * 取结果集中指定行记录
	 */
	public function result($query, $row = 0) {
		return @mysql_result($query, $row);
	}

	/**
	 * 返回结果集的记录数
	 */
	public function num_rows($query) {
		return @mysql_num_rows($query);
	}

	/**
	 * 返回结果集的字段数
	 */
	public function num_fields($query) {
		return @mysql_num_fields($query);
	}

	/**
	 * 返回上一条INSERT查询的自动增加ID
	 */
	public function insert_id() {
		return mysql_insert_id();
	}

	/**
	 * 查询影响的记录数
	 */
	public function affected_rows() {
		return mysql_affected_rows();
	}

	/**
	 * 进行字符串转义
	 */
	public function escape($str) {
		return mysql_real_escape_string($str);
	}

	/**
	 * 释放一个结果集
	 */
	public function free($query) {
		return mysql_free_result($query);
	}

	/**
	 * 关闭数据库
	 */
	public function close() {
		mysql_close();
	}

	/**
	 * 取得数据库版本
	 * @return string
	 */
	public function version() {
		return mysql_get_server_info();
	}

	/**
	 * 查询错误信息
	 */
	public function error() {
		return mysql_error();
	}

	/**
	 * 查询错误号
	 */
	public function errno() {
		return mysql_errno();
	}
}
/* End of this file */