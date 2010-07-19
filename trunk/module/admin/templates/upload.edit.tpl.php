<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 上传文件编辑页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar"><?php echo Lang::_('admin_upload_new_tip');?></div>
  <form action="index.php?m=admin&amp;a=upload&amp;do=edit" method="post" enctype="multipart/form-data">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_upload_file_1_tip');?>:</span><input name="file[]" type="file" /></p>
				<p><span class="left"><?php echo Lang::_('admin_upload_file_2_tip');?>:</span><input name="file[]" type="file" /></p>
				<p><span class="left"><?php echo Lang::_('admin_upload_file_3_tip');?>:</span><input name="file[]" type="file" /></p>
				<p><span class="left"><?php echo Lang::_('admin_upload_file_4_tip');?>:</span><input name="file[]" type="file" /></p>
				<p><span class="left"><?php echo Lang::_('admin_upload_file_5_tip');?>: </span><input name="file[]" type="file" /></p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_upload_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_upload_reset_tip');?>">
		</div>
  </form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>