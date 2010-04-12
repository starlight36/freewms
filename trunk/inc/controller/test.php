<?php if (!defined("IN_SYS")) die("Access Denied.");
class ctrl_test extends controller {

	public function  __construct() {
		parent::__construct();
	}

	public function action_index() {
		$arr['test']['test']['test'] = 'aaaa';
		echo $arr['test']['test']['test'].'1<br />';
		$value =& path_array($arr, 'test/test/test');
		echo $value.'2<br />';
		$value = 'bbbb';
		echo $arr['test']['test']['test'].'3<br />';
	}
}

/* End of the file */