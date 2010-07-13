<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 内容显示模块
 */

$key = $_GET['key'];
$type = $_GET['type'];

if(empty($key)) {
	show_404();
}

$content = new Content();
$cinfo = $content->get_content($key);
if(!$cinfo){
	show_404();
}
View::set_title($cinfo['content_title']);
View::set_description($cinfo['content_title'].'-'.$cinfo['cate_description']);
View::set_keywords($cinfo['content_title']);
if($type == 'print') {
	View::load($cinfo['cate_template'].'/print', $cinfo);
}else{
	View::load($cinfo['cate_template'].'/view', $cinfo);
}
/* End of this file */