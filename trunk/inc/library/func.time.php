<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 时间函数库
 */

/**
 * 取得当前时间的函数,已考虑服务器时差
 * @return int
 */
function now() {
	if (defined('TIME_DIFF')) {
		$now = gmmktime() + TIME_DIFF;
		$system_time = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));
		if (strlen($system_time) < 10) {
			$system_time = time();
		}
		return $system_time;
	}else{
		return time();
	}
}

/**
 * 取得一个以MYSQL时间标记的时间
 * @param string $datestr
 * @param string $time
 * @return int
 */
function mdate($datestr = '', $time = '') {
	if ($datestr == '')
		return '';
	if ($time == '')
		$time = now();
	$datestr = str_replace('%\\', '', preg_replace("/([a-z]+?){1}/i", "\\\\\\1", $datestr));
	return date($datestr, $time);
}
/**
 * 取得标准格式时间
 * @param string $fmt 格式代码
 * @param int $time 时间戳
 * @return string
 */
function standard_date($fmt = 'DATE_RFC822', $time = '') {
	$formats = array(
			'DATE_ATOM'		=>	'%Y-%m-%dT%H:%i:%s%Q',
			'DATE_COOKIE'	=>	'%l, %d-%M-%y %H:%i:%s UTC',
			'DATE_ISO8601'	=>	'%Y-%m-%dT%H:%i:%s%O',
			'DATE_RFC822'	=>	'%D, %d %M %y %H:%i:%s %O',
			'DATE_RFC850'	=>	'%l, %d-%M-%y %H:%m:%i UTC',
			'DATE_RFC1036'	=>	'%D, %d %M %y %H:%i:%s %O',
			'DATE_RFC1123'	=>	'%D, %d %M %Y %H:%i:%s %O',
			'DATE_RSS'		=>	'%D, %d %M %Y %H:%i:%s %O',
			'DATE_W3C'		=>	'%Y-%m-%dT%H:%i:%s%Q'
	);
	if ( ! isset($formats[$fmt])) {
		return FALSE;
	}
	return mdate($formats[$fmt], $time);
}

function unix_to_human($time = '', $style = 'both') {
	if($style == 'date_only') {
		return date('Y-m-d', $time);
	}elseif($style == 'time_only'){
		return date('H:i:s', $time);
	}else{
		return date('Y-m-d H:i:s', $time);
	}
}