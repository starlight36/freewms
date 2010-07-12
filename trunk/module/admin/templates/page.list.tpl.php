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
		<a href="index.php?m=admin&amp;a=page&amp;do=edit" title="添加新自定义">添加新自定义页</a><br />
		说明</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="10%">自定义页ID</td>
			<td class="titletd" width="15%">自定义页名</td>
			<td class="titletd">自定义页描述</td>
            <td class="titletd">自定义页关键</td>
			<td class="titletd" width="20%">操作</td>
		</tr>
		<?php if($plist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5">没有任何自定义页</td>
		</tr>
		<?php else: ?>
		<?php foreach ($plist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['page_id'] ?></td>
			<td class="listtd"><?php echo $row['page_name'] ?></td>
			<td class="listtd"><?php echo $row['page_desc'] ?></td>
            <td class="listtd"><?php echo $row['page_key'] ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=page&amp;do=edit&id=<?php echo $row['page_id'] ?>" title="修改">修改</a> |
				<a href="index.php?m=admin&amp;a=page&amp;do=del&id=<?php echo $row['page_id'] ?>" onclick="return confirm('确定要删除吗?');" title="删除">删除</a>
			</td>
		</tr>
		<?php endforeach;
		endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>