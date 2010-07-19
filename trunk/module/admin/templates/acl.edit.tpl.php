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
		权限条目编辑
	</div>
	<form method="post" action="index.php?m=admin&amp;a=acl&amp;do=edit&id=<?php echo $id; ?>">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">权限ID: </span>
					<span class="green bold"><?php if(!$id) {echo '新建权限';}else{ echo $id;} ?></span>
				</p>
				<p><span class="left">权限名称: </span>
					<input type="text" class="text shorttext" name="acl_name" value="<?php echo Form::set_value('acl_name', $aclinfo['acl_name']);?>" />
					<?php echo Form::get_error('acl_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">权限简介: </span>
					<input type="text" class="text shorttext" name="acl_desc" value="<?php echo Form::set_value('acl_desc', $aclinfo['acl_desc']);?>" />
					<?php echo Form::get_error('acl_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">权限标识符: </span>
					<input type="text" class="text shorttext" name="acl_key" value="<?php echo Form::set_value('acl_key', $aclinfo['acl_key']);?>" />
					<?php echo Form::get_error('acl_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">权限设置默认值: </span>
					<input type="text" class="text shorttext" name="acl_default" value="<?php echo Form::set_value('acl_default', $aclinfo['acl_default']);?>" />
					<?php echo Form::get_error('acl_default', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">权限类型: </span>
					<label><input type="radio" name="acl_type" value="0"<?php if(Form::set_value('acl_type', $aclinfo['acl_type']) == '0'){echo ' checked="checked"';} ?> />&nbsp;用户权限</label>
					<label><input type="radio" name="acl_type" value="1"<?php if(Form::set_value('acl_type', $aclinfo['acl_type']) == '1'){echo ' checked="checked"';} ?> />&nbsp;管理权限</label>
					<?php echo Form::get_error('acl_type', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="保存修改">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重置表单">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>