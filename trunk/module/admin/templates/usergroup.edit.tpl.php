<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 用户组编辑模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_group_modify_tip');?>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=usergroup&amp;do=edit&id=<?php echo $id; ?>">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_group_id_tip');?>: </span>
					<span class="green bold"><?php if(!$id) {echo Lang::_('admin_group_add_tip');}else{ echo $id;} ?></span>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_group_name_tip');?>: </span>
					<input type="text" class="text shorttext" name="group_name" value="<?php echo Form::set_value('group_name', $ginfo['group_name']);?>" />
					<?php echo Form::get_error('group_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_group_ad_tip');?>: </span>
					<label><input type="radio" name="group_isadmin" value="1"<?php if(Form::set_value('group_isadmin', $ginfo['group_isadmin']) == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_group_ad_yes');?></label>
					<label><input type="radio" name="group_isadmin" value="0"<?php if(Form::set_value('group_isadmin', $ginfo['group_isadmin']) == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_group_ad_no');?></label>
					<?php echo Form::get_error('group_isadmin', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_group_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_group_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>