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
		<p>上传文件  说明：</p>
		<p> <a href="index.php?m=admin&amp;a=upload&amp;do=edit">添加新的上传文件</a></p>
    <form method="post" action="index.php?m=admin&amp;a=upload">
    年份：
    	<select name="year">
    		<option value="">所有年份</option>
 			<?php for($i=2000;$i<=2038;$i++){
				$yearlist[$i] = '<option value="'.$i.'"';
				if( $yearnum == $i) $yearlist[$i] = $yearlist[$i].' selected=selected';
				$yearlist[$i] = $yearlist[$i].">".$i."年</option>";
				echo $yearlist[$i];
				}?>
   		</select>&nbsp;
    &nbsp;月:
    	<select name="month">
    		<option value="">所有月份</option>
    		<?php for($i=1;$i<=12;$i++){
				$monthlist[$i] = '<option value="'.$i.'" ';
				if( $monthnum == $i) $monthlist[$i] = $monthlist[$i].' selected=selected';
				$monthlist[$i] = $monthlist[$i].'>'.$i.'月</option>';
				echo $monthlist[$i];
			}?>
    	</select>&nbsp;
    &nbsp;文件名:
    	<input type="text" class="text" size="14" name="upload_name" value="<?php echo $namenum; ?>" />
        <input type="submit" value="筛选" />
    </form>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=upload">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40">操作</td>
				<td class="titletd" width="110px">文件名</td>
				<td class="titletd" width="90px">文件大小</td>
				<td class="titletd" width="120px">上传时间</td>
				<td class="titletd" width="10%">操作</td>
  </tr>
			<?php if($uploadlist == NULL): ?>
			<tr>
				<td class="titletd" colspan="7">所选范围内没有找到上传文件</td>
			</tr>
			<?php else: ?>
			<!--{分类层次列表开始}-->
    <?php foreach ($uploadlist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['upload_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['upload_name']; ?></td>
				<td class="listtd"><?php
				$f = new Format();
				echo $f->filesize($row['upload_size']); ?></td>
                <td class="listtd"><?php echo date("Y-m-d H:i", $row['upload_time']); ?></td>
           		<td class="listtd"><a href="index.php?m=admin&amp;a=upload&amp;do=rm&amp;id=<?php echo $row['upload_id']; ?>" onclick="return confirm('确定删除？')" title="删除" >删除</a></td>
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
					<input type="hidden" value="rm" name="do">
					<input type="submit" class="actionbtn pointer" value="删除">
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