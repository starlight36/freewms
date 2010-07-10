<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 内容列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<script type="text/javascript">
//<!--
function DoFitter() {
	var url = 'index.php?m=admin&a=content';
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
		<?php if(preg_match('/^\d+$/',$cate_id)): ?><a href="index.php?m=admin&amp;a=content&amp;do=save&amp;cid=<?php echo $cate_id; ?>" title="<?php echo Lang::_('admin_content_add_title');?>"><?php echo Lang::_('admin_content_add_tip');?></a><?php endif; ?>
		<p>
			<?php echo Lang::_('admin_content_show_option_tip');?>:
			<a href="index.php?m=admin&amp;a=content&amp;state=0" title="<?php echo Lang::_('admin_content_all_title');?>"<?php if($state=='0') echo ' style="color: #FF0000;"'; ?>><?php echo Lang::_('admin_content_all_tip');?></a> |
			<a href="index.php?m=admin&amp;a=content&amp;state=1" title="<?php echo Lang::_('admin_content_pend_title');?>"<?php if($state=='1') echo ' style="color: #FF0000;"'; ?>><?php echo Lang::_('admin_content_pend_tip');?></a> |
			<a href="index.php?m=admin&amp;a=content&amp;state=2" title="<?php echo Lang::_('admin_content_lock_title');?>"<?php if($state=='2') echo ' style="color: #FF0000;"'; ?>><?php echo Lang::_('admin_content_lock_tip');?></a> |
			<a href="index.php?m=admin&amp;a=content&amp;state=3" title="<?php echo Lang::_('admin_content_draft_title');?>"<?php if($state=='3') echo ' style="color: #FF0000;"'; ?>><?php echo Lang::_('admin_content_draft_tip');?></a> |
			<a href="index.php?m=admin&amp;a=content&amp;state=4" title="<?php echo Lang::_('admin_content_delete_list_title');?>"<?php if($state=='4') echo ' style="color: #FF0000;"'; ?>><?php echo Lang::_('admin_recycle_tip');?></a>
		</p>
		<form method="post" onsubmit="return DoFitter();" id="fitter_form">
			<p>
				<input type="hidden" name="state" value="<?php echo $state; ?>" />
				<?php echo Lang::_('admin_select_cid_tip');?>:
				<select name="cid">
					<option value="all"><?php echo Lang::_('admin_all_cid_tip');?></option>
					<?php echo $cate_select_tree; ?>
				</select>
				<?php echo Lang::_('admin_search_type_tip');?>:
				<select name="search_type">
					<option value="id"<?php if($search_type=='id') echo ' selected=selected'; ?>><?php echo Lang::_('admin_search_id_tip');?></option>
					<option value="key"<?php if($search_type=='key') echo ' selected=selected'; ?>><?php echo Lang::_('admin_search_url_tip');?></option>
					<option value="tag"<?php if($search_type=='tag') echo ' selected=selected'; ?>><?php echo Lang::_('admin_search_tag_tip');?></option>
					<option value="title"<?php if($search_type=='title') echo ' selected=selected'; ?>><?php echo Lang::_('admin_search_title_tip');?></option>
					<option value="desc"<?php if($search_type=='desc') echo ' selected=selected'; ?>><?php echo Lang::_('admin_search_desc_tip');?></option>
				</select>
				<input type="text" class="text shorttext" name="keywords" value="<?php echo $keywords; ?>" />
				<?php echo Lang::_('admin_start_time_tip');?>:
				<input type="text" class="text" name="start_time" size="10" value="<?php echo $start_time; ?>" /> -
				<input type="text" class="text" name="end_time" size="10" value="<?php echo $end_time; ?>" />
			    每页显示
				<select name="pagesize">
						<option value="5" <?php if($pagesize==5) echo ' selected=selected';?>><?php echo "5条"; ?></option>
						<option value="10"<?php if($pagesize==10) echo ' selected=selected';?>><?php echo "10条"; ?></option>
						<option value="15"<?php if($pagesize==15) echo ' selected=selected';?>><?php echo "15条"; ?></option>
						<option value="20"<?php if($pagesize==20) echo ' selected=selected';?>><?php echo "20条"; ?></option>
						<option value="30"<?php if($pagesize==30) echo ' selected=selected';?>><?php echo "30条"; ?></option>
						<option value="50"<?php if($pagesize==50) echo ' selected=selected';?>><?php echo "50条"; ?></option>
						<option value="70"<?php if($pagesize==70) echo ' selected=selected';?>><?php echo "70条"; ?></option>
						<option value="100"<?php if($pagesize==100) echo ' selected=selected';?>><?php echo "100条"; ?></option>
					</select>
				<?php if(isset($_REQUEST['rid'])):?><input type="hidden" name="rid" value="<?php echo $rid;?>"/><?php endif;?>
				<?php if(isset($_REQUEST['sid'])):?><input type="hidden" name="sid" value="<?php echo $sid;?>"/><?php endif;?>
				<input type="submit" value="<?php echo Lang::_('admin_content_screening_tip');?>" class="searchbtn pointer" />
			</p>
		</form>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=content">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40"><?php echo Lang::_('admin_content_option_tip');?></td>
				<td class="titletd" width="80"><?php echo Lang::_('admin_content_model_tip');?></td>
				<td class="titletd"><?php echo Lang::_('admin_title_tip');?></td>
				<td class="titletd" width="90"><?php echo Lang::_('admin_cid_tip');?></td>
				<td class="titletd" width="90"><?php echo Lang::_('admin_release_users_tip');?></td>
				<td class="titletd" width="130"><?php echo Lang::_('admin_release_time_tip');?></td>
				<td class="titletd" width="150"><?php echo Lang::_('admin_operation_tip');?></td>
			</tr>
			<?php if($clist == NULL): ?>
			<tr class="out blue">
				<td colspan="7" class="listtd"><?php echo Lang::_('admin_null_tip');?></td>
			</tr>
			<?php else: ?>
			<?php foreach($clist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['content_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['mod_name']; ?></td>
				<td class="listtd" style="text-align: left;">
					<?php if($row['content_istop'] < 6 && $row['content_istop'] > 0): ?><span class="green">[<?php echo Lang::_('admin_content_1_tip');?><?php echo $row['content_istop']; ?>]</span><?php endif; ?>
					<?php if($row['content_state'] == 1): ?><span class="alert">[<?php echo Lang::_('admin_content_2_tip');?>]</span><?php elseif($row['content_state'] == 2): ?><span class="alert">[<?php echo Lang::_('admin_content_3_tip');?>]</span><?php elseif($row['content_state'] == 3): ?><span class="alert">[<?php echo Lang::_('admin_content_4_tip');?>]</span><?php elseif($row['content_state'] == 4): ?><span class="alert">[<?php echo Lang::_('admin_content_5_tip');?>]</span><?php endif; ?>
					<?php if($row['content_viewrole']): ?><span class="alert">[<?php echo Lang::_('admin_content_6_tip');?>]</span><?php endif; ?><?php if($row['content_viewuser']): ?><span class="alert">[<?php echo Lang::_('admin_content_7_tip');?>]</span><?php endif; ?><?php if($row['content_viewpass']): ?><span class="alert">[<?php echo Lang::_('admin_content_8_tip');?>]</span><?php endif; ?>
					<a href="<?php echo $row['content_url']; ?>" target="_blank" title="<?php echo Lang::_('admin_content_url_scan_tip');?>"><?php echo Format::str_sub($row['content_title'], 50);?></a>(<?php echo $row['content_readnum']; ?>/<?php echo $row['content_commentnum']; ?>)
				</td>
				<td class="listtd"><?php echo $row['cate_name'];?></td>
				<td class="listtd"><?php echo $row['user_name'];?></td>
				<td class="listtd"><?php echo date(SITE_DATETIME_FORMAT, $row['content_time']); ?></td>
				<td class="listtd">
					<a href="index.php?m=admin&amp;a=content&amp;do=save&amp;id=<?php echo $row['content_id'];?>" title="<?php echo Lang::_('admin_content_id_edit_title');?>"><?php echo Lang::_('admin_content_id_edit_tip');?></a> |
					<a href="" title=""><?php echo Lang::_('admin_content_id_comment_tip');?></a> |
					<a href="index.php?m=admin&amp;a=content&amp;do=rm&amp;id=<?php echo $row['content_id'];?>" title=""><?php echo Lang::_('admin_content_id_delete_tip');?></a>		    
					<?php if(isset($_REQUEST['rid'])):?> | <a href="index.php?m=admin&amp;a=content&amp;do=cl&amp;rid=<?php echo $_REQUEST['rid']; ?>&amp;id=<?php echo $row['content_id']?>" title="取消将此内容放入推荐">取消</a><?php endif;?>
					<?php if(isset($_REQUEST['sid'])):?> | <a href="index.php?m=admin&amp;a=content&amp;do=cls&amp;sid=<?php echo $_REQUEST['sid']; ?>&amp;id=<?php echo $row['content_id']?>" title="取消将此内容放入专题">取消</a><?php endif;?>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
			<tr>
				<td class="actiontd" colspan="7">
					<span class="space6">
						<a class="sa" title="<?php echo Lang::_('admin_content_selectall_title');?>" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_content_selectall_tip');?></a> /
						<a class="sa" title="<?php echo Lang::_('admin_content_clearall_title');?>" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)"><?php echo Lang::_('admin_content_clearall_tip');?></a>
					</span>
					<span class="space3 blue bold"><?php echo Lang::_('admin_selected_tip');?>：</span>
					<select name="do">
						<option value="normal"><?php echo Lang::_('admin_normal_tip');?></option>
						<option value="lock"><?php echo Lang::_('admin_do_lock_tip');?></option>
						<option value="recycle"><?php echo Lang::_('admin_do_recycle_tip');?></option>
						<option value="drafts"><?php echo Lang::_('admin_do_drafts_tip');?></option>
						<option value="rm"><?php echo Lang::_('admin_do_rm_tip');?></option>
					</select>
					<input type="submit" value="<?php echo Lang::_('admin_do_submit_tip');?>" class="batchbtn pointer" />
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