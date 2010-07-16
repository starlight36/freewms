<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 部件列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=widget&amp;do=edit" title="<?php echo Lang::_('admin_widget_add_new_title');?>"><?php echo Lang::_('admin_widget_add_new_tip');?></a>
		<?php echo Lang::_('admin_widget_model_tip');?>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=widget&amp;do=rm" onsubmit="return confirm('<?php echo Lang::_('admin_widget_confirm_tip');?>?');">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="10%"><?php echo Lang::_('admin_widget_select_tip');?></td>
				<td class="titletd" width="20%"><?php echo Lang::_('admin_widget_name_tip');?></td>
				<td class="titletd" ><?php echo Lang::_('admin_widget_desc_tip');?></td>
				<td class="titletd" width="15%"><?php echo Lang::_('admin_widget_key_tip');?></td>
				<td class="titletd" width="15%"><?php echo Lang::_('admin_widget_operate_tip');?></td>
			</tr>
			<?php if($wlist == NULL): ?>
			<tr>
				<td class="titletd" colspan="5"><?php echo Lang::_('admin_widget_no_found_tip');?></td>
			</tr>
			<?php else: ?>
			<?php foreach ($wlist as $id => $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $id + 1;?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['name'] ?></td>
				<td class="listtd"><?php echo $row['desc'] ?></td>
				<td class="listtd"><?php echo $row['key'] ?></td>
				<td class="listtd">
					<a href="index.php?m=admin&amp;a=widget&amp;do=edit&amp;id=<?php echo $id + 1; ?>" title="<?php echo Lang::_('admin_widget_edit_title');?>"><?php echo Lang::_('admin_widget_edit_tip');?></a> |
					<a href="index.php?m=admin&amp;a=widget&amp;do=rm&amp;id=<?php echo $id + 1; ?>" title="<?php echo Lang::_('admin_widget_delete_title');?>"><?php echo Lang::_('admin_widget_delete_tip');?></a>
				</td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td class="actiontd" colspan="5">
					<span class="space6">
						<a class="sa" title="<?php echo Lang::_('admin_widget_selectall_title');?>" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_widget_selectall_tip');?></a> /
						<a class="sa" title="<?php echo Lang::_('admin_widget_noselect_title');?>" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_widget_noselect_tip');?></a>
					</span>
					<input type="submit" value="<?php echo Lang::_('admin_widget_delete_query_tip');?>" class="batchbtn pointer" />
				</td>
			</tr>
			<?php endif;?>
		</table>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>