<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 自定义页面控制器
 */

class page extends controller {

	public function  __construct() {
		parent::__construct();
	}

	public function action_index() {
		if($this->config->get('site/page_cache') == TRUE) {
			cache_page_load();
		}
		$page_key = $this->in->get['name'];
		if(!check_safety_name($page_key)) {
			show_404();
		}
		$arr_page = cache_get('page_'.$page_key);
		if($arr_page == FALSE) {
			$this->db->where('page_key', $page_key);
			$q_page = $this->db->get('page');
			if($q_page->num_rows() == 1) {
				$arr_page = $q_page->row_array();
			}else{
				show_404();
			}
			cache_put('page_'.$page_key, $arr_page);
		}
		$this->out->set_title($arr_page['page_name']);
		$this->out->set_keywords($arr_page['page_keyword']);
		$this->out->set_description($arr_page['page_description']);
		$this->out->view('page/'.$arr_page['page_key']);
		if($this->config->get('site/page_cache') == TRUE) {
			cache_page_save();
		}
	}
}