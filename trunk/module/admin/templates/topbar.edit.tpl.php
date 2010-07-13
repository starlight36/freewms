<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 网站导航编辑页模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<script type="text/javascript">
//<!--
$(document).ready(function(){
	$('#cate_id').val($('#topbar_bindid').val());
	$('#page_id').val($('#topbar_bindid').val());
	var obj = $('input[name=topbar_type]');
	for(var i = 0; i < obj.length; i++) {
		if(obj[i].checked) {
			$(obj[i]).click();
			return;
		}
	}
});
function check_type(id) {
	$('#guide_byurl').slideUp(200);
	$('#guide_bycate').slideUp(200);
	$('#guide_bypage').slideUp(200);
	$('#'+id).slideDown(100);
}
//-->
</script>
<div id="showmain">
	<div class="titlebar">
		新建导航
	</div>
	<form action="index.php?m=admin&amp;a=topbar&amp;do=edit&id=<?php echo $id; ?>" method="post">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left">导航ID: </span>
					<span class="green bold"><?php if(!$id) {echo "新建导航";}else{ echo $id;} ?></span>
				</p>
				<p><span class="left">导航名称: </span>
				  <input type="text" class="text shorttext" name="topbar_name" value="<?php echo Form::set_value('topbar_name', $tinfo['topbar_name']);?>" />
				  <?php echo Form::get_error('topbar_name', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">导航简介: </span>
					<input type="text" class="text normaltext" name="topbar_desc" value="<?php echo Form::set_value('topbar_desc', $tinfo['topbar_desc']);?>" />
					<?php echo Form::get_error('topbar_desc', '<span class="fielderrormsg">', '</span>');?>
				</p>
                <p><span class="left">自定义属性: </span>
					<input type="text" class="text normaltext" name="topbar_attribute" value="<?php echo Form::set_value('topbar_attribute', $tinfo['topbar_attribute']);?>" />
					<?php echo Form::get_error('topbar_attribute', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">打开方式: </span>
					<label><input type="radio" name="topbar_target" value="_self"<?php if(Form::set_value('topbar_target', $tinfo['topbar_target']) == '_self'){echo ' checked="checked"';} ?> />&nbsp;本窗口</label>
					<label><input type="radio" name="topbar_target" value="_blank"<?php if(Form::set_value('topbar_target', $tinfo['topbar_target']) == '_blank'){echo ' checked="checked"';} ?> />&nbsp;新建窗口</label>
					<label><input type="radio" name="topbar_target" value="_parent"<?php if(Form::set_value('topbar_target', $tinfo['topbar_target']) == '_parent'){echo ' checked="checked"';} ?> />&nbsp;父窗口</label>
					<?php echo Form::get_error('topbar_target', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">链接类型: </span>
					<label><input type="radio" name="topbar_type" onclick="check_type('guide_byurl');" value="0"<?php if(Form::set_value('topbar_type', $tinfo['topbar_type']) == '0'){echo ' checked="checked"';} ?> />&nbsp;外部链接</label>
					<label><input type="radio" name="topbar_type" onclick="check_type('guide_bycate');" value="1"<?php if(Form::set_value('topbar_type', $tinfo['topbar_type']) == '1'){echo ' checked="checked"';} ?> />&nbsp;分类链接</label>
					<label><input type="radio" name="topbar_type" onclick="check_type('guide_bypage');" value="2"<?php if(Form::set_value('topbar_type', $tinfo['topbar_type']) == '2'){echo ' checked="checked"';} ?> />&nbsp;单页链接</label>
					<?php echo Form::get_error('topbar_type', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p id="guide_byurl" style="display: none;"><span class="left">URL链接: </span>
					<input type="text" class="text normaltext" name="topbar_url" value="<?php echo Form::set_value('topbar_url', $tinfo['topbar_url']);?>" />
					<?php echo Form::get_error('topbar_url', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p id="guide_bycate" style="display: none;"><span class="left">转向分类: </span>
					<select id="cate_id" style="width: 158px;" onchange="$('#topbar_bindid').val($(this).val());">
						<option>选择一个分类</option>
						<?php echo $cate_select_tree; ?>
					</select>
				</p>
				<p id="guide_bypage" style="display: none;"><span class="left">转向页面: </span>
					<select id="page_id" style="width: 158px;" onchange="$('#topbar_bindid').val($(this).val());">
						<option>选择一个页面</option>
						<?php foreach($page_select_tree as $row): ?>
						<option value="<?php echo $row['page_id']; ?>"><?php echo $row['page_name']; ?></option>
						<?php endforeach;?>
					</select>
				</p>
				<p><span class="left">排序: </span>
					<input type="text" class="text shorttext" name="topbar_order" value="<?php echo Form::set_value('topbar_order', $tinfo['topbar_order']);?>" />
					<?php echo Form::get_error('topbar_order', '<span class="fielderrormsg">', '</span>');?>
                </p>
				<p><span class="left">是否显示: </span>
					<label><input type="radio" name="topbar_hide" value="0"<?php if(Form::set_value('topbar_hide', $tinfo['topbar_hide']) == '0'){echo ' checked="checked"';} ?> />&nbsp;显示</label>
					<label><input type="radio" name="topbar_hide" value="1"<?php if(Form::set_value('topbar_hide', $tinfo['topbar_hide']) == '1'){echo ' checked="checked"';} ?> />&nbsp;隐藏</label>
					<?php echo Form::get_error('topbar_hide', '<span class="fielderrormsg">', '</span>');?>
				</p>
			</div>
		</div>
		<div>
			<input type="hidden" id="topbar_bindid" name="topbar_bindid" value="<?php echo Form::set_value('topbar_bindid', $tinfo['topbar_bindid']? $tinfo['topbar_bindid']:'0');?>" />
			<input type="submit" class="actionbtn pointer" value="保存修改">&nbsp;
			<input type="reset" class="actionbtn pointer" value="重置">
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>
