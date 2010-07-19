<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 友情链接列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<p><a href="index.php?m=admin&amp;a=link&amp;do=edit"><?php echo Lang::_('admin_link_new_tip');?></a></p>
		<?php echo Lang::_('admin_link_desc_1_tip');?>：
  </div>
	<form method="post" action="index.php?m=admin&amp;a=link">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40px">操作</td>
				<td class="titletd" width="15%"><?php echo Lang::_('admin_link_title_tip');?></td>
				<td class="titletd"><?php echo Lang::_('admin_link_desc_tip');?></td>
                <td class="titletd" width="80px"><?php echo Lang::_('admin_link_img_tip');?></td>
                <td class="titletd" width="15%"><?php echo Lang::_('admin_link_isdisplay_tip');?></td>
				<td class="titletd" width="120px"><?php echo Lang::_('admin_link_operate_tip');?>
  </tr>
			<?php if($linklist == NULL): ?>
			<tr>
				<td class="titletd" colspan="6"><?php echo Lang::_('admin_link_no_tip');?></td>
			</tr>
			<?php else: ?>
			<!--{链接层次列表开始}-->
    <?php foreach ($linklist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['link_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><a href="<?php echo $row['link_url']; ?>" target="_blank" ><?php echo $row['link_title']; ?></a></td>
				<td class="listtd"><?php echo $row['link_desc']; ?></td>
				<td class="listtd">
					<?php if($row['link_img']):?><img alt="<?php echo Lang::_('admin_link_fault_tip');?>" src="<?php echo $row['link_img']; ?>" width="80px" /></td>
					<?php else:?><?php echo Lang::_('admin_link_no_img_tip');?>
					<?php endif ?>
                <td class="listtd"><?php
					if($row['link_isdisplay'] == 0)  echo Lang::_('admin_link_display_no_tip');
					if($row['link_isdisplay'] == 1)  echo Lang::_('admin_link_display_tip');
				?></td>
				<td class="listtd">
				    <a href="index.php?m=admin&amp;a=link&amp;do=edit&amp;id=<?php echo $row['link_id']; ?>" title=""><?php echo Lang::_('admin_link_edit_tip');?></a> |
           			<a href="index.php?m=admin&amp;a=link&amp;do=rm&amp;id=<?php echo $row['link_id']; ?>" onclick="return confirm('<?php echo Lang::_('admin_link_delete_confirm_tip');?>')" title="<?php echo Lang::_('admin_link_delete_title');?>" ><?php echo Lang::_('admin_link_delete_tip');?></a>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif;?>
<tr>
				<td class="actiontd" colspan="7">
					<span class="space6">
						<a class="sa" title="<?php echo Lang::_('admin_link_selectall_title');?>" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_link_selectall_tip');?></a> /
						<a class="sa" title="<?php echo Lang::_('admin_link_cancel_title');?>" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_link_cancel_tip');?></a>
					</span>
					<span class="space3 blue bold"><?php echo Lang::_('admin_link_selected_tip');?>：</span>
					<select name="do">
	        			<option value="dly"><?php echo Lang::_('admin_link_dly_tip');?></option>
                        <option value="undly"><?php echo Lang::_('admin_link_undly_tip');?></option>
						<option value="rm"><?php echo Lang::_('admin_link_rm_tip');?></option>
					</select>
				  <input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_link_run_tip');?>">
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