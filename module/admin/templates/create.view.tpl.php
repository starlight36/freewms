<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 生成分类静态管理模板
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<script type="text/javascript">
//<!--
var select_state = false;
function doSelect() {
	var obj = $('select[id=cate_id] option');
	for(var i = 0; i < obj.length; i++) {
		if(select_state) {
			obj[i].selected = false;
		}else{
			obj[i].selected = true;
		}
	}
	if(select_state) {
		select_state = false;
	}else{
		select_state = true;
	}
}

function submitform() {
	$(this).attr('disabled', 'disabled');
	$(this).val('请稍候..');
	$('#loadingmsg').show();
}
//-->
</script>
<div id="showmain">
	<div class="titlebar">
		生成内容静态页
	</div>
	<form method="post" action="index.php?m=admin&amp;a=create&amp;do=view">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left" style="line-height: 120px;">选择分类: </span>
					<select id="cate_id" name="id[]" multiple="multiple" style="width: 150px; height: 120px;">
						<?php echo $cate_select_tree; ?>
					</select><br />
					<input type="button" class="actionbtn pointer" onclick="doSelect();" value="全选/不选" />
				</p>
				<p><span class="left">时间条件: </span>
					<select name="time">
						<option value="0" selected="selected">不限</option>
						<option value="1">24小时内</option>
						<option value="3">3天内</option>
						<option value="7">一周内</option>
						<option value="30">一个月内</option>
						<option value="90">三个月内</option>
						<option value="180">半年内</option>
					</select>
				</p>
				<p><span class="left">处理数条件: </span>
					<select name="num">
						<option value="0" selected="selected">不限制</option>
						<option value="30">最近30条</option>
						<option value="30">最近50条</option>
						<option value="30">最近100条</option>
						<option value="30">最近300条</option>
						<option value="30">最近500条</option>
					</select>
				</p>
				<p>
					<input type="submit" class="actionbtn pointer" value="开始生成" onclick="submitform();" /><span style="display: none;" id="loadingmsg"><img src="<?php echo Url::base();?>module/admin/images/loading.gif" alt="Loading" align="absmiddle"/>静态生成中. 程序可能需要较长时间, 请耐心等待完成...</span>
				</p>
			</div>
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>