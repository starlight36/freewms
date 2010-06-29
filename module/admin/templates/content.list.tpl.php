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
		<?php if(preg_match('/^\d+$/',$cate_id)): ?><a href="index.php?m=admin&amp;a=content&amp;do=save&amp;cid=<?php echo $cate_id; ?>" title="在当前分类下添加新内容">添加新内容</a><?php endif; ?>
		<p>
			选择显示:
			<a href="index.php?m=admin&amp;a=content&amp;state=0" title="列出全部内容"<?php if($state=='0') echo ' style="color: #FF0000;"'; ?>>全部内容</a> |
			<a href="index.php?m=admin&amp;a=content&amp;state=1" title="待审内容"<?php if($state=='1') echo ' style="color: #FF0000;"'; ?>>待审内容</a> |
			<a href="index.php?m=admin&amp;a=content&amp;state=2" title="锁定内容"<?php if($state=='2') echo ' style="color: #FF0000;"'; ?>>锁定内容</a> |
			<a href="index.php?m=admin&amp;a=content&amp;state=3" title="草稿箱中的内容"<?php if($state=='3') echo ' style="color: #FF0000;"'; ?>>草稿箱</a> |
			<a href="index.php?m=admin&amp;a=content&amp;state=4" title="列出已删除的内容"<?php if($state=='4') echo ' style="color: #FF0000;"'; ?>>回收站</a>
		</p>
		<form method="post" onsubmit="return DoFitter();" id="fitter_form">
			<p>
				<input type="hidden" name="state" value="<?php echo $state; ?>" />
				选择分类: 
				<select name="cid">
					<option value="all">全部分类</option>
					<?php echo $cate_select_tree; ?>
				</select>
				搜索:
				<select name="search_type">
					<option value="id"<?php if($search_type=='id') echo ' selected=selected'; ?>>内容ID</option>
					<option value="key"<?php if($search_type=='key') echo ' selected=selected'; ?>>URL名</option>
					<option value="tag"<?php if($search_type=='tag') echo ' selected=selected'; ?>>TAG</option>
					<option value="title"<?php if($search_type=='title') echo ' selected=selected'; ?>>标题</option>
					<option value="desc"<?php if($search_type=='desc') echo ' selected=selected'; ?>>摘要</option>
				</select>
				<input type="text" class="text shorttext" name="keywords" value="<?php echo $keywords; ?>" />
				时间范围:
				<input type="text" class="text" name="start_time" size="10" value="<?php echo $start_time; ?>" /> -
				<input type="text" class="text" name="end_time" size="10" value="<?php echo $end_time; ?>" />
				<input type="submit" value="筛选内容" class="searchbtn pointer" />
			</p>
		</form>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=content">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40">选择</td>
				<td class="titletd" width="80">模型</td>
				<td class="titletd">标题(浏览/评论)</td>
				<td class="titletd" width="100">所属分类</td>
				<td class="titletd" width="90">发布用户</td>
				<td class="titletd" width="130">发布时间</td>
				<td class="titletd" width="120">操作</td>
			</tr>
			<?php if($clist == NULL): ?>
			<tr class="out blue">
				<td colspan="7" class="listtd">在所选范围内没有找到任何内容</td>
			</tr>
			<?php else: ?>
			<?php foreach($clist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id" value="<?php echo $row['content_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['mod_name']; ?></td>
				<td class="listtd" style="text-align: left;">
					<?php if($row['content_istop'] > 6 && $row['content_istop'] > 0): ?><span class="green">[顶<?php echo $row['content_istop']; ?>]</span><?php endif; ?>
					<?php if($row['content_state'] == 1): ?><span class="alert">[待审]</span><?php elseif($row['content_state'] == 2): ?><span class="alert">[锁定]</span><?php elseif($row['content_state'] == 3): ?><span class="alert">[草稿]</span><?php elseif($row['content_state'] == 4): ?><span class="alert">[回收]</span><?php endif; ?>
					<?php if($row['content_viewrole']): ?><span class="alert">[定组]</span><?php endif; ?><?php if($row['content_viewuser']): ?><span class="alert">[定员]</span><?php endif; ?><?php if($row['content_viewpass']): ?><span class="alert">[加密]</span><?php endif; ?>
					<a href="<?php echo $row['content_url']; ?>" target="_blank" title="浏览该内容"><?php echo Format::str_sub($row['content_title'], 50);?></a>(<?php echo $row['content_readnum']; ?>/<?php echo $row['content_commentnum']; ?>)
				</td>
				<td class="listtd"><?php echo $row['cate_name'];?></td>
				<td class="listtd"><?php echo $row['user_name'];?></td>
				<td class="listtd"><?php echo date(SITE_DATETIME_FORMAT, $row['content_time']); ?></td>
				<td class="listtd">
					<a href="index.php?m=admin&amp;a=content&amp;do=save&amp;id=<?php echo $row['content_id'];?>" title="编辑">编辑</a> |
					<a href="" title="">评论</a> | 
					<a href="" title="">删除</a>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
			<tr>
				<td class="actiontd" colspan="7">
					<span class="space6">
						<a class="sa" title="全部选择" onclick="SelectAll('id');ChangeColor('All');" href="javascript:void(0)">全选</a> / 
						<a class="sa" title="取消选择" onclick="ClearAll('id');ChangeColor('All');" href="javascript:void(0)">不选</a>
					</span>
					<span class="space3 blue bold">对选中项进行：</span>
					<select name="do">
						<option value="normal">设为正常</option>
						<option value="lock">锁定内容</option>
						<option value="recycle">移至回收站</option>
						<option value="drafts">转入草稿箱</option>
						<option value="rm">直接删除</option>
					</select>
					<input type="submit" value="确认执行" class="batchbtn pointer" />
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