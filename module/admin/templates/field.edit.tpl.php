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
		修改自定义字段说明
	</div>
	<form action="index.php?m=admin&amp;a=field&amp;do=edit&amp;modid=<?php echo $modid; ?>&amp;id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">字段ID: </span>
					<span class="green bold"><?php if(!$id) {echo '新字段';}else{ echo $id;} ?></span>
				</p>
				<p><span class="left">字段名称: </span>
					<input type="text" class="text shorttext" name="field_name" value="<?php echo Form::set_value('field_name', $field['field_name']);?>" />
					<?php echo Form::get_error('field_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">字段关键字: </span>
					<input type="text" class="text shorttext" name="field_key" value="<?php echo Form::set_value('field_key', $field['field_key']);?>" />
					<a class="tip" href="javascript:void(0)" title="唯一识别此字段的标识, 不能与已有字段关键字重复, 由数字/字母/下划线组成">[?]</a>
					<?php echo Form::get_error('field_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">字段说明: </span>
					<input type="text" class="text normaltext" name="field_desc" value="<?php echo Form::set_value('field_desc', $field['field_desc']);?>" />
					<?php echo Form::get_error('field_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">字段输入框: </span>
					<textarea class="normaltextarea" name="field_input"><?php echo Form::set_value('field_input', $field['field_input']);?></textarea>
					<a class="tip" href="javascript:void(0)" title="使用HTML代码构建一个输入框">[?]</a>
					<?php echo Form::get_error('field_input', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">字段默认值: </span>
					<input type="text" class="text normaltext" name="field_default" value="<?php echo Form::set_value('field_default', $field['field_default']);?>" />
					<?php echo Form::get_error('field_default', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">字段验证规则: </span>
					<input type="text" class="text shorttext" name="field_rules" value="<?php echo Form::set_value('field_rules', $field['field_rules']);?>" />
					<select id="rule_list" style="width: 128px;">
						<option value="required">非空(required)</option>
						<option value="matches[%n%]">匹配字段(matches[字段名])</option>
						<option value="min_length[%n%]">最少字数(min_length[数])</option>
						<option value="max_length[%n%]">最多字数(max_length[数])</option>
						<option value="min_num[%n%]">最小值(min_num[值])</option>
						<option value="max_num[%n%]">最大值(max_num[值])</option>
						<option value="exact_length[%n%]">指定长度(exact_length[长度值])</option>
						<option value="valid_email">Email格式(valid_email)</option>
						<option value="valid_ip">IP格式(valid_ip)</option>
						<option value="dir_name">目录名(dir_name)</option>
						<option value="user_name">用户名(user_name)</option>
						<option value="numeric">数值(numeric)</option>
						<option value="integer">整数(integer)</option>
						<option value="natural">自然数(natural)</option>
						<option value="valid_code">验证码(valid_code)</option>
						<option value="regex[%n%]">正则表达式(regex[表达式])</option>
					</select>
					<input type="button" class="actionbtn pointer" onclick="add_role();" value="插入" />
					<a class="tip" href="javascript:void(0)" title="字段必须满足的验证条件, 选择一个规则, 也可自己添加, 多个用|分隔">[?]</a>
					<?php echo Form::get_error('field_rules', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">字段过滤规则: </span>
					<input type="text" class="text normaltext" name="field_filters" value="<?php echo Form::set_value('field_filters', $field['field_filters']);?>" />
					<a class="tip" href="javascript:void(0)" title="字段过滤规则, 可以是系统中任何可用的单参数函数, 多个用|分隔">[?]</a>
					<?php echo Form::get_error('field_filters', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="submit" class="actionbtn pointer" value="保存修改">&nbsp;
			<input type="reset" class="actionbtn pointer" value="撤销修改">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>