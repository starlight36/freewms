<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/**
 * 友情链接类
 */
class Link {
	/**
	 * 拉取友情链接列表
	 * @param mixed $args
	 * @param int $pagesize
	 * @param int $pagenum
	 * @param int $record_count
	 * @param int $pagecount
	 * @return mixed
	 */
	public function get_link_list($args, $pagesize = NULL, &$pagenum = NULL, &$record_count = NULL, &$pagecount = NULL){
		//解析参数标记
		if(!is_array($args)) {
			$args = path_array(Spyc::YAMLLoadString($args), 'args');
		}
		//导入数据库
		$db = DB::get_instance();
		$sql_where = NULL;
		//指定状态
		if(preg_match('/^[0-9]+$/', $args['isdisplay'])) {
			$sql_where[] = "`link_isdisplay` = '{$args['isdisplay']}'";
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
		$db->select('*')->from('link');
		$db->sql_add($sql_where.$sql_order.$sql_limit);
		$list = $db->get();
		//处理结果
		if($list == NULL) {
			return FALSE;
		}
		return $list;
	}
}