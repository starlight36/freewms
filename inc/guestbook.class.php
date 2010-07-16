<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/**
 * 留言类
 */
class Guestbook {
	public $msg = NULL;
	/**
	 * 读取留言
	 * @param string $key 评论关键字ID
	 * @return mixed
	 */
	public function get_guestbook($key) {
		//从数据库读取
		$db = DB::get_instance();
		//检查KEY是否为数字
		if(preg_match('/^[0-9]+$/', $key)){
			$sql_where = 'WHERE `gb_id` = ?';
		}else return NULL;
		//读取评论
		$db->select('*')->from('guestbook');
		$db->sql_add($sql_where, $key);
		$guestbook = $db->get();
		if($guestbook == NULL) {
			$this->msg = '留言不存在或者已被删除.';
			return FALSE;
		}
		$guestbook = $guestbook[0];
		return $guestbook;
	}
	/**
	 * 取得一个分页列表 读取留言
	 * @param string $args 查询参数
	 * @param int $pagesize 每页内容条数
	 * @param int $pagenum 要显示的内容列表页码
	 * @param int $record_count 总共记录数
	 * @param int $pagecount 总共分页数
	 * @return mixed
	 */
	public function get_guestbook_list($args, $pagesize = NULL, &$pagenum = NULL, &$record_count = NULL, &$pagecount = NULL) {
	//解析参数标记
		if(!is_array($args)) {
			$args = path_array(Spyc::YAMLLoadString($args), 'args');
		}
		//导入数据库
		$db = DB::get_instance();
		$sql_where = NULL;
		//指定用户
		if(preg_match('/^[0-9]+$/', $args['userid'])) {
			$sql_where[] = "`gb_userid` = '{$args['userid']}'";
		}
		//指定状态
		if(preg_match('/^[0-9]+$/', $args['state'])) {
			$sql_where[] = "`gb_state` = '{$args['state']}'";
		}
		//指定日期
	    if(isset($args['time'])) {
			$sql_where[] = "`gb_time` = '{$args['time']}'";
		}
		//结果返回数
		if(preg_match('/^[0-9]+$/', $args['limit'])) {
			$sql_limit = ' LIMIT '.$args['limit'];
		}
		//附加查询条件
    	if(!empty($args['where'])) {
			if(is_array($args['where'])) {
				foreach($args['where'] as $row) {
					$sql_where[] = $row;
				}
			}else{
				$sql_where[] = $args['where'];
			}
		}
		if(!empty($sql_where)) {
			$sql_where = ' WHERE '.implode(' AND ', $sql_where);
		}

		//如果指定了分页, 那么覆盖返回结果数, 同时计算总记录数
		if($pagesize != NULL) {
			$db->select('count(*)')->from('guestbook')->sql_add($sql_where);
			$record_count = $db->result($db->query()); //总记录数
			$pagecount = ceil($record_count / $pagesize); //总分页数
			$pagenum = is_null($pagenum) ? 1 : $pagenum;
			$pagenum = $pagenum > $pagecount ? $pagecount : $pagenum;
			$offset = ($pagenum - 1) * $pagesize;
			if($offset < 0) $offset = 0;
			$sql_limit = " LIMIT {$offset}, {$pagesize}";
		}

		//排序
		if(!empty($args['order'])) {
			$sql_order = ' ORDER BY ';
			if(is_array($args['order'])) {
				$sql_order .= implode(', ', $args['order']);
			}else{
				$sql_order .= $args['order'];
			}
		}
		//查询数据库
		$db->select('*')->from('guestbook');
		$db->sql_add($sql_where.$sql_order.$sql_limit);
		$list = $db->get();
		//处理结果
		if($list == NULL) {
			return FALSE;
		}
		return $list;
	}
	/**
	 * 删除留言
	 * @param <type> $in
	 * @return <type>
	 */
	public function delete_guestbook($key){
			    //从数据库读取
		$db = DB::get_instance();
		//检查KEY是否为数字
		if(preg_match('/^[0-9]+$/', $key)){
			$sql_where = 'WHERE `guestbook_id` = ?';
		}else return NULL;
		//删除数据
		$db->sql_add($sql_where, $key);
    	$db->delete('guestbook');
	    Cache::clear();
	    Cache::delete_page();
	}

	public function set_guestbook($in){
		//验证输入是否为数组
		if(!is_array($in)) {
			return FALSE;
		}
			//初始化局部ID
		$id = $in['gb_id'];
		if(!preg_match('/^[0-9]+$/', $id)) {
			$id = 0;
		}
		//载入数据库对象
		$db = DB::get_instance();
		
		if($id != 0) {
			$old_guestbook = $this->get_guestbook($id);
			if(!$old_guestbook){
				return FALSE;
			}
			 //更新内容主体
			$in['gb_replytime'] = time();
			$in['gb_replystate'] = 1;
		    $db->set($in);
			$db->sql_add('WHERE `gb_id` = ?', $id);
			$db->update('guestbook');
		}else{
			$in['gb_userid'] = User::get_info('user_id');
			if($in['gb_userid'] != 0) {
				$in['gb_username'] = User::get_info('user_name');
			}else{
				$in['gb_username'] .= '(游客)';
			}
			$in['gb_time'] = time();
			$in['gb_ip'] = get_ip();
			$db->set($in);
			$db->insert('guestbook');
			$id = $db->insert_id();
		}
	}
}