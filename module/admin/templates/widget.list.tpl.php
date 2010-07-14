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
		<a href="index.php?m=admin&amp;a=widget&amp;do=edit" title="添加新部件">添加新部件</a>
		部件列表页模板
	</div>
	<form method="post" action="index.php?m=admin&amp;a=widget&amp;do=rm" onsubmit="return confirm('确认删除选中的部件?');">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="10%">选择</td>
				<td class="titletd" width="20%">部件名称</td>
				<td class="titletd" >部件简介</td>
				<td class="titletd" width="15%">部件标识</td>
				<td class="titletd" width="15%">操作</td>
			</tr>
			<?php if($wlist == NULL): ?>
			<tr>
				<td class="titletd" colspan="5">没有找到任何部件</td>
			</tr>
			<?php else: ?>
			<?php foreach ($wlist as $id => $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $id + 1;?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['name'] ?></td>
				<td class="listtd"><?php echo $row['desc'] ?></td>
				<td class="listtd"><?php echo $row['key'] ?></td>
				<td class="listtd">
					<a href="index.php?m=admin&amp;a=widget&amp;do=edit&amp;id=<?php echo $id + 1; ?>" title="编辑部件">编辑</a> |
					<a href="index.php?m=admin&amp;a=widget&amp;do=rm&amp;id=<?php echo $id + 1; ?>" title="删除部件">删除</a>
				</td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td class="actiontd" colspan="5">
					<span class="space6">
						<a class="sa" title="全选" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)">全选</a> /
						<a class="sa" title="不选" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)">不选</a>
					</span>
					<input type="submit" value="批量删除" class="batchbtn pointer" />
				</td>
			</tr>
			<?php endif;?>
		</table>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>