<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 主题列表页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		模板主题管理页面
	</div>
	<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
		<tr>
            <td class="titletd" width="18%">主题名称</td>
			<td class="titletd">主题说明</td>
			<td class="titletd" width="10%">主题版本</td>
			<td class="titletd" width="10%">更新时间</td>
			<td class="titletd" width="10%">版权所有</td>
			<td class="titletd" width="10%">分发协议</td>
			<td class="titletd" width="12%">操作</td>
		</tr>
		<?php if($theme_list == NULL): ?>
		<tr>
			<td class="titletd" colspan="7">没有找到任何模板</td>
		</tr>
		<?php else: ?>
		<?php foreach ($theme_list as $row): ?>
		<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
			<td class="listtd"><?php echo $row['name'];?></td>
			<td class="listtd"><?php echo $row['desc'] ?></td>
			<td class="listtd"><?php echo $row['version'] ?></td>
            <td class="listtd"><?php echo $row['update'] ?></td>
			<td class="listtd"><a href="<?php echo $row['link'] ?>" title="访问主页" target="_blank"><?php echo $row['copyright'] ?></a></td>
			<td class="listtd"><?php echo $row['licence'] ?></td>
			<td class="listtd">
				<?php if($row['path'] == Config::get('site_theme')): ?>
				<span class="alert bold">[当前主题方案]</span>
				<?php else: ?>
				<a href="index.php?m=admin&amp;a=theme&amp;do=use&amp;path=<?php echo $row['path'] ?>" title="使用此主题方案">使用此主题方案</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif;?>
  </table>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>