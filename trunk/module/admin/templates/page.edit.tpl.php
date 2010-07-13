<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 自定义页编辑页模板
 */

?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_page_new_tip');?>
	</div>
	<form action="index.php?m=admin&amp;a=page&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_page_id_tip');?>: </span>
					<span class="green bold"><?php if(!$id) {echo Lang::_('admin_page_id_title');}else{ echo $id;} ?></span>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_page_name_tip');?>: </span>
				  <input type="text" class="text shorttext" name="page_name" value="<?php echo Form::set_value('page_name', $pinfo['page_name']);?>" />
				  <?php echo Form::get_error('page_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_page_key_tip');?>: </span>
					<input type="text" class="text shorttext" name="page_key" value="<?php echo Form::set_value('page_key', $pinfo['page_key']);?>" />
					<?php echo Form::get_error('page_key', '<span class="fielderrormsg">', '</span>');?>
                </p>
				<p><span class="left"><?php echo Lang::_('admin_page_keyword_tip');?>: </span>
					<input type="text" class="text normaltext" name="page_keyword" value="<?php echo Form::set_value('page_keyword', $pinfo['page_keyword']);?>" />
					<?php echo Form::get_error('page_keyword', '<span class="fielderrormsg">', '</span>');?>
                </p>
				<p><span class="left"><?php echo Lang::_('admin_page_desc_tip');?>: </span>
					<input type="text" class="text normaltext" name="page_desc" value="<?php echo Form::set_value('page_desc', $pinfo['page_desc']);?>" />
					<?php echo Form::get_error('page_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
                <p><span class="left"><?php echo Lang::_('admin_page_template_tip');?>: </span>
					<input type="text" class="text shorttext" name="page_template" value="<?php echo Form::set_value('page_template', $pinfo['page_template']);?>" />
					<?php echo Form::get_error('page_template', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p id="guide_bypage" style="display: none;"><span class="left"><?php echo Lang::_('admin_page_turn_tip');?>: </span>
					<select id="page_id" style="width: 158px;" onchange="$('#topbar_bindid').val($(this).val());">
						<option><?php echo Lang::_('admin_page_select_tip');?></option>
						<?php foreach($page_select_tree as $row): ?>
						<option value="<?php echo $row['page_id']; ?>"><?php echo $row['page_name']; ?></option>
						<?php endforeach;?>
					</select>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_page_static_tip');?>: </span>
				    <label><input type="radio" name="page_static" value="0"<?php if(Form::set_value('page_static', $pinfo['page_static']) == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_page_static_no_tip');?></label>
					<label><input type="radio" name="page_static" value="1"<?php if(Form::set_value('page_static', $pinfo['page_static']) == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_page_static_yes_tip');?></label>
					<?php echo Form::get_error('page_static', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_page_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_page_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>