<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 友情链接列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<p><a href="index.php?m=admin&amp;a=link&amp;do=edit">添加链接</a></p>
		友情链接说明：
  </div>
	<form method="post" action="index.php?m=admin&amp;a=link">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40px"></td>
				<td class="titletd" width="15%">链接标题</td>
				<td class="titletd">链接描述</td>
                <td class="titletd" width="80px">链接图片</td>
                <td class="titletd" width="15%">是否显示</td>
				<td class="titletd" width="120px">操作
  </tr>
			<?php if($linklist == NULL): ?>
			<tr>
				<td class="titletd" colspan="6">没有链接</td>
			</tr>
			<?php else: ?>
			<!--{链接层次列表开始}-->
    <?php foreach ($linklist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['link_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><a href="<?php echo $row['link_url']; ?>" target="_blank" ><?php echo $row['link_title']; ?></a></td>
				<td class="listtd"><?php echo $row['link_desc']; ?></td>
				<td class="listtd">
					<?php if($row['link_img']):?><img alt="图片错误" src="<?php echo $row['link_img']; ?>" width="80px" /></td>
					<?php else:?>无图片
					<?php endif ?>
                <td class="listtd"><?php
					if($row['link_isdisplay'] == 0)  echo "不显示";
					if($row['link_isdisplay'] == 1)  echo "显示";
				?></td>
				<td class="listtd">
				    <a href="index.php?m=admin&amp;a=link&amp;do=edit&amp;id=<?php echo $row['link_id']; ?>" title="">修改</a> |
           			<a href="index.php?m=admin&amp;a=link&amp;do=rm&amp;id=<?php echo $row['link_id']; ?>" onclick="return confirm('确定删除？')" title="删除" >删除</a>
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
	        			<option value="dly">设置显示</option>
                        <option value="undly">设置不显示</option>
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