<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 留言列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php if(!isset($_GET['state'])):?><p>用户留言管理</p>
		<?php else: $gb_state = $_GET['state'];?><p>用户留言审核</p><?php endif?>
		说明：
	</div>
	<form method="post" action="index.php?m=admin&amp;a=guestbook">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40px">操作</td>
				<td class="titletd" width="15%">作者</td>
				<td class="titletd">作者ip</td>
                <td class="titletd" width="25%">评论内容</td>
				<td class="titletd" width="15%">时间</td>
                <td class="titletd" width="15%">状态</td>
				<td class="titletd" width="120px">操作
  </tr>
			<?php if($gblist == NULL): ?>
			<tr>
				<td class="titletd" colspan="7">没有留言</td>
			</tr>
			<?php else: ?>
			<!--{分类层次列表开始}-->
    <?php foreach ($gblist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['gb_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['gb_username']; ?></td>
				<td class="listtd"><?php echo $row['gb_ip']; ?></td>
				<td class="listtd"><?php echo $row['gb_content']; ?></td>
                <td class="listtd"><?php echo $row['gb_time']; ?></td>
                <td class="listtd"><?php
					if($row['gb_state'] == 0)  echo "正常/";
					if($row['gb_state'] == 1)  echo "待审/";
					if($row['gb_state'] == 2)  echo "锁定/";
					if($row['gb_replystate'] == 1) echo "已回复";
					else echo "<font color='#FF0000'>未</font>回复";
				?></td>
				<td class="listtd">
                	<a href="index.php?m=admin&amp;a=guestbook&amp;do=edit&id=<?php echo $row['gb_id']; ?>" title="回复" >回复</a> |
					<?php if($row['gb_state'] == 1):?><a href="index.php?m=admin&amp;a=guestbook&amp;do=normal&amp;id=<?php echo $row['gb_id']; ?>" title="正常">正常</a> | <?php endif?>
                    <?php if($row['gb_state'] == 0):?><a href="index.php?m=admin&amp;a=guestbook&amp;do=lock&amp;id=<?php echo $row['gb_id']; ?>" title="锁定">锁定</a> | <?php endif?>
					<?php if($row['gb_state'] == 2):?><a href="index.php?m=admin&amp;a=guestbook&amp;do=normal&amp;id=<?php echo $row['gb_id']; ?>" title="解锁">解锁</a> | <?php endif?>
           			<a href="index.php?m=admin&amp;a=guestbook&amp;do=rm&amp;id=<?php echo $row['gb_id']; ?>" onclick="return confirm('确定删除？')" title="删除" >删除</a>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif;?>
<tr>
				<td class="actiontd" colspan="7">
					<span class="space6">
						<a class="sa" title="全部选着" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)">全选</a> /
						<a class="sa" title="取消选着" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)">不选</a>
					</span>
					<span class="space3 blue bold">对选中项进行：</span>
					<select name="do">
	        			<option value="normal">设置正常</option>
						<?php if(!isset($_GET['state'])):?><option value="lock">设置锁定</option><?php endif?>
						<option value="rm">删除</option>
					</select>
				  <input type="submit" class="actionbtn pointer" value="执行">
				</td>
			</tr>
			<tr>
				<td class="pagetd" colspan="7">
					<div id="paginate"><?php echo Paginate::get_paginate('firstpage', 'currentpage') ?></div>
				</td>
			</tr>
		</table>
    </form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>