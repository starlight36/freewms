<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 留言列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php if(!isset($_GET['state'])):?><p><?php echo Lang::_('admin_gb_manage_tip');?></p>
		<?php else: $gb_state = $_GET['state'];?><p><?php echo Lang::_('admin_gb_audit_tip');?></p><?php endif?>
		<?php echo Lang::_('admin_gb_desc_tip');?>：
	</div>
	<form method="post" action="index.php?m=admin&amp;a=guestbook">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40px"><?php echo Lang::_('admin_gb_operate_tip');?></td>
				<td class="titletd" width="110px"><?php echo Lang::_('admin_gb_username_tip');?></td>
				<td class="titletd" width="90px"><?php echo Lang::_('admin_gb_ip_tip');?></td>
                <td class="titletd"><?php echo Lang::_('admin_gb_content_tip');?></td>
				<td class="titletd" width="120px"><?php echo Lang::_('admin_gb_time_tip');?></td>
                <td class="titletd" width="10%"><?php echo Lang::_('admin_gb_state_tip');?></td>
				<td class="titletd" width="10%"><?php echo Lang::_('admin_gb_operate_tip');?>
			</tr>
			<?php if($gblist == NULL): ?>
			<tr>
				<td class="titletd" colspan="7"><?php echo Lang::_('admin_gb_no_tip');?></td>
			</tr>
			<?php else: ?>
			<!--{分类层次列表开始}-->
    <?php foreach ($gblist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['gb_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['gb_username']; ?></td>
				<td class="listtd"><?php echo $row['gb_ip']; ?></td>
				<td class="listtd"><?php echo $row['gb_content']; ?></td>
                <td class="listtd"><?php echo date("Y-m-d H:i", $row['gb_time']); ?></td>
                <td class="listtd"><?php
					if($row['gb_state'] == 0)  echo Lang::_('admin_gb_state_0_tip');
					if($row['gb_state'] == 1)  echo Lang::_('admin_gb_state_1_tip');
					if($row['gb_state'] == 2)  echo Lang::_('admin_gb_state_2_tip');
					if($row['gb_replystate'] == 1) echo Lang::_('admin_gb_state_3_tip');
					else echo "<font color='#FF0000'>".Lang::_('admin_gb_state_4_tip')."</font>";
				?></td>
				<td class="listtd">
                	<a href="index.php?m=admin&amp;a=guestbook&amp;do=edit&id=<?php echo $row['gb_id']; ?>" title="<?php echo Lang::_('admin_gb_id_0_title');?>" ><?php echo Lang::_('admin_gb_id_0_tip');?></a> |
					<?php if($row['gb_state'] == 1):?><a href="index.php?m=admin&amp;a=guestbook&amp;do=normal&amp;id=<?php echo $row['gb_id']; ?>" title="<?php echo Lang::_('admin_gb_id_1_title');?>"><?php echo Lang::_('admin_gb_id_1_tip');?></a> | <?php endif?>
                    <?php if($row['gb_state'] == 0):?><a href="index.php?m=admin&amp;a=guestbook&amp;do=lock&amp;id=<?php echo $row['gb_id']; ?>" title="<?php echo Lang::_('admin_gb_id_2_title');?>"><?php echo Lang::_('admin_gb_id_2_tip');?></a> | <?php endif?>
					<?php if($row['gb_state'] == 2):?><a href="index.php?m=admin&amp;a=guestbook&amp;do=normal&amp;id=<?php echo $row['gb_id']; ?>" title="<?php echo Lang::_('admin_gb_id_3_title');?>"><?php echo Lang::_('admin_gb_id_3_tip');?></a> | <?php endif?>
           			<a href="index.php?m=admin&amp;a=guestbook&amp;do=rm&amp;id=<?php echo $row['gb_id']; ?>" onclick="return confirm('<?php echo Lang::_('admin_gb_id_warn_tip');?>')" title="<?php echo Lang::_('admin_gb_id_4_tip');?>" ><?php echo Lang::_('admin_gb_id_4_tip');?></a>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif;?>
<tr>
				<td class="actiontd" colspan="7">
					<span class="space6">
						<a class="sa" title="<?php echo Lang::_('admin_gb_all_title');?>" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_gb_all_tip');?></a> /
						<a class="sa" title="<?php echo Lang::_('admin_gb_cancle_title');?>" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_gb_cancel_tip');?></a>
					</span>
					<span class="space3 blue bold"><?php echo Lang::_('admin_gb_slected_tip');?>：</span>
					<select name="do">
	        			<option value="normal"><?php echo Lang::_('admin_gb_normal_tip');?></option>
						<?php if(!isset($_GET['state'])):?><option value="lock"><?php echo Lang::_('admin_gb_lock_tip');?></option><?php endif?>
						<option value="rm"><?php echo Lang::_('admin_gb_delete_tip');?></option>
					</select>
				  <input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_gb_run_tip');?>">
				</td>
			</tr>
			<tr>
				<td class="pagetd" colspan="7">
					<div id="paginate"><?php echo Paginate::get_paginate('firstpage', 'currentpage') ?></div>
				</td>
			</tr>
		</table>
    </form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>