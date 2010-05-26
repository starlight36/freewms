{#include:header}
hello, world!
<!--#get:clist{
	array(
		'order' => array(					//排序条件
			'time' => 'desc'				//时间降序排列
		),
		'limit' => 1
	)
}-->
<!--#if{empty($clist)}-->
<p>没找到任何条目</p>
<!--#else-->
<ul>
	<!--#loop{$clist}-->
	<li>{#item:title}|{#item:url}</li>
	<!--#endloop-->
</ul>
<!--#endif-->
{#include:footer}