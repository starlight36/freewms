<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 字段列表页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=field&amp;modid=<?php echo $modid; ?>&amp;do=edit" title="<?php echo Lang::_('admin_add_new_field_title');?>"><?php echo Lang::_('admin_add_new_field_tip');?></a><br />
		<?php echo Lang::_('admin_field_desc');?>
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="10%"><?php echo Lang::_('admin_field_ID_tip');?></td>
			<td class="titletd" width="20%"><?php echo Lang::_('admin_field_name_tip');?></td>
			<td class="titletd"><?php echo Lang::_('admin_field_desc_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_default_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_operation_tip');?></td>
		</tr>
		<?php if($flist == NULL): ?>
		<tr>
			<td class="titletd" colspan="6"><?php echo Lang::_('admin_no_found_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($flist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['field_id']; ?></td>
			<td class="listtd"><?php echo $row['field_name']; ?></td>
			<td class="listtd"><?php echo $row['field_desc']; ?></td>
			<td class="listtd"><?php if($row['field_default'] == ''){echo '<span class="alert">NULL</span>';}else{echo $row['field_default'];} ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=field&amp;do=edit&amp;modid=<?php echo $modid; ?>&amp;id=<?php echo $row['field_id']; ?>" title="<?php echo Lang::_('admin_field_edit_title');?>"><?php echo Lang::_('admin_field_edit_tip');?></a> |
				<a href="index.php?m=admin&amp;a=field&amp;do=rm&amp;modid=<?php echo $modid; ?>&amp;id=<?php echo $row['field_id']; ?>" title="<?php echo Lang::_('admin_field_del_title');?>" onclick="return confirm('<?php echo Lang::_('admin_field_del_warning');?>');"><?php echo Lang::_('admin_field_del_tip');?></a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>