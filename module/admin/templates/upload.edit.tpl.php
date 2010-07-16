<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 上传文件编辑页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">添加新的上传文件</div>
  <form action="index.php?m=admin&amp;a=upload&amp;do=edit" method="post" enctype="multipart/form-data">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">上传文件1:</span><input name="file[]" type="file" /></p>
				<p><span class="left">上传文件2:</span><input name="file[]" type="file" /></p>
				<p><span class="left">上传文件3:</span><input name="file[]" type="file" /></p>
				<p><span class="left">上传文件4:</span><input name="file[]" type="file" /></p>
				<p><span class="left">上传文件5: </span><input name="file[]" type="file" /></p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="提交">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重置">
		</div>
  </form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>