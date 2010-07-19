<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 权限管理页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=acl&amp;do=edit" title="添加新权限">添加新权限</a><br />
		权限管理
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
			<td class="titletd" width="100px">权限ID</td>
			<td class="titletd" width="20%">权限名称</td>
			<td class="titletd">权限简介</td>
			<td class="titletd" width="15%">权限标识</td>
			<td class="titletd" width="15%">权限类型</td>
			<td class="titletd" width="120px">操作</td>
		</tr>
		<?php if($list == NULL): ?>
		<tr>
			<td class="titletd" colspan="6">没有任何权限条目</td>
		</tr>
		<?php else: ?>
		<?php foreach ($list as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['acl_id'] ?></td>
			<td class="listtd"><?php echo $row['acl_name'] ?></td>
			<td class="listtd"><?php echo $row['acl_desc'] ?></td>
			<td class="listtd"><?php echo $row['acl_key'] ?></td>
			<td class="listtd"><?php if($row['acl_type'] == '0') {echo '<span class="green bold">[用户权限]</span>';}else{echo '<span class="alert bold">[管理权限]</span>';}  ?></td>
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=acl&amp;do=edit&amp;id=<?php echo $row['acl_id'] ?>" title="修改">修改</a> |
				<a href="index.php?m=admin&amp;a=acl&amp;do=del&amp;id=<?php echo $row['acl_id'] ?>" onclick="return confirm('确认要删除此权限吗? 一旦删除将无法恢复')" title="删除权限">删除</a>
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<td class="pagetd" colspan="6">
				<div id="paginate"><?php echo Paginate::get_paginate('firstpage', 'currentpage') ?></div>
			</td>
		</tr>
		<?php endif;?>
	</table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>