<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 后台设置管理页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">系统设置</div>
	<form id="save_edit" name="save_edit" method="post" action="index.php?m=admin&amp;a=config">
		<ul id="tabs">
			<li id="tab1" class="selecttab">
				<a href="javascript:void(0);" title="站点基本设置" onclick="SelectTab('tabcontent1','tab1');">站点基本设置</a>
			</li>
			<li id="tab2">
				<a href="javascript:void(0);" title="用户选项设置" onclick="SelectTab('tabcontent2','tab2');">用户选项设置</a>
			</li>
			<li id="tab3">
				<a href="javascript:void(0);" title="上传文件设置" onclick="SelectTab('tabcontent3','tab3');">上传文件设置</a>
			</li>
			<li id="tab4">
				<a href="javascript:void(0);" title="邮件发送设置" onclick="SelectTab('tabcontent4','tab4');">邮件发送设置</a>
			</li>
			<li id="tab5">
				<a href="javascript:void(0);" title="系统安全设置" onclick="SelectTab('tabcontent5','tab5');">系统安全设置</a>
			</li>
		</ul>
		<div id="tabcontent">
			<div id="tabcontent1" class="showtabcon" style="display: block;">
				<p><span class="left">站点名称:</span>
					<input type="text" class="text shorttext" name="config[site_name]" value="<?php echo htmlspecialchars(Config::get('site_name'));?>" />
					<?php echo Form::get_error('site_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">站点简介:</span>
					<input type="text" class="text normaltext" name="config[site_desc]" value="<?php echo htmlspecialchars(Config::get('site_desc'));?>" />
					<a class="tip" href="javascript:void(0)" title="站点简介, 这些文字将会出现在HTML头里面, 用于SEO">[?]</a>
					<?php echo Form::get_error('site_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">站点关键字:</span>
					<input type="text" class="text normaltext" name="config[site_keywords]" value="<?php echo htmlspecialchars(Config::get('site_keywords'));?>" />
					<a class="tip" href="javascript:void(0)" title="SEO使用, 多个请用半角逗号隔开">[?]</a>
					<?php echo Form::get_error('site_keywords', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">站点URL:</span>
					<input type="text" class="text normaltext" name="config[site_url]" value="<?php echo htmlspecialchars(Config::get('site_url'));?>" />
					<a class="tip" href="javascript:void(0)" title="站点URL根, 以http开头, /结尾">[?]</a>
					<?php echo Form::get_error('site_url', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">系统默认主题:</span>
					<select name="config[site_theme]">
					<?php
						//输出主题列表
						if($theme_list) {
							foreach($theme_list as $item) {
								echo '<option value="'.$item.'"';
								if($item == Config::get('site_theme')) {
									echo ' selected="selected"';
								}
								echo ">{$item}</option>\n";
							}
						}
					?>
					</select>
					<?php echo Form::get_error('site_theme', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">站点开放状态:</span>
					<label><input type="radio" name="config[site_state]" value="1"<?php if(Config::get('site_state') == '1') echo ' checked="checked"' ?> />开放</label>&nbsp;
					<label><input type="radio" name="config[site_state]" value="0"<?php if(Config::get('site_state') == '0') echo ' checked="checked"' ?> />关闭</label>
					<?php echo Form::get_error('site_state', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">页面缓存状态:</span>
					<label><input type="radio" name="config[site_page_cache]" value="1"<?php if(Config::get('site_page_cache') == '1') echo ' checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[site_page_cache]" value="0"<?php if(Config::get('site_page_cache') == '0') echo ' checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)" title="开启此项可以加快页面显示速度, 获得更高的负载量, 但是会造成一定的页面更新延时.">[?]</a>
					<?php echo Form::get_error('site_page_cache', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">静态文件扩展名:</span>
					<select name="config[site_staticize_extname]">
						<option value="html"<?php if(Config::get('site_staticize_extname') == 'html') echo ' selected="selected"' ?>>html</option>
						<option value="htm"<?php if(Config::get('site_staticize_extname') == 'htm') echo ' selected="selected"' ?>>htm</option>
						<option value="shtml"<?php if(Config::get('site_staticize_extname') == 'shtml') echo ' selected="selected"' ?>>shtml</option>
						<option value="shtm"<?php if(Config::get('site_staticize_extname') == 'shtm') echo ' selected="selected"' ?>>shtm</option>
						<option value="php"<?php if(Config::get('site_staticize_extname') == 'php') echo ' selected="selected"' ?>>php</option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('site_staticize_extname', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">首页静态生成:</span>
					<label><input type="radio" name="config[site_index_staticize]" value="1" <?php if(Config::get('site_index_staticize') == '1') echo 'checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[site_index_staticize]" value="0" <?php if(Config::get('site_index_staticize') == '0') echo 'checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('site_index_staticize', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">系统URL方案:</span>
					<select name="config[site_url_plan]">
						<option value="normal"<?php if(Config::get('site_url_plan') == 'normal') echo ' selected="selected"' ?>>查询字符串</option>
						<option value="php_path"<?php if(Config::get('site_url_plan') == 'php_path') echo ' selected="selected"' ?>>PHP路径</option>
						<option value="url_rewrite"<?php if(Config::get('site_url_plan') == 'url_rewrite') echo ' selected="selected"' ?>>URL伪静态</option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('site_url_plan', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
			<div id="tabcontent2" class="showtabcon" style="display: none;">
				<p><span class="left">游客默认用户组:</span>
					<select name="config[user_guest_gid]">
					<?php
						//输出用户组列表
						if($group_list != NULL) {
							foreach($group_list as $row) {
								echo '<option value="'.$row['group_id'].'"';
								if($row['group_id'] == Config::get('user_guest_gid')) {
									echo ' selected="selected"';
								}
								echo ">{$row['group_name']}</option>\n";
							}
						}
					?>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_guest_gid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">用户注册开关:</span>
					<label><input type="radio" name="config[user_reg]" value="1" <?php if(Config::get('user_reg') == '1') echo 'checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[user_reg]" value="0" <?php if(Config::get('user_reg') == '0') echo 'checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_reg', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">用户注册验证码:</span>
					<label><input type="radio" name="config[user_regvalidcode]" value="1" <?php if(Config::get('user_regvalidcode') == '1') echo 'checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[user_regvalidcode]" value="0" <?php if(Config::get('user_regvalidcode') == '0') echo 'checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_regvalidcode', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">用户注册邮件验证:</span>
					<label><input type="radio" name="config[user_emailvalid]" value="1" <?php if(Config::get('user_emailvalid') == '1') echo 'checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[user_emailvalid]" value="0" <?php if(Config::get('user_emailvalid') == '0') echo 'checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_emailvalid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">用户注册管理员验证:</span>
					<label><input type="radio" name="config[user_adminvalid]" value="1" <?php if(Config::get('user_adminvalid') == '1') echo 'checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[user_adminvalid]" value="0" <?php if(Config::get('user_adminvalid') == '0') echo 'checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_adminvalid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">新用户默认用户组:</span>
					<select name="config[user_default_gid]">
					<?php
						//输出用户组列表
						if($group_list != NULL) {
							foreach($group_list as $row) {
								echo '<option value="'.$row['group_id'].'"';
								if($row['group_id'] == Config::get('user_default_gid')) {
									echo ' selected="selected"';
								}
								echo ">{$row['group_name']}</option>\n";
							}
						}
					?>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_default_gid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">待审核/验证用户组:</span>
					<select name="config[user_unvalid_gid]">
					<?php
						//输出用户组列表
						if($group_list != NULL) {
							foreach($group_list as $row) {
								echo '<option value="'.$row['group_id'].'"';
								if($row['group_id'] == Config::get('user_unvalid_gid')) {
									echo ' selected="selected"';
								}
								echo ">{$row['group_name']}</option>\n";
							}
						}
					?>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_unvalid_gid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">用户名长度限制:</span>
					<input type="text" class="text shorttext" name="config[user_name_length]" value="<?php echo htmlspecialchars(Config::get('user_name_length'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_name_length', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">用户名限制列表:</span>
					<input type="text" class="text shorttext" name="config[user_name_denylist]" value="<?php echo htmlspecialchars(Config::get('user_name_denylist'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_name_denylist', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
			<div id="tabcontent3" class="showtabcon" style="display: none;">
				<p><span class="left">上传文件存储位置:</span>
					<input type="text" class="text shorttext" name="config[upload_save_path]" value="<?php echo htmlspecialchars(Config::get('upload_save_path'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('upload_save_path', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">上传文件访问根:</span>
					<input type="text" class="text shorttext" name="config[upload_url]" value="<?php echo htmlspecialchars(Config::get('upload_url'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('upload_url', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">上传文件限制(字节):</span>
					<input type="text" class="text shorttext" name="config[upload_size]" value="<?php echo htmlspecialchars(Config::get('upload_size'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('upload_size', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">上传文件扩展名:</span>
					<input type="text" class="text normaltext" name="config[upload_extname]" value="<?php echo htmlspecialchars(Config::get('upload_extname'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('upload_extname', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">是否生成图片缩略图:</span>
					<label><input type="radio" name="config[pic_thumb]" value="1" <?php if(Config::get('pic_thumb') == '1') echo 'checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[pic_thumb]" value="0" <?php if(Config::get('pic_thumb') == '0') echo 'checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_thumb', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">图片缩略图尺寸:</span>
					<input type="text" class="text shorttext" name="config[pic_thumb_size]" value="<?php echo htmlspecialchars(Config::get('pic_thumb_size'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_thumb_size', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">是否缩放大图片:</span>
					<label><input type="radio" name="config[pic_resize]" value="1" <?php if(Config::get('pic_resize') == '1') echo 'checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[pic_resize]" value="0" <?php if(Config::get('pic_resize') == '0') echo 'checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_resize', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">图片缩放尺寸:</span>
					<input type="text" class="text shorttext" name="config[pic_resize_size]" value="<?php echo htmlspecialchars(Config::get('pic_resize_size'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_resize_size', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">是否缩给图片加水印:</span>
					<label><input type="radio" name="config[pic_watermark]" value="1" <?php if(Config::get('pic_watermark') == '1') echo 'checked="checked"' ?> />开启</label>&nbsp;
					<label><input type="radio" name="config[pic_watermark]" value="0" <?php if(Config::get('pic_watermark') == '0') echo 'checked="checked"' ?> />关闭</label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">加水印最小尺寸:</span>
					<input type="text" class="text shorttext" name="config[pic_watermark_size]" value="<?php echo htmlspecialchars(Config::get('pic_watermark_size'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark_size', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">水印图片路径:</span>
					<input type="text" class="text shorttext" name="config[pic_watermark_path]" value="<?php echo htmlspecialchars(Config::get('pic_watermark_path'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark_path', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">水印图片透明度:</span>
					<input type="text" class="text shorttext" name="config[pic_watermark_pct]" value="<?php echo htmlspecialchars(Config::get('pic_watermark_pct'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark_pct', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">水印图片位置:</span>
					<select name="config[pic_watermark_postion]">
						<option value="0"<?php if(Config::get('pic_watermark_postion') == '0') echo ' selected="selected"' ?>>右下</option>
						<option value="1"<?php if(Config::get('pic_watermark_postion') == '1') echo ' selected="selected"' ?>>左上</option>
						<option value="2"<?php if(Config::get('pic_watermark_postion') == '2') echo ' selected="selected"' ?>>左下</option>
						<option value="3"<?php if(Config::get('pic_watermark_postion') == '3') echo ' selected="selected"' ?>>右上</option>
						<option value="4"<?php if(Config::get('pic_watermark_postion') == '4') echo ' selected="selected"' ?>>居中</option>
						<option value="r"<?php if(Config::get('pic_watermark_postion') == 'r') echo ' selected="selected"' ?>>随机</option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark_postion', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
			<div id="tabcontent4" class="showtabcon" style="display: none;">
				<p><span class="left">邮件发送组件:</span>
					<select name="config[mail_lib]">
						<option value="none"<?php if(Config::get('mail_lib') == 'none') echo ' selected="selected"' ?>>关闭邮件发送</option>
						<option value="socket"<?php if(Config::get('mail_lib') == 'socket') echo ' selected="selected"' ?>>Socket SMTP</option>
						<option value="mail"<?php if(Config::get('mail_lib') == 'mail') echo ' selected="selected"' ?>>mail函数</option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_lib', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">SMTP邮箱帐号:</span>
					<input type="text" class="text shorttext" name="config[mail_account]" value="<?php echo htmlspecialchars(Config::get('mail_account'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_account', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">SMTP服务器:</span>
					<input type="text" class="text shorttext" name="config[mail_smtp_host]" value="<?php echo htmlspecialchars(Config::get('mail_smtp_host'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_smtp_host', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">SMTP端口:</span>
					<input type="text" class="text shorttext" name="config[mail_smtp_port]" value="<?php echo htmlspecialchars(Config::get('mail_smtp_port'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_smtp_port', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">SMTP登录用户名:</span>
					<input type="text" class="text shorttext" name="config[mail_smtp_user]" value="<?php echo htmlspecialchars(Config::get('mail_smtp_user'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_smtp_user', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">SMTP登录密码:</span>
					<input type="text" class="text shorttext" name="config[mail_smtp_pass]" value="<?php echo htmlspecialchars(Config::get('mail_smtp_pass'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_smtp_pass', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
			<div id="tabcontent5" class="showtabcon" style="display: none;">
				<p><span class="left">敏感字处理方案:</span>
					<select name="config[safe_wordfilt_plan]">
						<option value="0"<?php if(Config::get('safe_wordfilt_plan') == '0') echo ' selected="selected"' ?>>不处理</option>
						<option value="1"<?php if(Config::get('safe_wordfilt_plan') == '1') echo ' selected="selected"' ?>>替换为星号</option>
						<option value="2"<?php if(Config::get('safe_wordfilt_plan') == '2') echo ' selected="selected"' ?>>设为待审</option>
						<option value="3"<?php if(Config::get('safe_wordfilt_plan') == '3') echo ' selected="selected"' ?>>拒绝提交</option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_lib', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">非法文字过滤列表:</span>
					<textarea class="normaltextarea" name="config[safe_denyword]"><?php echo htmlspecialchars(Config::get('safe_denyword'));?></textarea>
					<?php echo Form::get_error('safe_denyword', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">用户登录/注册屏蔽IP:</span>
					<textarea class="normaltextarea" name="config[safe_denyip]"><?php echo htmlspecialchars(Config::get('safe_denyip'));?></textarea>
					<?php echo Form::get_error('safe_denyip', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="保存编辑">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重新编辑">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>