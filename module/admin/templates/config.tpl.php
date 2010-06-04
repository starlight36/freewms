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
	<div class="titlebar"><?php echo Lang::_('admin_sys_set_tip');?></div>
	<form id="save_edit" name="save_edit" method="post" action="index.php?m=admin&amp;a=config">
		<ul id="tabs">
			<li id="tab1" class="selecttab">
				<a href="javascript:void(0);" title="<?php echo Lang::_('admin_site_set_title');?>" onclick="SelectTab('tabcontent1','tab1');"><?php echo Lang::_('admin_site_set_tip');?></a>
			</li>
			<li id="tab2">
				<a href="javascript:void(0);" title="<?php echo Lang::_('admin_user_option_set_title');?>" onclick="SelectTab('tabcontent2','tab2');"><?php echo Lang::_('admin_user_option_set_tip');?></a>
			</li>
			<li id="tab3">
				<a href="javascript:void(0);" title="<?php echo Lang::_('admin_upload_set_title');?>" onclick="SelectTab('tabcontent3','tab3');"><?php echo Lang::_('admin_upload_set_tip');?></a>
			</li>
			<li id="tab4">
				<a href="javascript:void(0);" title="<?php echo Lang::_('admin_email_set_title');?>" onclick="SelectTab('tabcontent4','tab4');"><?php echo Lang::_('admin_email_set_tip');?></a>
			</li>
			<li id="tab5">
				<a href="javascript:void(0);" title="<?php echo Lang::_('admin_sys_security_set_title');?>" onclick="SelectTab('tabcontent5','tab5');"><?php echo Lang::_('admin_sys_security_set_tip');?></a>
			</li>
		</ul>
		<div id="tabcontent">
			<div id="tabcontent1" class="showtabcon" style="display: block;">
				<p><span class="left"><?php echo Lang::_('admin_site_name_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[site_name]" value="<?php echo htmlspecialchars(Config::get('site_name'));?>" />
					<?php echo Form::get_error('site_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_site_profile_tip');?>:</span>
					<input type="text" class="text normaltext" name="config[site_desc]" value="<?php echo htmlspecialchars(Config::get('site_desc'));?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_site_profile_title');?>">[?]</a>
					<?php echo Form::get_error('site_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_site_keywords_tip');?>:</span>
					<input type="text" class="text normaltext" name="config[site_keywords]" value="<?php echo htmlspecialchars(Config::get('site_keywords'));?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_site_keywords_title');?>">[?]</a>
					<?php echo Form::get_error('site_keywords', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_site_URL_tip');?>:</span>
					<input type="text" class="text normaltext" name="config[site_url]" value="<?php echo htmlspecialchars(Config::get('site_url'));?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_site_URL_title');?>">[?]</a>
					<?php echo Form::get_error('site_url', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_sys_default_theme_tip');?>:</span>
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
				<p><span class="left"><?php echo Lang::_('admin_site_state_tip');?>:</span>
					<label><input type="radio" name="config[site_state]" value="1"<?php if(Config::get('site_state') == '1') echo ' checked="checked"' ?> /><?php echo Lang::_('admin_site_state_yes');?></label>&nbsp;
					<label><input type="radio" name="config[site_state]" value="0"<?php if(Config::get('site_state') == '0') echo ' checked="checked"' ?> /><?php echo Lang::_('admin_site_state_no');?></label>
					<?php echo Form::get_error('site_state', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_site_page_cache_tip');?>:</span>
					<label><input type="radio" name="config[site_page_cache]" value="1"<?php if(Config::get('site_page_cache') == '1') echo ' checked="checked"' ?> /><?php echo Lang::_('admin_site_page_cache_yse');?></label>&nbsp;
					<label><input type="radio" name="config[site_page_cache]" value="0"<?php if(Config::get('site_page_cache') == '0') echo ' checked="checked"' ?> /><?php echo Lang::_('admin_site_page_cache_no');?></label>
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_site_page_cache_title');?>">[?]</a>
					<?php echo Form::get_error('site_page_cache', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_site_staticize_extname_tip');?>:</span>
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
				<p><span class="left"><?php echo Lang::_('admin_site_index_staticize_tip');?>:</span>
					<label><input type="radio" name="config[site_index_staticize]" value="1" <?php if(Config::get('site_index_staticize') == '1') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_site_index_staticize_yse');?></label>&nbsp;
					<label><input type="radio" name="config[site_index_staticize]" value="0" <?php if(Config::get('site_index_staticize') == '0') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_site_index_staticize_no');?></label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('site_index_staticize', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_site_url_plan_tip');?>:</span>
					<select name="config[site_url_plan]">
						<option value="normal"<?php if(Config::get('site_url_plan') == 'normal') echo ' selected="selected"' ?>><?php echo Lang::_('admin_site_url_plan_normal');?></option>
						<option value="path"<?php if(Config::get('site_url_plan') == 'path') echo ' selected="selected"' ?>><?php echo Lang::_('admin_site_url_plan_php_path');?></option>
						<option value="rewrite"<?php if(Config::get('site_url_plan') == 'rewrite') echo ' selected="selected"' ?>><?php echo Lang::_('admin_site_url_plan_url_rewrite');?></option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('site_url_plan', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
			<div id="tabcontent2" class="showtabcon" style="display: none;">
				<p><span class="left"><?php echo Lang::_('admin_user_guest_gid_tip');?>:</span>
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
				<p><span class="left"><?php echo Lang::_('admin_user_reg_tip');?>:</span>
					<label><input type="radio" name="config[user_reg]" value="1" <?php if(Config::get('user_reg') == '1') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_user_reg_yes');?></label>&nbsp;
					<label><input type="radio" name="config[user_reg]" value="0" <?php if(Config::get('user_reg') == '0') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_user_reg_no');?></label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_reg', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_user_regvalidcode_tip');?>:</span>
					<label><input type="radio" name="config[user_regvalidcode]" value="1" <?php if(Config::get('user_regvalidcode') == '1') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_user_regvalidcode_yes');?></label>&nbsp;
					<label><input type="radio" name="config[user_regvalidcode]" value="0" <?php if(Config::get('user_regvalidcode') == '0') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_user_regvalidcode_no');?></label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_regvalidcode', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_user_emailvalid_tip');?>:</span>
					<label><input type="radio" name="config[user_emailvalid]" value="1" <?php if(Config::get('user_emailvalid') == '1') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_user_emailvalid_yes');?></label>&nbsp;
					<label><input type="radio" name="config[user_emailvalid]" value="0" <?php if(Config::get('user_emailvalid') == '0') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_user_emailvalid_no');?></label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_emailvalid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_user_adminvalid_tip');?>:</span>
					<label><input type="radio" name="config[user_adminvalid]" value="1" <?php if(Config::get('user_adminvalid') == '1') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_user_adminvalid_yes');?></label>&nbsp;
					<label><input type="radio" name="config[user_adminvalid]" value="0" <?php if(Config::get('user_adminvalid') == '0') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_user_adminvalid_no');?></label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_adminvalid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_user_default_gid_tip');?>:</span>
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
				<p><span class="left"><?php echo Lang::_('admin_user_unvalid_gid_tip');?>:</span>
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
				<p><span class="left"><?php echo Lang::_('admin_user_name_length_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[user_name_length]" value="<?php echo htmlspecialchars(Config::get('user_name_length'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_name_length', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_user_name_denylist_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[user_name_denylist]" value="<?php echo htmlspecialchars(Config::get('user_name_denylist'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('user_name_denylist', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
			<div id="tabcontent3" class="showtabcon" style="display: none;">
				<p><span class="left"><?php echo Lang::_('admin_upload_save_path_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[upload_save_path]" value="<?php echo htmlspecialchars(Config::get('upload_save_path'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('upload_save_path', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_upload_url_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[upload_url]" value="<?php echo htmlspecialchars(Config::get('upload_url'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('upload_url', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_upload_size_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[upload_size]" value="<?php echo htmlspecialchars(Config::get('upload_size'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('upload_size', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_upload_extname_tip');?>:</span>
					<input type="text" class="text normaltext" name="config[upload_extname]" value="<?php echo htmlspecialchars(Config::get('upload_extname'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('upload_extname', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_thumb_tip');?>:</span>
					<label><input type="radio" name="config[pic_thumb]" value="1" <?php if(Config::get('pic_thumb') == '1') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_pic_thumb_yes');?></label>&nbsp;
					<label><input type="radio" name="config[pic_thumb]" value="0" <?php if(Config::get('pic_thumb') == '0') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_pic_thumb_no');?></label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_thumb', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_thumb_size_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[pic_thumb_size]" value="<?php echo htmlspecialchars(Config::get('pic_thumb_size'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_thumb_size', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_resize_tip');?>:</span>
					<label><input type="radio" name="config[pic_resize]" value="1" <?php if(Config::get('pic_resize') == '1') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_pic_resize_yes');?></label>&nbsp;
					<label><input type="radio" name="config[pic_resize]" value="0" <?php if(Config::get('pic_resize') == '0') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_pic_resize_no');?></label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_resize', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_resize_size_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[pic_resize_size]" value="<?php echo htmlspecialchars(Config::get('pic_resize_size'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_resize_size', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_watermark_tip');?>:</span>
					<label><input type="radio" name="config[pic_watermark]" value="1" <?php if(Config::get('pic_watermark') == '1') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_pic_watermark_yes');?></label>&nbsp;
					<label><input type="radio" name="config[pic_watermark]" value="0" <?php if(Config::get('pic_watermark') == '0') echo 'checked="checked"' ?> /><?php echo Lang::_('admin_pic_watermark_no');?></label>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_watermark_size_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[pic_watermark_size]" value="<?php echo htmlspecialchars(Config::get('pic_watermark_size'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark_size', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_watermark_path_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[pic_watermark_path]" value="<?php echo htmlspecialchars(Config::get('pic_watermark_path'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark_path', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_watermark_pct_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[pic_watermark_pct]" value="<?php echo htmlspecialchars(Config::get('pic_watermark_pct'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark_pct', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_pic_watermark_postion_tip');?>:</span>
					<select name="config[pic_watermark_postion]">
						<option value="0"<?php if(Config::get('pic_watermark_postion') == '0') echo ' selected="selected"' ?>><?php echo Lang::_('admin_pic_watermark_postion_0');?></option>
						<option value="1"<?php if(Config::get('pic_watermark_postion') == '1') echo ' selected="selected"' ?>><?php echo Lang::_('admin_pic_watermark_postion_1');?></option>
						<option value="2"<?php if(Config::get('pic_watermark_postion') == '2') echo ' selected="selected"' ?>><?php echo Lang::_('admin_pic_watermark_postion_2');?></option>
						<option value="3"<?php if(Config::get('pic_watermark_postion') == '3') echo ' selected="selected"' ?>><?php echo Lang::_('admin_pic_watermark_postion_3');?></option>
						<option value="4"<?php if(Config::get('pic_watermark_postion') == '4') echo ' selected="selected"' ?>><?php echo Lang::_('admin_pic_watermark_postion_4');?></option>
						<option value="r"<?php if(Config::get('pic_watermark_postion') == 'r') echo ' selected="selected"' ?>><?php echo Lang::_('admin_pic_watermark_postion_r');?></option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('pic_watermark_postion', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
			<div id="tabcontent4" class="showtabcon" style="display: none;">
				<p><span class="left"><?php echo Lang::_('admin_mail_lib_tip');?>:</span>
					<select name="config[mail_lib]">
						<option value="none"<?php if(Config::get('mail_lib') == 'none') echo ' selected="selected"' ?>><?php echo Lang::_('admin_mail_lib_none');?></option>
						<option value="socket"<?php if(Config::get('mail_lib') == 'socket') echo ' selected="selected"' ?>><?php echo Lang::_('admin_mail_lib_socket');?></option>
						<option value="mail"<?php if(Config::get('mail_lib') == 'mail') echo ' selected="selected"' ?>><?php echo Lang::_('admin_mail_lib_mail');?></option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_lib', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mail_account_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[mail_account]" value="<?php echo htmlspecialchars(Config::get('mail_account'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_account', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mail_smtp_host_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[mail_smtp_host]" value="<?php echo htmlspecialchars(Config::get('mail_smtp_host'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_smtp_host', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mail_smtp_port_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[mail_smtp_port]" value="<?php echo htmlspecialchars(Config::get('mail_smtp_port'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_smtp_port', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mail_smtp_user_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[mail_smtp_user]" value="<?php echo htmlspecialchars(Config::get('mail_smtp_user'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_smtp_user', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_mail_smtp_pass_tip');?>:</span>
					<input type="text" class="text shorttext" name="config[mail_smtp_pass]" value="<?php echo htmlspecialchars(Config::get('mail_smtp_pass'));?>" />
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_smtp_pass', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
			<div id="tabcontent5" class="showtabcon" style="display: none;">
				<p><span class="left"><?php echo Lang::_('admin_safe_wordfilt_plan_tip');?>:</span>
					<select name="config[safe_wordfilt_plan]">
						<option value="0"<?php if(Config::get('safe_wordfilt_plan') == '0') echo ' selected="selected"' ?>><?php echo Lang::_('admin_safe_wordfilt_plan_0');?></option>
						<option value="1"<?php if(Config::get('safe_wordfilt_plan') == '1') echo ' selected="selected"' ?>><?php echo Lang::_('admin_safe_wordfilt_plan_1');?></option>
						<option value="2"<?php if(Config::get('safe_wordfilt_plan') == '2') echo ' selected="selected"' ?>><?php echo Lang::_('admin_safe_wordfilt_plan_2');?></option>
						<option value="3"<?php if(Config::get('safe_wordfilt_plan') == '3') echo ' selected="selected"' ?>><?php echo Lang::_('admin_safe_wordfilt_plan_3');?></option>
					</select>
					<a class="tip" href="javascript:void(0)">[?]</a>
					<?php echo Form::get_error('mail_lib', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_safe_denyword_tip');?>:</span>
					<textarea class="normaltextarea" name="config[safe_denyword]"><?php echo htmlspecialchars(Config::get('safe_denyword'));?></textarea>
					<?php echo Form::get_error('safe_denyword', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_safe_denyip_tip');?>:</span>
					<textarea class="normaltextarea" name="config[safe_denyip]"><?php echo htmlspecialchars(Config::get('safe_denyip'));?></textarea>
					<?php echo Form::get_error('safe_denyip', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_submit_title');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_reset_title');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>