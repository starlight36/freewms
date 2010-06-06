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
		<a href="index.php?m=admin&amp;a=module&amp;do=edit" title="添加新模型">添加新模型</a><br />
		系统模型简介
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="7%">模型ID</td>
			<td class="titletd" width="18%">模型名称</td>
			<td class="titletd">模型说明</td>
			<td class="titletd" width="18%">模型类型</td>
			<td class="titletd" width="24%">操作</td>
		</tr>
		<?php if($mlist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5">没找到任何模型, 请检查数据库是否被破坏.</td>
		</tr>
		<?php else: ?>
		<?php foreach ($mlist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['mod_id']; ?></td>
			<td class="listtd"><?php echo $row['mod_name']; ?></td>
			<td class="listtd"><?php echo $row['mod_desc']; ?></td>
			<td class="listtd">
				<?php if($row['mod_is_system']): ?>
				<span class="alert">[系统模型]</span>
				<?php else: ?>
				<span class="green">[用户模型]</span>
				<?php endif; ?>
			</td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=module&amp;do=edit&amp;id=<?php echo $row['mod_id']; ?>" title="修改模型">修改模型</a> |
				<a href="index.php?m=admin&amp;a=field&amp;modid=<?php echo $row['mod_id']; ?>" title="编辑字段">管理字段</a> |
				<a href="<?php if($row['mod_is_system']){echo 'javascript:alert(\'您不能删除一个系统模型\');';}else{echo 'index.php?m=admin&amp;a=module&amp;do=rm&amp;id='.$row['mod_id'];} ?>" onclick="return confirm('你确定要删除这个模型吗? \n一旦执行无法撤销.');" title="删除模型">删除模型</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>