模型列表
{#if:!empty($modlist)}
	{#loop:modlist}
	<li>ID:{#item:mod_id}|name:{#item:mod_name}|class:{#item:mod_class}|plugin:{#item:mod_plugin}|manage:{#item:mod_manage}</li>
	{#endloop}
{#else}
暂无任何模型
{#endif}
