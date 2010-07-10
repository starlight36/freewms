<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 文件浏览器上传文件模版
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传列表</title>
<style type="text/css">
<!--
body {
	padding: 0;
	margin: 0;
	width: 499px;
	height: 268px;
	overflow: hidden;
}
/*---------------main-style----------*/
#main {
	width: 100%;
	height: 100%;
	background-color: #f0f0ee;
}
.file {
	border-style: solid;
	border-color: #bbb;
	border-width: 1px;
	height: 256px;
	float: left;
	margin: 5px 0 5px 5px;
	background-color: #fff;
}
.file_list {
	width: 300px;
}
.file_upload {
	width: 180px;
	text-align: center;
}

/*--------------file-list---------------------*/
.file_list input {
	margin: 20px auto 0 20px;
}
.file_list p {
	color: #333;
	font-size: 12px;
	margin: 20px auto auto 20px;
}
.file_upload input {
	width: 100px;
	height: 30px;
	background-color: #89d325;
	color:#FFF;
	border: 0px;
	margin-top: 80px;
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body>

<div id="main">
	<div class="file">
    	<div class="file_list">
        	<input type="file" />
            <input type="file" />
            <input type="file" />
            <input type="file" />
            <input type="file" />
            <p>提示：您一次可以选择1-5个文件进行上传</p>
    	</div>
	</div>
	<div class="file">
    	<div class="file_upload">
        	<input type="button" value="开始上传" />
        </div>
	</div>
</div>

</body>
</html>
