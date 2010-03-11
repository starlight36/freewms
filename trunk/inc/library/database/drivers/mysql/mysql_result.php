<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 数据库组件 mysql结果集接口
 * 源自 CodeIgniter框架
 * 版权 Copyright (c) 2008 - 2009, EllisLab, Inc.
 * 作者 ExpressionEngine Dev Team
 * 主页 http://codeigniter.com/user_guide/database/
 */

class db_mysql_result extends db_result {

	/**
	 * Number of rows in the result set
	 *
	 * @access	public
	 * @return	integer
	 */
	public function num_rows() {
		return @mysql_num_rows($this->result_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Number of fields in the result set
	 *
	 * @access	public
	 * @return	integer
	 */
	public function num_fields() {
		return @mysql_num_fields($this->result_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch Field Names
	 *
	 * Generates an array of column names
	 *
	 * @access	public
	 * @return	array
	 */
	public function list_fields() {
		$field_names = array();
		while ($field = mysql_fetch_field($this->result_id)) {
			$field_names[] = $field->name;
		}

		return $field_names;
	}

	// --------------------------------------------------------------------

	/**
	 * Field data
	 *
	 * Generates an array of objects containing field meta-data
	 *
	 * @access	public
	 * @return	array
	 */
	public function field_data() {
		$retval = array();
		while ($field = mysql_fetch_field($this->result_id)) {
			$F				= new stdClass();
			$F->name 		= $field->name;
			$F->type 		= $field->type;
			$F->default		= $field->def;
			$F->max_length	= $field->max_length;
			$F->primary_key = $field->primary_key;

			$retval[] = $F;
		}

		return $retval;
	}

	// --------------------------------------------------------------------

	/**
	 * Free the result
	 *
	 * @return	null
	 */
	public function free_result() {
		if (is_resource($this->result_id)) {
			mysql_free_result($this->result_id);
			$this->result_id = FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Data Seek
	 *
	 * Moves the internal pointer to the desired offset.  We call
	 * this internally before fetching results to make sure the
	 * result set starts at zero
	 *
	 * @access	private
	 * @return	array
	 */
	protected function _data_seek($n = 0) {
		return mysql_data_seek($this->result_id, $n);
	}

	// --------------------------------------------------------------------

	/**
	 * Result - associative array
	 *
	 * Returns the result set as an array
	 *
	 * @access	private
	 * @return	array
	 */
	protected function _fetch_assoc() {
		return mysql_fetch_assoc($this->result_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Result - object
	 *
	 * Returns the result set as an object
	 *
	 * @access	private
	 * @return	object
	 */
	protected function _fetch_object() {
		return mysql_fetch_object($this->result_id);
	}

}

/* End of the file */