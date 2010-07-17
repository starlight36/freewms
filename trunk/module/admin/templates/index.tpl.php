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
			<li><a href="index.php?m=admin&amp;a=main" title="<?php echo Lang::_('admin_show_main_page_title');?>"><?php echo Lang::_('admin_show_main_page_tip');?></a></li>
			<li><a href="index.php?m=admin&amp;a=config" title="<?php echo Lang::_('admin_sys_set_title');?>"><?php echo Lang::_('admin_sys_set_tip');?></a></li>
			<li><a href="index.php?m=admin&amp;a=comment" title="<?php echo Lang::_('admin_comment_title');?>"><?php echo Lang::_('admin_comment_title');?></a></li>
			<li><a href="index.php?m=admin&amp;a=guestbook" title="<?php echo Lang::_('admin_guestbook_title');?>"><?php echo Lang::_('admin_guestbook_tip');?></a></li>
			<li><a href="index.php?m=admin&amp;a=create&amp;do=index" title="<?php echo Lang::_('admin_generated_page_title');?>"><?php echo Lang::_('admin_generated_page_tip');?></a></li>
			<li><a href="index.php" title="<?php echo Lang::_('admin_front_page_title');?>" target="_blank"><?php echo Lang::_('admin_front_page_tip');?></a></li>
			<li><a href="index.php?m=admin&amp;a=logout" title="<?php echo Lang::_('admin_exit_index_title');?>" target="_self"><?php echo Lang::_('admin_exit_index_tip');?></a></li>
		</ul>
	  </div>
		<div id="topmsg" style="display: none;"><img src="<?php echo Url::base();?>module/admin/images/loading.gif" alt="Loading" align="absmiddle"/><?php echo Lang::_('admin_load_tip');?></div>
	</div>
