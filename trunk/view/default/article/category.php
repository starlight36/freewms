{#include:header}
{#out:category_name}
<br />
下级还有分类
<ul>
	<!--#loop{$content_list}-->
	<li><a href="{#item:url}">{#item:title}</a></li>
	<!--#loopend-->
</ul>
{#include:footer}