<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 添加/修改分类页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		修改分类说明
	</div>
	<form action="index.php?m=admin&amp;a=category&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">分类ID: </span>
					<span class="green bold"><?php if(!$id) {echo '新建分类';}else{ echo $id;} ?></span>
				</p>
				<p><span class="left">所属分类: </span>
					<select name="cate_parentid">
						<option value="0">作为根分类</option>
						<?php echo $cate_select_tree; ?>
					</select>
					<?php echo Form::get_error('cate_parentid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">绑定内容模型: </span>
					<select name="cate_modid">
						<?php foreach($mod_select_list as $row): ?>
						<option value="<?php echo $row['mod_id']; ?>"><?php echo $row['mod_name']; ?></option>
						<?php endforeach; ?>
					</select>
					<?php echo Form::get_error('cate_modid', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">分类名称: </span>
					<input type="text" class="text shorttext" name="cate_name" value="<?php echo Form::set_value('cate_name', $cate['cate_name']);?>" />
					<?php echo Form::get_error('cate_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">分类目录名: </span>
					<input type="text" class="text shorttext" name="cate_key" value="<?php echo Form::set_value('cate_key', $cate['cate_key']);?>" />
					<a class="tip" href="javascript:void(0)" title="唯一识别此分类的标识, 不能与已有分类目录名重复, 由数字/字母/下划线组成">[?]</a>
					<?php echo Form::get_error('cate_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">分类关键字: </span>
					<input type="text" class="text normaltext" name="cate_keywords" value="<?php echo Form::set_value('cate_keywords', $cate['cate_keywords']);?>" />
					<?php echo Form::get_error('cate_keywords', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">分类简介: </span>
					<input type="text" class="text normaltext" name="cate_description" value="<?php echo Form::set_value('cate_description', $cate['cate_description']);?>" />
					<?php echo Form::get_error('cate_description', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">分类模板目录名称: </span>
					<input type="text" class="text shorttext" name="cate_template" value="<?php echo Form::set_value('cate_template', $cate['cate_template']);?>" />
					<a class="tip" href="javascript:void(0)" title="如果要单独设定该分类的模板, 请指定模板目录名, 留空将自动继承使用模型默认模板">[?]</a>
					<?php echo Form::get_error('cate_template', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">分类内容列表每页条数: </span>
					<input type="text" class="text shorttext" name="cate_pagesize" value="<?php echo Form::set_value('cate_pagesize', $cate['cate_pagesize']);?>" />
					<?php echo Form::get_error('cate_pagesize', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">分类排序序号: </span>
					<input type="text" class="text shorttext" name="cate_order" value="<?php echo Form::set_value('cate_order', $cate['cate_order']);?>" />
					<?php echo Form::get_error('cate_order', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">为用户组赋予管理权: </span>
					<?php foreach($role_select_list as $row): ?>
					<label><input type="checkbox" name="cate_role" value="<?php echo $row['group_id']; ?>"<?php if(in_array($row['group_id'], $cate['cate_role'])){echo ' checked="checked"';} ?> />&nbsp;<?php echo $row['group_name']; ?></label>
					<?php endforeach; ?>
				</p>
				<p><span class="left">是否开启生成静态: </span>
					<label><input type="radio" name="cate_static" value="0"<?php if(Form::set_value('cate_static', $cate['cate_static']) == '0'){echo ' checked="checked"';} ?> />&nbsp;关闭</label>
					<label><input type="radio" name="cate_static" value="1"<?php if(Form::set_value('cate_static', $cate['cate_static']) == '1'){echo ' checked="checked"';} ?> />&nbsp;开启</label>
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