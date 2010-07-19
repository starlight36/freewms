<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * URL方案管理模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">URL方案和路由方案管理</div>
	<form id="save_edit" name="save_edit" method="post" action="index.php?m=admin&amp;a=url&amp;do=save">
		<ul id="tabs">
			<li id="tab1" class="selecttab">
				<a href="javascript:void(0);" title="URL方案文件" onclick="SelectTab('tabcontent1','tab1');">URL方案文件</a>
			</li>
			<li id="tab2">
				<a href="javascript:void(0);" title="路由方案文件" onclick="SelectTab('tabcontent2','tab2');">路由方案文件</a>
			</li>
		</ul>
		<div id="tabcontent">
			<div id="tabcontent1" class="showtabcon" style="display: block;">
				<textarea class="normaltextarea" name="url" style="width: 100%; height: 350px;"><?php echo htmlspecialchars($url_content);?></textarea>
			</div>
			<div id="tabcontent2" class="showtabcon" style="display: none;">
				<textarea class="normaltextarea" name="route" style="width: 100%; height: 350px;"><?php echo htmlspecialchars($route_content);?></textarea>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="保存修改">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重置表单">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>