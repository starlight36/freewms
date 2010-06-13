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
		<a href="index.php?m=admin&amp;a=category&amp;do=edit" title="添加新分类">添加新分类</a>
		自定义分类说明
	</div>
	<form method="post" action="index.php?m=admin&amp;a=category&amp;do=order">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="70">排序</td>
				<td class="titletd" width="20%">分类名称</td>
				<td class="titletd">分类说明</td>
				<td class="titletd" width="15%">关联模型</td>
				<td class="titletd" width=270">操作</td>
			</tr>
			<?php if($clist == NULL): ?>
			<tr>
				<td class="titletd" colspan="6">没找到任何分类.</td>
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
					<a href="index.php?m=admin&amp;a=category&amp;do=edit&amp;id=<?php echo $row['cate_id']; ?>" title="修改">修改</a> |
					<a href="index.php?m=admin&amp;a=category&amp;do=del&amp;id=<?php echo $row['cate_id']; ?>" title="" onclick="return confirm('你确认要清空此分类下的所有内容吗?\n一旦进行则无法恢复!');">清空内容</a> |
					<a href="#" title="">生成静态</a> |
					<a href="index.php?m=admin&amp;a=content&amp;cid=<?php echo $row['cate_id']; ?>" title="">管理内容</a> |
					<a href="index.php?m=admin&amp;a=category&amp;do=rm&amp;id=<?php echo $row['cate_id']; ?>" title="" onclick="return confirm('你确认要删除此分类吗?\n一旦进行则无法恢复!');">删除</a>
				</td>
			</tr>
			<?php
				$child_list = _get_child_category($row['cate_id']);
				_show_cate_list($child_list, $prefix.'…');
			?>
			<?php endforeach; ?>
			<?php }?>
			<?php _show_cate_list(_get_child_category(0)); ?>
			<!--{分类层次列表结束}-->
			<?php endif;?>
		</table>
		<div>
			<input type="submit" class="actionbtn pointer" value="保存排序">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>