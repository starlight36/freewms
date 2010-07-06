<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 自定义字段类
 */

class Field{

	private $db = NULL;

	public function  __construct() {
		$this->db = DB::get_instance();
	}

	/**
	 * 读取一个模型的自定义字段
	 * @param int $modid
	 * @return mixed
	 */
	public function get_field($modid) {
		if(!is_numeric($modid)) {
			return FALSE;
		}
		$this->db->select('*')->from('field')->sql_add('WHERE `field_modid` = ?', $modid);
		$field_list = $this->db->get();
		foreach($field_list as $row) {
			$new_array[$row['field_key']] = $row;
		}
		return $new_array;
	}

	/**
	 * 读取内容的自定义字段值列表
	 * @param int $cid
	 * @return mixed
	 */
	public function get_value($cid) {
		if(!is_numeric($cid)) {
			return FALSE;
		}
		$this->db->select('field_key')->select('field_value');
		$this->db->from('field')->from('field_value');
		$this->db->sql_add('WHERE `fieldid` = `field_id` AND `contentid` = ?', $cid);
		$value_list = $this->db->get();
		foreach($value_list as $row) {
			$new_array[$row['field_key']] = $row['field_value'];
		}
		return $new_array;
	}

	/**
	 * 设置自定义字段的值
	 * @param array $args
	 * @param int $modid
	 * @param int $cid
	 * @return bool
	 */
	public function set_value($args, $modid, $cid) {
		$field_list = $this->get_field($modid);
		if($field_list == NULL) {
			return FALSE;
		}
		if(!is_array($args)) {
			return FALSE;
		}
		foreach($args as $key => $value) {
			if(!isset($field_list[$key])){
				continue;
			}
			$this->db->select('field_id')->from('field')->sql_add('WHERE `field_key` = ?', $key);
			$query = $this->db->query();
			if($this->db->num_rows($query) == 0) {
				continue;
			}
			$field_id = $this->db->result($query);

			$this->db->select('fieldid')->from('field_value');
			$this->db->sql_add('WHERE fieldid = ? AND `contentid` = ?', $field_id, $cid);
			$query = $this->db->query();
			if($this->db->num_rows($query) > 0) {
				$this->db->sql_add('WHERE `fieldid` = ?', $field_id);
				$this->db->update('field_value', array('field_value' => $value));
			}else{
				$data = array(
					'field_value' => $value,
					'fieldid' => $field_id,
					'contentid' => $cid
				);
				$this->db->insert('field_value', $data);
			}
			$this->db->free($query);
		}
		return TRUE;
	}

	/**
	 * 删除字段值
	 * @param int $cid
	 */
	public function del_value($cid) {
		if(!is_numeric($cid)) {
			return;
		}
		$this->db->sql_add('WHERE `contentid` = ?', $cid);
		$this->db->delete('field_value');
	}
}


/* End of this file */