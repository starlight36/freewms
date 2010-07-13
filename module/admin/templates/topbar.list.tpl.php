<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 导航条列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=topbar&amp;do=edit" title="<?php echo Lang::_('admin_topbar_new_title');?>"><?php echo Lang::_('admin_topbar_new_tip');?></a><br />
		<?php echo Lang::_('admin_topbar_desc_title');?>：
	</div>
<form method="post" action="index.php?m=admin&amp;a=topbar&amp;do=order">
  <table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
            <td class="titletd" width="6%"><?php echo Lang::_('admin_topbar_order_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_topbar_name_tip');?></td>
			<td class="titletd"><?php echo Lang::_('admin_topbar_desc_tip');?></td>
			<td class="titletd" width="20%"><?php echo Lang::_('admin_topbar_target_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_topbar_operate_tip');?></td>
		</tr>
		<?php if($tlist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5"><?php echo Lang::_('admin_topbar_no_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($tlist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
        <td class="listtd"><input type="text" class="text ordertext" maxlength="3" value="<?php echo $row['topbar_order']; ?>" name="order[<?php echo $row['topbar_id']; ?>]"></td>
			<td class="listtd"><?php echo $row['topbar_name'] ?></td>
			<td class="listtd"><?php echo $row['topbar_desc'] ?></td>
            <td class="listtd"><?php
			if($row['topbar_target']=='_self'){	echo Lang::_('admin_topbar_local_tip');}
			if($row['topbar_target']=='_blank'){	echo Lang::_('admin_topbar_add_tip');}
			if($row['topbar_target']=='_parent'){	echo Lang::_('admin_topbar_parent_tip');}
			?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=topbar&amp;do=edit&amp;id=<?php echo $row['topbar_id'] ?>" title="<?php echo Lang::_('admin_topbar_edit_title');?>"><?php echo Lang::_('admin_topbar_edit_tip');?></a> |
				<a href="index.php?m=admin&amp;a=topbar&amp;do=del&amp;id=<?php echo $row['topbar_id'] ?>" onclick="return confirm('<?php echo Lang::_('admin_topbar_delete_warn_tip');?>?');" title="<?php echo Lang::_('admin_topbar_delete_title');?>"><?php echo Lang::_('admin_topbar_delete_tip');?></a>
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
  <div>
     <input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_topbar_order_save_tip');?>" />
  </div>
</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>