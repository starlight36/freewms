<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/*
 * 上传文件类
 */

class Upload {
	private $file = NULL;
	private $error = NULL;
	public $count = 0;
	private $filelist = NULL;

	public function  __construct($field = 'file') {
		if(!is_array($_FILES[$field]['name'])) {
			$this->file[] = $_FILES[$field];
		}else{
			foreach($_FILES[$field]['name'] as $i => $value) {
				if(empty($value)) continue;
				$this->file[] = array(
					'name' => $value,
					'type' => $_FILES[$field]['type'][$i],
					'size' => $_FILES[$field]['size'][$i],
					'temp_name' => $_FILES[$field]['tmp_name'][$i],
					'error' => $_FILES[$field]['error'][$i]
				);
			}
		}
	}

	/**
	 * 保存上传文件
	 * @return bool
	 */
	public function savefile() {
		if($this->file == NULL) {
			$this->error[] = '没有提交任何文件';
			return FALSE;
		}

		//生成保存路径

		$filedir = date('Ym').'/';
		$basepath = Config::get('upload_save_path');
		if(substr($basepath, 0, 1) != '/') {
			$basepath = BASEPATH.$basepath;
		}
		$basepath .= $filedir;
		create_dir($basepath);

		//准备图片处理组件
		$image = new Image();
		$preview_size = explode('|', Config::get('pic_thumb_size'));
		$limit_size = explode('|', Config::get('pic_resize_size'));

		//载入数据库组件
		$db = DB::get_instance();

		foreach($this->file as $file) {
			if($file['error'] > 0) {
				$this->error[$file['name']] = '系统错误: Code '.$file['error'].'.更多信息请参考PHP手册.';
				continue;
			}
			if(!is_uploaded_file($file['temp_name'])) {
				continue;
			}
			if(!$file['size'] > Config::get('upload_size')) {
				$this->error[$file['name']] = '文件大小超过了系统允许.';
				continue;
			}
			if(!in_array(file_ext_name($file['name']), explode('|', Config::get('upload_extname')))) {
				$this->error[$file['name']] = '此类型文件不允许上传.';
				continue;
			}
			if(defined('SAFE_MODE')) {
				if(in_array(file_ext_name($file['name']), array('asp', 'php', 'jsp', 'sh', 'pl', 'py'))) {
					$this->error[$file['name']] = '此类型文件不允许上传.';
					continue;
				}
			}

			//保存上传文件
			$filepath = date('YmdHis').rand(100, 999);
			$ext_name = '.'.file_ext_name($file['name']);
			$save_path = $basepath.$filepath.$ext_name;
			if(!move_uploaded_file($file['temp_name'], $save_path)) {
				$this->error[$file['name']] = '移动上传文件出错, 请检查上传文件夹是否有写入权限.';
				continue;
			}
			//对图片格式缩放/生成缩略图/加水印
			if(in_array(file_ext_name($file['name']), array('jpg', 'gif', 'png', 'jpeg'))) {
				if(Config::get('pic_resize') == '1') {
					$image->resize($save_path, $save_path, $limit_size[0], $limit_size[1]);
				}
				if(Config::get('pic_thumb') == '1') {
					$image->resize($save_path, $basepath.$filepath.'_preview'.$ext_name, $preview_size[0], $preview_size[1]);
				}
				if(Config::get('pic_watermark') == '1') {
					$image->watermark($save_path);
				}
			}
			//录入数据库
			$data = array(
				'upload_name' => $file['name'],
				'upload_time' => time(),
				'upload_size' => $file['size'],
				'upload_path' => $filedir.$filepath.$ext_name
			);
			$db->set($data);
			$db->insert('upload');
			$this->filelist[] = array(
				'name' => $file['name'],
				'size' => $file['size'],
				'url' => Config::get('upload_url').$filedir.$filepath.$ext_name
			);
			$this->count++;
		}
		if(count($this->error) > 0) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

	/**
	 * 读取错误信息
	 * @param string $type 返回错误信息的类型
	 * @return mixed
	 */
	public function get_errors($type = 'string') {
		if($type == 'string') {
			$error = NULL;
			foreach($this->error as $file => $msg) {
				$error .= basename($file).'上传出错: '.$msg.'<br />';
			}
			return $error;
		}else{
			return $this->error;
		}
	}

	/**
	 * 返回上传的文件列表
	 */
	public function get_upload_files() {
		return $this->filelist;
	}
}

/* End of the file */