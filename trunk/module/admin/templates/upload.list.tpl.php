<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 上传文件列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<script type="text/javascript">
//<!--
function DoFitter() {
	var url = 'index.php?m=admin&a=upload';
	$.each($('#fitter_form *[name]'), function(i, row) {
		url += '&'+$(row).attr('name')+'='+escape($(row).val());
	});
	window.location.href = url;
	return false;
}
//-->
</script>
<div id="showmain">
  <div class="titlebar">
		<p><?php echo Lang::_('admin_upload_desc_tip');?>：</p>
		<p> <a href="index.php?m=admin&amp;a=upload&amp;do=edit"><?php echo Lang::_('admin_upload_new_tip');?></a></p>
		<form method="post" id="fitter_form" onsubmit="return DoFitter();">
    <?php echo Lang::_('admin_upload_year_tip');?>：
    	<select name="year">
    		<option value=""><?php echo Lang::_('admin_upload_all_year_tip');?></option>
 			<?php for($i=2000;$i<=2038;$i++){
				$yearlist[$i] = '<option value="'.$i.'"';
				if( $yearnum == $i) $yearlist[$i] = $yearlist[$i].' selected=selected';
				$yearlist[$i] = $yearlist[$i].">".$i.Lang::_('admin_upload_year_1_tip')."</option>";
				echo $yearlist[$i];
				}?>
   		</select>&nbsp;
    &nbsp;<?php echo Lang::_('admin_upload_month_tip');?>:
    	<select name="month">
    		<option value=""><?php echo Lang::_('admin_upload_all_month_tip');?></option>
    		<?php for($i=1;$i<=12;$i++){
				$monthlist[$i] = '<option value="'.$i.'" ';
				if( $monthnum == $i) $monthlist[$i] = $monthlist[$i].' selected=selected';
				$monthlist[$i] = $monthlist[$i].'>'.$i.Lang::_('admin_upload_month_tip').'</option>';
				echo $monthlist[$i];
			}?>
    	</select>&nbsp;
    &nbsp;<?php echo Lang::_('admin_upload_filename_tip');?>:
    	<input type="text" class="text" size="14" name="upload_name" value="<?php echo $namenum; ?>" />
        <input type="submit" value="<?php echo Lang::_('admin_upload_name_title');?>"   class="searchbtn pointer" />
    </form>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=upload">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>

				<td class="titletd" width="40"><?php echo Lang::_('admin_upload_operate_tip');?></td>
				<td class="titletd" ><?php echo Lang::_('admin_upload_filename_tip');?></td>
				<td class="titletd" width="20%"><?php echo Lang::_('admin_upload_filesize_tip');?></td>
				<td class="titletd" width="20%"><?php echo Lang::_('admin_upload_time_tip');?></td>
				<td class="titletd" width="10%"><?php echo Lang::_('admin_upload_operate_tip');?></td>

  </tr>
			<?php if($uploadlist == NULL): ?>
			<tr>
				<td class="titletd" colspan="7"><?php echo Lang::_('admin_upload_no_found_tip');?></td>
			</tr>
			<?php else: ?>
			<!--{分类层次列表开始}-->
    <?php foreach ($uploadlist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['upload_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['upload_name']; ?></td>
				<td class="listtd"><?php
				$f = new Format();
				echo $f->filesize($row['upload_size']); ?></td>
                <td class="listtd"><?php echo date("Y-m-d H:i", $row['upload_time']); ?></td>
           		<td class="listtd"><a href="index.php?m=admin&amp;a=upload&amp;do=rm&amp;id=<?php echo $row['upload_id']; ?>" onclick="return confirm('<?php echo Lang::_('admin_upload_delete_warn_tip');?>')" title="<?php echo Lang::_('admin_upload_delete_title');?>" ><?php echo Lang::_('admin_upload_delete_tip');?></a></td>
			</tr>
			<?php endforeach; ?>
			<?php endif;?>
			<tr>
				<td class="actiontd" colspan="7">
					<span class="space6">
						<a class="sa" title="<?php echo Lang::_('admin_upload_selectall_title');?>" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_upload_selectall_tip');?></a> /
						<a class="sa" title="<?php echo Lang::_('admin_upload_cancel_title');?>" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_upload_cancel_tip');?></a>
					</span>
					<span class="space3 blue bold"><?php echo Lang::_('admin_upload_selected_tip');?>：</span>
					<input type="hidden" value="rm" name="do">
					<input type="submit" class="actionbtn pointer" value="<?php echo Lang::_('admin_upload_delete_tip');?>">
				</td>
			</tr>
			<tr>
				<td class="pagetd" colspan="7">
					<div id="paginate"><?php echo Paginate::get_paginate('firstpage', 'currentpage') ?></div>
				</td>
			</tr>
		</table>
    </form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>