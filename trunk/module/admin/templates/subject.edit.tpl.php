<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 专题编辑页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		专题编辑说明
	</div>
	<form action="index.php?m=admin&amp;a=subject&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">专题ID: </span>
					<span class="green bold"><?php if(!$id) {echo '新建专题';}else{ echo $id;} ?></span>
				</p>
				<p><span class="left">专题所属分类: </span>
					<select name="subject_cateid">
						<option value="0">不属于任何分类</option>
						<?php echo $cate_select_tree; ?>
					</select>
					<?php echo Form::get_error('subject_cateid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">专题标题: </span>
					<input type="text" class="text normaltext" name="subject_title" value="<?php echo Form::set_value('subject_title', $sinfo['subject_title']);?>" />
					<?php echo Form::get_error('subject_title', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">专题简介: </span>
					<input type="text" class="text normaltext" name="subject_desc" value="<?php echo Form::set_value('subject_desc', $sinfo['subject_desc']);?>" />
					<?php echo Form::get_error('subject_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">专题封面: </span>
					<input type="text" class="text normaltext" name="subject_icon" value="<?php echo Form::set_value('subject_icon', $sinfo['subject_icon']);?>" />
					<a style="position: absolute; margin: 6px 0 0 -23px ! important;" title="选择图片"><img alt="选择一张图片" align="absmiddle" class="pointer" onclick="" src="<?php echo Url::base();?>module/admin/images/selectfile.gif"></a>
					<?php echo Form::get_error('subject_icon', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">专题URL名: </span>
					<input type="text" class="text shorttext" name="subject_key" value="<?php echo Form::set_value('subject_key', $sinfo['subject_key']);?>" />
					<?php echo Form::get_error('subject_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">专题模板: </span>
					<input type="text" class="text shorttext" name="subject_template" value="<?php echo Form::set_value('subject_template', $sinfo['subject_template']);?>" />
					<?php echo Form::get_error('subject_template', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">专题状态: </span>
					<label><input type="radio" name="subject_state" value="0"<?php if(Form::set_value('subject_state', $sinfo['subject_state']) == '0'){echo ' checked="checked"';} ?> />&nbsp;开启</label>
					<label><input type="radio" name="subject_state" value="1"<?php if(Form::set_value('subject_state', $sinfo['subject_state']) == '1'){echo ' checked="checked"';} ?> />&nbsp;关闭</label>
				</p>
				<p><span class="left">管理权用户组: </span>
					<?php foreach($role_select_list as $row): ?>
					<label><input type="checkbox" name="subject_roles[]" value="<?php echo $row['group_id']; ?>"<?php if(in_array($row['group_id'], $sinfo['subject_roles'])){echo ' checked="checked"';} ?> />&nbsp;<?php echo $row['group_name']; ?></label>
					<?php endforeach; ?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="保存">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重置">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>