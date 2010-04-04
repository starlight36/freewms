<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 文章类
 */
class mod_article extends module {

	public function  __construct() {
		parent::__construct();
	}

	public function get($row) {
		$id = $row->content_id;
		$this->db->where('article_contentid', $id);
		$q_a = $this->db->get('content_article');
		$row = $q_a->first_row();
		return array('content' => $row->article_content);
	}

	public function save($data) {
		$action = $data['action'];
		unset($data['action']);
		foreach($data as $k => $v) {
			$temp['article_'.$k] = $v;
		}
		if($action == 'add') {
			$this->db->set($data);
			$this->db->insert('content_article');
		}else{
			$this->db->where('article_contentid', $data['contentid']);
			$this->db->set($data);
			$this->db->update('content_article');
		}
	}
}