<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 后台操作消息页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">系统提示消息</div>
	<div class="showsimplecon">
		<p><?php echo $type ?></p>
		<p><?php echo $msg ?></p>
		<p><?php var_dump($go_url, $autogo); ?></p>
	</div>
	<div style="clear: both;"></div>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>