<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 推荐位列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=recommend&amp;do=edit" title="<?php echo Lang::_('admin_rec_new_title');?>"><?php echo Lang::_('admin_rec_new_tip');?></a><br />
		<?php echo Lang::_('admin_rec_desc_title');?>
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="12%"><?php echo Lang::_('admin_rec_id_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_rec_key_tip');?></td>
			<td class="titletd" width="20%"><?php echo Lang::_('admin_rec_name_tip');?></td>
			<td class="titletd"><?php echo Lang::_('admin_rec_desc_tip');?></td>
			<td class="titletd" width="20%"><?php echo Lang::_('admin_rec_operate_tip');?></td>
		</tr>
		<?php if($rlist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5"><?php echo Lang::_('admin_rec_no_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($rlist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['rec_id'] ?></td>
			<td class="listtd"><?php echo $row['rec_key'] ?></td>
			<td class="listtd"><?php echo $row['rec_name'] ?></td>
			<td class="listtd"><?php echo $row['rec_desc'] ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=recommend&amp;do=edit&amp;id=<?php echo $row['rec_id'] ?>" title="<?php echo Lang::_('admin_rec_edit_title');?>"><?php echo Lang::_('admin_rec_edit_tip');?></a> |
				<a href="index.php?m=admin&amp;a=content&amp;rid=<?php echo $row['rec_id'] ?>" title="<?php echo Lang::_('admin_rec_edit_title');?>"><?php echo Lang::_('admin_rec_list_tip');?></a> |
				<a href="index.php?m=admin&amp;a=recommend&amp;do=del&amp;id=<?php echo $row['rec_id'] ?>" onclick="return confirm('<?php echo Lang::_('admin_rec_delete_worn_tip');?>')" title="<?php echo Lang::_('admin_rec_delete_title');?>"><?php echo Lang::_('admin_rec_delete_tip');?></a>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td class="pagetd" colspan="5">
				<div id="paginate"><?php echo Paginate::get_paginate('firstpage', 'currentpage') ?></div>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>