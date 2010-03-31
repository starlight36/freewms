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
}