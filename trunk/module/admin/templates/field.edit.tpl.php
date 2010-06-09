<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 编辑/修改自定义字段页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<script type="text/javascript">
//<!--
//添加规则函数
function add_role() {
	var v = $('#rule_list').val();
	var obj = $("input[name='field_rules']");
	if(v.indexOf("%n%") >= 0) {
		var input = prompt("请指定此规则的参数");
		if(!input) {
			alert('规则参数不能为空.');
			return false;
		}
		v = v.replace("%n%", input);
	}
	if(obj.val().indexOf(v) >= 0) {
		alert('此规则已存在');
		return false;
	}
	if(obj.val() != "") {
		obj.val(obj.val()+'|'+v);
	}else{
		obj.val(v);
	}
}
//-->
</script>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_field_edit_desc_tip');?>
	</div>
	<form action="index.php?m=admin&amp;a=field&amp;do=edit&amp;modid=<?php echo $modid; ?>&amp;id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left"><?php echo Lang::_('admin_field_ID_tip');?>: </span>
					<span class="green bold"><?php if(!$id) {echo Lang::_('admin_field_new');}else{ echo $id;} ?></span>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_field_name_tip');?>: </span>
					<input type="text" class="text shorttext" name="field_name" value="<?php echo Form::set_value('field_name', $field['field_name']);?>" />
					<?php echo Form::get_error('field_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_field_key_tip');?>: </span>
					<input type="text" class="text shorttext" name="field_key" value="<?php echo Form::set_value('field_key', $field['field_key']);?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_field_key_desc');?>">[?]</a>
					<?php echo Form::get_error('field_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_field_desc_tip');?>: </span>
					<input type="text" class="text normaltext" name="field_desc" value="<?php echo Form::set_value('field_desc', $field['field_desc']);?>" />
					<?php echo Form::get_error('field_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_field_input_tip');?>: </span>
					<textarea class="normaltextarea" name="field_input"><?php echo Form::set_value('field_input', $field['field_input']);?></textarea>
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_field_input_title');?>">[?]</a>
					<?php echo Form::get_error('field_input', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_field_default_tip');?>: </span>
					<input type="text" class="text normaltext" name="field_default" value="<?php echo Form::set_value('field_default', $field['field_default']);?>" />
					<?php echo Form::get_error('field_default', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_field_rules_tip');?>: </span>
					<input type="text" class="text shorttext" name="field_rules" value="<?php echo Form::set_value('field_rules', $field['field_rules']);?>" />
					<select id="rule_list" style="width: 128px;">
						<option value="required"><?php echo Lang::_('admin_required_tip');?></option>
						<option value="matches[%n%]"><?php echo Lang::_('admin_matches_tip');?></option>
						<option value="min_length[%n%]"><?php echo Lang::_('admin_min_length_tip');?></option>
						<option value="max_length[%n%]"><?php echo Lang::_('admin_max_length_tip');?></option>
						<option value="min_num[%n%]"><?php echo Lang::_('admin_min_num_tip');?></option>
						<option value="max_num[%n%]"><?php echo Lang::_('admin_max_num_tip');?></option>
						<option value="exact_length[%n%]"><?php echo Lang::_('admin_exact_length_tip');?></option>
						<option value="valid_email"><?php echo Lang::_('admin_valid_email_tip');?></option>
						<option value="valid_ip"><?php echo Lang::_('admin_valid_ip_tip');?></option>
						<option value="dir_name"><?php echo Lang::_('admin_dir_name_tip');?></option>
						<option value="user_name"><?php echo Lang::_('admin_user_name_tip');?></option>
						<option value="numeric"><?php echo Lang::_('admin_numeric_tip');?></option>
						<option value="integer"><?php echo Lang::_('admin_integer_tip');?></option>
						<option value="natural"><?php echo Lang::_('admin_natural_tip');?></option>
						<option value="valid_code"><?php echo Lang::_('admin_valid_code_tip');?></option>
						<option value="regex[%n%]"><?php echo Lang::_('admin_regex_tip');?></option>
					</select>
					<input type="button" class="actionbtn pointer" onclick="add_role();" value="<?php echo Lang::_('admin_add_role');?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_add_role_title');?>">[?]</a>
					<?php echo Form::get_error('field_rules', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_field_filters_tip');?>: </span>
					<input type="text" class="text normaltext" name="field_filters" value="<?php echo Form::set_value('field_filters', $field['field_filters']);?>" />
					<a class="tip" href="javascript:void(0)" title="<?php echo Lang::_('admin_fidld_filters_title');?>">[?]</a>
					<?php echo Form::get_error('field_filters', '<span class="fielderrormsg">', '</span>');?>
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