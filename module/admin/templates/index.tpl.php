<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 后台首页模版
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo Url::base();?>module/admin/images/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo Url::base();?>module/admin/images/index.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Url::base();?>module/admin/images/menu.js"></script>
<title><?php echo Config::get('site_name'); ?> - <?php echo Lang::_('admin_index_title');?></title>
<base target="main" href="<?php echo Url::base();?>"></base>
</head>
<body>
<div id="topframe">
	<div id="topleft"><img src="<?php echo Url::base();?>module/admin/images/logo.jpg" alt="FreeWMS" /></div>
	<div id="topright">
	  <div class="menubar">
		<ul id="navlist">
		  <li><a href="javascript:void(0)" title="关闭左边管理导航菜单" target="_self">关闭左栏</a></li>
		  <li><a href="javascript:void(0)" title="对blog进行系统设置" target="_self">系统设置</a></li>
		  <li><a href="javascript:void(0)" title="发表一篇新的日志" target="_self">发表日志</a></li>
		  <li><a href="javascript:void(0)" title="设计制作主题风格" target="_self">风格设计</a></li>
		  <li><a href="javascript:void(0)" title="生成首页静态文件" target="_self">生成首页</a></li>
		  <li><a href="javascript:void(0)" title="打开前台首页" target="_self">前台首页</a></li>
		  <li><a href="index.php?m=admin&amp;a=logout" title="退出后台管理" target="_self">退出后台</a></li>
		</ul>
	  </div>
		<div id="topmsg" style="display: none;"><img src="<?php echo Url::base();?>module/admin/images/loading.gif" alt="Loading" align="absmiddle"/>数据加载中，请稍候.....</div>
	</div>
</div>
<div id="leftframe">
	<div id="menu">
		<div id="menuall">
			<div id="leftmenu" class="sdmenu">
				<div class="collapsed">
					<span class="content">网站内容管理</span>
					<a onclick="return false;" title="发布内容" style="padding-left: 10px;">
						<select onchange="window.main.location.href='?m=admin&a='+this.value;" style="width:140px">
							<option value="main" selected="selected" disabled="disabled">选择分类发布新内容</option>
							<?php echo $cate_select_tree; ?>
						</select>
					</a>
					<a href="#" title="">全部内容管理</a>
					<a href="#" title="">内容审核管理</a>
					<a href="#" title="">内容分类管理</a>
					<a href="#" title="">内容专题管理</a>
					<a href="#" title="">内容推荐管理</a>
					<a href="#" title="">草稿箱管理</a>
					<a href="#" title="">回收站管理</a>
				</div>
				<div class="collapsed">
					<span class="comment">留言评论管理</span>
					<a href="#" title="">内容评论管理</a>
					<a href="#" title="">评论审核管理</a>
					<a href="#" title="">用户留言管理</a>
					<a href="#" title="">留言审核管理</a>
				</div>
				<div class="collapsed">
					<span class="create">静态生成管理</span>
					<a href="#" title="">首页静态生成</a>
					<a href="#" title="">分类页静态生成</a>
					<a href="#" title="">专题页静态生成</a>
					<a href="#" title="">内容页静态生成</a>
				</div>
				<div class="collapsed">
					<span class="user">用户管理中心</span>
					<a href="#" title="">全站用户管理</a>
					<a href="#" title="">用户审核管理</a>
					<a href="#" title="">用户组管理</a>
					<a href="#" title="">管理员管理</a>
				</div>
				<div class="collapsed">
					<span class="theme">界面管理中心</span>
					<a href="#" title="">主题模板管理</a>
					<a href="#" title="">网站导航管理</a>
					<a href="#" title="">自定义页管理</a>
					<a href="#" title="">Widget管理</a>
				</div>
				<div class="collapsed">
					<span class="sys">系统管理中心</span>
					<a href="#" title="">全站设置管理</a>
					<a href="#" title="">内容模型管理</a>
					<a href="#" title="">上传文件管理</a>
					<a href="#" title="">调查投票管理</a>
					<a href="#" title="">友情链接管理</a>
					<a href="#" title="">URL方案管理</a>
				</div>
				<div class="collapsed">
					<span class="data">数据管理中心</span>
					<a href="#" title="">全站数据备份</a>
					<a href="#" title="">数据备份恢复</a>
					<a href="#" title="">数据库优化</a>
					<a href="#" title="">执行SQL语句</a>
				</div>
				<div class="collapsed">
					<span class="support">支持与帮助</span>
					<a href="#" title="取得官方参考手册">用户参考手册</a>
					<a href="#" title="FreeWMS按照BSD协议开发,点此了解更多">授权使用协议</a>
					<a href="#" title="取得专业的技术支持和二次开发">支持与额外服务</a>
					<a href="http://code.google.com/p/freewms/" target="_blank" title="FreeWMS开源项目首页">FreeWMS项目组</a>
					<a href="http://www.wedong.com" target="_blank" title="取得FreeWMS商业支持">维动网络</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="mainframe">
	<iframe frameborder="0" scrolling="auto" name="main" style="height:100%;width:100%;" src="<?php echo URL::base(); ?>index.php?m=admin&amp;a=main"></iframe>
</div>
</body>
</html>
