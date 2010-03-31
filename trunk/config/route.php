<?php
/*
 * URI 路由设置
 */
$route['info'] = 'page/index/name';
$route['#(\w*+)\/view\/(\w*+)#'] = '$1/view/key/$2';

/* End of the file */