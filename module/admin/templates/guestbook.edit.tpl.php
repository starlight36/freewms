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
							echo Lang::_('admin_gb_alterstate_tip');
						}else {
							echo Lang::_('admin_gb_replystate_tip');
						}
						?>
	</div>
	<form action="index.php?m=admin&amp;a=guestbook&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
					<span class="green bold">
						
					</span>
                <?php if($gbinfo['gb_replystate'] == 1):?><p><span class="green bold"><?php echo Lang::_('admin_gb_replytime_tip');?>：</span><?php echo date("Y-m-d H:i:s", $gbinfo['gb_replytime']);?></p><?php endif;?>
				<p><span class="left"><?php echo Lang::_('admin_gb_reply_tip');?>: </span>
					<textarea class="normaltextarea" name="gb_reply"><?php echo Form::set_value('gb_reply', $gbinfo['gb_reply']);?></textarea>
					<?php echo Form::get_error('gb_reply', '<span class="fielderrormsg">', '</span>');?>
				</p>

			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_gb_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_gb_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>