<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 顶部导航条类
 */

class Topbar {
	public function get(){
		$topbar = Cache::get('topbar');
		if($topbar) return $topbar;
		//载入数据库对象
        $db = DB::get_instance();
		$db->select('*')->from('topbar')->sql_add('WHERE `topbar_hide` = 0');
		$tinfo = $db->get();
		if($tinfo == NULL) {
			return NULL;
		}
		$content = new Content();
		foreach($tinfo as $row) {
			if($row['topbar_type'] == '1') {
				$row['topbar_url'] = $content->get_category($row['topbar_bindid']);
			}elseif($row['topbar_type'] == '2') {
				$row['topbar_url'] = Page::get($row['topbar_bindid']);
			}
			$topbar[] = $row;
		}
		Cache::set('topbar', $topbar);
		return $topbar;
	}
}
?>
