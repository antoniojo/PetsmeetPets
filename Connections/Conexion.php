<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
//$hostname_Conexion = "xxx";
//$database_Conexion = "xxx";
//$username_Conexion = "xxx";
//$password_Conexion = "xxx";
$hostname_Conexion = "localhost";
$database_Conexion = "petsmeetpets";
$username_Conexion = "root";
$password_Conexion = "";
$Conexion = mysql_pconnect($hostname_Conexion, $username_Conexion, $password_Conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
?>