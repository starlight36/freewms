<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 专题列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=subject&amp;do=edit" title="<?php echo Lang::_('admin_subject_new_title');?>"><?php echo Lang::_('admin_subject_new_tip');?></a><br />
		<?php echo Lang::_('admin_subject_desc_title');?>
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="12%"><?php echo Lang::_('admin_subject_id_tip');?></td>
			<td class="titletd" width="25%"><?php echo Lang::_('admin_subject_title_tip');?></td>
			<td class="titletd"><?php echo Lang::_('admin_subject_desc_tip');?></td>
			<td class="titletd" width="20%"><?php echo Lang::_('admin_subject_operate_tip');?></td>
		</tr>
		<?php if($slist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5"><?php echo Lang::_('admin_subject_no_found_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($slist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['subject_id'] ?></td>
			<td class="listtd"><?php echo $row['subject_title'] ?></td>
			<td class="listtd"><?php echo $row['subject_desc'] ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=subject&amp;do=edit&amp;id=<?php echo $row['subject_id'] ?>" title="<?php echo Lang::_('admin_subject_edit_title');?>"><?php echo Lang::_('admin_subject_edit_tip');?></a> |
				<a href="index.php?m=admin&amp;a=content&amp;sid=<?php echo $row['subject_id'] ?>" title="<?php echo Lang::_('admin_subject_edit_title');?>"><?php echo Lang::_('admin_subject_list_tip');?></a> |
				<a href="index.php?m=admin&amp;a=subject&amp;do=del&amp;id=<?php echo $row['subject_id'] ?>" onclick="return confirm('<?php echo Lang::_('admin_subject_delete_warn_tip');?>')" title="<?php echo Lang::_('admin_subject_delete_title');?>"><?php echo Lang::_('admin_subject_delete_tip');?></a>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td class="pagetd" colspan="4">
				<div id="paginate"><?php echo Paginate::get_paginate('firstpage', 'currentpage') ?></div>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>