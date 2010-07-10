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
		<?php echo Lang::_('admin_rec_desc_1_tip');?>
	</div>
	<form action="index.php?m=admin&amp;a=recommend&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_rec_id_tip');?>: </span>
					<span class="green bold"><?php if(!$id) {echo  Lang::_('admin_rec_add_tip');}else{ echo $id;} ?></span>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_rec_name_tip');?>: </span>
					<input type="text" class="text shorttext" name="rec_name" value="<?php echo Form::set_value('rec_name', $rinfo['rec_name']);?>" />
					<?php echo Form::get_error('rec_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_rec_key_tip');?>: </span>
					<input type="text" class="text shorttext" name="rec_key" value="<?php echo Form::set_value('rec_key', $rinfo['rec_key']);?>" />
					<?php echo Form::get_error('rec_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_rec_desc_tip');?>: </span>
					<input type="text" class="text shorttext" name="rec_desc" value="<?php echo Form::set_value('rec_desc', $rinfo['rec_desc']);?>" />
					<?php echo Form::get_error('rec_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_rec_rec_roles_tip');?>: </span>
					<?php foreach($role_select_list as $row): ?>
					<label><input type="checkbox" name="rec_roles[]" value="<?php echo $row['group_id']; ?>"<?php if(in_array($row['group_id'], $rinfo['rec_roles'])){echo ' checked="checked"';} ?> />&nbsp;<?php echo $row['group_name']; ?></label>
					<?php endforeach; ?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_rec_return_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_rec_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>