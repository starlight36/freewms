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
	var obj = $('option');
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
		生成分类静态页
	</div>
	<form method="post" action="index.php?m=admin&amp;a=create&amp;do=category">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left" style="line-height: 120px;">生成分类: </span>
					<select id="cate_id" name="id[]" multiple="multiple" style="width: 150px; height: 120px;">
						<?php echo $cate_select_tree; ?>
					</select><br />
					<input type="button" class="actionbtn pointer" onclick="doSelect();" value="全选/不选" />
				</p>
				<p><span class="left">生成目标: </span>
					<label><input type="checkbox" name="task[]" value="index" checked="checked" />分类首页</label>
					<label><input type="checkbox" name="task[]" value="list" checked="checked" />分类列表页</label>
				</p>
				<p>
					<input type="submit" class="actionbtn pointer" value="开始生成" onclick="submitform();" /><span style="display: none;" id="loadingmsg"><img src="<?php echo Url::base();?>module/admin/images/loading.gif" alt="Loading" align="absmiddle"/>静态生成中. 程序可能需要较长时间, 请耐心等待完成...</span>
				</p>
			</div>
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>