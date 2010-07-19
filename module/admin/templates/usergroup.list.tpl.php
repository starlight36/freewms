<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 上传文件列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=usergroup&amp;do=edit&id=0" title="<?php echo Lang::_('admin_group_new_title');?>"><?php echo Lang::_('admin_group_new_tip');?></a>
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="12%"><?php echo Lang::_('admin_group_id_tip');?></td>
			<td class="titletd"><?php echo Lang::_('admin_group_name_tip');?></td>
			<td class="titletd" width="18%"><?php echo Lang::_('admin_group_type_tip');?></td>
			<td class="titletd" width="18%"><?php echo Lang::_('admin_group_attribute_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_group_operate_tip');?></td>
		</tr>
		<?php if($list == NULL): ?>
		<tr>
			<td class="titletd" colspan="5"><?php echo Lang::_('admin_group_no_found_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($list as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['group_id']; ?></td>
			<td class="listtd"><?php echo $row['group_name']; ?></td>
			<td class="listtd"><?php if($row['group_isadmin'] == '1') {echo '<span class="alert bold">'.Lang::_('admin_group_0_tip').'</span>';}else{echo '<span class="green bold">'.Lang::_('admin_group_1_tip').'</span>';} ?></td>
			<td class="listtd"><?php if($row['group_issys'] == '1') {echo '<span class="alert bold">'.Lang::_('admin_group_2_tip').'</span>';}else{echo '<span class="green bold">'.Lang::_('admin_group_3_tip').'</span>';} ?></td>
			<td class="listtd">

				<a href="index.php?m=admin&amp;a=usergroup&amp;do=edit&id=<?php echo $row['group_id'] ?>" title="<?php echo Lang::_('admin_group_edit_title');?>"><?php echo Lang::_('admin_group_edit_tip');?></a> |
				<a href="index.php?m=admin&amp;a=acl&amp;do=auth_group&amp;id=<?php echo $row['group_id'] ?>" title="<?php echo Lang::_('admin_group_edit_permission_tip');?>"><?php echo Lang::_('admin_group_permission_tip');?></a> |
				<a href="index.php?m=admin&amp;a=usergroup&amp;do=rm&amp;id=<?php echo $row['group_id'] ?>" onclick="return confirm('<?php echo Lang::_('admin_group_delete_warn_tip');?>')" title="<?php echo Lang::_('admin_group_delete_title');?>"><?php echo Lang::_('admin_group_delete_tip');?></a>

			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>