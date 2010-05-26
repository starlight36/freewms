<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

//载入数据库驱动类
require_once BASEPATH.'inc/database/'.DB_TYPE.'.class.php';

/*-------------------------------------------------
 | 数据库类
 *-----------------------------------------------*/

class DB extends DB_DRIVER {

	private static $instance;

	private $sql_set = array();
	private $sql_select = array();
	private $sql_from = array();
	private $sql_where = NULL;
	private $sql_add = array();
	
	private $sql = NULL;


	private function  __construct() {
		$this->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PCONN);
	}

	private function  __clone() {
		return FALSE;
	}

	/**
	 * 获取数据库对象
	 * @return object
	 */
	public static function get_instance() {
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * 读取记录保存为一个结果集数组
	 * @param string $sql
	 * @return array
	 */
	public function get($sql = NULL) {
		if($sql == NULL) {
			$sql = $this->get_sql();
		}
		$query = $this->query($sql);
		if($this->num_rows($query) > 0) {
			while($row = $this->fetch($query)) {
				$result[] = $row;
			}
		}else{
			$result = NULL;
		}
		return $result;
	}

	/**
	 * 添加一条SELECT子句
	 */
	public function select($str) {
		$str = str_ireplace('$prefix', DB_PREFIX, $str);
		$this->sql_select[] = $str;
		return $this;
	}

	/**
	 * 添加一条from子句
	 */
	public function from($str, $autoprefix = TRUE) {
		if($autoprefix) {
			$str = DB_PREFIX.$str;
		}
		$str = str_ireplace('$prefix', DB_PREFIX, $str);
		$this->sql_from[] = $str;
		return $this;
	}

	/**
	 * 添加附加SQL语句
	 */
	public function sql_add($str) {
		$str = str_ireplace('$prefix', DB_PREFIX, $str);
		if(func_num_args() > 1) {
			for($i = 1; $i < func_num_args(); $i++) {
				$arg = "'".$this->escape(func_get_arg($i))."'";
				$str = @preg_replace('/\?/i', $arg, $str, 1);
			}
		}
		$this->sql_add[] = $str;
	}

	/**
	 * 获取SQL生成的语句
	 */
	public function get_sql() {
		$sql = 'SELECT '.implode(', ', $this->sql_select);
		$sql .= ' FROM '.implode(', ', $this->sql_from);
		$sql .= ' '.implode(' ', $this->sql_add);
		$this->sql = $sql;
		return $sql;
	}

	/**
	 * 设置更新字段列表数组
	 */
	public function set($k, $v = NULL) {
		if(is_array($k)) {
			foreach ($k as $key => $value) {
				$this->set($key, $value);
			}
		}else{
			$k = $this->escape($k);
			$v = $this->escape($v);
			$this->sql_set[] = array('key'=> "`{$k}`", 'value'=> "'{$v}'");
		}
	}

	public function query($sql = NULL, $silence = 0) {
		if($sql == NULL) {
			$sql = $this->get_sql();
		}
		$this->reset_sql();
		return parent::query($sql, $silence);
	}

	/**
	 * 向数据库插入记录
	 */
	public function insert($table, $data = NULL) {
		if($data != NULL) {
			$this->set($data);
		}
		$sql = "INSERT INTO `".DB_PREFIX.$table."` ";
		$sql_key = $sql_value = NULL;
		foreach($this->sql_set as $row) {
			$sql_key[] = $row['key'];
			$sql_value[] = $row['value'];
		}
		$sql .= '('.implode(', ', $sql_key).') values ('.implode(', ', $sql_value).')';
		$this->query($sql);
		$this->reset_sql();
		return $this->insert_id();
	}

	/**
	 * 更新记录
	 */
	public function update($table, $data = NULL) {
		if($data != NULL) {
			$this->set($data);
		}
		$sql = "UPDATE `".DB_PREFIX.$table."` SET ";
		$sql_map = NULL;
		foreach($this->sql_set as $row) {
			$sql_map[] = $row['key'].' = '.$row['value'];
		}
		$sql .= implode(', ', $sql_map).' '.implode(' ', $this->sql_add);
		$this->query($sql);
		$this->reset_sql();
		return;
	}

	/**
	 * 复位SQL参数以便下次查询
	 */
	private function reset_sql() {
		$this->sql_set = array();
		$this->sql_select = array();
		$this->sql_from = array();
		$this->sql_where = NULL;
		$this->sql_add = array();
	}
	
	/**
	 * 放出一个数据库失败消息, 并终止系统运行
	 * @param string $msg
	 * @param string $sql
	 */
	public static function halt($msg = NULL, $sql = NULL) {
		$timestamp = time();
		$errmsg = '';

		$error = parent::error();
		$errno = parent::errno();
		$error = str_replace(DB_PREFIX, '***', $error);
		$sql = str_replace(DB_PREFIX, '***', $sql);


		$errmsg = "<b>A database error occured to FreeWMS</b>: \n\n$msg\n\n";
		$errmsg .= "<b>Time</b>: ".gmdate("Y-n-j g:ia", $timestamp)."\n";
		$errmsg .= "<b>Script</b>: ".$_SERVER['PHP_SELF']."\n";
		if($sql) {
			$errmsg .= "<b>SQL</b>: ".htmlspecialchars($sql)."\n";
		}
		$errmsg .= "<b>Error</b>:  $error\n";
		$errmsg .= "<b>Errno.</b>:  $errno";

		@header("Content-Type: text/html; charset=utf-8");
		echo '<html><head><title>DB ERROR</title></head><body>';
		echo "<p style=\"font-family: Verdana, Tahoma; font-size: 11px; background: #FFFFFF;\">";
		echo nl2br($errmsg);
		echo '</p>';
		echo '</body></html>';
		exit;
	}
}

/* End of this file */