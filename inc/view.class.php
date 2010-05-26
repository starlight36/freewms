<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 视图类
 */
class View {

	private static $html_heads = array();
	private static $page_title = NULL;
	private static $page_keywords = array();
	private static $page_description = NULL;

	private function  __construct() {
		return FALSE;
	}

	private function  __clone() {
		return FALSE;
	}

	/**
	 * 设置页面标题
	 * @access	public
	 * @return	void
	 */
	public static function set_title($v = NULL) {
		self::$page_title = htmlspecialchars($v);
	}

	/**
	 * 设置简介
	 * @access	public
	 * @return	void
	 */
	public static function set_description($v = NULL) {
		self::$page_description = htmlspecialchars($v);
	}

	/**
	 * 设置页面关键字
	 * @access	public
	 * @param string $v
	 */
	public static function set_keywords($v = NULL) {
		self::$page_keywords[] = htmlspecialchars($v);
	}

	/**
	 * 添加HTML头
	 * @access	public
	 * @param string $str
	 */
	public static function html_header($str = NULL) {
		if(!empty($str)) {
			self::$html_heads[] = $str;
		}
	}

	/**
	 * 添加一个meta头
	 * @param string $k 输入的meta头
	 * @param string $v 输入的值
	 */
	public static function html_meta($k = NULL, $v = NULL) {
		self::$html_heads[] = "<meta name=\"{$k}\" content=\"{$v}\" />";
	}

	/**
	 * 加载一个视图
	 * @param string $file
	 * @param array $data
	 * @param bool $return
	 * @return mixed
	 */
	public static function load($file, $data = NULL, $return = FALSE, $content_type = 'text/html') {
		if(is_array($data) && !empty($data)) {
			foreach($data as $k => $v){
				$$k = $v;
			}
		}
		if($return) {
			@ob_start();
			@ob_clean();
		}else{
			@header("Content-Type: {$content_type}; charset=utf-8");
		}
		@include self::template($file);
		self::$html_heads = self::$page_description = NULL;
		self::$page_keywords = self::$page_title = NULL;
		if($return) {
			$result = @ob_get_contents();
			@ob_clean();
			return $result;
		}else{
			return TRUE;
		}
	}

	/**
	 * 直接输出错误消息页
	 * @param string $type
	 * @param string $msg
	 * @param mixed $go_url
	 * @param int $autogo
	 */
	public static function show_message($type = 'error', $msg = NULL, $go_url = NULL, $autogo = NULL) {
		if(!is_array($go_url) || $go_url == NULL) {
			$go_url = array('返回前页' => $go_url);
		}
		if($autogo != NULL) {
			$redirect = current($go_url);
			self::html_header("<meta http-equiv=\"refresh\"  content=\"{$autogo};url={$redirect}\" />");
		}
		$pdata = array(
			'golist' => $go_url,
			'msgtype' => $type,
			'msgstr' => $msg
		);
		Lang::load('view');
		self::set_title(Lang::_('sys_view_show_message_title').' - '.Config::get('site_name'));
		self::load('system/message', $pdata);
		exit();
	}

	/**
	 * 读取一个模板的实际路径
	 * @param string $path
	 * @return string
	 */
	public static function template($path = NULL) {
		$temp_file = BASEPATH.'cache/tpl/'.$path.'.php';
		if(!is_file($temp_file) || DEBUG) {
			self::parse_template($path);
		}
		return $temp_file;
	}

	/**
	 * 解析并编译模板
	 * @param string $path
	 */
	private static function parse_template($path) {
		//真实模板文件名和编译文件名称
		$file = BASEPATH.'theme/'.Config::get('site_theme').'/'.$path.'.tpl.html';
		$temp_file = BASEPATH.'cache/tpl/'.$path.'.php';
		$temp_path = dirname($path);
		//新建模板缓存目录
		if(!is_dir(BASEPATH.'cache/tpl/'.$temp_path)) {
			create_dir(BASEPATH.'cache/tpl/'.$temp_path);
		}
		if(!is_file($file)) {
			$file = BASEPATH.'theme/default/'.$path.'.php';
		}
		$content = file_get_contents($file);

		$content = "<?php if(!defined('BASEPATH')) die('Access Denied'); ?>".$content;
		/*
		 * 正则表达式替换标签
		 */
		//解析包含文件
		$content = preg_replace('/\<!--#include\{([A-Za-z0-9._\/-]+?)\}-->/i', '<?php @include self::template(\'$1\'); ?>', $content);
		//解析head头区域
		$content = str_ireplace('<!--#heads-->', '<?php echo self::get_html_head(); ?>', $content);
		//解析if条件
		$content = preg_replace('/<!--#if\{(.+?)\}-->/i', '<?php if($1): ?>', $content);
		//解析elseif条件
		$content = preg_replace('/<!--#elseif\{(.+?)\}-->/i', '<?php elseif($1): ?>', $content);
		//解析else和endif
		$content = str_ireplace('<!--#else-->', '<?php else: ?>', $content);
		$content = str_ireplace('<!--#endif-->', '<?php endif; ?>', $content);
		//解析循环标签
		$content = preg_replace('/<!--#loop\{(.+?)\}-->/i', '<?php foreach($1 as $item): ?>', $content);
		$content = preg_replace('/\${item:(.+?)\}/i', '<?php echo $item[\'$1\']; ?>', $content);
		$content = str_ireplace('<!--#endloop-->', '<?php endforeach; ?>', $content);
		//解析设置项标签
		$content = preg_replace('/\${config:([A-Za-z0-9_\/]+?)\}/i', '<?php echo Config::get(\'$1\'); ?>', $content);
		//解析语言标签
		$content = preg_replace('/\${lang:([A-Za-z0-9_\/]+?)\}/i', '<?php echo Lang::_(\'$1\'); ?>', $content);
		//Widget标签解析
		$content = preg_replace('/\${widget:([A-Za-z0-9_\/]+?)\}/i', '<?php @include self::template(\'widget/$1\'); ?>', $content);
		//解析表达式输出
		$content = preg_replace('/\${(.+?)\}/i', '<?php echo $1; ?>', $content);
		//执行一行语句, 什么也不输出
		$content = preg_replace('/\@{(.+?)\}/i', '<?php $1; ?>', $content);
		file_put_contents($temp_file, $content);
	}

	/**
	 * 取得页面头部
	 * @return string
	 */
	private static function get_html_head() {
		self::html_meta('keywords', self::$page_keywords);
		self::html_meta('description', self::$page_description);
		return implode("\n", self::$html_heads)."\n";
	}
}

/* End of this file */