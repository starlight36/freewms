<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 内容类
 */
class mod_content extends module {
	public $msg = NULL;
	private $channel = NULL;

	public function  __construct() {
		parent::__construct();
	}

	/**
	 * 设置当前频道
	 * @param string $name
	 */
	public function set_channel($name, $id = 0) {
		$this->channel = $this->get_channel($name, $id);
		return $this->channel;
	}

	/**
	 * 读取一个频道的信息
	 * @param string key
	 * @param int id
	 * @return unknown
	 */
	public function get_channel($key = NULL, $id = 0, $cache = TRUE) {
		if(empty($key) && $id < 1) {
			return FALSE;
		}
		$cache_name = 'channel_'.$key.$id;
		$ch_info = cache_get($cache_name);
		if($ch_info == FALSE || $cache == FALSE) {
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
				$ch_info['mod_class'] = $row->mod_class;
				$ch_info['mod_manage'] = $row->mod_manage;
				$ch_info['mod_plugin'] = empty($row->ch_plugin)?$row->mod_plugin:$row->ch_plugin;
				$ch_info['keywords'] = $row->ch_keywords;
				$ch_info['description'] = $row->ch_description;
				$ch_info['template'] = empty($row->ch_template)?$row->mod_class:$row->ch_template;
				$ch_info['staticize'] = $row->staticize;
				cache_put($cache_name, $ch_info);
			}
		}
		return $ch_info;
	}

	/**
	 * 保存一个频道
	 * @param array $data
	 * @return int
	 */
	public function save_channel($data) {
		if(!isset($data['id'])) {
			$this->msg = '频道ID未指定';
			return FALSE;
		}
		foreach($data as $k => $v) {
			$temp['ch_'.$k] = $v;
		}
		if($data['id'] == 0) {
			unset($temp['ch_id']);
			$this->db->set($temp);
			$this->db->insert('channel');
			$data['id'] = $this->db->insert_id();
		}else{
			$this->db->where('ch_id', $temp['ch_id']);
			unset($temp['ch_id']);
			$this->db->set($temp);
			$this->db->update('channel');
		}
		$cate_info = $this->get_channel(NULL, $data['id'], FALSE);
		$this->get_channel($cate_info['key'], NULL, FALSE);
		return $data['id'];
	}

	/**
	 * 读取一个分类
	 * @param mixed $key 分类标识符
	 * @return mixed
	 */
	public function get_category($key = NULL, $cache = TRUE) {
		if(empty($key)) {
			return FALSE;
		}
		$cache_name = 'category_'.$key;
		$row = cache_get($cache_name);
		if($cate_info == FALSE || $cache == FALSE) {
			if(is_numeric($key)) {
				$this->db->where('cate_id', $key);
			}else{
				$this->db->where('cate_key', $key);
			}
			$this->db->join('module', 'mod_id = cate_modid');
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
				$cate_info['templete'] = $row->cate_templete;
				$cate_info['pagesize'] = $row->cate_pagesize;
				$cate_info['itemname'] = $row->cate_itemname;
				$cate_info['itemunit'] = $row->cate_itemunit;
				$cate_info['mod_class'] = $row->mod_class;
				$cate_info['mod_plugin'] = $row->mod_plugin;
				$cate_info['mod_manage'] = $row->mod_manage;
				//取得分类的URL
				if($staticfix == 'close' || $is_staticize == 0) {
					$cate_info['path'] = 'category/'.$cate_info['key'];
				}else{
					//递归获取当前分类的路径
					if(!empty($row->cate_parentid)) {
						$p_cate = $this->get_category($row->cate_parentid);
						$cate_info['path'] = $p_cate['path'].$row->cate_key.'/';
					}else{
						$cate_info['path'] = $row->cate_key.'/';
					}
				}
				//读取子分类id
				$this->db->select('cate_id');
				$this->db->where('cate_parentid', $row->cate_id);
				$q_ch_cate = $this->db->get('category');
				$ch_idlist = array();
				if($q_ch_cate->num_rows() > 0) {
					foreach($q_ch_cate->result() as $ch_row) {
						$ch_idlist[] = $ch_row->cate_id;
					}
					$cate_info['children'] = $ch_idlist;
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
	 * 保存一个分类
	 * @param array $data
	 * @return int
	 */
	public function save_category($data) {
		if(!isset($data['id'])) {
			$this->msg = '分类ID未定义';
			return FALSE;
		}
		foreach($data as $k => $v) {
			$temp['cate_'.$k] = $v;
		}
		if($data['id'] == 0) {
			unset($temp['cate_id']);
			$this->db->set($temp);
			$this->db->insert('category');
			$data['id'] = $this->db->insert_id();
		}else{
			$this->db->where('cate_id', $temp['cate_id']);
			unset($temp['cate_id']);
			$this->db->set($temp);
			$this->db->update('category');
		}
		$cate_info = $this->get_category($data['id'], FALSE);
		$this->get_category($cate_info['key'], FALSE);
		return $data['id'];
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
		$this->db->join('category', 'cate_id = content_cateid');
		$this->db->join('module', 'mod_id = cate_modid');
		$q_content = $this->db->get('content');
		if($q_content->num_rows() != 1) {
			$this->msg = '没有找到要查看的页面.';
			return FALSE;
		}else{
			$row = $q_content->first_row();
			$url = $this->get_content_url($row->content_cateid, $row->content_id, $row->content_key);
			$content = array(
				'id' => $row->content_id,
				'title' => $row->content_title,
				'titlestyle' => $row->content_titlestyle,
				'cateid' => $row->content_cateid,
				'catename' => $row->cate_name,
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
				'modclass' => $row->mod_class,
				'modmanage' => $row->mod_manage,
				'url' => $url
			);
			$c_obj =& load_class($content['modclass']);
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
			if(pagenum <= 0 || !is_numeric($pagenum)) {
				$pagenum = 1;
			}
			//读取内容记录数,准备分页
			$param['limit'] = 0;
			$this->parse_list_param($param);
			$resultcount = $this->db->count_all_results('content');
			$pagecount = (int)($resultcount / $pagesize)
							+ ($resultcount % $pagesize == 0)?0:1;
			if($pagecount == 0) $pagecount = 1;
			$param['limit'] = $pagesize;
			$pagenum = ($pagenum > $pagecount) ? $pagecount : $pagenum;
			$offset = ($pagenum - 1) * $pagesize;
		}else{
			$offset = 0;
		}
		//查询内容
		$this->parse_list_param($param, $offset);
		$this->db->join('user', 'user_id = content_userid');
		$this->db->join('category', 'cate_id = content_cateid');
		$this->db->join('module', 'mod_id = cate_modid');
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
					'chid' => $row->content_chid,
					'cateid' => $row->content_cateid,
					'catename' => $row->cate_name,
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
					'url' => $url,
					'modclass' => $row->mod_class,
					'modname' => $row->mod_name
				);
			}
		}
		if($pagesize > 0) {
			return array(
				'result' => $content,
				'pagenum' => $pagenum,
				'pagecount' => $pagecount,
				'pagesize' => $pagesize,
				'resultcount' => $resultcount
			);
		}else{
			return $content;
		}
	}

	public function save_content($data) {
		if(!isset($data['id'])) {
			$this->msg = '内容ID不能为空.';
			return FALSE;
		}
		$data['chid'] = $this->channel['id'];
		$content = $data['content'];
		unset($data['content']);
		foreach($data as $k => $v) {
			$temp['content_'.$k] = $v;
		}
		if($data['id'] == 0) {
			unset($temp['content_id']);
			$this->db->set($temp);
			$this->db->insert('content');
			$data['id'] = $this->db->insert_id();
			$content['action'] = 'add';
		}else{
			$this->where('content_id', $temp['content_id']);
			unset($temp['content_id']);
			$this->db->set($temp);
			$this->db->update('category');
			$content['action'] = 'update';
		}
		$content['contentid'] = $data['id'];
		$c_obj =& load_class($this->channel['key']);
		$content_main = $c_obj->save($content);
		return $data['id'];
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
		$is_staticize = $this->channel['staticize'];
		//处理内容的URL
		if($staticfix == 'close' || $is_staticize == 0) {
			if(empty($ckey)) {
				$url = site_url('content/view/'.$cid);
			}else{
				$url = site_url('content/view/'.$ckey);
			}
		}else{
			if(empty($ckey)) {
				$url = $cateinfo['path'].$cid.$staticfix;
			}else{
				$url = $cateinfo['path'].$ckey.$staticfix;
			}
		}
		return $url;
	}

	/**
	 * 从传入的列表参数生成查询条件
	 * @param array $param 传入条件
	 * @param int $offset 记录偏移量
	 * @return bool
	 */
	private function parse_list_param($param, $offset = 0) {
		if(!is_array($param)) {
			return FALSE;
		}
		$cate_id = NULL;
		if(is_array($param['where'])) {
			foreach($param['where'] as $k => $v) {
				if($k == 'cateid') {
					$cate_id = $v;
				}
				$this->db->where('content_'.$k, $v);
			}
		}
		if(is_array($param['id_in'])) {
			$this->db->where_in($param['id_in']);
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
		if(!empty($param['children_category']) && !empty($cate_id)) {
			$cate_info = $this->get_category(NULL, $cate_id);
			if(!empty($cate_info['children'])) {
				$this->db->or_where_in('content_cateid', $cate_info['children']);
			}
		}
		return TRUE;
	}
}