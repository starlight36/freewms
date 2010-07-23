<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 权限编辑模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_acl_edit_list_tip');?>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=acl&amp;do=edit&id=<?php echo $id; ?>">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_acl_id_tip');?>: </span>
					<span class="green bold"><?php if(!$id) {echo Lang::_('admin_acl_add_tip');}else{ echo $id;} ?></span>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_acl_name_tip');?>: </span>
					<input type="text" class="text shorttext" name="acl_name" value="<?php echo Form::set_value('acl_name', $aclinfo['acl_name']);?>" />
					<?php echo Form::get_error('acl_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_acl_desc_tip');?>: </span>
					<input type="text" class="text shorttext" name="acl_desc" value="<?php echo Form::set_value('acl_desc', $aclinfo['acl_desc']);?>" />
					<?php echo Form::get_error('acl_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_acl_key_tip');?>: </span>
					<input type="text" class="text shorttext" name="acl_key" value="<?php echo Form::set_value('acl_key', $aclinfo['acl_key']);?>" />
					<?php echo Form::get_error('acl_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_acl_default_tip');?>: </span>
					<input type="text" class="text shorttext" name="acl_default" value="<?php echo Form::set_value('acl_default', $aclinfo['acl_default']);?>" />
					<?php echo Form::get_error('acl_default', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_acl_type_tip');?>: </span>
					<label><input type="radio" name="acl_type" value="0"<?php if(Form::set_value('acl_type', $aclinfo['acl_type']) == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_acl_type_0_tip');?></label>
					<label><input type="radio" name="acl_type" value="1"<?php if(Form::set_value('acl_type', $aclinfo['acl_type']) == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_acl_type_1_tip');?></label>
					<?php echo Form::get_error('acl_type', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_acl_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_acl_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>