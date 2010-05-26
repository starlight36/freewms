<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 后台欢迎页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<style type="text/css">
div#divw { width: 98%; margin: 10px auto 0 auto; /*background-color: #f6f9fd;*/ border: 1px solid #a9c9e2; padding: 1px; text-align: left; }
div#divn { float: left; width: 100%; }
div#divnt1 { background-color: #d4e8f7; border-bottom: 1px solid #a9c9e2; padding: 5px; font-weight: bold; color: #356aa0; /*text-align: center;*/ }
div#divnt2 { background-color: #ddeffd; border-bottom: 1px solid #a9c9e2; padding: 5px; color: #2e466b; }
div#divnt3 { background-color: #e7f4fe; border-bottom: 1px solid #a9c9e2; padding: 5px; color: #2e466b; }
div#divnt4 { background-color: #f0f8fe; border-bottom: 1px solid #a9c9e2; padding: 5px; color: #2e466b; }
div.divlbox { float: left; width: 50%;}
div.divlbox div.divlcon1 { background-color: #f0f8fe; border-right: 1px solid #a9c9e2; border-bottom: 1px solid #a9c9e2; padding: 5px; color: #2e466b; }
div.divlbox div.divlcon2 { background-color: #e7f4fe; border-right: 1px solid #a9c9e2; border-bottom: 1px solid #a9c9e2; padding: 5px; color: #2e466b; }
div.divrbox { margin-left: 50%; }
div.divrbox div.divrcon1 { background-color: #f0f8fe; border-bottom: 1px solid #a9c9e2; padding: 5px; color: #2e466b; }
div.divrbox div.divrcon2 { background-color: #e7f4fe; border-bottom: 1px solid #a9c9e2; padding: 5px; color: #2e466b; }
</style>
<div id="divw">
	<div id="divnt1">系统信息概况</div>
	<div id="divnt2"><span class="bold"><?php echo Session::get('user/user_name'); ?></span> 您好, 欢迎进入FreeWMS后台管理.您上次登录记录: <?php echo date('Y-m-d H:i:s, T', Session::get('user/user_lastlogintime')); ?>,IP: <?php echo Session::get('user/user_lastloginip'); ?></div>
	<div id="divnt3">系统状态: <?php if(Config::get('site_state') == 1) echo '<span class="green">运行中</span>'; else echo '<span class="alert">已停止</span>'; ?>，当前版本为 FreeWMS <?php echo SYS_VERSION; ?>，数据库类型为&nbsp;<span class="alert"><?php echo strtoupper(DB_TYPE).' '.$db->version(); ?></span></div>
	<div id="divn">
		<div class="divlbox">
			<?php $os = explode(" ", php_uname());?>
			<div class="divlcon1">服务器操作系统: <?php echo $os[0];?> 内核版本<?php echo $os[2];?></div>
		</div>
		<div class="divrbox">
			<div class="divrcon1">Web服务器: <?php echo $_SERVER["SERVER_SOFTWARE"]; ?></div>
		</div>
	</div>
	<div style="clear: both;"></div>
	<div id="divn">
		<div class="divlbox">
			<div class="divlcon2">PHP引擎: <?php echo PHP_VERSION; ?>&nbsp;<a href="index.php?m=admin&amp;a=phpinfo" target="_blank" title="查看PHPINFO">查看phpinfo()</a></div>
		</div>
		<div class="divrbox">
			<div class="divrcon2">服务器名称 / IP: <?php echo $_SERVER["HTTP_HOST"];?> / <?php echo $_SERVER["LOCAL_ADDR"];?></div>
		</div>
	</div>
	<div style="clear: both;"></div>
	<div id="divn">
		<div class="divlbox">
			<div class="divlcon1">PHP运行模式: <?php echo strtoupper(php_sapi_name());?></div>
		</div>
		<div class="divrbox">
			<div class="divrcon1">图形处理 GD Library: <span class="alert"><?php echo (false !== function_exists('gd_info'))?'支持':'不支持'; ?></span></div>
		</div>
	</div>
	<div style="clear: both;"></div>
	<div id="divnt1">网站事务清单</div>
	<div id="divn">
		<div class="divlbox">
			<div style="border-right: 1px solid rgb(169, 201, 226); height: 163px; overflow: hidden; padding-left: 10px;" class="divlcon1">
				<form method="post" action="index.php?m=admin&amp;a=main" id="savenoteform" name="savenoteform">
					<textarea class="text" style="width:95%;" name="admin_note" cols="60" rows="9"><?php echo htmlspecialchars(file_get_contents(MOD_PATH.substr(md5(SAFETY_STRING.'adminnote'), 0, 12).'.txt')); ?></textarea>
					<br /><input type="submit" class="actionbtn pointer" value="保存便签" />
					<span style="display: none; padding-left: 5px;" id="savenotetip"></span>
				</form>
			</div>
		</div>
		<div class="divrbox">
			<div class="divrcon2">有<span class="alert bold"><?php echo $content_verify_count;?></span>条内容等待审核,<a href="#">进行审核&gt;&gt;</a></div>
			<div class="divrcon1">有<span class="alert bold"><?php echo $comment_verify_count;?></span>条网友评论正在等待审核,<a href="#">进行审核&gt;&gt;</a></div>
			<div class="divrcon2">有<span class="alert bold"><?php echo $content_draft_count;?></span>条草稿内容,<a href="#">继续完成&gt;&gt;</a></div>
			<div class="divrcon1">有<span class="alert bold"><?php echo $gb_verify_count;?></span>条网友留言正在等待审核,<a href="#">进行审核&gt;&gt;</a></div>
			<div class="divrcon2">有<span class="alert bold"><?php echo $gb_reply_count;?></span>条网友留言正在等待回复,<a href="#">进行回复&gt;&gt;</a></div>
			<div class="divrcon1">有<span class="alert bold"><?php echo $user_verify_count;?></span>个注册用户等待管理员认证,<a href="#">进行认证&gt;&gt;</a></div>
		</div>
	</div>
	<div style="clear: both;"></div>
	<div id="divnt1">FreeWMS项目组</div>
	<div id="divnt3"><span class="bold">使用及分发协议: </span> <a href="http://www.opensource.org/licenses/bsd-license.php" target="_blank" title="To see more about BSD license"><span class="bold">BSD Licenses</span></a></div>
	<div id="divnt4"><span class="bold">项目组成员: (排名不分先后, 按参与项目先后顺序)</span><br />刘思贤（大连东软-SOVO） 李阳（哈工大威海） 汪海平（大连东软-SOVO） 吴晨亮（大连东软-SOVO）<br />张法勇（大连东软-SOVO） 王科霖（大连东软-SOVO）</div>
	<div id="divnt3"><span class="bold">UI设计: </span> 董宇飞（哈尔滨维动网络科技有限公司） 修改：王雨薇（大连东软-SOVO）</div>
	<div id="divnt4"><span class="bold">特别感谢: </span> <a href="http://sovo.neusoft.edu.cn" title="大连东软信息学院 - SOVO" target="_blank">大连东软信息学院-SOVO系统运营管理部</a> <a href="http://www.wedong.com" title="哈尔滨维动网络科技有限公司" target="_blank">哈尔滨维动网络科技有限公司</a></div>
	<div style="border: 0pt none;" id="divnt3"><span class="bold">项目首页: </span><a href="http://code.google.com/p/freewms" title="项目首页" target="_blank">http://code.google.com/p/freewms</a> <span class="bold">联系邮箱:</span> <a href="mailto:starlight36@163.com" title="点击发送邮件联系我们">starlight36@163.com</a></div>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>