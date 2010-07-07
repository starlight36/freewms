<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 分类列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=category&amp;do=edit" title="<?php echo Lang::_('admin_cate_tip');?>"><?php echo Lang::_('admin_cate_tip');?></a>
		<?php echo Lang::_('admin_custom_classification_tip');?>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=category&amp;do=order">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="70"><?php echo Lang::_('admin_cate_order_tip');?></td>
				<td class="titletd" width="20%"><?php echo Lang::_('admin_cate_name_tip');?></td>
				<td class="titletd"><?php echo Lang::_('admin_cate_description_tip');?></td>
				<td class="titletd" width="15%"><?php echo Lang::_('admin_correlation_model_tip');?></td>
				<td class="titletd" width=270"><?php echo Lang::_('admin_cate_operate_tip');?></td>
			</tr>
			<?php if($clist == NULL): ?>
			<tr>
				<td class="titletd" colspan="6"><?php echo Lang::_('admin_cate_no_found_tip');?></td>
			</tr>
			<?php else: ?>
			<!--{分类层次列表开始}-->
			<?php function _show_cate_list($list, $prefix = NULL){ ?>
			<?php foreach ($list as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="text" class="text ordertext" maxlength="3" value="<?php echo $row['cate_order']; ?>" name="order[<?php echo $row['cate_id']; ?>]"></td>
				<td class="listtd" style="text-align: left;"><?php echo $prefix.$row['cate_name']; ?></td>
				<td class="listtd"><?php echo $row['cate_desc']; ?></td>
				<td class="listtd"><?php echo $row['mod_name']; ?></td>
				<td class="listtd">
					<a href="index.php?m=admin&amp;a=category&amp;do=edit&amp;id=<?php echo $row['cate_id']; ?>" title="<?php echo Lang::_('admin_cate_modify_title');?>"><?php echo Lang::_('admin_cate_modify_tip');?></a> |
					<a href="index.php?m=admin&amp;a=category&amp;do=del&amp;id=<?php echo $row['cate_id']; ?>" title="" onclick="return confirm('<?php echo Lang::_('admin_empty_title');?>');"><?php echo Lang::_('admin_empty_tip');?></a> |
					<a href="#" title=""><?php echo Lang::_('admin_static_tip');?></a> |
					<a href="index.php?m=admin&amp;a=content&amp;cid=<?php echo $row['cate_id']; ?>" title=""><?php echo Lang::_('admin_management_content_tip');?></a> |
					<a href="index.php?m=admin&amp;a=category&amp;do=rm&amp;id=<?php echo $row['cate_id']; ?>" title="" onclick="return confirm('<?php echo Lang::_('admin_cate_delete_title');?>');"><?php echo Lang::_('admin_cate_delete_tip');?></a>
				</td>
			</tr>
			<?php
				$child_list = _get_child_category($row['cate_id']);
				_show_cate_list($child_list, $prefix.'|— ');
			?>
			<?php endforeach; ?>
			<?php }?>
			<?php _show_cate_list(_get_child_category(0)); ?>
			<!--{分类层次列表结束}-->
			<?php endif;?>
		</table>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_submit_order_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>