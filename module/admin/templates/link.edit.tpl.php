<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 友情链接编辑页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_link_edit_1_tip');?>
	</div>
	<form action="index.php?m=admin&amp;a=link&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_link_num_tip');?>: </span>
					<span class="green bold"><?php if(!$id) {
						echo  Lang::_('admin_link_add_tip');
						}else { 
						echo $id;
						} ?></span>

				</p>
				<p><span class="left"><?php echo Lang::_('admin_link_title_tip');?>: </span>
				<input type="text" class="text normaltext" name="link_title" value="<?php echo Form::set_value('link_title', $linkinfo['link_title']);?>" />
					<?php echo Form::get_error('link_title', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_link_desc_tip');?>: </span>
				<input type="text" class="text normaltext" name="link_desc" value="<?php echo Form::set_value('link_desc', $linkinfo['link_desc']);?>" />
					<?php echo Form::get_error('link_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_link_url_tip');?>: </span>
				<input type="text" class="text normaltext" name="link_url" value="<?php echo Form::set_value('link_url', $linkinfo['link_url']);?>" />
					<?php echo Form::get_error('link_url', '<span class="fielderrormsg">', '</span>');?>
				</p>
                <p><span class="left"><?php echo Lang::_('admin_link_img_tip');?>: </span>
				<input type="text" class="text normaltext" name="link_img" value="<?php echo Form::set_value('link_img', $linkinfo['link_img']);?>" />
					<?php echo Form::get_error('link_img', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_link_isdisplay_tip');?>: </span>
				  <label><input type="radio" name="link_isdisplay" value="1"<?php if(Form::set_value('link_isdisplay', $linkinfo['link_isdisplay']) == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_link_isdisplay_yes');?></label>
					<label><input type="radio" name="link_isdisplay" value="0"<?php if(Form::set_value('link_isdisplay', $linkinfo['link_isdisplay']) == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_link_isdisplay_no');?></label>
			  </p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_link_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_link_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>