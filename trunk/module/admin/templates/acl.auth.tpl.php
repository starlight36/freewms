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
		<?php echo Lang::_('admin_acl_group_edit_tip');?>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=acl&amp;do=<?php echo $_REQUEST['do']; ?>&amp;id=<?php echo $id; ?>">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_acl_group_tip');?>: </span>
					<span class="green bold"><?php echo $uname; ?></span>
				</p>
				<?php foreach($list as $row): ?>
				<p><span class="left <?php echo ($row['acl_type'] == '1') ? 'alert' : 'green'; ?>"><?php echo $row['acl_name'] ?>: </span>
					<label><input type="radio" name="acl_type[<?php echo $row['acl_id'] ?>]" value=""<?php if(is_null($row['acl_state'])){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_acl_id_0_tip');?></label>
					<label><input type="radio" name="acl_type[<?php echo $row['acl_id'] ?>]" value="0"<?php if($row['acl_state'] == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_acl_id_1_tip');?></label>
					<label><input type="radio" name="acl_type[<?php echo $row['acl_id'] ?>]" value="1"<?php if($row['acl_state'] == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_acl_id_2_tip');?></label>&nbsp;&nbsp;
					<span class="bold"><?php echo Lang::_('admin_acl_value_tip');?>: </span><input type="text" class="text shorttext" name="acl_value[<?php echo $row['acl_id'] ?>]" value="<?php echo htmlspecialchars($row['acl_value']); ?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo htmlspecialchars($row['acl_desc']); ?>">[?]</a>
				</p>
				<?php endforeach; ?>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_acl_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_acl_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>