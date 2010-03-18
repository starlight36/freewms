<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * URL类
 * 为系统提供URL处理功能
 */
class cls_url {
	private $config = NULL;
	public function  __construct() {
		$this->config =& load_class('config');
		$this->config->load('site');
	}

	/**
	 * 取得站点根URL
	 * @return string
	 */
	public function base_url() {
		return $this->config->get('site/base_url');
	}

	/**
	 * 取得站点中的实际地址
	 * @param string $str URI路径
	 * @return string
	 */
	public function site_url($str = NULL) {
		if(strtolower(substr($str, 0, 7)) == 'http://') {
			return $str;			
		}
		$base_url = $this->base_url();
		if(!URL_REWRITE) {
			$base_url .= FRONT_CONTROLLER;
		}
		if(URI_MODE == 'GET') {
			@include DIR_ROOT.'config/route.php';
			if(!empty($route)) {
				foreach($route as $k => $v) {
					if(check_str_in($k, '#')) {
						$str = preg_replace($k, $v, $str);
					}else{
						$str = str_replace($k, $v, $str);
					}
				}
			}
			$arr_segment = explode('/', $str);
			$controller = empty($arr_segment[0])?DEFAULT_CONTROLLER:$arr_segment[0];
			$action = empty($arr_segment[1])?DEFAULT_ACTION:$arr_segment[1];
			$site_url = $base_url.'?c='.$controller.'&a='.$action;
			if(count($arr_segment) > 2) {
				for($i = 2; $i < count($arr_segment); $i += 2) {
					if(isset($arr_segment[$i + 1])) {
						$site_url .= '&'.urlencode($arr_segment[$i]);
						$site_url .= '='.urlencode($arr_segment[$i + 1]);
					}
				}
			}
			return $site_url;
		}elseif(URI_MODE == 'PATH'){
			return $base_url.'/'.$str;
		}else{
			return $base_url.'?'.$str;
		}
	}
}
/* End of the file */