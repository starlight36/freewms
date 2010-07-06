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
<title>上传文件</title>
<style type="text/css">
<!--
* {
	padding: 0;
	margin: 0;
	font-size: 12px;
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
}
.inner_table {
	width: 100%;
	height: 100%;
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
.inner_table th {
	height: 20px;
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
-->
</style>
</head>

<body>
	<table border="0" cellpadding="0" cellspacing="0" class="outer_table">
  <tr>
	<td rowspan="4" class="table_border" width="5"></td>
    <td colspan="3" height="30" class="table_title">
    <select>
		<option>1990</option>
		<option>1991</option>
    </select>&nbsp;年
    <select>
		<option>七</option>
		<option>八</option>
		<option>十一</option>
    </select>&nbsp;月
    <input type="text" class="table_input" value="文件名" onfocus="this.value=''" />
    <input type="button" class="table_screen" value="筛选"/>
    <div class="upload_file">
    <input type="button" value="上传文件"/>
    </div>
    </td>
    <td rowspan="4" class="table_border" width="5"></td>
  </tr>
  <tr>
    <td colspan="3" class="table_border" height="5"></td>
  </tr>
  <tr>
    <td width="309" height="228" class="inner_border">
		<table border="0" cellpadding="0" cellspacing="0" class="inner_table">
			<th>
				<td class="innertable_border">文件名</td>
				<td class="innertable_border">大小</td>
				<td class="innertable_title">上传时间</td>
			</th>
			<tr>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</td>
    <td width="5" class="table_border"></td>
    <td width="165" class="inner_border">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" height="5" class="table_border"></td>
  </tr>
</table>
</body>
</html>
