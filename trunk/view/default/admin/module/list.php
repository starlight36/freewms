{#include:admin/header}
<div class="mainmodwrap">
	<div class="mainmod">
		<div class="modtitle">系统内容模型列表</div>
		<div class="modcontent">
			<div><a href="{#out:site_url('admin/module_modify/id/0')}" title="添加新模型">添加模型</a></div>
			<!--#if{!empty($list)}-->
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<th style="width: 10%">ID</th>
						<th style="width: 15%">模型名称</th>
						<th style="width: 45%">模型说明</th>
						<th style="width: 15%">模型类型</th>
						<th style="width: 15%">操作</th>
					</tr>
				<!--#loop{$list}-->
					<tr>
						<td>{#item:mod_id}</td>
						<td>{#item:mod_name}</td>
						<td>{#item:mod_desc}</td>
						<!--#if{$item['mod_is_system']}-->
						<td>系统模型</td>
						<!--#else-->
						<td>用户模型</td>
						<!--#endif-->
						<td>
							<a href="{#out:site_url('admin/module_modify/id/'.$item['mod_id'])}" title="编辑模型">编辑</a>
							<!--#if{!$item['mod_is_system']}-->
							| <a href="{#out:site_url('admin/module_remove/id/'.$item['mod_id'])}" title="删除此模型" onclick="return confirm('确认要删除此模型吗?');">删除</a>
							<!--#endif-->
						</td>
					</tr>
				<!--#endloop-->
				</table>
			<!--#else-->
			暂无任何模型
			<!--#endif-->
		</div>
	</div>
</div>
{#include:admin/header}