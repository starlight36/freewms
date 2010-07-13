<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 自定义用户列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=page&amp;do=edit" title="<?php echo Lang::_('admin_page_add_title');?>"><?php echo Lang::_('admin_page_add_tip');?></a><br />
		<?php echo Lang::_('admin_page_desc_title');?></div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="10%"><?php echo Lang::_('admin_cpage_id_tip');?></td>
			<td class="titletd" width="15%"><?php echo Lang::_('admin_cpage_name_tip');?></td>
			<td class="titletd" width="30%"><?php echo Lang::_('admin_cpage_desc_tip');?></td>
            <td class="titletd"><?php echo Lang::_('admin_cpage_key_tip');?></td>
			<td class="titletd" width="20%"><?php echo Lang::_('admin_cpage_operate_tip');?></td>
		</tr>
		<?php if($plist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5"><?php echo Lang::_('admin_cpage_nofound_tip');?></td>
		</tr>
		<?php else: ?>
		<?php foreach ($plist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['page_id'] ?></td>
			<td class="listtd"><?php echo $row['page_name'] ?></td>
			<td class="listtd"><?php echo $row['page_desc'] ?></td>
            <td class="listtd"><?php echo $row['page_key'] ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=page&amp;do=edit&id=<?php echo $row['page_id'] ?>" title="<?php echo Lang::_('admin_page_edit_title');?>"><?php echo Lang::_('admin_page_edit_tip');?></a> |
				<a href="index.php?m=admin&amp;a=page&amp;do=del&id=<?php echo $row['page_id'] ?>" onclick="return confirm('<?php echo Lang::_('admin_page_delete_warn_tip');?>');" title="<?php echo Lang::_('admin_page_delete_title');?>"><?php echo Lang::_('admin_page_delete_tip');?></a>
			</td>
		</tr>
		<?php endforeach;
		endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>