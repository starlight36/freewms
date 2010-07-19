<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 用户编辑页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		 <?php echo Lang::_('admin_user_modify_tip');?>
	</div>
	<form action="index.php?m=admin&amp;a=user&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_user_id_tip');?>: </span>
					<span class="green bold"><?php
					if(!$id) {
						echo Lang::_('admin_user_add_tip');
						$uinfo['user_groupid'] = Config::get('user_default_gid');

						}else { echo $id;} ?></span>
				</p>
<p><span class="left"><?php echo Lang::_('admin_user_name_tip');?>: </span>
					<?php if(!$id):?>
						<input type="text" class="text shorttext" name="user_name" value="<?php echo Form::set_value('user_name', $uinfo['user_name']);?>" />
						<p><?php echo Form::get_error('user_name', '<span class="fielderrormsg">', '</span>');?></p>
					<?php
					else:
						echo $uinfo['user_name'];
					?>
						<input type="hidden" name="user_name" value="<?php echo $uinfo['user_name'];?>"/>
					<?php endif?>
                <p><span class="left"><?php echo Lang::_('admin_user_groupid_tip');?>: </span>
					<select name="user_groupid">
					<?php foreach ($glist as $row): ?>
					<option value="<? echo $row['group_id']?>" <?php if(Form::set_value('user_gender', $uinfo['user_groupid']) == $row['group_id']){ echo "selected=\"selected\"";}?>>&nbsp;<?php echo $row['group_name']; ?></option>
					<?php endforeach; ?>
					</select>
                </p>
		    	<p><span class="left"><?php echo Lang::_('admin_user_pass_tip');?>: </span>
					<input type="password" class="text normaltext" name="user_pass" />
				<?php echo Form::get_error('user_pass', '<span class="fielderrormsg">', '</span>');?>
			  	</p>
                <p><span class="left"><?php echo Lang::_('admin_user_pass2_tip');?>: </span>
					<input type="password" class="text normaltext" name="user_pass2" />
				<?php echo Form::get_error('user_pass2', '<span class="fielderrormsg">', '</span>');?>
			  	</p>
                <p><span class="left"><?php echo Lang::_('admin_user_nickname_tip');?>: </span>
					<input type="txt" class="text normaltext" name="user_nickname" value="<?php echo Form::set_value('user_nickname', $userinfo['user_nickname']);?>" />
				<?php echo Form::get_error('user_nickname', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left"><?php echo Lang::_('admin_user_gender_tip');?>: </span>
					<label><input type="radio" name="user_gender" value="0"<?php if(Form::set_value('user_gender', $uinfo['user_gender']) == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_gender_m');?></label>
					<label><input type="radio" name="user_gender" value="1"<?php if(Form::set_value('user_gender', $uinfo['user_gender']) == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_gender_f');?></label>
                </p>
			  	<p><span class="left"><?php echo Lang::_('admin_user_email_tip');?>: </span>
					<input type="txt" class="text normaltext" name="user_email" value="<?php echo Form::set_value('user_email', $uinfo['user_email']);?>" />
				<?php echo Form::get_error('user_email', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left"><?php echo Lang::_('admin_user_birthday_tip');?>: </span>
					<input type="txt" class="text normaltext" name="user_birthday" value="<?php echo Form::set_value('user_birthday', $uinfo['user_birthday']);?>" />
				<?php echo Form::get_error('user_birthday', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left"><?php echo Lang::_('admin_user_from_tip');?>: </span>
					<input type="txt" class="text normaltext" name="user_from" value="<?php echo Form::set_value('user_from', $uinfo['user_from']);?>" />
				<?php echo Form::get_error('user_from', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left"><?php echo Lang::_('admin_user_qq_tip');?>: </span>
					<input type="txt" class="text normaltext" name="user_qq" value="<?php echo Form::set_value('user_qq', $uinfo['user_qq']);?>" />
				<?php echo Form::get_error('user_qq', '<span class="fielderrormsg">', '</span>');?>
                </p>

               	<p><span class="left"><?php echo Lang::_('admin_user_msn_tip');?>: </span>
					<input type="txt" class="text normaltext" name="user_msn" value="<?php echo Form::set_value('user_msn', $uinfo['user_msn']);?>" />
				<?php echo Form::get_error('user_msn', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left"><?php echo Lang::_('admin_user_homepage_tip');?>: </span>
					<input type="txt" class="text normaltext" name="user_homepage" value="<?php echo Form::set_value('user_homepage', $uinfo['user_homepage']);?>" />
				<?php echo Form::get_error('user_homepage', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left"><?php echo Lang::_('admin_user_description_tip');?>: </span>
					<input type="txt" class="text normaltext" name="user_description" value="<?php echo Form::set_value('user_description', $uinfo['user_description']);?>" />
				<?php echo Form::get_error('user_description', '<span class="fielderrormsg">', '</span>');?>
                </p>
				 <p><span class="left"><?php echo Lang::_('admin_user_adminvalid_tip');?>: </span>
					<label><input type="radio" name="user_adminvalid" value="1"<?php if(Form::set_value('user_state', $uinfo['user_adminvalid']) == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_adminvalid_yes');?></label>
					<label><input type="radio" name="user_adminvalid" value="0"<?php if(Form::set_value('user_state', $uinfo['user_adminvalid']) == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_adminvalid_no');?></label>
                </p>
				 <p><span class="left"><?php echo Lang::_('admin_user_emailvalid_tip');?>: </span>
					<label><input type="radio" name="user_emailvalid" value="1"<?php if(Form::set_value('user_state', $uinfo['user_emailvalid']) == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_emailvalid_yes');?></label>
					<label><input type="radio" name="user_emailvalid" value="0"<?php if(Form::set_value('user_state', $uinfo['user_emailvalid']) == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_emailvalid_no');?></label>
                </p>
				 <p><span class="left"><?php echo Lang::_('admin_user_state_tip');?>: </span>
					<label><input type="radio" name="user_state" value="0"<?php if(Form::set_value('user_state', $uinfo['user_state']) == '0'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_state_0_tip');?></label>
					<label><input type="radio" name="user_state" value="1"<?php if(Form::set_value('user_state', $uinfo['user_state']) == '1'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_state_1_tip');?></label>
					<label><input type="radio" name="user_state" value="2"<?php if(Form::set_value('user_state', $uinfo['user_state']) == '2'){echo ' checked="checked"';} ?> />&nbsp;<?php echo Lang::_('admin_user_state_2_tip');?></label>
                </p>
				<p>&nbsp;</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_user_submit_tip');?>">&nbsp;
			<input type="reset" class="actionbtn pointer" value="<?php echo Lang::_('admin_user_reset_tip');?>">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>