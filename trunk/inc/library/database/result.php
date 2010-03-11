<?php if (!defined("IN_SYS")) die("Access Denied.");
/**
 * 数据库组件 结果集处理类
 * 源自 CodeIgniter框架
 * 版权 Copyright (c) 2008 - 2009, EllisLab, Inc.
 * 作者 ExpressionEngine Dev Team
 * 主页 http://codeigniter.com/user_guide/database/
 */

class db_result {

	public $conn_id		= NULL;
	public $result_id		= NULL;
	public $result_array	= array();
	public $result_object	= array();
	public $current_row 	= 0;
	public $num_rows		= 0;
	public $row_data		= NULL;


	/**
	 * Query result.  Acts as a wrapper public function for the following public functions.
	 *
	 * @access	public
	 * @param	string	can be "object" or "array"
	 * @return	mixed	either a result object or array
	 */
	public function result($type = 'object') {
		return ($type == 'object') ? $this->result_object() : $this->result_array();
	}

	// --------------------------------------------------------------------

	/**
	 * Query result.  "object" version.
	 *
	 * @access	public
	 * @return	object
	 */
	public function result_object() {
		if (count($this->result_object) > 0) {
			return $this->result_object;
		}

		// In the event that query caching is on the result_id variable
		// will return FALSE since there isn't a valid SQL resource so
		// we'll simply return an empty array.
		if ($this->result_id === FALSE OR $this->num_rows() == 0) {
			return array();
		}

		$this->_data_seek(0);
		while ($row = $this->_fetch_object()) {
			$this->result_object[] = $row;
		}

		return $this->result_object;
	}

	// --------------------------------------------------------------------

	/**
	 * Query result.  "array" version.
	 *
	 * @access	public
	 * @return	array
	 */
	public function result_array() {
		if (count($this->result_array) > 0) {
			return $this->result_array;
		}

		// In the event that query caching is on the result_id variable
		// will return FALSE since there isn't a valid SQL resource so
		// we'll simply return an empty array.
		if ($this->result_id === FALSE OR $this->num_rows() == 0) {
			return array();
		}

		$this->_data_seek(0);
		while ($row = $this->_fetch_assoc()) {
			$this->result_array[] = $row;
		}

		return $this->result_array;
	}

	// --------------------------------------------------------------------

	/**
	 * Query result.  Acts as a wrapper public function for the following public functions.
	 *
	 * @access	public
	 * @param	string
	 * @param	string	can be "object" or "array"
	 * @return	mixed	either a result object or array
	 */
	public function row($n = 0, $type = 'object') {
		if ( ! is_numeric($n)) {
			// We cache the row data for subsequent uses
			if ( ! is_array($this->row_data)) {
				$this->row_data = $this->row_array(0);
			}

			// array_key_exists() instead of isset() to allow for MySQL NULL values
			if (array_key_exists($n, $this->row_data)) {
				return $this->row_data[$n];
			}
			// reset the $n variable if the result was not achieved
			$n = 0;
		}

		return ($type == 'object') ? $this->row_object($n) : $this->row_array($n);
	}

	// --------------------------------------------------------------------

	/**
	 * Assigns an item into a particular column slot
	 *
	 * @access	public
	 * @return	object
	 */
	public function set_row($key, $value = NULL) {
		// We cache the row data for subsequent uses
		if ( ! is_array($this->row_data)) {
			$this->row_data = $this->row_array(0);
		}

		if (is_array($key)) {
			foreach ($key as $k => $v) {
				$this->row_data[$k] = $v;
			}

			return;
		}

		if ($key != '' AND ! is_null($value)) {
			$this->row_data[$key] = $value;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Returns a single result row - object version
	 *
	 * @access	public
	 * @return	object
	 */
	public function row_object($n = 0) {
		$result = $this->result_object();

		if (count($result) == 0) {
			return $result;
		}

		if ($n != $this->current_row AND isset($result[$n])) {
			$this->current_row = $n;
		}

		return $result[$this->current_row];
	}

	// --------------------------------------------------------------------

	/**
	 * Returns a single result row - array version
	 *
	 * @access	public
	 * @return	array
	 */
	public function row_array($n = 0) {
		$result = $this->result_array();

		if (count($result) == 0) {
			return $result;
		}

		if ($n != $this->current_row AND isset($result[$n])) {
			$this->current_row = $n;
		}

		return $result[$this->current_row];
	}


	// --------------------------------------------------------------------

	/**
	 * Returns the "first" row
	 *
	 * @access	public
	 * @return	object
	 */
	public function first_row($type = 'object') {
		$result = $this->result($type);

		if (count($result) == 0) {
			return $result;
		}
		return $result[0];
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the "last" row
	 *
	 * @access	public
	 * @return	object
	 */
	public function last_row($type = 'object') {
		$result = $this->result($type);

		if (count($result) == 0) {
			return $result;
		}
		return $result[count($result) -1];
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the "next" row
	 *
	 * @access	public
	 * @return	object
	 */
	public function next_row($type = 'object') {
		$result = $this->result($type);

		if (count($result) == 0) {
			return $result;
		}

		if (isset($result[$this->current_row + 1])) {
			++$this->current_row;
		}

		return $result[$this->current_row];
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the "previous" row
	 *
	 * @access	public
	 * @return	object
	 */
	public function previous_row($type = 'object') {
		$result = $this->result($type);

		if (count($result) == 0) {
			return $result;
		}

		if (isset($result[$this->current_row - 1])) {
			--$this->current_row;
		}
		return $result[$this->current_row];
	}

	// --------------------------------------------------------------------

	/**
	 * The following public functions are normally overloaded by the identically named
	 * methods in the platform-specific driver -- except when query caching
	 * is used.  When caching is enabled we do not load the other driver.
	 * These public functions are primarily here to prevent undefined public function errors
	 * when a cached result object is in use.  They are not otherwise fully
	 * operational due to the unavailability of the database resource IDs with
	 * cached results.
	 */
	public function num_rows() {
		return $this->num_rows;
	}
	public function num_fields() {
		return 0;
	}
	public function list_fields() {
		return array();
	}
	public function field_data() {
		return array();
	}
	public function free_result() {
		return TRUE;
	}
	public function _data_seek() {
		return TRUE;
	}
	public function _fetch_assoc() {
		return array();
	}
	public function _fetch_object() {
		return array();
	}

}
// END DB_result class

/* End of the file */