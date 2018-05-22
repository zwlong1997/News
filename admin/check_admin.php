<?php

session_start(); //开启回话

if(!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']))
{
    session_destroy();  //销毁整个会话 和里面的所有缓存变量
    show_msg("请登录","login.php");
}


?>