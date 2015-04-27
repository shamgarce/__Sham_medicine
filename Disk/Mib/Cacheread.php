<?php



$db = new SQLite3('mysqlitedb.db');

//获取文件2进制流
$filename = "http://www.jb51.net/logo.gif";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize ($filename));
fclose($handle);
//创建数据表
$db->exec('CREATE TABLE person (idnum TEXT,name TEXT,photo BLOB)');

$stmt = $db->prepare("INSERT INTO person VALUES ('41042119720101001X', '张三',?)");
$stmt->bindValue(1, $contents, SQLITE3_BLOB);
$stmt->execute();















echo 1;
/**
 * @param $key
 * @param $value
 * @param int $time     时间
 * @return array|bool
 */
function set_cache($key, $value, $time = 0) {
    if ($time == 0) $time = null; //null情况下永久缓存
    return apc_store($key, $value, $time);
}



/**
 * Apc缓存-获取缓存
 * 通过KEY获取缓存数据
 * @param  string $key   KEY值
 */
function get_cache($key) {
    return apc_fetch($key);
}




/**
 * Apc缓存-清除一个缓存
 * 从memcache中删除一条缓存
 * @param  string $key   KEY值
 */
function clear($key) {
    return apc_delete($key);
}

/**
 * Apc缓存-清空所有缓存
 * 不建议使用该功能
 * @return
 */
function clear_all() {
    apc_clear_cache('user'); //清除用户缓存
    return apc_clear_cache(); //清楚缓存
}

/**
 * 检查APC缓存是否存在
 * @param  string $key   KEY值
 */
function exists($key) {
    return apc_exists($key);
}

/**
 * 字段自增-用于记数
 * @param string $key  KEY值
 * @param int    $step 新增的step值
 */
function inc($key, $step) {
    return apc_inc($key, (int) $step);
}

/**
 * 字段自减-用于记数
 * @param string $key  KEY值
 * @$key int    $step 新增的step值
 */
function dec($key, $step) {
    return apc_dec($key, (int) $step);
}

/**
 * 返回APC缓存信息
 */
function info() {
    return apc_cache_info();
}





exit;
$mem = new Memcache;
$mem->connect("127.0.0.1", 11211);
//保存数据
$mem->set('key1', 'This is first value', 0, 60);
$val = $mem->get('key1');
echo "Get key1 value: " . $val ."<br />";


$mstr = serialize($mem);


//测试

/**
 *
 */
$m = function () {
	//检查 top hash表
	echo 1;
};
//$m  = '123';
//这个可以序列化吗      不可以
//$mstr = serialize($m);


echo $mstr;



/*
 *
 * 重要的
 * 1 : 函数名记忆
 * 2 : 重要单词记忆
 * 3 : 每天阅读
 * 4 : 每天记忆
 *
 *
1 : hash表 APC
2 : 数据缓存暂存 memcache



3 : 永久存储 mysql
4 : 永久存储 mongodb
*/

/*
基本

读取表的某一条记录
User:id:3
User:id:5



$mc  = getmc();

getmc(
    $mc = getmc()
    if(!fmepty()){
        $mc =
    }
    return $mc
);
*/



