<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 部件编辑页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_widget_new_tip');?>
	</div>
	<form action="index.php?m=admin&amp;a=widget&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_widget_id_tip');?>: </span>
					<span class="green bold"><?php if(!$id) {echo Lang::_('admin_widget_add_tip');}else{ echo $id;} ?></span>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_widget_name_tip');?>: </span>
				  <input type="text" class="text shorttext" name="name" value="<?php echo Form::set_value('name', $winfo['name']);?>" />
				  <?php echo Form::get_error('name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_widget_desc_tip');?>: </span>
				  <input type="text" class="text shorttext" name="desc" value="<?php echo Form::set_value('desc', $winfo['desc']);?>" />
				  <?php echo Form::get_error('desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_widget_key_tip');?>: </span>
				  <input type="text" class="text shorttext" name="key" value="<?php echo Form::set_value('key', $winfo['key']);?>" />
				  <?php echo Form::get_error('key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_widget_content_tip');?>:</span>
					<textarea class="normaltextarea" name="content"><?php echo Form::set_value('content', $winfo['content']);?></textarea>
					<?php echo Form::get_error('content', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_widget_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_widget_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>