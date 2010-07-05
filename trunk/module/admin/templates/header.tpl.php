<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 后台页首
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo Url::base();?>module/admin/images/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo Url::base();?>js/artdialog/skin/admin/style.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo Url::base();?>js/jquery/core.js"></script>
<script type="text/javascript" src="<?php echo Url::base();?>module/admin/images/common.js"></script>
<script type="text/javascript" src="<?php echo Url::base();?>js/artdialog/artDialog.min.js"></script>
<title><?php echo Config::get('site_name'); ?> - <?php echo Lang::_('admin_index_title');?></title>
<base href="<?php echo Url::base();?>"></base>
</head>
<body>
<script type="text/javascript">ShowLoadMsg();</script>
<div id="all">