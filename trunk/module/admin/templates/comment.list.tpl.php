<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 评论列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php if(!isset($_GET['state'])):?><p>评论管理</p>
		<?php else: $comment_state = $_GET['state'];?><p>评论审核</p><?php endif?>
		说明：
	</div>
	<form method="post" action="index.php?m=admin&amp;a=comment">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40">操作</td>
				<td class="titletd" width="110px">作者</td>
				<td class="titletd" width="90px">作者IP</td>
                <td class="titletd">评论内容</td>
				<td class="titletd" width="120px">时间</td>
                <td class="titletd" width="10%">状态</td>
				<td class="titletd" width="10%">操作
  </tr>
			<?php if($comlist == NULL): ?>
			<tr>
				<td class="titletd" colspan="7">所选范围内没有找到评论</td>
			</tr>
			<?php else: ?>
			<!--{分类层次列表开始}-->
    <?php foreach ($comlist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['comment_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['comment_username']; ?></td>
				<td class="listtd"><?php echo $row['comment_ip']; ?></td>
				<td class="listtd"><?php echo $row['comment_content']; ?></td>
                <td class="listtd"><?php echo date("Y-m-d H:i", $row['comment_time']); ?></td>
                <td class="listtd"><?php
					if($row['comment_state'] == 0)  echo "正常";
					if($row['comment_state'] == 1)  echo "待审";
					if($row['comment_state'] == 2)  echo "锁定";
				?></td>
				<td class="listtd">
					<?php if($row['comment_state'] == 1):?><a href="index.php?m=admin&amp;a=comment&amp;do=normal&amp;id=<?php echo $row['comment_id']; ?>" title="通过">设为正常</a> | <?php endif?>
                    <?php if($row['comment_state'] == 0):?><a href="index.php?m=admin&amp;a=comment&amp;do=lock&amp;id=<?php echo $row['comment_id']; ?>" title="锁定">锁定</a> | <?php endif?>
					<?php if($row['comment_state'] == 2):?><a href="index.php?m=admin&amp;a=comment&amp;do=normal&amp;id=<?php echo $row['comment_id']; ?>" title="解锁">解锁</a> | <?php endif?>
           			<a href="index.php?m=admin&amp;a=comment&amp;do=rm&amp;id=<?php echo $row['comment_id']; ?>" onclick="return confirm('确定删除？')" title="删除" >删除</a>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif;?>
			<tr>
				<td class="actiontd" colspan="7">
					<span class="space6">
						<a class="sa" title="全部选中" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)">全选</a> /
						<a class="sa" title="取消全选" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)">不选</a>
					</span>
					<span class="space3 blue bold">对选中项进行：</span>
					<select name="do">
	        			<option value="normal">设为正常</option>
						<?php if(!isset($_GET['state'])):?><option value="lock">锁定评论</option><?php endif?>
						<option value="rm">删除评论</option>
					</select>
				  <input type="submit" class="actionbtn pointer" value="确认执行">
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