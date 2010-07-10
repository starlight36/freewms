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
		//初始化传入变量
		if(is_array($data) && !empty($data)) {
			foreach($data as $k => $v){
				$$k = $v;
			}
		}
		//初始化部件对象
		$widget = Widget::get_instance();
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
	 * 直接输出消息页
	 * @param string $type
	 * @param string $msg
	 * @param mixed $go_url
	 * @param int $autogo
	 */
	public static function show_message($type = 'error', $msg = NULL, $go_url = NULL, $autogo = NULL) {
		Lang::load('view');
		if(!is_array($go_url) || $go_url == NULL) {
			$go_url = array(Lang::_('sys_view_goto_pre_page') => $go_url);
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
		$content = preg_replace('/<t:include page="(.+)".*>/i', '<?php @include self::template(\'$1\'); ?>', $content);
		//解析head头区域
		$content = preg_replace('/<t:head(.*)>/i', '<?php echo self::get_html_head(); ?>', $content);
		//解析部件标签
		$content = preg_replace('/<t:widget (.+?)>(.*)<\/t:widget>/ise', 'self::tag_widget(\'$1\', \'$2\')', $content);
		//解析if条件
		$content = preg_replace('/<t:if test="(.+)">/i', '<?php if($1): ?>', $content);
		//解析elseif条件
		$content = preg_replace('/<t:elseif test="(.+?)".*>/i', '<?php elseif($1): ?>', $content);
		//解析else和endif
		$content = preg_replace('/<t:else.*>/i', '<?php else: ?>', $content);
		$content = str_ireplace('</t:if>', '<?php endif; ?>', $content);
		//解析循环标签For
		$content = preg_replace('/<t:for (.+?)>/ie', 'self::tag_for(\'$1\')', $content);
		$content = str_ireplace('</t:for>', "<?php endfor; ?>", $content);
		//解析循环标签While
		$content = preg_replace('/<t:while (.+?)>/ie', 'self::tag_while(\'$1\')', $content);
		$content = str_ireplace('</t:while>', "<?php endwhile; ?>", $content);
		//解析循环标签Loop
		$content = preg_replace('/<t:loop (.+?)>/ie', 'self::tag_loop(\'$1\')', $content);
		$content = str_ireplace('</t:loop>', "<?php \$_i++; ?>\n<?php endforeach; ?>\n<?php endif; ?>", $content);
		//解析语言标签
		$content = preg_replace('/<t:lang key="(.+)".*>/i', '<?php echo Lang::get(\'$1\'); ?>', $content);
		//输出标签
		$content = preg_replace('/<t:out (.+?)\/>/ie', 'self::tag_out(\'$1\')', $content);
		//解析PHP语句块
		$content = preg_replace('/<script .*="php".*>(.*)<\/script>/is', '<?php$1?>', $content);
		//变量表达式 - 读取设置
		$content = preg_replace('/\$\{config=(.+?)\}/i', 'Config::get(\'$1\')', $content);
		//变量表达式 - 读取语言
		$content = preg_replace('/\$\{lang=(.+?)\}/i', 'Lang::get(\'$1\')', $content);
		//变量表达式 - 读取缓存
		$content = preg_replace('/\$\{cache=(.+?)\}/i', 'Cache::get(\'$1\')', $content);
		//变量表达式 - 读取Session
		$content = preg_replace('/\$\{session=(.+?)\}/i', 'Session::get(\'$1\')', $content);
		//变量表达式 - 读取请求变量
		$content = preg_replace('/\$\{request=(.+?)\}/i', 'path_array($_REQUEST, \'$1\')', $content);
		//变量表达式 - 读取COOKIE
		$content = preg_replace('/\$\{cookie=(.+?)\}/i', 'path_array($_COOKIE, \'$1\')', $content);
		//变量表达式 - 本次循环键名
		$content = str_ireplace('${key}', '$key', $content);
		//变量表达式 - 本次循环编号
		$content = str_ireplace('${i}', '$_i', $content);
		//变量表达式 - 本次循环结果
		$content = preg_replace('/\$\{get=(.+?)\}/i', '$row[\'$1\']', $content);
		file_put_contents($temp_file, $content);
	}

	/**
	 * 解析标签属性
	 * @param string $str 参数字串
	 * @return array;
	 */
	private static function parse_param($str) {
		$str = trim(str_replace('\"', '"', $str));
		preg_match_all('/(\w+)="(.*?)"/i', $str, $matches);
		$result = array();
		for($i = 0; $i < count($matches[0]); $i++) {
			$result[$matches[1][$i]] = trim($matches[2][$i]);
		}
		return $result;
	}

	/**
	 * 构造模板For标签
	 * @param string $str
	 * @return string
	 */
	private static function tag_for($str) {
		$param = self::parse_param($str);
		return "<?php for({$param['start']}; {$param['test']}; {$param['next']}): ?>";
	}

	/**
	 * 构造模板While标签
	 * @param string $str
	 * @return string
	 */
	private static function tag_while($str) {
		$param = self::parse_param($str);
		return "<?php while({$param['test']}): ?>";
	}

	/**
	 * 构造模板Loop标签
	 * @param string $str
	 * @return string
	 */
	private static function tag_loop($str) {
		$param = self::parse_param($str);
		$result = "<?php if(empty({$param['exp']})): ?>\n";
		$result .= $param['default'];
		$result .= "<?php else: ?>\n";
		$result .= "<?php \$_i = 1; foreach({$param['exp']} as \$key => \$row): ?>\n";
		return $result;
	}

	/**
	 * 构造模板Widget标签
	 * @param string $str
	 * @return string
	 */
	private static function tag_widget($param, $content) {
		$param = self::parse_param($param);
		if(!$param['bind'] || !$param['call']) {
			return ;
		}
		$str = '<?php $_temp = $widget->'.$param['bind'].'->'.$param['call'].'(\''.$param['param'].'\'); ?>';
		if($param['foreach'] == 'false') {
			$str .= '<?php echo $_temp; ?>';
		}else{
			$str .= "\n".'<t:loop exp="$_temp" default="'.$param['default'].'">'.$content;
			$str .= '</t:loop>';
		}
		return $str;
	}

	/**
	 * 构造模板Out标签
	 * @param string $str
	 * @return string
	 */
	private static function tag_out($str) {
		$param = self::parse_param($str);
		$str = $param['exp'];
		if(!empty($param['filter'])) {
			$filters = explode('|', $param['filter']);
			foreach($filters as $item) {
				if(preg_match("/(.*?)\\[(.*)\\]/", $item, $match)) {
					$filter = $match[1];
					$f_param = $match[2];
				}else{
					$filter	= $item;
				}
				if(method_exists('Format', $filter)) {
					$str = 'Format::'.$filter.'('.$str;
				}elseif(function_exists($filter)) {
					$str = $filter.'('.$str;
				}else{
					continue;
				}
				if($f_param) {
					$str .= ', '.$f_param.')';
				}else{
					$str .= ')';
				}
			}
		}
		return "<?php echo {$str}; ?>";
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