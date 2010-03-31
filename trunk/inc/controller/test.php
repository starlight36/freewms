<?php if (!defined("IN_SYS")) die("Access Denied.");
class ctrl_test extends controller {

	public function  __construct() {
		parent::__construct();
	}

	public function action_index() {
		$content =& load_class('content');
		$param = array(
			'where' => array(
				'cateid' => 3
			),
			'order' => array(
				'time' => 'desc'
			)
		);
		print_r($content->get_list_widget($param));
		exit();
	}
}

/* End of the file */