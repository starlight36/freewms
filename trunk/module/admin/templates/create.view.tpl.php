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
	$(this).val('<?php echo Lang::_('admin_cate_wait_tip');?>');
	$('#loadingmsg').show();
}
//-->
</script>
<div id="showmain">
	<div class="titlebar">
		<?php echo Lang::_('admin_cate_content_tip');?>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=create&amp;do=view">
		<div id="tabcontent">
			<div class="showsimplecon">
				<p><span class="left" style="line-height: 120px;"><?php echo Lang::_('admin_cate_select_classify_tip');?>: </span>
					<select id="cate_id" name="id[]" multiple="multiple" style="width: 150px; height: 120px;">
						<?php echo $cate_select_tree; ?>
					</select><br />
					<input type="button" class="actionbtn pointer" onclick="doSelect();" value="<?php echo Lang::_('admin_cate_select_tip');?>" />
				</p>
				<p><span class="left"><?php echo Lang::_('admin_cate_time_tip');?>: </span>
					<select name="time">
						<option value="0" selected="selected"><?php echo Lang::_('admin_cate_no_limit_tip');?></option>
						<option value="1"><?php echo Lang::_('admin_cate_24_hour_tip');?></option>
						<option value="3"><?php echo Lang::_('admin_cate_3_day_tip');?></option>
						<option value="7"><?php echo Lang::_('admin_cate_1_week_tip');?></option>
						<option value="30"><?php echo Lang::_('admin_cate_1_month_tip');?></option>
						<option value="90"><?php echo Lang::_('admin_cate_3_month_tip');?></option>
						<option value="180"><?php echo Lang::_('admin_cate_half_year_tip');?></option>
					</select>
				</p>
				<p><span class="left"><?php echo Lang::_('admin_cate_num_tip');?>: </span>
					<select name="num">
						<option value="0" selected="selected"><?php echo Lang::_('admin_cate_num_no_limit_tip');?></option>
						<option value="30"><?php echo Lang::_('admin_cate_30_tip');?></option>
						<option value="30"><?php echo Lang::_('admin_cate_50_tip');?></option>
						<option value="30"><?php echo Lang::_('admin_cate_100_tip');?></option>
						<option value="30"><?php echo Lang::_('admin_cate_300_tip');?></option>
						<option value="30"><?php echo Lang::_('admin_cate_500_tip');?></option>
					</select>
				</p>
				<p>
					<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_cate_begin_tip');?>" onclick="submitform();" /><span style="display: none;" id="loadingmsg"><img src="<?php echo Url::base();?>module/admin/images/loading.gif" alt="Loading" align="absmiddle"/><?php echo Lang::_('admin_cate_running_tip');?></span>
				</p>
			</div>
		</div>
	</form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>