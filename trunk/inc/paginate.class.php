<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/**
 * 分页组件
 */
class Paginate {

	private static $pagenum;
	private static $pagecount;
	private static $pagesize;

	private static $url_tpl;
	private static $style;
	

	/**
	 * 创建分页
	 * @param string $url_tpl URL模板
	 * @param int $pagenum 当前页面页码
	 * @param int $pagecount 分页总数
	 * @param int $pagesize 每页条数
	 * @param int $style 分页样式
	 */
	public static function set_paginate($url_tpl, $pagenum, $pagecount, $pagesize, $style = 0) {
		Lang::load('paginate');
		self::$pagecount = $pagecount;
		self::$pagenum = $pagenum;
		self::$pagesize = $pagesize;
		self::$style = $style;
		self::$url_tpl = $url_tpl;
	}

	/**
	 * 读取显示分页
	 * @param string $link_style 链接样式类
	 * @param string $curr_sytle 当前页样式类
	 * @param int $link_num 要显示的链接数
	 * @return string
	 */
	public static function get_paginate($link_style = NULL, $curr_sytle = NULL, $link_num = 5) {
		$str = NULL;
		switch (self::$style) {
			case '0': //样式0 显示全部分页列表
				$str .= '<a class="pageinfo">Page'.self::$pagenum.'/'.ceil(self::$pagecount/self::$pagesize).'<a>';
				for($i = 1; $i <= ceil(self::$pagecount/self::$pagesize); $i++) {
					if(self::$pagenum == $i) {
						$str .= '<a class="'.$curr_sytle.'">'.$i.'</a>';
					}else{
						$url = str_replace('{page}', $i, self::$url_tpl);
						$str .= '<a class="'.$link_style.'" href="'.$url.'" title="Page '.$i.'">'.$i.'</a>';
					}
				}
				break;
			case '1': //样式1 以"首页/上一页/下一页/末页"导航
				$str .= '<a class="pageinfo">Page'.self::$pagenum.'/'.ceil(self::$pagecount/self::$pagesize).'<a>';
				if(self::$pagenum > 1) {
					$str .= '<a class="'.$link_style.'" href="'.str_replace('{page}', 1, self::$url_tpl).'" title="'.
							Lang::_('page_first_page').'">'.Lang::_('page_first_page').'</a>';
					$str .= '<a class="'.$link_style.'" href="'.str_replace('{page}', self::$pagenum - 1, self::$url_tpl).'" title="'.
							Lang::_('page_pre_page').'">'.Lang::_('page_pre_page').'</a>';
				}
				if(self::$pagenum < ceil(self::$pagecount/self::$pagesize)) {
					$str .= '<a class="'.$link_style.'" href="'.str_replace('{page}', self::$pagenum + 1, self::$url_tpl).'" title="'.
							Lang::_('page_next_page').'">'.Lang::_('page_next_page').'</a>';
					$str .= '<a class="'.$link_style.'" href="'.str_replace('{page}', ceil(self::$pagecount/self::$pagesize), self::$url_tpl).'" title="'.
							Lang::_('page_last_page').'">'.Lang::_('page_last_page').'</a>';
				}
				break;
			case '2': //样式2 以"首页/上一页/中间页码/下一页/末页"导航
				$str .= '<a class="pageinfo">Page'.self::$pagenum.'/'.ceil(self::$pagecount/self::$pagesize).'<a>';
				if(self::$pagenum > 1) {
					$str .= '<a class="'.$link_style.'" href="'.str_replace('{page}', 1, self::$url_tpl).'" title="'.
							Lang::_('page_first_page').'">'.Lang::_('page_first_page').'</a>';
					$str .= '<a class="'.$link_style.'" href="'.str_replace('{page}', self::$pagenum - 1, self::$url_tpl).'" title="'.
							Lang::_('page_pre_page').'">'.Lang::_('page_pre_page').'</a>';
				}
				for($i = 1; $i <= ceil(self::$pagecount/self::$pagesize); $i++) {
					if(self::$pagenum == $i) {
						$str .= '<a class="'.$curr_sytle.'">'.$i.'</a>';
					}else{
						$url = str_replace('{page}', $i, self::$url_tpl);
						$str .= '<a class="'.$link_style.'" href="'.$url.'" title="Page '.$i.'">'.$i.'</a>';
					}
				}
				if(self::$pagenum < ceil(self::$pagecount/self::$pagesize)) {
					$str .= '<a class="'.$link_style.'" href="'.str_replace('{page}', self::$pagenum + 1, self::$url_tpl).'" title="'.
							Lang::_('page_next_page').'">'.Lang::_('page_next_page').'</a>';
					$str .= '<a class="'.$link_style.'" href="'.str_replace('{page}', ceil(self::$pagecount/self::$pagesize), self::$url_tpl).'" title="'.
							Lang::_('page_last_page').'">'.Lang::_('page_last_page').'</a>';
				}
				break;
			default:
				break;
		}
		return $str;
	}
}
/* End of this file */