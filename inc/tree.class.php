<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 分类树形列表生成类
 */
class Tree {

	private $list = array();
	private $icon = array('│','├','└');
	private $tree_str = NULL;

	public function  __construct($array) {
		$this->list = $array;
	}

	/**
	 * 读取指定父ID的子节点
	 * @param <type> $id
	 * @return <type>
	 */
	private function get_child($id) {
		$temp = NULL;
		if(!is_array($this->list)) {
			return NULL;
		}
		foreach ($this->list as $k => $v) {
			if($v['parentid'] == $id) {
				$temp[$k] = $v;
			}
		}
		return $temp;
	}

	/**
	 * 种一棵树
	 * @param int $id 树的起始节点ID
	 * @param string $template 条目模板
	 * @param mixed $selected_id 默认选中的条目的ID
	 * @param string $prefix_add 前缀添加,递归时使用
	 * @return string
	 */
	public function plant($id, $template, $selected_id = NULL, $prefix_add = NULL) {
		$child_node = $this->get_child($id);
		if(!is_array($child_node)) {
			return;
		}
		$i = 1;
		$count = count($child_node);
		foreach($child_node as $k => $v) {
			$icon = NULL;
			if($i == $count) {
				$icon[0] = $this->icon[2];
			}else{
				$icon[0] = $this->icon[1];
				$icon[1] = $prefix_add ? $this->icon[0] : NULL;
			}
			$value = ($prefix_add ? $prefix_add.$icon[0] : NULL).$v['name'];
			if(is_array($selected_id)) {
				$selected = (in_array($k, $selected_id)) ? ' selected="selected"' : NULL;
			}else{
				$selected = ($k == $selected_id) ? 'selected="selected"' : NULL;
			}
			$this->tree_str .= str_replace(array('$id', '$selected', '$value'), array($k, $selected, $value), $template);
			$this->plant($k, $template, $selected_id, $prefix_add.$icon[1].'&nbsp;');
			$i++;
		}
		return $this->tree_str;
	}
}

/* End of this file */