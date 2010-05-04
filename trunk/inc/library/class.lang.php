<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 语言类
 * 为系统提供多语言支持
 */
class cls_lang {
	private $lang_name = DEF_LANG;
	private $lang = array();

	/**
	 * 初始化设置使用的语种
	 * @param string $str
	 */
	public function init($str = DEF_LANG) {
		$str = strtolower($str);
		if(is_dir(DIR_INC.'language/'.$str)) {
			$this->lang_name = $str;
		}else{
			$this->lang_name = DEF_LANG;
		}
		//自动加载的语言设置
		$autoload_file = DIR_INC.'language/'.$this->lang_name.'/config.php';
		if(is_file($autoload_file)) {
			@include_once $autoload_file;
			if(!empty($config['autoload']) && is_array($config['autoload'])) {
				foreach($config['autoload'] as $row) {
					$this->load($row);
				}
			}
		}
		return TRUE;
	}

	/**
	 * 设置客户端语言
	 * @param <type> $str
	 */
	public function set_lang($str) {
		setcookie('DF_LANG', $str, time() + 31536000);
	}

	/**
	 * 加载一个语言文件
	 * @param string $path
	 * @return bool
	 */
	public function load($path = NULL) {
		if(is_null($path)) {
			$in =& load_class('in');
			$path = $in->controller().'/'.$in->action();
		}
		$path = DIR_INC.'language/'.$this->lang_name.'/'.$path.'.php';
		if(is_file($path)) {
			@include_once $path;
			$this->lang = array_merge($this->lang, $lang);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * 读取一个语言参数
	 * @param string $path
	 * @return unknown
	 */
	public function get($path = NULL) {
		$arglist = func_get_args();
		$argcount = func_num_args();
		if($argcount > 1) {
			for($i = 1; $i < $argcount; $i++) {
				$args[] = "'{$arglist[$i]}'";
			}
			eval('$value=sprintf(path_array($this->lang, $path), '.implode(',', $args).');');
		}else{
			$value = path_array($this->lang, $path);
		}
		return $value;
	}
}

/* End of the file */