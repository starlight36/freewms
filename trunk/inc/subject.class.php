<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 专题类
 */
class Subject {
	public function get($key) {
		$sinfo = Cache::get('subject/'.$key);
		if($sinfo) return $sinfo;
		$db = DB::get_instance();
		$db->select('*')->from('subject');
		if(preg_match('/^[0-9]+$/i', $key)) {
			$db->sql_add('WHERE `subject_id` = ?', $key);
		}else{
			$db->sql_add('WHERE `subject_key` = ?', $key);
		}
		$sinfo = $db->get();
		if($sinfo == NULL) {
			return FALSE;
		}
		$sinfo = $sinfo[0];
		$key = $sinfo['subject_key']?$sinfo['subject_key']:$sinfo['subject_id'];
		$sinfo['subject_url'] = URL::get_url('subject', 'm=subject&key='.$key);
		$sinfo['subject_listurl'] = URL::get_url('subject', 'm=list&type=list&key='.$key.'&page=1');
		Cache::set('subject/'.$key, $sinfo);
		return $sinfo;
	}
}

/* End of this file */