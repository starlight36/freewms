{#include:admin/header}
<div class="mainmodwrap">
	<div class="mainmod">
		<div class="modtitle">频道列表</div>
		<div class="modcontent">
			<div><a href="{#out:site_url('admin/channel_modify/id/0')}" title="添加新模型">添加频道</a></div>
			<!--#if{!empty($list)}-->
				<!--#loop{$list}-->
					{#item:ch_name}|{#item:ch_desc}
				<!--#endloop-->
			<!--#else-->
			暂无任何频道
			<!--#endif-->
		</div>
	</div>
</div>
{#include:admin/header}