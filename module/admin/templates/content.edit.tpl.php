<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 内容编辑页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<link href="<?php echo Url::base();?>js/calendar/syscalendar.css" title="blue" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?php echo Url::base();?>js/xheditor/xheditor-zh-cn.min.js"></script>
<script type="text/javascript" src="<?php echo Url::base();?>js/calendar/syscalendar.js"></script>
<script type="text/javascript" src="<?php echo Url::base();?>js/calendar/syscalendar-zh.js"></script>
<script type="text/javascript" src="<?php echo Url::base();?>js/calendar/syscalendar-setup.js"></script>
<div id="showmain">
	<div class="titlebar">编辑内容提示</div>
	<form method="post" id="cform" action="index.php?m=admin&amp;a=content&amp;do=save&amp;id=<?php echo $id; ?>">
		<ul id="tabs">
			<li id="tab1" class="selecttab">
				<a href="javascript:void(0);" title="基本内容信息" onclick="SelectTab('tabcontent1','tab1');">基本内容信息</a>
			</li>
			<li id="tab2">
				<a href="javascript:void(0);" title="高级选项设置" onclick="SelectTab('tabcontent2','tab2');">高级选项设置</a>
			</li>
		</ul>
		<div id="tabcontent">
			<div id="tabcontent1" class="showtabcon" style="display: block;">
				<p><span class="left"><?php echo $cinfo['mod_itemname']; ?>分类:</span>
					<select name="content_cateid">
						<?php echo $cate_select_tree; ?>
					</select>
				</p>
				<p><span class="left"><?php echo $cinfo['mod_itemname']; ?>标题:</span>
					<input type="text" class="text normaltext" id="content_title" name="content_title" value="<?php echo Form::set_value('content_title', $cinfo['content_title']);?>" style="<?php echo Form::set_value('content_titlestyle', $cinfo['content_titlestyle']);?>" />
					<a style="position: absolute; margin: 6px 0 0 -27px ! important;" title="编辑标题样式"><img alt="编辑标题样式" align="absmiddle" class="pointer" onclick="ShowStylePicker();" src="<?php echo Url::base();?>module/admin/images/titlecbar.gif"></a>
					<input type="hidden" id="content_titlestyle" id="content_titlestyle" name="content_titlestyle" value="<?php echo Form::set_value('content_titlestyle', $cinfo['content_titlestyle']);?>" />
					<?php echo Form::get_error('content_title', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">TAG:</span>
					<input type="text" class="text normaltext" id="content_tags" name="content_tags" value="<?php echo Form::set_value('content_tags', implode(' ', $cinfo['content_tags']));?>" />
					<a style="position: absolute; margin: 6px 0 0 -30px ! important;" title="显示常用TAG"><img alt="显示常用TAG" align="absmiddle" class="pointer" onclick="TagPicker();" src="<?php echo Url::base();?>module/admin/images/taginput.gif"></a>
					<a class="tip" href="javascript:void(0)" title="多个TAG请用空格分隔">[?]</a>
					<?php echo Form::get_error('content_tags', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">URL名称:</span>
					<input type="text" class="text normaltext" name="content_key" value="<?php echo Form::set_value('content_key', $cinfo['content_key']);?>" />
					<a class="tip" href="javascript:void(0)" title="作为此内容的名称访问标识,使用字母,数字,下划线命名.不可重复">[?]</a>
					<?php echo Form::get_error('content_key', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">预览缩略图:</span>
					<label><input type="radio" name="thumbtype" value="0" onclick="$('#content_thumb').val('');$('#thumb_select').hide();"<?php if(!$cinfo['content_thumb']){ echo ' checked="checked"';} ?> />关闭</label>
					<label><input type="radio" name="thumbtype" value="1" onclick="$('#thumb_select').show();"<?php if($cinfo['content_thumb']){ echo ' checked="checked"';} ?> />开启</label>
					<span id="thumb_select" style="<?php if(!$cinfo['content_thumb']){ echo 'display: none;';} ?>">
						<input type="text" class="text" id="content_thumb" name="content_thumb" style="width: 260px; padding-right: 20px;" value="<?php echo Form::set_value('content_thumb', $cinfo['content_thumb']);?>" />
						<a style="position: absolute; margin: 6px 0 0 -27px ! important;" title="选择或者上传一张图片"><img alt="选择或者上传一张图片" align="absmiddle" class="pointer" onclick="" src="<?php echo Url::base();?>module/admin/images/selectfile.gif"></a>
					</span>
					<a class="tip" href="javascript:void(0)" title="设置一张图片作为内容缩略图.如果为开启状态, 但图片地址为空,系统将自动取得该内容的一张图片作为缩略图.">[?]</a>
				</p>
				<p><span class="left" style="line-height:150px; vertical-align:middle;"><?php echo $cinfo['mod_itemname']; ?>简介:</span>
					<textarea  class="xheditor-simple {localUrl:'rel',upBtnText:'浏览',upLinkUrl:'!index.php?m=admin&a=filebrowser&filetype=all',upLinkExt:'zip',upImgUrl:'!index.php?m=admin&a=filebrowser&filetype=image',upImgExt:'jpg,jpeg,gif,png,bmp',upFlashUrl:'!index.php?m=admin&a=filebrowser&filetype=flash',upFlashExt:'swf',upMediaUrl:'!index.php?m=admin&a=filebrowser&filetype=media',upMediaExt:'wmv,avi,wma,mp3,mid,asf',modalWidth:'500',modalHeight:'300'}" rows="8" cols="95" name="content_intro"><?php echo htmlspecialchars($cinfo['content_intro']);?></textarea>
					<?php echo Form::get_error('content_intro', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<?php foreach($fieldlist as $field): ?>
				<p>
					<?php
						$input = $field['field_input'];
						if(!empty($cinfo[$field['field_key']])) {
							 $field['field_default'] = $cinfo[$field['field_key']];
						}
						$field['field_default'] = Form::set_value($field['field_key'], $field['field_default']);
						$input = str_replace('{field_key}', $field['field_key'], $input);
						$input = str_replace('{field_name}', $field['field_name'], $input);
						$input = str_replace('{field_default}', htmlspecialchars($field['field_default']), $input);
						$input = str_replace('{field_error}', Form::get_error($field['field_key'], '<span class="fielderrormsg">', '</span>'), $input);
						echo $input;
					?>
				</p>
				<?php endforeach; ?>
			</div>
			<div id="tabcontent2" class="showtabcon" style="display: none;">
				<p><span class="left"><?php echo $cinfo['mod_itemname']; ?>作者:</span>
					<input type="text" class="text shorttext" name="content_author" value="<?php echo Form::set_value('content_author', $cinfo['content_author']?$cinfo['content_author']:'未知');?>" />
					<?php echo Form::get_error('content_author', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left"><?php echo $cinfo['mod_itemname']; ?>来源:</span>
					<input type="text" class="text shorttext" name="content_from" value="<?php echo Form::set_value('content_from', $cinfo['content_from']?$cinfo['content_from']:'未知');?>" />
					<?php echo Form::get_error('content_from', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">发布时间:</span>
					<input type="text" class="text shorttext" id="content_time" name="content_time" value="<?php echo Form::set_value('content_time', date('Y-m-d H:i:s', $cinfo['content_time'] ? $cinfo['content_time'] : time()));?>" />
					<a style="position: absolute; margin: 3px 0 0 -25px ! important;" title="设置发布时间"><img alt="设置发布时间" align="absmiddle" class="pointer" id="time_picker_icon" src="<?php echo Url::base();?>module/admin/images/datebar.gif"></a>
					<?php echo Form::get_error('content_time', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">浏览人数:</span>
					<input type="text" class="text shorttext" name="content_readnum" value="<?php echo Form::set_value('content_readnum', $cinfo['content_readnum']?$cinfo['content_readnum']:0);?>" />
					<?php echo Form::get_error('content_readnum', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">置顶级别:</span>
					<select name="content_istop">
						<option value="6"<?php if($cinfo['content_istop'] == '6') echo ' selected="selected"';?>>不置顶</option>
						<?php for($i = 1; $i < 6; $i++): ?>
						<option value="<?php echo $i;?>"<?php if($cinfo['content_istop'] == $i) echo ' selected="selected"';?>>置顶级别<?php echo $i;?></option>
						<?php endfor; ?>
					</select>
					<a class="tip" href="javascript:void(0)" title="设置置顶级别, 1级最高, 5级最低">[?]</a>
					<?php echo Form::get_error('content_istop', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">评论状态:</span>
					<label><input type="radio" name="content_iscomment" value="1"<?php if($cinfo['content_iscomment'] != '0') echo ' checked="checked"';?> />允许评论</label>
					<label><input type="radio" name="content_iscomment" value="0"<?php if($cinfo['content_iscomment'] == '0') echo ' checked="checked"';?> />禁止评论</label>
					<?php echo Form::get_error('content_iscomment', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">允许浏览的用户组:</span>
					<?php foreach($role_select_list as $row): ?>
					<label><input type="checkbox" name="content_viewrole[]" value="<?php echo $row['group_id']; ?>"<?php if(in_array($row['group_id'], $cinfo['content_viewrole'])){echo ' checked="checked"';} ?> />&nbsp;<?php echo $row['group_name']; ?></label>
					<?php endforeach; ?>
					<a class="tip" href="javascript:void(0)" title="选择特定用户组能访问此内容, 全不选表示可被任何用户访问.">[?]</a>
				</p>
				<p><span class="left">访问密码:</span>
					<input type="text" class="text shorttext" name="content_viewpass" value="<?php echo Form::set_value('content_viewpass', $cinfo['content_viewpass']);?>" />
					<a class="tip" href="javascript:void(0)" title="访问此内容所需的密码,小于16位">[?]</a>
					<?php echo Form::get_error('content_viewpass', '<span class="fielderrormsg">', '</span>');?>
				</p>
				<p><span class="left">所属推荐位:</span>
					<?php if($recmd_select_list != NULL): ?>
					<?php foreach($recmd_select_list as $row): ?>
					<label><input type="checkbox" name="content_recmd_list[]" value="<?php echo $row['rec_id']; ?>"<?php if(in_array($row['rec_id'], $cinfo['recmd_list'])){echo ' checked="checked"';} ?> />&nbsp;<?php echo $row['rec_name']; ?></label>
					<?php endforeach; ?>
					<?php else: ?>
					<span class="alert bold">没有推荐位可选</span>
					<?php endif; ?>
				</p>
				<p><span class="left">所属专题:</span>
					<?php if($subject_select != NULL): ?>
					<?php foreach($subject_select_list as $row): ?>
					<label><input type="checkbox" name="content_subj_list[]" value="<?php echo $row['subject_id']; ?>"<?php if(in_array($row['subject_id'], $cinfo['subj_list'])){echo ' checked="checked"';} ?> />&nbsp;<?php echo $row['subject_title']; ?></label>
					<?php endforeach; ?>
					<?php else: ?>
					<span class="alert bold">没有专题可选</span>
					<?php endif; ?>
				</p>
			</div>
		</div>
		<div>
			<input type="hidden" name="content_id" value="<?php echo $id; ?>" />
			<input type="hidden" id="content_state" name="content_state" value="<?php echo $cinfo['content_state'] ? $cinfo['content_state'] : '0'; ?>" />
			<input type="submit" class="actionbtn pointer" value="保存修改" />&nbsp;
			<input type="button" class="actionbtn pointer" onclick="SaveAsDraft();" value="存为草稿" />&nbsp;
			<input type="button" class="actionbtn pointer" onclick="history.go(-1);" value="返回列表" />
		</div>
	</form>
</div>
<script type="text/javascript">
//<!--

//存为草稿
function SaveAsDraft() {
	$('#content_state').val('3');
	$('#cform').submit();
}

//标题样式选择器
function ShowStylePicker() {
	art.dialog({
			title:'标题样式',
			content:'<span class="alert bold">颜色: </span>'
					+'<label><input type="radio" name="title_color" value="#000" />默认</label> '
					+'<label><input type="radio" name="title_color" value="#f00" />红色</label> '
					+'<label><input type="radio" name="title_color" value="#0f0" />绿色</label> '
					+'<label><input type="radio" name="title_color" value="#00f" />蓝色</label> '
					+'<span class="alert bold">字体: </span>'
					+'<label><input type="checkbox" name="title_font_bold" value="true" />加粗</label> '
					+'<label><input type="checkbox" name="title_font_italic" value="true" />斜体</label>',
			menuBtn:$(this),
			id:'style_picker'
		},
		function(){
			var obj = $('input[name=title_color]');
			for(var i = 0; i < obj.length; i++) {
				if(obj[i].checked == true) {
					$('#content_title').css('color', obj[i].value);
					break;
				}
			}
			obj = $("input[name=title_font_bold]");
			if(obj.attr('checked') == true) {
				$('#content_title').css('font-weight', 'bold');
			}else{
				$('#content_title').css('font-weight', 'normal');
			}
			obj = $("input[name=title_font_italic]");
			if(obj.attr('checked') == true) {
				$('#content_title').css('font-style', 'italic');
			}else{
				$('#content_title').css('font-style', 'normal');
			}
			$('#content_titlestyle').val($('#content_title').attr('style'));
		}
	);
}

//常用TAG选择器
function TagPicker() {
	art.dialog({
			title:'TAG列表',
			content:'<span id="taglist">Loading...</span>',
			menuBtn:$(this),
			width:'280px',
			height:'120px',
			id:'tag_picker'
		},
		function() {
			var obj = $('input[name=tag_item]');
			var tags = '';
			for(var i = 0; i < obj.length; i++) {
				if(obj[i].checked == true) {
					tags += obj[i].value+' ';
				}
			}
			$('#content_tags').val($.trim(tags));
		}
	);
	$('#taglist').load('index.php?m=admin&a=content&do=taglist');
}

//日历选择控件
Calendar.setup({
	inputField	: "content_time",
	ifFormat	: "%Y-%m-%d %H:%M:%S",
	showsTime	: true,
	timeFormat	: "24",
	button		: "time_picker_icon",
	align		: "Bl",
	singleClick	: true
});
//-->
</script>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>