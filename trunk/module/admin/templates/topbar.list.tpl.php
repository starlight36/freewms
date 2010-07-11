<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 导航条列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<a href="index.php?m=admin&amp;a=topbar&amp;do=edit" title="添加新网站导航">添加新网站导航</a><br />
		说明：
	</div>
<form method="post" action="index.php?m=admin&amp;a=topbar&amp;do=order">
  <table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
            <td class="titletd" width="6%">排序</td>
			<td class="titletd" width="15%">网站导航名</td>
			<td class="titletd">导航简介</td>
			<td class="titletd" width="25%">目标</td>
			<td class="titletd" width="15%">操作</td>
		</tr>
		<?php if($tlist == NULL): ?>
		<tr>
			<td class="titletd" colspan="5">没有任何导航</td>
		</tr>
		<?php else: ?>
		<?php foreach ($tlist as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
        <td class="listtd"><input type="text" class="text ordertext" maxlength="3" value="<?php echo $row['topbar_order']; ?>" name="order[<?php echo $row['topbar_id']; ?>]"></td>
			<td class="listtd"><?php echo $row['topbar_name'] ?></td>
			<td class="listtd"><?php echo $row['topbar_desc'] ?></td>
            <td class="listtd"><?php echo $row['topbar_target'] ?></td>			
			<td class="listtd">
				<a href="index.php?m=admin&amp;a=topbar&amp;do=edit&amp;id=<?php echo $row['topbar_id'] ?>" title="修改">修改</a> |
				<a href="index.php?m=admin&amp;a=topbar&amp;do=del&amp;id=<?php echo $row['topbar_id'] ?>" title="删除">删除</a> 
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
  <div>
     <input type="submit" class="actionbtn pointer" value="保存排序" />
  </div>
</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>