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
	<div class="titlebar"><?php echo Lang::_('admin_sys_message_title'); ?></div>
	<div id="tabcontent">
		<div class="showsimplecon">
			<div id="msg_area">
				<div id="msg_<?php echo $type ?>"></div>
				<div id="msg_info">
					<span class="alert bold"><?php echo $msg ?></span>
					<ul style="margin: 0;padding: 10px 0 0 10px;">
					<?php
					foreach($go_url as $key => $url) {
						echo '<li><a class="bold" href="'.$url.'">'.$key.'</a></li>'."\n";
					}
					?>
					</ul>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
setTimeout("window.location.href='<?php echo $redirect; ?>'",<?php echo $autogo; ?>*1000);
</script>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>