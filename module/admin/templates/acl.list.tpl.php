<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 权限管理页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=acl&amp;do=edit" title="<?php echo Lang::_('admin_acl_new_title');?>"><?php echo Lang::_('admin_acl_new_tip');?></a><br />
		<?php echo Lang::_('admin_acl_right_management_tip');?>
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="100px"><?php echo Lang::_('admin_acl_id_tip');?></td>
			<td class="titletd" width="20%"><?php echo Lang::_('admin_acl_name_tip');?></td>
			<td class="titletd"><?php echo Lang::_('admin_acl_desc_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_acl_key_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_acl_type_tip');?></td>
			<td class="titletd" width="120px"><?php echo Lang::_('admin_acl_operate_tip');?></td>
		</tr>
		<?php if($list == NULL): ?>
		<tr>
			<td class="titletd" colspan="6"><?php echo Lang::_('admin_acl_no_found_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($list as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['acl_id'] ?></td>
			<td class="listtd"><?php echo $row['acl_name'] ?></td>
			<td class="listtd"><?php echo $row['acl_desc'] ?></td>
			<td class="listtd"><?php echo $row['acl_key'] ?></td>
			<td class="listtd"><?php if($row['acl_type'] == '0') {echo '<span class="green bold">'.Lang::_('admin_acl_right_0_tip').'</span>';}else{echo '<span class="alert bold">'.Lang::_('admin_acl_right_1_tip').'</span>';}  ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=acl&amp;do=edit&amp;id=<?php echo $row['acl_id'] ?>" title="<?php echo Lang::_('admin_acl_edit_title');?>"><?php echo Lang::_('admin_acl_edit_tip');?></a> |
				<a href="index.php?m=admin&amp;a=acl&amp;do=del&amp;id=<?php echo $row['acl_id'] ?>" onclick="return confirm('<?php echo Lang::_('admin_acl_delete_warn_tip');?>')" title="<?php echo Lang::_('admin_acl_delete_title');?>"><?php echo Lang::_('admin_acl_delete_tip');?></a>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td class="pagetd" colspan="6">
				<div id="paginate"><?php echo Paginate::get_paginate('firstpage', 'currentpage') ?></div>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>