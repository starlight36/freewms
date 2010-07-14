<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 *  编辑/修改管理员回复留言页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php
						if($gbinfo['gb_replystate'] == 1){
							echo "修改回复";
						}else {
							echo "回复留言";
						}
						?>
	</div>
	<form action="index.php?m=admin&amp;a=guestbook&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
					<span class="green bold">
						
					</span>
                <?php if($gbinfo['gb_replystate'] == 1):?><p><span class="green bold">上次回复时间：</span><?php echo date("Y-m-d H:i:s", $gbinfo['gb_replytime']);?></p><?php endif;?>
				<p><span class="left">回复: </span>
					<textarea class="normaltextarea" name="gb_reply"><?php echo Form::set_value('gb_reply', $gbinfo['gb_reply']);?></textarea>
					<?php echo Form::get_error('gb_reply', '<span class="fielderrormsg">', '</span>');?>
				</p>

			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="提交">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重置">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>