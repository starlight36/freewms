<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 编辑/修改模型页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_mod_edit_desc_tip');?>
	</div>
	<form action="index.php?m=admin&amp;a=module&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_mod_id_tip');?>: </span>
					<span class="green bold"><?php if(!$id) {echo Lang::_('admin_new_mod');}else{ echo $id;} ?></span>
					<?php if($mod['mod_is_system']): ?>
					<span class="alert bold"><?php echo Lang::_('admin_sys_mod_tip');?></span>
					<?php else: ?>
					<span class="green bold"><?php echo Lang::_('admin_user_mod_tip');?></span>
					<?php endif; ?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mod_name_tip');?>: </span>
					<input type="text" class="text shorttext" name="mod_name" value="<?php echo Form::set_value('mod_name', $mod['mod_name']);?>" />
					<?php echo Form::get_error('mod_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mod_desc_tip');?>: </span>
					<input type="text" class="text normaltext" name="mod_desc" value="<?php echo Form::set_value('mod_desc', $mod['mod_desc']);?>" />
					<?php echo Form::get_error('mod_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mod_itemname_tip');?>: </span>
					<input type="text" class="text shorttext" name="mod_itemname" value="<?php echo Form::set_value('mod_itemname', $mod['mod_itemname']);?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_mod_itemname_title');?>">[?]</a>
					<?php echo Form::get_error('mod_itemname', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mod_itemunit_tip');?>: </span>
					<input type="text" class="text shorttext" name="mod_itemunit" value="<?php echo Form::set_value('mod_itemunit', $mod['mod_itemunit']);?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_mod_itemunit_title');?>">[?]</a>
					<?php echo Form::get_error('mod_itemunit', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mod_template_tip');?>: </span>
					<input type="text" class="text shorttext" name="mod_template" value="<?php echo Form::set_value('mod_template', $mod['mod_template']);?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_mod_template_title');?>">[?]</a>
					<?php echo Form::get_error('mod_template', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_submit_title');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_reset_title');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>