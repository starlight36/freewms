{#include:admin/header}
{#out:msgtype} : {#out:msgstr}
<ul>
<?php foreach($golist as $gomsg => $url): ?>
	<li><a href="{#out:url}" title="{#out:gomsg}">{#out:gomsg}</a></li>
<?php endforeach;?>
</ul>
{#include:admin/footer}