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
<title><?php echo Lang::_('admin_upload_list_tip');?></title>
<style type="text/css">
<!--
html, body, div {
	padding: 0;
	margin: 0;
}
body {
	width: 499px;
	height: 268px;
	overflow: hidden;
	background-color: #f0f0ee;
	font-size: 12px;
}
/*---------------main-style----------*/
#main {
	width: 100%;
	height: 100%;
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
.msg {
	border-style: solid;
	border-color: #bbb;
	border-width: 1px;
	height: 240px;
	width: 468px;
	margin: 5px 0 5px 5px;
	background-color: #fff;
	padding: 10px;
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
	<?php if(TPL_PART == 'INPUT'): ?>
	<form action="index.php?m=admin&amp;a=filebrowser&do=upload" method="post" enctype="multipart/form-data">
		<div class="file">
			<div class="file_list">
				<input name="file[]" type="file" />
				<input name="file[]" type="file" />
				<input name="file[]" type="file" />
				<input name="file[]" type="file" />
				<input name="file[]" type="file" />
				<p><?php echo Lang::_('admin_upload_clew_tip');?></p>
			</div>
		</div>
		<div class="file">
			<div class="file_upload">
				<input type="submit" value="<?php echo Lang::_('admin_upload_start_tip');?>" />
			</div>
		</div>
	</form>
	<?php endif; ?>
	<?php if(TPL_PART == 'ERROR'): ?>
	<div class="msg">
		<h4><?php echo Lang::_('admin_upload_error_tip');?>：</h4>
		<p>
			<?php echo implode('</p><p>', $errorlist); ?><br />
		</p>
		<p><a href="javascript:void(0);" onclick="window.location.href='index.php?m=admin&a=filebrowser&do=upload'" title="<?php echo Lang::_('admin_upload_again_title');?>"><?php echo Lang::_('admin_upload_again_return_tip');?></a></p>
	</div>
	<?php endif; ?>
	<?php if(TPL_PART == 'SUCCESS'): ?>
	<div class="msg">
		<h4><?php echo Lang::_('admin_upload_success_tip');?></h4>
		<?php foreach($filelist as $row): ?>
		<p><?php echo Lang::_('admin_upload_file_tip');?>: <?php echo $row['name']; ?>(<?php echo Format::filesize($row['size']); ?>)<input type="button" value="<?php echo Lang::_('admin_insert_file_tip');?>" onclick="callback('<?php echo $row['url']; ?>');" /></p>
		<?php endforeach; ?>
		<p>
			<a href="javascript:void(0);" onclick="window.location.href='index.php?m=admin&a=filebrowser&do=upload'" title="<?php echo Lang::_('admin_upload_continue_title');?>"><?php echo Lang::_('admin_upload_continue_return_tip');?></a>
			<a href="index.php?m=admin&amp;a=filebrowser" title="<?php echo Lang::_('admin_upload_return_title');?>"><?php echo Lang::_('admin_upload_teturn_tip');?></a>
		</p>
	</div>
	<?php endif; ?>
</div>
</body>
</html>
