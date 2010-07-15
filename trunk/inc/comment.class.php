<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 评论类
 */

class Comment {
	public $msg = NULL;

	 /**
	 * 读取评论
	 * @param string $key 评论关键字ID
	 * @return mixed
	 */
	public function get_comment($key) {
		//从数据库读取
		$db = DB::get_instance();
		//检查KEY是否为数字
		if(preg_match('/^[0-9]+$/', $key)){
			$sql_where = 'WHERE `comment_id` = ?';
		}else{
			return NULL;
		}
		//读取评论
	    $db->select('*')->from('comment');
		$db->sql_add($sql_where, $key);
		$comment = $db->get();
		if($comment == NULL) {
			$this->msg = '评论不存在或者已被删除.';
			return FALSE;
		}
		$comment = $comment[0];
		return $comment;
	}

	/**
	 * 取得一个分页列表 读取评论
	 * @param string $args 查询参数
	 * @param int $pagesize 每页内容条数
	 * @param int $pagenum 要显示的内容列表页码
	 * @param int $record_count 总共记录数
	 * @param int $pagecount 总共分页数
	 * @return mixed
	 *
	 */
	public function get_comment_list($args, $pagesize = NULL, &$pagenum = NULL, &$record_count = NULL, &$pagecount = NULL) {
		//解析参数标记
		if(!is_array($args)) {
			$args = path_array(Spyc::YAMLLoadString($args), 'args');
		}
		//导入数据库
		$db = DB::get_instance();
		$sql_where = NULL;
		//指定用户
		if(preg_match('/^[0-9]+$/', $args['userid'])) {
			$sql_where[] = "`comment_userid` = '{$args['userid']}'";
		}
		//指定文章
		if(preg_match('/^[0-9]+$/', $args['contentid'])) {
			$sql_where[] = "`comment_contentid` = '{$args['contentid']}'";
		}
		//指定状态
		if(preg_match('/^[0-9]+$/', $args['state'])) {
			$sql_where[] = "`comment_state` = '{$args['state']}'";
		}

		//指定日期
	    if(isset($args['time'])) {
			$sql_where[] = "`comment_gb` = '{$args['time']}'";
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
			$db->select('count(*)')->from('comment')->sql_add($sql_where);
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
		$db->select('*')->from('comment');
		$db->sql_add($sql_where.$sql_order.$sql_limit);
		$list = $db->get();
		//处理结果
		if($list == NULL) {
			return FALSE;
		}
		return $list;
	}

	/**
	 * 保存评论
	 * @param array $in 内容基本字段
	 * @return mixed
	 */
	public function set_comment($in){
		//验证输入是否为数组
		if(!is_array($in)) {
			return FALSE;
		}

		//初始化局部ID
		$id = $in['comment_id'];
		if(!preg_match('/^[0-9]+$/', $id)) {
			$id = 0;
		}
		//载入数据库对象
		$db = DB::get_instance();

		//检查文章是否存在
		$cont = new Content();
		$content = $cont->get_content($in['comment_contentid']);
		if(!$content) {
			$this->msg = '要评论的内容不存在.';
			return FALSE;
		}
		if($content['content_iscomment'] != '1') {
			$this->msg = '该内容不允许发表评论.';
			return FALSE;
		}

		//检查用户是否存在 是否匿名
		$user_id = $in['comment_userid'];
		if(!preg_match('/^[0-9]+$/', $user_id)) {
			$userid = 0;
		}
		if($userid == 0) {
			$comment_username = "匿名留言";
		}else{
			$db->select('user_name')->from('user');
			$db->sql_add('WHERE `user_id` = ?', $userid);
			$comment_username = $db->result($db->query());
		}
		$in['comment_username'] = $comment_username;

		if($id != 0) {
			$old_comment = $this->get_comment($id);
			if(!$old_comment){
				return FALSE;
			}
		    //更新内容主体
		    $db->set($in);
			$db->sql_add('WHERE `comment_id` = ?', $id);
			$db->update('comment');
		}else {
			$in['comment_ip'] = get_ip();
			$db->set($in);
			$db->insert('comment');
			$id = $db->insert_id();
			//内容评论数增加
            $db->query('UPDATE `'.DB_PREFIX.'content` SET `content_commentnum` = `content_commentnum` + 1 WHERE `content_id` = '.$set_value['comment_contentid']);
		}
		//更新自定义字段
		$field = new Field();
		$field->set_value($in, $id);

		//更新缓存
		Cache::clear();

		//返回更新的内容的ID
		return $id;
	}
	/**
	 * 删除评论
	 * @param string $key 评论关键字ID
	 * @return mixed
	 */
	public function delete_comment($key){
		//从数据库读取
		$db = DB::get_instance();
		//检查KEY是否为数字
		if(preg_match('/^[0-9]+$/', $key)){
			$sql_where = 'WHERE `comment_id` = ?';
		}else return NULL;
		//删除数据
		$db->sql_add($sql_where, $key);
		$db->select('comment_contentid')->from('comment');
		$comment_contentid  = $db->result($db->query());
		$db->sql_add($sql_where, $key);
    	$db->delete('comment');
		$db->query('UPDATE `'.DB_PREFIX.'content` SET `content_commentnum` = `content_commentnum` - 1 WHERE `content_id` = '.$comment_contentid);
	    Cache::clear();
	    Cache::delete_page();
	}
}
