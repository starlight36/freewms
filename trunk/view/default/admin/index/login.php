<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="UTF-8" />
<meta content="all" name="robots" />
<meta name="author" content="FreeWMS" />
<link rel="stylesheet" href="{#out:base_url()}view/default/skin/admin/base.css" type="text/css" media="all" />
<link rel="stylesheet" href="{#out:base_url()}view/default/skin/admin/login.css" type="text/css" media="all" />
<script type="text/javascript" src="{#out:base_url()}js/jquery/jquery.core.js"></script>
<script type="text/javascript" src="{#out:base_url()}js/jquery/jquery.form.js"></script>
<script type="text/javascript" src="{#out:base_url()}js/admin/common.js"></script>
<title>后台管理登录 - FreeWMS</title>
</head>
<body>
<div id="loginpage" class="moditem">
	<form id="loginform" action="{#out:site_url('admin/login')}" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="moditem">
			<tr>
				<th colspan="2">管理员登录</th>
			</tr>
			<!--#if{validation_errors()}-->
			<tr>
				<td colspan="2"><div class="errormsg">{#out:validation_errors()}</div></td>
			</tr>
			<!--#endif-->
			<tr>
				<td class="labelcol">用户名：</td>
				<td><input type="text" name="admin" id="admin" value="{#out:set_value('admin')}" /></td>
			</tr>
			<tr>
				<td class="labelcol">用户密码：</td>
				<td><input name="passwd" type="password" id="passwd" value="{#out:set_value('passwd')}" /></td>
			</tr>
			<tr>
				<td class="labelcol">管理密码：</td>
				<td><input name="adminpass" type="password" id="adminpass" value="{#out:set_value('adminpass')}" /></td>
			</tr>
			<tr>
				<td colspan="2" class="buttonrow"><input type="submit" value="提交" /> <input type="reset" value="重置" /></td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>
