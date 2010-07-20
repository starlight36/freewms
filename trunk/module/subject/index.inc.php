<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 专题显示模块
 */

$key = $_GET['key'];

if(empty($key)) {
	show_404();
}

$subj = new Subject();
$subject = $subj->get($key);
if(!$subject){
	show_404();
}

View::set_title($subject['subject_title']);
View::set_description($subject['subject_title'].'-'.$subject['subject_desc']);
View::set_keywords($subject['subject_title']);
View::load($subject['subject_template'], $subject);

/* End of this file */