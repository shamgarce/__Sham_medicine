<?php

/*
 * 加载配置文件
 * */
include "Seter/Seter.php";
/*
 * 对象实例化
 * */
$Seter = new Seter();

//============================================================
//对象赋值
$Seter->reawd = 123;
$Seter['reawd'] = 1234;

//调用apc
//$Seter->apc->set_cache("vid",19999999);
//$Seter->apc->get_cache("vid");

//调用Mysql
//$sql = "select * from dy_user";
//$rc = $Seter->db->getall($sql);

//调用 mongodb
//$ar = $Seter->mdb->find("dy_user", array());

//调用memcache

//print_r($ar);
exit;
