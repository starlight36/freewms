<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 主题列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_theme_manage_tip');?>
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
            <td class="titletd" width="18%"><?php echo Lang::_('admin_theme_name_tip');?></td>
			<td class="titletd"><?php echo Lang::_('admin_theme_desc_tip');?></td>
			<td class="titletd" width="10%"><?php echo Lang::_('admin_theme_version_tip');?></td>
			<td class="titletd" width="10%"><?php echo Lang::_('admin_theme_update_tip');?></td>
			<td class="titletd" width="10%"><?php echo Lang::_('admin_theme_right_tip');?></td>
			<td class="titletd" width="10%"><?php echo Lang::_('admin_theme_licence_tip');?></td>
			<td class="titletd" width="12%"><?php echo Lang::_('admin_theme_operate_tip');?></td>
		</tr>
		<?php if($theme_list == NULL): ?>
		<tr>
			<td class="titletd" colspan="7"><?php echo Lang::_('admin_theme_no_model_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($theme_list as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['name'];?></td>
			<td class="listtd"><?php echo $row['desc'] ?></td>
			<td class="listtd"><?php echo $row['version'] ?></td>
            <td class="listtd"><?php echo $row['update'] ?></td>
			<td class="listtd"><a href="<?php echo $row['link'] ?>" title="<?php echo Lang::_('admin_theme_index_tip');?>" target="_blank"><?php echo $row['copyright'] ?></a></td>
			<td class="listtd"><?php echo $row['licence'] ?></td>
			<td class="listtd">
				<?php if($row['path'] == Config::get('site_theme')): ?>
				<span class="alert bold"><?php echo Lang::_('admin_theme_current_tip');?></span>
				<?php else: ?>
				<a href="index.php?m=admin&amp;a=theme&amp;do=use&amp;path=<?php echo $row['path'] ?>" title="<?php echo Lang::_('admin_theme_use_title');?>"><?php echo Lang::_('admin_theme_use_tip');?></a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif;?>
  </table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>