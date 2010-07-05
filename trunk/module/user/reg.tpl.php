<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 注册页模版
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>注册</title>

	</head>
	<body>
		<div id="all">
			<div id="loginbox">
				<form name="manageregform" id="manageregform" action="<?php echo Url::base();?>index.php?m=user&amp;a=reg" method="post">
    <p><?php echo 用户名;?>:<input name="admin" id="admin" type="text" class="text" maxlength="20" />;</p>
    <p><?php echo 密码;?>:<input name="pass" id="pass" type="password" class="text" />;</p>
    <p> <?php echo dd;?>:<input type="text" name="validcode" id="checkcode" maxlength="4" class="checkcode" /></p>
					<img src="<?php echo Url::base();?>index.php?m=validcode" id="validcodeimg" width="60" height="20" border="0" align="absmiddle" alt="<?php echo Lang::_('admin_login_valid_code_tip');?>" onclick="this.src='<?php echo Url::base();?>index.php?m=validcode&random='+Math.random();" />
					<input name="loginbtn" id="loginbtn" type="submit" class="btn" value="<?php echo Lang::_('admin_login_submit_tip');?>" />
				</form>
			</div>
		</div>
	</body>
</html>
