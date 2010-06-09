<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 模型列表页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=module&amp;do=edit" title="<?php echo Lang::_('admin_add_new_mod_title');?>"><?php echo Lang::_('admin_add_new_mod_tip');?></a><br />
		<?php echo Lang::_('admin_sys_mod_desc_tip');?>
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="7%"><?php echo Lang::_('admin_mod_ID_tip');?></td>
			<td class="titletd" width="18%"><?php echo Lang::_('admin_mod_name_tip');?></td>
			<td class="titletd"><?php echo Lang::_('admin_mod_desc_tip');?></td>
			<td class="titletd" width="18%"><?php echo Lang::_('admin_mod_type_tip');?></td>
			<td class="titletd" width="24%"><?php echo Lang::_('admin_operate_tip');?></td>
		</tr>
		<?php if($mlist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5"><?php echo Lang::_('admin_mod_warn_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($mlist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['mod_id']; ?></td>
			<td class="listtd"><?php echo $row['mod_name']; ?></td>
			<td class="listtd"><?php echo $row['mod_desc']; ?></td>
			<td class="listtd">
				<?php if($row['mod_is_system']): ?>
				<span class="alert"><?php echo Lang::_('admin_sys_mod_tip');?></span>
				<?php else: ?>
				<span class="green"><?php echo Lang::_('admin_user_mod_tip');?></span>
				<?php endif; ?>
			</td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=module&amp;do=edit&amp;id=<?php echo $row['mod_id']; ?>" title="<?php echo Lang::_('admin_mod_edit_title');?>"><?php echo Lang::_('admin_mod_edit_tip');?></a> |
				<a href="index.php?m=admin&amp;a=field&amp;modid=<?php echo $row['mod_id']; ?>" title="<?php echo Lang::_('admin_feild_edit_title');?>"><?php echo Lang::_('admin_mang_field_tip');?></a> |
				<a href="<?php if($row['mod_is_system']){echo 'javascript:alert(\''.Lang::_('admin_no_mod_del_tip').'\');';}else{echo 'index.php?m=admin&amp;a=module&amp;do=rm&amp;id='.$row['mod_id'];} ?>" onclick="return confirm('<?php echo Lang::_('admin_mod_del_warn_tip');?>');" title="<?php echo Lang::_('admin_mod_del_title');?>"><?php echo Lang::_('admin_mod_del_tip');?></a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>