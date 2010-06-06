<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 编辑/修改模型页面模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		修改模型说明
	</div>
	<form action="index.php?m=admin&amp;a=module&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">模型ID/模型类型: </span>
					<span class="green bold"><?php if(!$id) {echo '新模型';}else{ echo $id;} ?></span>
					<?php if($mod['mod_is_system']): ?>
					<span class="alert bold">[系统模型]</span>
					<?php else: ?>
					<span class="green bold">[用户模型]</span>
					<?php endif; ?>
				</p>
				<p><span class="left">模型名称: </span>
					<input type="text" class="text shorttext" name="mod_name" value="<?php echo Form::set_value('mod_name', $mod['mod_name']);?>" />
					<?php echo Form::get_error('mod_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">模型简介: </span>
					<input type="text" class="text normaltext" name="mod_desc" value="<?php echo Form::set_value('mod_desc', $mod['mod_desc']);?>" />
					<?php echo Form::get_error('mod_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">内容条目名称: </span>
					<input type="text" class="text shorttext" name="mod_itemname" value="<?php echo Form::set_value('mod_itemname', $mod['mod_itemname']);?>" />
					<a class="tip" href="javascript:void(0)" title="如文章模块每条内容被成为'文章'">[?]</a>
					<?php echo Form::get_error('mod_itemname', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">内容条目单位: </span>
					<input type="text" class="text shorttext" name="mod_itemunit" value="<?php echo Form::set_value('mod_itemunit', $mod['mod_itemunit']);?>" />
					<a class="tip" href="javascript:void(0)" title="如文章模块以用'篇'作单位">[?]</a>
					<?php echo Form::get_error('mod_itemunit', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">模型默认模板文件夹: </span>
					<input type="text" class="text shorttext" name="mod_template" value="<?php echo Form::set_value('mod_template', $mod['mod_template']);?>" />
					<a class="tip" href="javascript:void(0)" title="指定主题目录下的一个子目录, 前后均无'/'">[?]</a>
					<?php echo Form::get_error('mod_template', '<span class="fielderrormsg">', '</span>');?>
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