</div>
<div id="leftframe">
	<div id="menu">
		<div id="menuall">
			<div id="leftmenu" class="sdmenu">
				<div class="collapsed">
					<span class="content"><?php echo Lang::_('admin_content_tip');?></span>
					<a onclick="return false;" title="<?php echo Lang::_('admin_release_content_title');?>" style="padding-left: 10px;">
						<select onchange="window.main.location.href='index.php?m=admin&a=content&do=save&cid='+this.value;" style="width:140px">
							<option value="main" id="df_main" selected="selected" disabled="disabled"><?php echo Lang::_('admin_select_content_tip');?></option>
							<?php echo $cate_select_tree; ?>
						</select>
					</a>
					<a href="index.php?m=admin&amp;a=content&amp;state=0" title=""><?php echo Lang::_('admin_all_content_tip');?></a>
					<a href="index.php?m=admin&amp;a=content&amp;state=1" title=""><?php echo Lang::_('admin_review_content_tip');?></a>
					<a href="index.php?m=admin&amp;a=category" title=""><?php echo Lang::_('admin_classify_content_tip');?></a>
					<a href="index.php?m=admin&amp;a=subject" title=""><?php echo Lang::_('admin_sub_content_tip');?></a>
					<a href="index.php?m=admin&amp;a=recommend" title=""><?php echo Lang::_('admin_recommend_content_tip');?></a>
					<a href="index.php?m=admin&amp;a=content&amp;state=3" title=""><?php echo Lang::_('admin_draft_box_tip');?></a>
					<a href="index.php?m=admin&amp;a=content&amp;state=4" title=""><?php echo Lang::_('admin_recycle_tip');?></a>
				</div>
				<div class="collapsed">
					<span class="comment"><?php echo Lang::_('admin_comment_tip');?></span>
					<a href="index.php?m=admin&amp;a=comment" title=""><?php echo Lang::_('admin_content_comment_tip');?></a>
					<a href="index.php?m=admin&amp;a=comment&amp;state=1" title=""><?php echo Lang::_('admin_comment_moderation_tip');?></a>
					<a href="index.php?m=admin&amp;a=guestbook" title=""><?php echo Lang::_('admin_user_message_tip');?></a>
					<a href="index.php?m=admin&amp;a=guestbook&amp;state=1" title=""><?php echo Lang::_('admin_message_audit_tip');?></a>
				</div>
				<div class="collapsed">
					<span class="create"><?php echo Lang::_('admin_static_formation_tip');?></span>
					<a href="index.php?m=admin&amp;a=create&amp;do=index" title=""><?php echo Lang::_('admin_static_page_tip');?></a>
					<a href="index.php?m=admin&amp;a=create&amp;do=category" title=""><?php echo Lang::_('admin_classify_page_tip');?></a>
					<a href="index.php?m=admin&amp;a=create&amp;do=view" title=""><?php echo Lang::_('admin_content_page_tip');?></a>
					<a href="index.php?m=admin&amp;a=create&amp;do=page" title=""><?php echo Lang::_('admin_page_tip');?></a>
				</div>
				<div class="collapsed">
					<span class="user"><?php echo Lang::_('admin_user_center_tip');?></span>
					<a href="#" title=""><?php echo Lang::_('admin_all_user_tip');?></a>
					<a href="#" title=""><?php echo Lang::_('admin_user_audit_tip');?></a>
					<a href="index.php?m=admin&amp;a=usergroup" title=""><?php echo Lang::_('admin_user_group_tip');?></a>
					<a href="#" title=""><?php echo Lang::_('admin_admin_tip');?></a>
				</div>
				<div class="collapsed">
					<span class="theme"><?php echo Lang::_('admin_interface_tip');?></span>
					<a href="index.php?m=admin&amp;a=theme" title=""><?php echo Lang::_('admin_theme_templates_tip');?></a>
					<a href="index.php?m=admin&amp;a=topbar" title=""><?php echo Lang::_('admin_site_nav_tip');?></a>
					<a href="index.php?m=admin&amp;a=page" title=""><?php echo Lang::_('admin_costom_page_tip');?></a>
					<a href="index.php?m=admin&amp;a=widget" title=""><?php echo Lang::_('admin_widget_tip');?></a>
				</div>
				<div class="collapsed">
					<span class="sys"><?php echo Lang::_('admin_sys_center_tip');?></span>
					<a href="index.php?m=admin&amp;a=config" title=""><?php echo Lang::_('admin_survey_set_tip');?></a>
					<a href="index.php?m=admin&amp;a=module" title=""><?php echo Lang::_('admin_content_model_tip');?></a>
					<a href="index.php?m=admin&amp;a=upload" title=""><?php echo Lang::_('admin_upload_tip');?></a>
					<a href="#" title=""><?php echo Lang::_('admin_vote_tip');?></a>
					<a href="index.php?m=admin&amp;a=link" title=""><?php echo Lang::_('admin_links_tip');?></a>
					<a href="#" title=""><?php echo Lang::_('admin_URL_tip');?></a>
					<a href="index.php?m=admin&amp;a=cache" title=""><?php echo Lang::_('admin_rebuild_cache_tip');?></a>
				</div>
				<div class="collapsed">
					<span class="data"><?php echo Lang::_('admin_dm_tip');?></span>
					<a href="#" title=""><?php echo Lang::_('admin_backup_tip');?></a>
					<a href="#" title=""><?php echo Lang::_('admin_resture_tip');?></a>
					<a href="#" title=""><?php echo Lang::_('admin_db_optimized_tip');?></a>
					<a href="#" title=""><?php echo Lang::_('admin_SQL_tip');?></a>
				</div>
				<div class="collapsed">
					<span class="support"><?php echo Lang::_('admin_support_help_tip');?></span>
					<a href="#" title="<?php echo Lang::_('admin_user_reference_title');?>"><?php echo Lang::_('admin_user_reference_tip');?></a>
					<a href="#" title="<?php echo Lang::_('admin_agreement_title');?>"><?php echo Lang::_('admin_agreement_tip');?></a>
					<a href="#" title="<?php echo Lang::_('admin_service_title');?>"><?php echo Lang::_('admin_service_tip');?></a>
					<a href="http://code.google.com/p/freewms/" target="_blank" title="<?php echo Lang::_('admin_pro_team_index_title');?>"><?php echo Lang::_('admin_pro_team_tip');?></a>
					<a href="http://www.wedong.com" target="_blank" title="<?php echo Lang::_('admin_get_network_title');?>"><?php echo Lang::_('admin_network_tip');?></a>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="mainframe">
	<iframe frameborder="0" scrolling="auto" name="main" style="height:100%;width:100%;position:absolute;left:0;_left:185px;" src="<?php echo URL::base(); ?>index.php?m=admin&amp;a=main"></iframe>
</div>
</body>
</html>
