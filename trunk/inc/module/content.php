<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 内容类
 */
class mod_content extends module {
	public $msg = NULL;
	public $channel_name = 'article';

	public function  __construct() {
		parent::__construct();
	}

	/**
	 * 设置当前频道
	 * @param string $name
	 */
	public function set_channel($name) {
		$this->channel_name = $name;
	}

	/**
	 * 读取一个频道的信息
	 * @param string key
	 * @param int id
	 * @return unknown
	 */
	public function get_channel($key = NULL, $id = 0) {
		if(empty($key) && $id < 1) {
			return FALSE;
		}
		$cache_name = 'channel_'.$key.$id;
		$ch_info = cache_get($cache_name);
		if($ch_info == FALSE) {
			if(!is_null($key)) {
				$this->db->where('ch_key', $key);
			}
			if($id > 0) {
				$this->db->where('ch_id', $id);
			}
			$this->db->join('module', 'mod_id = ch_modid');
			$q_ch = $this->db->get('channel');
			if($q_ch->num_rows() != 1) {
				return FALSE;
			}else{
				$row = $q_ch->first_row();
				$ch_info['id'] = $row->ch_id;
				$ch_info['name'] = $row->ch_name;
				$ch_info['key'] = $row->ch_key;
				$ch_info['mod_key'] = $row->mod_key;
				$ch_info['keywords'] = $row->ch_keywords;
				$ch_info['description'] = $row->ch_description;
				$ch_info['template'] = $row->ch_template;
				$ch_info['style'] = $row->ch_style;
				$ch_info['pagesize'] = $row->ch_pagesize;
				cache_put($cache_name, $ch_info);
			}
		}
		return $ch_info;
	}

	/**
	 * 读取一个分类
	 * @param string $key
	 * @param int $id
	 * @return bool
	 */
	public function get_category($key = NULL, $id = 0) {
		if(empty($key) && $id < 1) {
			return FALSE;
		}
		$cache_name = 'category_'.$key.$id;
		$cate_info = cache_get($cache_name);
		if($cate_info == FALSE) {
			if(!is_null($key)) {
				$this->db->where('cate_key', $key);
			}
			if($id > 0) {
				$this->db->where('cate_id', $id);
			}
			$q_cate = $this->db->get('category');
			if($q_cate->num_rows() != 1) {
				return FALSE;
			}else{
				$row = $q_cate->first_row();
				$cate_info['id'] = $row->cate_id;
				$cate_info['name'] = $row->cate_name;
				$cate_info['chid'] = $row->cate_chid;
				$cate_info['parentid'] = $row->cate_parentid;
				$cate_info['key'] = $row->cate_key;
				$cate_info['keywords'] = $row->cate_keywords;
				$cate_info['description'] = $row->cate_description;
				//递归获取当前分类的路径
				if(!empty($row->cate_parentid)) {
					$p_cate = $this->get_category(NULL, $row->cate_parentid);
					$cate_info['path'] = $p_cate['path'].$row->cate_key.'/';
				}else{
					$cate_info['path'] = $row->cate_key.'/';
				}
				cache_put($cache_name, $cate_info);
			}
		}
		return $cate_info;
	}

	/**
	 * 遍历取得分类地图
	 * @param string $id
	 * @return bool
	 */
	public function get_category_map($id, $recursion = TRUE) {
		$this->db->select('cate_id, cate_parentid');
		$this->db->where('cate_parentid', $id);
		$q_cate = $this->db->get('category');
		if($q_cate->num_rows() == 0) {
			return FALSE;
		}else{
			if($recursion == TRUE) {
				foreach ($q_cate->result() as $row) {
					$currinfo = $this->get_category(NULL, $row->cate_id);
					$currinfo['children'] = $this->get_category_map($row->cate_id, TRUE);
					$cate_array[] = $currinfo;
				}
			}
			return $cate_array;
		}
	}

