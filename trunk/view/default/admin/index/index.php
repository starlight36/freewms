<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="UTF-8" />
<meta content="all" name="robots" />
<meta name="author" content="FreeWMS" />
<link rel="stylesheet" rev="stylesheet" href="{#out:base_url()}view/default/skin/admin.css" type="text/css" />
<link rel="stylesheet" href="{#out:base_url()}/js/artdialog/skin/facebook/facebook.css" type="text/css" media="all" />
<script type="text/javascript" src="{#out:base_url()}js/jquery/jquery.core.js"></script>
<script type="text/javascript" src="{#out:base_url()}js/jquery/jquery.form.js"></script>
<script type="text/javascript" src="{#out:base_url()}js/artdialog/artdialog.js"></script>
<script type="text/javascript" src="{#out:base_url()}js/admin/common.js"></script>
<title>后台管理 - Powered By FreeWMS</title>
</head>
<body>
<div id="topframe">
	<h1 id="toptitle">网站后台管理</h1>
</div>
<div id="leftframe">
	<div id="guidetree">
		<div class="wrapitem">
			<div class="treeitem">
				<div>文章频道管理</div>
				<ul>
					<li>添加文章</li>
					<li>审核文章</li>
					<li>全部文章管理</li>
					<li>专题文章管理</li>
					<li>文章评论管理</li>
					<li>文章评论审核</li>
					<li>回收站管理</li>
					<li>分类管理</li>
					<li>专题管理</li>
					<li>关键字管理</li>
					<li>TAG管理</li>
					<li>字段管理</li>
					<li>上传附件管理</li>
				</ul>
			</div>
		</div>
		<div class="wrapitem">
			<div class="treeitem">
				<div>留言板管理</div>
				<ul>
					<li>网站留言审核</li>
					<li>网站留言管理</li>
					<li>留言板设置</li>
					<li>管理员管理</li>
				</ul>
			</div>
		</div>
		<div class="wrapitem">
			<div class="treeitem">
				<div>用户权限管理</div>
				<ul>
					<li>用户管理</li>
					<li>用户审核</li>
					<li>用户组管理</li>
					<li>管理员管理</li>
				</ul>
			</div>
		</div>
		<div class="wrapitem">
			<div class="treeitem">
				<div>模版主题设置</div>
				<ul>
					<li>模板方案管理</li>
					<li>主题风格管理</li>
					<li>自定义页管理</li>
					<li>Widget管理</li>
				</ul>
			</div>
		</div>
		<div class="wrapitem">
			<div class="treeitem">
				<div>网站系统设置</div>
				<ul>
					<li><a href="{#out:site_url('')}" title="常规设置" class="OpenMain">系统参数设置</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">全站频道设置</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">全站专题管理</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">上传附件管理</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">全站广告管理</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">友情链接管理</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">投票调查管理</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">关键字管理</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">全站TAG管理</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">脏字过滤管理</a></li>
					<li><a href="{#out:base_url()}" title="常规设置">功能模块管理</a></li>
				</ul>
			</div>
		</div>
		<div class="wrapitem">
			<div class="treeitem">
				<div>站点维护管理</div>
				<ul>
					<li>数据备份</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div id="mainframe">
	<h1>欢迎!</h1>
	<p>感谢您选择FreeWMS来驱动您的网站, 在这里您将可以对您的网站进行管理.</p>
	<div class="mainmodwrap">
		<div class="mainmod">
			<div class="modtitle">概述</div>
			<div class="modcontent"><a href="{#out:site_url('admin/module_modify')}" onclick="return ajax_dialog(this, 300, 200, false);" title="编辑模块">编辑模块</a></div>
</div>
	</div>
	<div class="mainmodwrap">
		<div class="mainmod">
			<div class="modtitle">概述</div>
			<div class="modcontent">xxxx</div>
		</div>
	</div>
</div>
</body>
</html>