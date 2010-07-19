<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 用户列表页模版
 */
?>
<?php include MOD_PATH.'templates/header.tpl.php'; ?>
<div id="showmain">
	<div class="titlebar">
		<p> <a href="index.php?m=admin&amp;a=user&amp;do=edit">添加新用户</a></p>
		<?php if(!isset($_GET['state'])):?><p>全站用户管理 &nbsp;说明：</p>
		<?php else: $gb_state = $_GET['state'];?><p>用户审核管理 &nbsp;说明：</p><?php endif;?>
		<form method="post" action="index.php?m=admin&amp;a=user">
			用户状态：
		  <select name="user_state">
			<option value="">全部状态</option>
			<option value="0" <?php if($userstate === '0'){ echo "selected=\"selected\"";}?>>正常</option>
            <option value="1" <?php if($userstate == 1){ echo "selected=\"selected\"";}?>>锁定</option>
            <option value="2" <?php if($userstate == 2){ echo "selected=\"selected\"";}?>>未审核</option>
			</select>&nbsp;
			&nbsp;搜索:
			<select name="mode">
				<option value="0"<?php if($mode === "0"){ echo "selected=\"selected\"";}?>>用户ID</option>
                <option value="1" <?php if($mode == 1){ echo "selected=\"selected\"";}?>>用户名</option>
                <option value="2" <?php if($mode == 2){ echo "selected=\"selected\"";}?>>Email</option>
                <option value="3" <?php if($mode == 3){ echo "selected=\"selected\"";}?>>昵称</option>
			</select>&nbsp;
			<input type="text" class="text" size="14" name="actionnum" value="<?php echo $actionnum; ?>" />
			<?php echo Form::get_error('actionnum', '<span class="fielderrormsg">', '</span>');?>&nbsp;
            &nbsp;排序:
            <select name="sequence">
            <option value="0"<?php if($userstate == 0){ echo "selected=\"selected\"";}?>>注册时间升序</option>
            <option value="1"<?php if($userstate == 1){ echo "selected=\"selected\"";}?>>注册时间降序</option>
            <option value="2"<?php if($userstate == 2){ echo "selected=\"selected\"";}?>>最后登录时间升序</option>
            <option value="3"<?php if($userstate == 3){ echo "selected=\"selected\"";}?>>最后登录时间降序</option>
            <option value="4"<?php if($userstate == 4){ echo "selected=\"selected\"";}?>>用户姓名排序</option>
            <option value="5"<?php if($userstate == 5){ echo "selected=\"selected\"";}?>>用户ID排序</option>
            </select>&nbsp;
			<input type="submit" value="筛选" class="searchbtn pointer" />
		</form>
	</div>
	<form method="post" action="index.php?m=admin&amp;a=user">
		<table cellspacing="1" cellpadding="3" border="0" align="center" width="100%" class="listtable">
			<tr>
				<td class="titletd" width="40px">操作</td>
				<td class="titletd" width="110px">用户名</td>
				<td class="titletd" width="90px">用户组名</td>
                <td class="titletd">Email</td>
				<td class="titletd" width="120px">注册时间</td>
                <td class="titletd" width="10%">注册IP</td>
                <td class="titletd" width="10%">状态</td>
				<td class="titletd" width="160px">操作</td>
			</tr>
			<?php if($userlist == NULL): ?>
			<tr>
				<td class="titletd" colspan="8">没有注册用户！</td>
			</tr>
			<?php else: ?>
			<!--{用户层次列表开始}-->
				<?php foreach ($userlist as $row): ?>
			<tr class="out blue" onmouseout="this.className='out blue'" onmouseover="this.className='over blue'">
				<td class="listtd"><input type="checkbox" name="id[]" value="<?php echo $row['user_id'];?>" onchange="ChangeColor(this);" /></td>
				<td class="listtd"><?php echo $row['user_name']; ?></td>
				<td class="listtd"><?php echo $row['group_name']; ?></td>
				<td class="listtd"><?php echo $row['user_email']; ?></td>
                <td class="listtd"><?php echo date("Y-m-d H:i", $row['user_regtime']); ?></td>
                <td class="listtd"><?php echo $row['user_regip']; ?></td>
                <td class="listtd"><?php
							if($row['user_state'] == 0)  echo "正常";
							if($row['user_state'] == 1)  echo "锁定";
							if($row['user_state'] == 2)  echo "未审核";
							?></td>
				<td class="listtd">
					<a href="index.php?m=admin&amp;a=user&amp;do=edit&id=<?php echo $row['user_id']; ?>" title="修改" >修改</a> |
							<?php if($row['user_state'] == 1):?><a href="index.php?m=admin&amp;a=user&amp;do=normal&amp;id=<?php echo $row['user_id']; ?>" title="解锁">解锁</a> | <?php endif?>
							<?php if($row['user_state'] == 0):?><a href="index.php?m=admin&amp;a=user&amp;do=lock&amp;id=<?php echo $row['user_id']; ?>" title="锁定">锁定</a> | <?php endif?>
							<?php if($row['user_state'] == 2):?><a href="index.php?m=admin&amp;a=user&amp;do=normal&amp;id=<?php echo $row['user_id']; ?>" title="通过">通过</a> | <?php endif?>
                    <a href="index.php?m=admin&amp;a=acl&amp;do=auth_user&amp;id=<?php echo $row['user_id']; ?>" title="管理用户权限">权限</a> |
					<a href="index.php?m=admin&amp;a=user&amp;do=rm&amp;id=<?php echo $row['user_id']; ?>" onclick="return confirm('确认要删除此用户吗?一旦删除将无法恢复.')" title="删除" >删除</a>
				</td>
			</tr>
				<?php endforeach; ?>
			<?php endif;?>
			<tr>
				<td class="actiontd" colspan="8">
					<span class="space6">
						<a class="sa" title="全选" onclick="SelectAll('id[]');ChangeColor('All');" href="javascript:void(0)">全选</a> /
						<a class="sa" title="不选" onclick="ClearAll('id[]');ChangeColor('All');" href="javascript:void(0)">不选</a>
					</span>
					<span class="space3 blue bold">对选中项进行：</span>
					<select name="do">
						<option value="normal">设为正常</option>
						<?php if(!isset($_GET['state'])):?><option value="lock">设为锁定</option><?php endif?>
                        <option value="passEmail">通过邮件验证</option>
                        <option value="passAdmin">通过管理员验证</option>
						<option value="rm">删除</option>
					</select>
					<input type="submit" class="actionbtn pointer" value="执行">
				</td>
			</tr>
			<tr>
				<td class="pagetd" colspan="8">
					<div id="paginate"><?php echo Paginate::get_paginate('firstpage', 'currentpage') ?></div>
				</td>
			</tr>
		</table>
    </form>
</div>
<?php include MOD_PATH.'templates/footer.tpl.php'; ?>