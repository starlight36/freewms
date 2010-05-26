<?php
/*
 * URI 路由设置
 */
//自定义页面的路由
$route['info'] = 'page/index/name';

//分类页路由
$route['#category\/(\w*+)#'] = 'content/category/key/$1';

//内容页路由
$route['#view\/(\w*+)#'] = 'content/view/key/$1';

/* End of the file */