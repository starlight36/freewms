<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 内容页面控制器
 */

class ctrl_content extends controller {

	private $content = NULL;
	private $channel = array();

	public function  __construct($channel = NULL) {
		if(is_null($channel)) {
			show_404();
		}
		parent::__construct();
		cache_page_load();
		$this->content =& load_class('content');
		$this->channel = $this->content->set_channel($channel);
		if($this->channel == FALSE) {
			show_404();
		}
	}

	//用于内容模块插件的钩子
	public function  __call($name,  $arguments = NULL) {
		$plugin_name = $this->channel['mod_plugin'];
		$plugin_file = DIR_INC.'plugin/'.$plugin_name.'.php';
		if(!is_file($plugin_file)) {
			show_404();
		}
		@include_once $plugin_file;
		$obj_plugin =& instantiate_class(new $plugin_name);
		if(!method_exists($obj_plugin, $name)) {
			show_404();
		}
		$obj_plugin->$name();
		return TRUE;
	}

	//频道首页
	public function action_index() {
		$this->out->set_title($this->channel['name']);
		$this->out->set_keywords($this->channel['keywords']);
		$this->out->set_description($this->channel['description']);
		$template_path = $this->channel['template'];
		//页面可用变量列表
		$pagedata = array(
			'channel_id' => $this->channel['id'],				//频道ID
			'channel_name' => $this->channel['name'],			//频道名称
			'channel_key' => $this->channel['key'],				//频道目录
			'channel_desc' => $this->channel['description']		//频道简介
		);
		$this->out->view($template_path.'/channel', $pagedata);
		cache_page_save();
	}

	//分类页
	public function action_category() {
		$cate_key = $this->in->get('key');
		$show_type = strtolower($this->in->get('type'));
		if(empty($cate_key) || !check_safety_name($cate_key)) {
			show_404();
		}
		$cate_info = $this->content->get_category($cate_key);
		if($cate_info == FALSE) {
			show_404();
		}

		//设置页面头信息
		$this->out->set_title($cate_info['name']);
		$this->out->set_keywords($cate_info['keywords']);
		$this->out->set_description($cate_info['description']);
		$template_path = $this->channel['template'].'/';
		if(!empty($cate_info['template'])) {
			$template_path .= $cate_info['template'].'/';
		}

		//判断页面展示形式
		if($show_type == 'list') {
			//强制使用分类文章列表形式
			$template_path .= 'list';
		}elseif($show_type == 'rss') {
			//以RSS形式输出
			$template_path .= 'rss';
		}else{
			//以分类主页形式显示
			$template_path .= 'category';
		}

		//判断是否还有下级分类
		$child_category = array();
		if(empty($cate_info['children'])) {
			$template_path .= 'list';
		}else{
			//将子分类信息加载
			foreach($cate_info['children'] as $row) {
				$child_category[] = $this->content->get_category(NULL, $row);
			}
		}

		//加载当前分类下内容列表
		//页码
		$pagenum = intval($this->in->get('page'));
		//列表内容参数
		$condition = array(
			//筛选条件
			'where' => array('cateid' => $cate_info['id']),
			//排序条件
			'order' => array(
				'istop' => 'asc',
				'time' => 'desc'
			)
		);

		//读取列表
		$content_list = $this->content->get_list($condition, $cate_info['pagesize'], $pagenum);

		//页面可用变量列表
		$pagedata = array(
			'channel_id' => $this->channel['id'],				//频道ID
			'channel_name' => $this->channel['name'],			//频道名称
			'channel_key' => $this->channel['key'],				//频道目录
			'channel_desc' => $this->channel['description'],	//频道简介
			'category_id' => $cate_info['id'],					//分类ID
			'category_name' => $cate_info['name'],				//分类名称
			'category_key' => $cate_info['key'],				//分类目录
			'category_desc' => $cate_info['description'],		//分类简介
			'category_url' => $cate_info['path'],				//分类路径
			'child_category' => $child_category,				//子分类
			'content_list' => $content_list['result'],			//内容列表
			'pagenum' => $content_list['pagenum'],				//当前页码
			'pagecount' => $content_list['pagecount'],			//分页总数
			'pagesize' => $content_list['pagesize'],			//每页条数
			'resultcount' => $content_list['resultcount']		//返回结果总数
		);

		//加载视图以应答
		if($show_type == 'rss') {
			$this->out->http_header('Content-Type', 'text/xml');
		}
		$this->out->view($template_path, $pagedata);
		cache_page_save();
	}

	//内容页
	public function action_view() {
		$key = $this->in->get('key');
		$show_type = $this->in->get('type');
		//判断是ID形式还是名称形式
		if(is_numeric($key)) {
			$id = intval($key);
			$key = NULL;
		}else{
			$id = 0;
		}
		//读取内容
		$content = $this->content->get_content($id, $key);
		if($content == FALSE) {
			$this->out->view('system/error', array('error_msg'=>$this->content->msg));
			return TRUE;
		}else{
			$cate_info = $this->content->get_category(NULL, $content['cateid']);
		}
		//设置页面头信息
		$this->out->set_title($content['title']);
		$this->out->set_keywords($cate_info['keywords']);
		$this->out->set_description($cate_info['description']);
		//页面可用变量列表
		$pagedata = array(
			'channel_id' => $this->channel['id'],				//频道ID
			'channel_name' => $this->channel['name'],			//频道名称
			'channel_key' => $this->channel['key'],				//频道目录
			'channel_desc' => $this->channel['description'],	//频道简介
			'category_id' => $cate_info['id'],					//分类ID
			'category_name' => $cate_info['name'],				//分类名称
			'category_key' => $cate_info['key'],				//分类目录
			'category_desc' => $cate_info['description'],		//分类简介
			'category_url' => $cate_info['path'],				//分类路径
			'child_category' => $child_category,				//子分类
		);
		$pagedata = array_merge($content, $pagedata);

		//读取模板路径
		$template_path = $this->channel['template'].'/';
		if(!empty($cate_info['template'])) {
			$template_path .= $cate_info['template'].'/';
		}
		//选择视图
		if($show_type == 'print') {
			$template_path .= 'print';
		}else{
			$template_path .= 'content';
		}
		//输出视图
		$this->out->view($template_path, $pagedata);
		cache_page_save();
	}

}
