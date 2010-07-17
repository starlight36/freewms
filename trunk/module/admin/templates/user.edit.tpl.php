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
		 修改用户
	</div>
	<form action="index.php?m=admin&amp;a=user&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">用户ID: </span>
					<span class="green bold"><?php
					if(!$id) {
						echo "新建用户";
						$uinfo['user_groupid'] = Config::get('user_default_gid');

						}else { echo $id;} ?></span>
				</p>
<p><span class="left">用户名: </span>
					<?php if(!$id):?>
						<input type="text" class="text shorttext" name="user_name" value="<?php echo Form::set_value('user_name', $uinfo['user_name']);?>" />
						<p><?php echo Form::get_error('user_name', '<span class="fielderrormsg">', '</span>');?></p>
					<?php
					else:
						echo $uinfo['user_name'];
					?>
						<input type="hidden" name="user_name" value="<?php echo $uinfo['user_name'];?>"/>
					<?php endif?>
                <p><span class="left">选着用户组: </span>
					<select name="user_groupid">
					<?php foreach ($glist as $row): ?>
					<option value="<? echo $row['group_id']?>" <?php if(Form::set_value('user_gender', $uinfo['user_groupid']) == $row['group_id']){ echo "selected=\"selected\"";}?>>&nbsp;<?php echo $row['group_name']; ?></option>
					<?php endforeach; ?>
					</select>
                </p>
		    	<p><span class="left">请输入密码: </span>
					<input type="password" class="text normaltext" name="user_pass" />
				<?php echo Form::get_error('user_pass', '<span class="fielderrormsg">', '</span>');?>
			  	</p>
                <p><span class="left">请再次输入密码: </span>
					<input type="password" class="text normaltext" name="user_pass2" />
				<?php echo Form::get_error('user_pass2', '<span class="fielderrormsg">', '</span>');?>
			  	</p>
                <p><span class="left">用户昵称: </span>
					<input type="txt" class="text normaltext" name="user_nickname" value="<?php echo Form::set_value('user_nickname', $userinfo['user_nickname']);?>" />
				<?php echo Form::get_error('user_nickname', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left">性别: </span>
					<label><input type="radio" name="user_gender" value="0"<?php if(Form::set_value('user_gender', $uinfo['user_gender']) == '0'){echo ' checked="checked"';} ?> />&nbsp;男</label>
					<label><input type="radio" name="user_gender" value="1"<?php if(Form::set_value('user_gender', $uinfo['user_gender']) == '1'){echo ' checked="checked"';} ?> />&nbsp;女</label>
                </p>
			  	<p><span class="left">Email: </span>
					<input type="txt" class="text normaltext" name="user_email" value="<?php echo Form::set_value('user_email', $uinfo['user_email']);?>" />
				<?php echo Form::get_error('user_email', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left">出生日期: </span>
					<input type="txt" class="text normaltext" name="user_birthday" value="<?php echo Form::set_value('user_birthday', $uinfo['user_birthday']);?>" />
				<?php echo Form::get_error('user_birthday', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left">来自: </span>
					<input type="txt" class="text normaltext" name="user_from" value="<?php echo Form::set_value('user_from', $uinfo['user_from']);?>" />
				<?php echo Form::get_error('user_from', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left">qq: </span>
					<input type="txt" class="text normaltext" name="user_qq" value="<?php echo Form::set_value('user_qq', $uinfo['user_qq']);?>" />
				<?php echo Form::get_error('user_qq', '<span class="fielderrormsg">', '</span>');?>
                </p>

               	<p><span class="left">MSN: </span>
					<input type="txt" class="text normaltext" name="user_msn" value="<?php echo Form::set_value('user_msn', $uinfo['user_msn']);?>" />
				<?php echo Form::get_error('user_msn', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left">用户主页: </span>
					<input type="txt" class="text normaltext" name="user_homepage" value="<?php echo Form::set_value('user_homepage', $uinfo['user_homepage']);?>" />
				<?php echo Form::get_error('user_homepage', '<span class="fielderrormsg">', '</span>');?>
                </p>
                <p><span class="left">用户简介: </span>
					<input type="txt" class="text normaltext" name="user_description" value="<?php echo Form::set_value('user_description', $uinfo['user_description']);?>" />
				<?php echo Form::get_error('user_description', '<span class="fielderrormsg">', '</span>');?>
                </p>
				 <p><span class="left">是否通过管理员验证: </span>
					<label><input type="radio" name="user_adminvalid" value="1"<?php if(Form::set_value('user_state', $uinfo['user_adminvalid']) == '1'){echo ' checked="checked"';} ?> />&nbsp;是</label>
					<label><input type="radio" name="user_adminvalid" value="0"<?php if(Form::set_value('user_state', $uinfo['user_adminvalid']) == '0'){echo ' checked="checked"';} ?> />&nbsp;否</label>
                </p>
				 <p><span class="left">是否通过邮件验证: </span>
					<label><input type="radio" name="user_emailvalid" value="1"<?php if(Form::set_value('user_state', $uinfo['user_emailvalid']) == '1'){echo ' checked="checked"';} ?> />&nbsp;是</label>
					<label><input type="radio" name="user_emailvalid" value="0"<?php if(Form::set_value('user_state', $uinfo['user_emailvalid']) == '0'){echo ' checked="checked"';} ?> />&nbsp;否</label>
                </p>
				 <p><span class="left">状态: </span>
					<label><input type="radio" name="user_state" value="0"<?php if(Form::set_value('user_state', $uinfo['user_state']) == '0'){echo ' checked="checked"';} ?> />&nbsp;正常</label>
					<label><input type="radio" name="user_state" value="1"<?php if(Form::set_value('user_state', $uinfo['user_state']) == '1'){echo ' checked="checked"';} ?> />&nbsp;锁定</label>
					<label><input type="radio" name="user_state" value="2"<?php if(Form::set_value('user_state', $uinfo['user_state']) == '2'){echo ' checked="checked"';} ?> />&nbsp;未审核</label>
                </p>
				<p>&nbsp;</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="提交">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重置">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>