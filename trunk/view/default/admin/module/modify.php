<form action="{#out:site_url('admin/module_modify/id/'.$mod_id)}" method="post">
	<p>模块名称: <input type="text" name="name" id="name" value="{#out:set_value('name', $mod_name)}" /></p>
	<p>模块简介: <input type="text" name="desc" id="desc" value="{#out:set_value('desc', $mod_desc)}" /></p>
	<p>模块类库: <input type="text" name="class" id="class" value="{#out:set_value('class', $mod_class)}" /></p>
	<p>模块插件: <input type="text" name="plugin" id="plugin" value="{#out:set_value('plugin', $mod_plugin)}" /></p>
	<p>管理接口: <input type="text" name="manage" id="manage" value="{#out:set_value('manage', $mod_manage)}" /></p>
	<input type="submit" value="保存" />
	<input type="reset" value="重置" />
</form>