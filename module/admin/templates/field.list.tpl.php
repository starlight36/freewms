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
		<a href="index.php?m=admin&amp;a=field&amp;modid=<?php echo $modid; ?>&amp;do=edit" title="添加新字段">添加新字段</a><br />
		自定义字段说明
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="10%">字段ID</td>
			<td class="titletd" width="20%">字段名称</td>
			<td class="titletd">字段说明</td>
			<td class="titletd" width="15%">默认值</td>
			<td class="titletd" width="15%">操作</td>
		</tr>
		<?php if($flist == NULL): ?>
		<tr>
			<td class="titletd" colspan="6">没找到任何自定义字段.</td>
		</tr>
		<?php else: ?>
		<?php foreach ($flist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['field_id']; ?></td>
			<td class="listtd"><?php echo $row['field_name']; ?></td>
			<td class="listtd"><?php echo $row['field_desc']; ?></td>
			<td class="listtd"><?php if($row['field_default'] == ''){echo '<span class="alert">NULL</span>';}else{echo $row['field_default'];} ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=field&amp;do=edit&amp;modid=<?php echo $modid; ?>&amp;id=<?php echo $row['field_id']; ?>" title="修改字段">修改</a> |
				<a href="index.php?m=admin&amp;a=field&amp;do=rm&amp;modid=<?php echo $modid; ?>&amp;id=<?php echo $row['field_id']; ?>" title="删除字段" onclick="return confirm('你确定要删除此字段吗?\n删除此字段会同时删除字段的所有值,\n一旦进行则无法回复.');">删除</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>