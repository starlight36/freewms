<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/*
 * 用户注册模块
 */

Cache::get_page('index', 7200);

Lang::load('index');
View::set_title(Lang::_('mod_index_title'));
View::load('index/index');
Cache::set_page('index');

//处理登录动作
$form = new Form($_POST);
if($form->is_post()) {
    $form->set_field('admin', Lang::_('admin_login_user_name_tip'), 'required', 'trim');



$sql=insert into user () values ('');
}
/* End of this file */