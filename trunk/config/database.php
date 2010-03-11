<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
| -------------------------------------------------------------------
| 数据库连接设置文件
| -------------------------------------------------------------------
| 此文件用以包含连接数据库的必要设置.
|
| -------------------------------------------------------------------
| 可用变量
| -------------------------------------------------------------------
|
|	['hostname'] 数据库服务器主机地址.
|	['username'] 数据库用户名
|	['password'] 数据库密码
|	['database'] 数据库名称
|	['dbdriver'] 数据库驱动类型, 系统支持以下数据库:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] 表名前缀
|	['pconnect'] TRUE/FALSE - 是否启用持久连接
|	['db_debug'] TRUE/FALSE - 是否为调试状态, 显示所有错误
|	['cache_on'] TRUE/FALSE - 是否允许数据库缓存
|	['char_set'] 内容字符集
|	['dbcollat'] 数据库字符集
|
| 变量$active_group用以决定使用那组数据库连接设置
*/

$active_group = "default";

$db['default']['hostname'] = "localhost";
$db['default']['username'] = "freewms";
$db['default']['password'] = "freewms";
$db['default']['database'] = "freewms";
$db['default']['dbdriver'] = "mysql";
$db['default']['dbprefix'] = "freewms_";
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['char_set'] = "utf8";
$db['default']['dbcollat'] = "utf8_general_ci";


/* End of the file */