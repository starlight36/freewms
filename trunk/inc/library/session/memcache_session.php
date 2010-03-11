<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * session库 memcache
 */

//打开session
function sess_open($session_path, $session_name) {
	
	return TRUE;
}

//关闭session
function sess_close() {
	
}

//读取session
function sess_read($session_id) {
	
}

//写入session
function sess_write($session_id, $session_value) {
	
}

//删除session
function sess_destroy($session_id) {

}

//清理session
function sess_gc($lifetime) {
	
}
