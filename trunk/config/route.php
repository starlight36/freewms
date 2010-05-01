<?php
/*
 * URI 路由设置
 */
//自定义页面的路由
$route['info'] = 'page/index/name';

//分类页路由
$route['#(\w*+)\/category\/(\w*+)#'] = '$1/category/key/$2';

//内容页路由
$route['#(\w*+)\/view\/(\w*+)#'] = '$1/view/key/$2';

/* End of the file */