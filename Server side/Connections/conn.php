<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn = "localhost";
$database_conn = "u932323222_bookS";
$username_conn = "u932323222_ahmad";//user_panel
$password_conn = "Com123";//h=?EKiOEXs(T
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("set character_set_server='utf8'");
mysql_query("set names 'utf8'");
mysql_set_charset('utf8');
?>