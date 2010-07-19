<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 上传文件列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=usergroup&amp;do=edit&id=0" title="添加用户组">添加用户组</a>
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="12%">用户组ID</td>
			<td class="titletd">用户组名称</td>
			<td class="titletd" width="18%">用户组类型</td>
			<td class="titletd" width="18%">用户组属性</td>
			<td class="titletd" width="15%">操作</td>
		</tr>
		<?php if($list == NULL): ?>
		<tr>
			<td class="titletd" colspan="5">没有找到任何用户组</td>
		</tr>
		<?php else: ?>
		<?php foreach ($list as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['group_id']; ?></td>
			<td class="listtd"><?php echo $row['group_name']; ?></td>
			<td class="listtd"><?php if($row['group_isadmin'] == '1') {echo '<span class="alert bold">[管理员组]</span>';}else{echo '<span class="green bold">[普通用户组]</span>';} ?></td>
			<td class="listtd"><?php if($row['group_issys'] == '1') {echo '<span class="alert bold">[系统用户组]</span>';}else{echo '<span class="green bold">[自定义用户组]</span>';} ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=usergroup&amp;do=edit&id=<?php echo $row['group_id'] ?>" title="编辑">编辑</a> |
				<a href="index.php?m=admin&amp;a=acl&amp;do=auth_group&amp;id=<?php echo $row['group_id'] ?>" title="修改用户组权限">权限</a> |
				<a href="index.php?m=admin&amp;a=usergroup&amp;do=rm&amp;id=<?php echo $row['group_id'] ?>" onclick="return confirm('确认要删除吗?\n一旦删除无法恢复.')" title="删除">删除</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>