	/**
	 * 获取一个内容页
	 * @param int $id
	 * @param string $key
	 * @return array
	 */
	public function get_content($id = 0, $key = NULL) {
		if(is_numeric($id) && $id >0) {
			$this->db->where('content_id', $id);
		}
		if(!is_null($key)) {
			$this->db->where('content_key', $key);
		}
		$this->db->join('user', 'user_id = content_userid');
		$q_content = $this->db->get('content');
		if($q_content->num_rows() != 1) {
			$this->msg = '没有找到要查看的内容.';
			return FALSE;
		}else{
			$row = $q_content->first_row();
			$url = $this->get_content_url($row->content_cateid, $row->content_id, $row->content_key);
			$content = array(
				'id' => $row->content_id,
				'title' => $row->content_title,
				'titlestyle' => $row->content_titlestyle,
				'cateid' => $row->content_cateid,
				'userid' => $row->content_userid,
				'auther' => $row->content_auther,
				'userid' => $row->content_userid,
				'username' => $row->user_name,
				'key' => $row->content_key,
				'intro' => $row->content_intro,
				'pubtime' => $row->content_time,
				'read' => $row->content_readnum,
				'comment' => $row->content_commentnum,
				'keywords' => $row->content_keywords,
				'istop' => $row->content_istop,
				'state' => $row->content_state,
				'url' => $url
			);
			$c_obj =& load_class($this->channel_name);
			$content_main = $c_obj->get($row);
			return array_merge($content, $content_main);
		}
	}

	/**
	 * 获取一个内容列表
	 * @param array $param
	 * @return array
	 */
	public function get_list($param, $pagesize = 0, $pagenum = 1) {
		if($pagesize > 0) {
			$param['limit'] = $pagesize;
		}
		if($pagesize > 0) {
			if(pagenum <= 0 || !is_numeric($pagenum)) {
				$pagenum = 1;
			}
			$pagenum = (int)$pagenum;
			$offset = ($pagenum - 1) * $pagesize;
			if(!$this->parse_list_param($param, $offset)) {
				return FALSE;
			}
			$resultcount = $this->db->count_all_results('content');
			$pagecount = (int)($resultcount / $pagesize)
							+ ($resultcount % $pagesize == 0)?0:1;
		}else{
			$offset = 0;
		}
		if(!$this->parse_list_param($param, $offset)) {
			return FALSE;
		}
		$this->db->join('user', 'user_id = content_userid');
		$q_list = $this->db->get('content');
		if($q_list->num_rows() == 0) {
			$this->msg = '没有找到要查看的内容.';
			return FALSE;
		}else{
			foreach($q_list->result() as $row) {
				$url = $this->get_content_url($row->content_cateid, $row->content_id, $row->content_key);
				$content[] = array(
					'id' => $row->content_id,
					'title' => $row->content_title,
					'titlestyle' => $row->content_titlestyle,
					'cateid' => $row->content_cateid,
					'userid' => $row->content_userid,
					'auther' => $row->content_auther,
					'userid' => $row->content_userid,
					'username' => $row->user_name,
					'key' => $row->content_key,
					'intro' => $row->content_intro,
					'pubtime' => $row->content_time,
					'read' => $row->content_readnum,
					'comment' => $row->content_commentnum,
					'keywords' => $row->content_keywords,
					'istop' => $row->content_istop,
					'state' => $row->content_state,
					'url' => $url
				);
			}
		}
		if($pagesize > 0) {
			return array(
				'list' => $content,
				'pagenum' => $pagenum,
				'pagecount' => $pagecount,
				'pagesize' => $pagesize,
				'resultcount' => $resultcount
			);
		}else{
			return $content;
		}
	}

	/**
	 * 获取一条内容的URL
	 * @param int $cateid
	 * @param int $cid
	 * @param string $ckey
	 * @return string
	 */
	private function get_content_url($cateid, $cid, $ckey) {
		$cateinfo = $this->get_category(NULL, $row->$cateid);
		$staticfix = $this->config->get('site/staticize');
		//处理内容的URL
		if($staticfix == 'close') {
			if(empty($ckey)) {
				$url = site_url($this->channel_name.'/view/'.$cid);
			}else{
				$url = site_url($this->channel_name.'/view/'.$ckey);
			}
		}else{
			if(empty($ckey)) {
				$url = $this->channel_name.'/'.$cateinfo['path'].$cid.$staticfix;
			}else{
				$url = $this->channel_name.'/'.$cateinfo['path'].$ckey.$staticfix;
			}
		}
		return $url;
	}

	private function parse_list_param($param, $offset = 0) {
		if(!is_array($param)) {
			return FALSE;
		}
		if(is_array($param['where'])) {
			foreach($param['where'] as $k => $v) {
				$this->db->where('content_'.$k, $v);
			}
		}
		if(is_array($param['like'])) {
			foreach($param['like'] as $k => $v) {
				$this->db->where('content_'.$k, $v);
			}
		}
		if(is_array($param['order'])) {
			foreach($param['order'] as $k => $v) {
				$this->db->order_by('content_'.$k, $v);
			}
		}
		if($param['limit'] > 0) {
			$this->db->limit($param['limit'], $offset);
		}
		return TRUE;
	}

	
}
