<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

class Topbar {
	public function get(){
		//载入数据库对象
        $db = DB::get_instance();
		$db->select('*')->from('topbar')->sql_add('WHERE `topbar_hide` = 0');
		$tinfo = $db->get();
		return $tinfo[0];
	}
}
?>
