<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 输出类
 * 为系统提供输出接口
 */
class cls_out extends base {
	private static $http_headers = array();
	private static $html_headers = array();
	private $page_title = NULL;
	private $page_keywords = NULL;
	private $page_description = NULL;

	public function  __construct() {
		parent::__construct();
	}

	/**
	 * 向浏览器发送一个Cookie
	 * @param string $key cookie 名称
	 * @param string $value cookie 值
	 * @param string $expire cookie 期限(Unix时间戳)
	 * @return bool
	 */
	public function cookie($key, $value = NULL, $expire = NULL) {
		$key = COOKIES_PERFIX.$key;
		return setcookie($key, $value, $expire, COOKIES_PATH, COOKIES_DOMAIN);
	}

	/**
	 * 设置一个HTTP头
	 * @param string/array $k 要设置的HTTP头
	 * @param string $v 设置的值
	 */
	public function http_header($k = NULL, $v = NULL) {
		if(is_string($k) && $v == NULL) {
			$this->http_headers[] = $k;
		}elseif(is_array($k) && $v == NULL){
			$this->http_headers = array_merge($this->http_headers, $k);
		}else{
			$this->http_headers[] = $k.': '.$v;
		}
	}

	/**
	 * 设置页面标题
	 * @param string $v
	 */
	public function set_title($v = NULL) {
		$this->page_title = htmlspecialchars($v);
	}

	/**
	 * 设置页面简介
	 * @param string $v
	 */
	public function set_description($v = NULL) {
		$this->page_description = htmlspecialchars($v);
	}

	/**
	 * 设置页面关键字
	 * @param string $v
	 */
	public function set_keywords($v = NULL) {
		$this->page_keywords = htmlspecialchars($v);
	}

	/**
	 * 添加HTML头
	 * @param string $str
	 */
	public function html_header($str = NULL) {
		if(!empty($str)) {
			$this->html_headers[] = $str;
		}
	}

	/**
	 * 添加一个meta头
	 * @param string/array $k 输入的meta头
	 * @param string $v 输入的值
	 */
	public function html_meta($k = NULL, $v = NULL) {
		if(is_string($k) && $v == NULL) {
			$this->html_headers[] = $k;
		}elseif(is_array($k) && $v == NULL){
			$this->html_headers = array_merge($this->html_headers, $k);
		}else{
			$this->html_headers[] = "<meta name=\"{$k}\" content=\"{$v}\" />";
		}
	}

	/**
	 * 添加一个外部样式表文件
	 * @param string $url 文件路径
	 * @return none
	 */
	public function html_style($url = NULL) {
		if(empty ($url)) return NULL;
		$this->config->load('site');
		if(substr($url, 0, 1) == '/') {
			$url = $this->config->get('site/base_url').'skin/'.substr($url, 1);
		}elseif(substr($url, 0, 7) != 'http://'){
			$url = $this->config->get('site/base_url').$url;
		}
		$this->html_headers[] = "<link href=\"{$url}\" rel=\"stylesheet\" type=\"text/css\" />";
	}

	/**
	 * 添加一个外部脚本文件
	 * @param string $url 文件路径
	 * @return none
	 */
	public function html_script($url = NULL) {
		if(empty ($url)) return NULL;
		if(substr($url, 0, 1) == '/') {
			$url = $this->config->get('site/base_url').'/'.substr($url, 1);
		}elseif(substr($url, 0, 7) != 'http://'){
			$url = $this->config->get('site/base_url').$url;
		}
		$this->html_headers[] = "<script type=\"text/javascript\" src=\"{$url}\"></script>";
	}

	/**
	 * 加载一个视图来应答
	 * @param string $path 视图路径
	 * @param array $data 传入数据
	 * @param bool $return 是否返回视图
	 * @return string/array
	 */
	public function view($path, $data = NULL, $return = FALSE) {
		if(is_array($data) && !empty($data)) {
			foreach($data as $k => $v) {
				$$k = $v;
			}
		}
		if($return) {
			@ob_start();
			@ob_clean();
		}
		@include $this->template($path);
		if($return) {
			$result = @ob_get_contents();
			@ob_clean();
			return $result;
		}else{
			return TRUE;
		}
	}

	/**
	 * 预处理模板路径
	 * @param string $path 模板路径
	 * @return string
	 */
	private function template($path = NULL) {
		$temp_file = DIR_ROOT.'cache/tpl/'.$path.'.php';
		if(!is_file($temp_file)) {
			$this->parse_template($path);
		}
		return $temp_file;
	}

	/**
	 * 解析一个模板文件,并存入缓存
	 * @param string $path
	 */
	private function parse_template($path) {
		$file = DIR_ROOT.'template/'.$this->config->get('site/template').'/'.$path.'.php';
		$temp_file = DIR_ROOT.'cache/tpl/'.$path.'.php';
		$temp_path = dirname($path);
		if(!is_dir(DIR_ROOT.'cache/tpl/'.$temp_path)) {
			create_dir(DIR_ROOT.'cache/tpl/'.$temp_path);
		}
		if(!is_file($file)) {
			$content = NULL;
		}else{
			$content = file_get_contents($file);
		}
		/*
		 * 正则表达式替换标签
		 */
		//解析包含文件
		$content = preg_replace('/\{#include:([A-Za-z0-9._\/-]+)\}/i', '<?php @include $this->template(\'$1\'); ?>', $content);
		//解析变量输出
		$content = preg_replace('/\{#out:([A-Za-z0-9_\/]+)\}/ie', 'self::out_path_array(\'$1\')', $content);
		//解析表达式输出
		$content = preg_replace('/\{#out:(.+)\}/i', '<?php echo $1; ?>', $content);
		//解析if条件
		$content = preg_replace('/\{#if:(.+)\}/i', '<?php if($1): ?>', $content);
		//解析elseif条件
		$content = preg_replace('/\{#elseif:(.+)\}/i', '<?php elseif($1): ?>', $content);
		//解析else和endif
		$content = str_ireplace('{#else}', '<?php else: ?>', $content);
		$content = str_ireplace('{#endif}', '<?php endif; ?>', $content);
		//解析循环标签
		$content = preg_replace('/\{#loop:(.+)\}/i', '<?php foreach($$1 as $_value): ?>', $content);
		$content = preg_replace('/\{#item:(.+)\}/i', '<?php echo $_value[\'$1\']; ?>', $content);
		$content = str_ireplace('{#endloop}', '<?php endforeach; ?>', $content);
		//解析设置项标签
		$content = preg_replace('/\{#config:([A-Za-z0-9_\/]+)\}/i', '<?php echo $this->config->get(\'$1\'); ?>', $content);
		//解析head头区域
		$content = str_ireplace('{#head}', '<?php echo $this->get_html_head(); ?>', $content);
		//解析自定义标签
		$content = preg_replace('/\{#my:([A-Za-z0-9._\/-]+)\}/i', '<?php @include $this->template(\'widget/$1\'); ?>', $content);
		//解析调用
		//未完成
		file_put_contents($temp_file, $content);
	}

	/**
	 * 返回HTML头
	 * @return string
	 */
	private function get_html_head() {
		return implode("\n", $this->html_headers)."\n";
	}

	/**
	 * 解析PATH形式变量输出
	 * @param <type> $path
	 */
	public function out_path_array($path) {
		$keyarray = explode('/', $path);
		$count = count($keyarray);
		$path = $keyarray[0];
		if($count >= 1) {
			for($i = 1; $i < $count; $i++) {
				$path .= "['{$v}']";
			}
		}
		return '<?php echo $'.$path.'; ?>';
	}
}

/* End of the file */