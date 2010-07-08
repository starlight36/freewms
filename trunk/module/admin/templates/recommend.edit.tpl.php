<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 专题编辑页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		专题编辑说明
	</div>
	<form action="index.php?m=admin&amp;a=recommend&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">推荐位ID: </span>
					<span class="green bold"><?php if(!$id) {echo '新建推荐位';}else{ echo $id;} ?></span>
				</p>
				<p><span class="left">推荐位名称: </span>
					<input type="text" class="text shorttext" name="rec_name" value="<?php echo Form::set_value('rec_name', $rinfo['rec_name']);?>" />
					<?php echo Form::get_error('rec_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">推荐位标识符: </span>
					<input type="text" class="text shorttext" name="rec_key" value="<?php echo Form::set_value('rec_key', $rinfo['rec_key']);?>" />
					<?php echo Form::get_error('rec_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">推荐位简介: </span>
					<input type="text" class="text shorttext" name="rec_desc" value="<?php echo Form::set_value('rec_desc', $rinfo['rec_desc']);?>" />
					<?php echo Form::get_error('rec_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">管理权用户组: </span>
					<?php foreach($role_select_list as $row): ?>
					<label><input type="checkbox" name="rec_roles[]" value="<?php echo $row['group_id']; ?>"<?php if(in_array($row['group_id'], $rinfo['rec_roles'])){echo ' checked="checked"';} ?> />&nbsp;<?php echo $row['group_name']; ?></label>
					<?php endforeach; ?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="保存">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重置">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>