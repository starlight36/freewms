<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 上传列表页面模版
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Lang::_('admin_file_upload_tip');?></title>
<style type="text/css">
<!--
body {
	background-color: #ffffff;
}
a {
	color: #000;
	text-decoration: none;
}
* {
	padding: 0;
	margin: 0;
	font-size: 12px;
}
table {
	border-collapse:collapse;
}
tr {
	padding: 0;
	margin: 0;
}
td {
	padding: 0;
	margin: 0;
}
select {
	margin-left: 8px;
	margin-right: 0px;
	height: 20px;
}

/*---------------table-tile--------------*/
.outer_table {
	width: 499px;
	height: 268px;
	overflow:hidden;
}
.inner_table {
	width: 100%;
}
.table_input {
	width: 80px;
	margin-left: 8px;
}
.table_screen {
	width: 50px;
	height: 20px;
	background-color: #89d325;
	color:#FFF;
	border: 0px;
	padding-top: 2px;
}
.upload_file input {
	width: 70px;
	height: 20px;
	background-color: #89d325;
	color:#FFF;
	border: 0px;
	padding-top: 2px;
}
.upload_file {
	float: right;
	margin-right: 10px;
}
.inner_table tr {
	height: 22px;
}
/*--------------border-style----------------*/
.table_border {
	background-color:#f0f0ee;
}
.innertable_border {
	background-color: #f5f5ee;
	border-color: #bbb;
	border-right-style: solid;
	border-width: 1px;
	border-bottom-style: solid;
	padding-left: 2px;
}
.innertable_title {
	background-color: #f5f5ee;
	border-color: #bbb;
	border-width: 1px;
	border-bottom-style: solid;
	padding-left: 2px;
}
.inner_border {
	border-width: 1px;
	border-style: solid;
	border-color: #bbb;
}
.table_title {
	border-width: 1px;
	border-style: none solid solid solid;
	border-color: #bbb;
}

.preview_img {
	max-width:160px;
	max-height: 180px;
	width:expression(width>160?"160px":width+"px");max-width: 160px;
	height:expression(height>180?"180px":height+"px");max-height: 180px;
	overflow:hidden;
}
.filerow {
	cursor: pointer;
}
-->
</style>
<script type="text/javascript" src="<?php echo Url::base();?>js/jquery/core.js"></script>
<script type="text/javascript">
//<!--
$(document).ready(function(){
	//鼠标滑过设置缩略图
	$('.filerow').mouseover(function(){
		$(this).css('background-color', '#f0f0ee');
		var id = this.id.toString().replace('filerow', 'fileinfo');
		var info = $('#'+id).val().split('|');
		$('#pv_img').attr('src', info[0]);
		$('#pv_name').html(info[1]);
		$('#pv_size').html(info[2]);
	});
	//滑出恢复颜色
	$('.filerow').mouseout(function(){
		$(this).css('background-color', '#ffffff');
	});
	//单击插入文件
	$('.filerow').click(function(){
		var id = this.id.toString().replace('filerow', 'fileinfo');
		var info = $('#'+id).val().split('|');
		if(info[3] != '') {
			callback(info[3]);
		}
	});
});
//-->
</script>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" class="outer_table">
	<tr>
		<td rowspan="5" class="table_border" width="5"></td>
		<td colspan="3" height="30" class="table_title">
			<form  method="post" id="fitter_form" action="index.php?m=admin&amp;a=filebrowser">
			<div style="width:330px; float:left;">
				<select name="year">
					<option value="">年份</option>
						<?php for($i=2000;$i<=2038;$i++){
							$yearlist[$i] = '<option value="'.$i.'"';
							if( $yearnum == $i) $yearlist[$i] = $yearlist[$i].' selected=selected';
							$yearlist[$i] = $yearlist[$i].">".$i."</option>";
							echo $yearlist[$i];
					}?>
				</select>&nbsp;<?php echo Lang::_('admin_file_year_tip');?>
				<select name="month">
					<option value="">月份</option>
					<?php for($i=1;$i<=12;$i++){
						$monthlist[$i] = '<option value="'.$i.'" ';
						if( $monthnum == $i) $monthlist[$i] = $monthlist[$i].' selected=selected';
						$monthlist[$i] = $monthlist[$i].'>'.$i.'</option>';
						echo $monthlist[$i];
					}?>
				</select>&nbsp;<?php echo Lang::_('admin_file_month_tip');?>
				<input type="text" class="table_input" name="filename" value="<?php echo Lang::_('admin_file_filename_tip');?>" onfocus="this.value=''" />
				<input type="submit" class="table_screen" value="<?php echo Lang::_('admin_table_screen_tip');?>"/>
			</div>
			</form>
			<div class="upload_file">
				<input type="button" value="上传文件" onclick="window.location.href='index.php?m=admin&a=filebrowser&do=upload'"/>
			</div>
		</td>
		<td rowspan="5" class="table_border" width="5"></td>
	</tr>
	<tr>
		<td colspan="3" class="table_border" height="5"></td>
	</tr>
	<tr>
		<td width="309" height="114" class="inner_border" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" class="inner_table">
				<tr class="header">
					<td width="130" class="innertable_border"><?php echo Lang::_('admin_filename_tip');?></td>
					<td width="70" class="innertable_border"><?php echo Lang::_('admin_file_size_tip');?></td>
					<td class="innertable_title"><?php echo Lang::_('admin_file_uploadtime_tip');?></td>
				</tr>
				<?php if($filelist == NULL): ?>
				<tr>
					<td colspan="3"><?php echo Lang::_('admin_file_nofound_tip');?></td>
				</tr>
				<?php else: ?>
				<?php foreach($filelist as $row): ?>
				<tr id="filerow_<?php echo $row['id'] ?>" class="filerow">
					<td>
						<input type="hidden" id="fileinfo_<?php echo $row['id'] ?>" value="<?php echo $row['preview'];?>|<?php echo $row['filename'] ?>|<?php echo $row['filesize'] ?>|<?php echo $row['filepath'] ?>" />
						<img alt="icon" src="<?php echo Url::base();?>images/files/16/<?php echo $row['filetype'];?>.png" height="16" width="16" border="0" />
						<?php echo $row['filename'] ?>
					</td>
					<td><?php echo $row['filesize'] ?></td>
					<td><?php echo $row['uploadtime'] ?></td>
				</tr>
				<?php endforeach; ?>
				<?php endif; ?>
			</table>
		</td>
		<td width="5" rowspan="2" class="table_border"></td>
		<td width="165" rowspan="2" class="inner_border">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td height="160" colspan="2" align="center"><img src="<?php echo Url::base();?>images/files/64/unknown.png" alt="预览图" id="pv_img" class="preview_img" /></td>
				</tr>
				<tr>
					<td width="50" height="24" align="center"><?php echo Lang::_('admin_pv_name_tip');?>：</td>
					<td><span id="pv_name"></span></td>
				</tr>
				<tr>
					<td height="24" align="center"><?php echo Lang::_('admin_pv_size_tip');?>：</td>
					<td height="24"><span id="pv_size"></span></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="height: 20px;" align="right" valign="middle" class="inner_border">
			<?php echo Paginate::get_paginate(); ?>
		</td>
	</tr>
	<tr>
		<td colspan="3" height="5" class="table_border"></td>
	</tr>
</table>
</body>
</html>
