<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 推荐位列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=recommend&amp;do=edit" title="添加新推荐位">添加新推荐位</a><br />
		推荐位列表说明
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="12%">推荐位ID</td>
			<td class="titletd" width="15%">推荐位标识</td>
			<td class="titletd" width="20%">推荐位名称</td>
			<td class="titletd">推荐位简介</td>
			<td class="titletd" width="20%">操作</td>
		</tr>
		<?php if($rlist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5">没有找到任何推荐位</td>
		</tr>
		<?php else: ?>
		<?php foreach ($rlist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['rec_id'] ?></td>
			<td class="listtd"><?php echo $row['rec_key'] ?></td>
			<td class="listtd"><?php echo $row['rec_name'] ?></td>
			<td class="listtd"><?php echo $row['rec_desc'] ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=recommend&amp;do=edit&amp;id=<?php echo $row['rec_id'] ?>" title="编辑">编辑</a> |
				<a href="index.php?m=admin&amp;a=recommend&amp;do=del&amp;id=<?php echo $row['rec_id'] ?>" onclick="return confirm('确认删除此推荐位吗?\n一旦删除不可恢复.')" title="删除">删除</a>
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
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>