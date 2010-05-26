<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/**
 * 图片处理组件
 */

class Image {

	private $watermark_size = "400|400";
	private $watermark_path = 'images/watermark.png';
	private $watermark_pct = 50;
	private $watermark_postion = '1';

	public function  __construct() {
		$this->watermark_size = Config::get('pic_watermark_size');
		$this->watermark_path = BASEPATH.Config::get('pic_watermark_path');
		$this->watermark_pct = Config::get('pic_watermark_pct');
		$this->watermark_postion = Config::get('pic_watermark_postion');
	}

	/**
	 * 读取图像信息数组
	 * @param string $img
	 * @return mixed
	 */
	public function get_info($img) {
		$imageinfo = getimagesize(BASEPATH.$img);
		if($imageinfo === false) return false;
		$imagetype = strtolower(substr(image_type_to_extension($imageinfo[2]),1));
		$imagesize = filesize(BASEPATH.$img);
		$info = array(
				'width'=>$imageinfo[0],
				'height'=>$imageinfo[1],
				'type'=>$imagetype,
				'size'=>$imagesize,
				'mime'=>$imageinfo['mime']
		);
		return $info;
	}

	/**
	 * 缩放图片
	 * @param string $s_img 源文件
	 * @param string $t_img 目标文件
	 * @param int $height 图像高度
	 * @param int $width 图像宽度
	 */
	public function resize($s_img, $t_img, $width, $height) {
		
		$pic_info = $this->get_info($s_img);
		$pic_width = $pic_info['width'];
		$pic_height = $pic_info['height'];

		if(($width && $pic_width > $width) || ($height && $pic_height > $height)) {

			$s_img = BASEPATH.$s_img;
			$t_img = BASEPATH.$t_img;

			if($width && $pic_width > $width) {
				$widthratio = $width/$pic_width;
				$resizewidth_tag = TRUE;
			}

			if($height && $pic_height>$height) {
				$heightratio = $height/$pic_height;
				$resizeheight_tag = TRUE;
			}

			if($resizewidth_tag && $resizeheight_tag) {
				if($widthratio < $heightratio) {
					$ratio = $widthratio;
				}else{
					$ratio = $heightratio;
				}
			}

			if($resizewidth_tag && !$resizeheight_tag) $ratio = $widthratio;
			if($resizeheight_tag && !$resizewidth_tag) $ratio = $heightratio;

			$newwidth = $pic_width * $ratio;
			$newheight = $pic_height * $ratio;

			//打开源文件
			$ext_name = strtolower(file_ext_name($s_img));
			if($ext_name == 'gif' && function_exists('imagecreatefromgif')) {
				$oldim = @imagecreatefromgif($s_img);
			}elseif($ext_name == 'png' && function_exists('imagecreatefrompng')) {
				$oldim = @imagecreatefrompng($s_img);
			}elseif(($ext_name == 'jpg' || $ext_name == 'jpeg') && function_exists('imagecreatefromjpeg')) {
				$oldim = @imagecreatefromjpeg($s_img);
			}else{
				$oldim = FALSE;
			}
			if($oldim == FALSE) {
				return FALSE;
			}

			//处理缩放图片
			if(function_exists("imagecopyresampled")) {
				$newim = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($newim, $oldim, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			}else{
				$newim = imagecreate($newwidth, $newheight);
				imagecopyresized($newim, $oldim, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			}

			//输出图像到文件
			if($ext_name == 'gif' && function_exists('imagegif')) {
				@imagegif($newim, $t_img);
			}elseif($ext_name == 'png' && function_exists('imagepng')) {
				@imagepng($newim, $t_img);
			}elseif(($ext_name == 'jpg' || $ext_name == 'jpeg') && function_exists('imagejpeg')) {
				@imagejpeg($newim, $t_img);
			}
			imagedestroy($newim);
			imagedestroy($oldim);
		}else{
			copy($s_img, $t_img);
		}
	}

	/**
	 * 给图片加水印
	 * @param string $img
	 */
	public function watermark($img) {
		$waterimg = $this->watermark_path;
		if (!is_file($waterimg)) {
			return false;
		}
		if (!function_exists('getimagesize')) {
			return false;
		}
		$pic_info = @getimagesize($img);
		if (!$pic_info[0] || !$pic_info[1]) {
			return false;
		}
		$watermark_size = explode('|', $this->watermark_size);
		if($pic_info[0] < $watermark_size[0] || $pic_info[1] < $watermark_size[1]) return true;
		switch($pic_info['mime']) {
			case 'image/jpeg':
				$tmp = @imagecreatefromjpeg($img);
				break;
			case 'image/gif':
				if(!function_exists('imagecreatefromgif')) {
					return false;
				}else{
					$tmp = @imagecreatefromgif($img);
				}
				break;
			case 'image/png':
				$tmp = @imagecreatefrompng($img);
				break;
			default:
				return false;
		}
		$marksize = @getimagesize($waterimg);
		$width = $marksize[0];
		$height = $marksize[1];
		switch($this->watermark_postion) {
			// right-bottom
			case '0':
				$pos_x = $pic_info[0] - $width - 5;
				$pos_y = $pic_info[1] - $height - 5;
				break;
			// left-top
			case '1':
				$pos_x = 5;
				$pos_y = 5;
				break;
			// left-bottom
			case '2':
				$pos_x = 5;
				$pos_y = $pic_info[1] - $height - 5;
				break;
			// right-top
			case '3':
				$pos_x = $pic_info[0] - $width - 5;
				$pos_y = 5;
				break;
			// mid
			case '4':
				$pos_x = ($pic_info[0]-$width)/2;
				$pos_y = ($pic_info[1]-$height)/2;
				break;
			// random
			default:
				$pos_x = rand(0, ($pic_info[0]-$width));
				$pos_y = rand(0, ($pic_info[1]-$height));
				break;
		}
		
		$ext_name = strtolower(file_ext_name($waterimg));
		if($ext_name == 'gif' && function_exists('imagecreatefromgif')) {
			$imgmark = @imagecreatefromgif($waterimg);
		}elseif($ext_name == 'png' && function_exists('imagecreatefrompng')) {
			$imgmark = @imagecreatefrompng($waterimg);
		}elseif(($ext_name == 'jpg' || $ext_name == 'jpeg') && function_exists('imagecreatefromjpeg')) {
			$imgmark = @imagecreatefromjpeg($waterimg);
		}else{
			return FALSE;
		}
		if($imgmark) {
			imageAlphaBlending($imgmark, false);
			if ($this->watermark_pct) {
				@imagecopymerge($tmp, $imgmark, $pos_x, $pos_y, 0, 0, $width, $height, $this->watermark_pct);
			} else {
				@imagecopy($tmp, $imgmark, $pos_x, $pos_y, 0, 0, $width, $height);
			}
		}
		switch ($pic_info['mime']) {
			case 'image/jpeg':
				@imagejpeg($tmp, $img,80);
				@imagedestroy($tmp);
				break;
			case 'image/gif':
				@imagegif($tmp, $img);
				@imagedestroy($tmp);
				break;
			case 'image/png':
				@imagepng($tmp, $img);
				@imagedestroy($tmp);
				break;
			default :
				return;
		}
	}
}

/* End of this file */