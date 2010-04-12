<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<div id="loginmain">
	<div id="logintitle">管理员登录</div>
	<div id="errormsg"><?php echo validation_errors(); ?></div>
    <form id="loginform" name="loginform" method="post" action="<?php echo site_url('admin/login'); ?>">
		<p>
			用户名: <input type="text" name="admin" id="admin" value="<?php echo set_value('admin'); ?>" />
		</p>
		<p>
			密码: <input name="passwd" type="password" id="passwd" value="<?php echo set_value('passwd'); ?>" />
		</p>
		<p>
			<input type="submit" name="button" id="button" value="登录" />
		</p>
    </form>
</div>
</body>
</html>