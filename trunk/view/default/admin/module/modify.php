<form action="{#out:site_url('admin/module_modify/id/'.$mod_id)}" method="post">
	<table style="width: 100%" class="dialog_form">
		<tr>
			<td>模块在哪名称:</td>
			<td><input type="text" name="name" id="name" value="{#out:set_value('name', $mod_name)}" /></td>
		</tr>
		<tr>
			<td>模块简介:</td>
			<td><input type="text" name="desc" id="desc" value="{#out:set_value('desc', $mod_desc)}" /></td>
		</tr>
		<tr>
			<td>模块类库:</td>
			<td><input type="text" name="class" id="class" value="{#out:set_value('class', $mod_class)}" /></td>
		</tr>
		<tr>
			<td>模块插件:</td>
			<td><input type="text" name="plugin" id="plugin" value="{#out:set_value('plugin', $mod_plugin)}" /></td>
		</tr>
		<tr>
			<td>管理接口:</td>
			<td><input type="text" name="manage" id="manage" value="{#out:set_value('manage', $mod_manage)}" /></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;">
				<input type="submit" value="保存" />
				<input type="reset" value="重置" />
			</td>
		</tr>
	</table>
</form>