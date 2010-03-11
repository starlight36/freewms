<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * session函数库
 */

if(SESSION_TYPE == 'file') {
	session_save_path(SESSION_PATH);
}else{
	$session_lib_file = DIR_INC.'libaray/session/'.SESSION_TYPE.'_session.php';
	if(is_file($session_lib_file)) {
		@include_once $session_lib_file;
		session_set_save_handler('sess_open', 'sess_close', 'sess_read', 'sess_write', 'sess_destroy', 'sess_gc');
	}else{
		die('Can not find session library named '.SESSION_TYPE);
	}
}
session_cache_expire(SESSION_EXPIRE);

/* End of the file */