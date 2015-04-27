<?php
include "Seter/Config.php";
$Seter = new Seter();               //实例化对象


echo __DIR__.'<br>';
echo __FILE__.'<br>';
$m = $Seter->uri->_do();

echo $m;


exit;









?>
<!Doctype html>
<html>
<head>
<title>路由测试~~</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

//$fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace);
//echo DIRECTORY_SEPARATOR;

    date_default_timezone_set("Asia/Shanghai");
    define("MODULE_DIR", "../class/");
    $_DocumentPath = $_SERVER['DOCUMENT_ROOT'];         //=>    E:/www/slim-API/public_html
    //$_FilePath = str_replace('\\', DIRECTORY_SEPARATOR, __FILE__);        //linux下
    $_FilePath = __FILE__;                              //=>    E:\www\slim-API\public_html\route.php
    $_RequestUri = $_SERVER['REQUEST_URI'];             //=>    /route.php?s=232

//echo "DOCUMENT_ROOT_____".$_RequestUri.'<br>';
//echo "__FILE_______".$_FilePath.'<br>';
//echo "REQUEST_URI_____".$_RequestUri.'<br>';

    $_AppPath = str_replace(Seter::uri($_DocumentPath), '', Seter::uri($_FilePath));    //==>\route.php



    $_UrlPath = $_RequestUri;    //==>/router/hello/router/a/b/c/d/abc/index.html?id=3&url=http:
    $_AppPathArr = explode(DIRECTORY_SEPARATOR, $_AppPath);



/**
* http://192.168.0.33/router/hello/router/a/b/c/d/abc/index.html?id=3&url=http:
* /hello/router/a/b/c/d/abc/index.html?id=3&url=http:
*/

    for ($i = 0; $i < count($_AppPathArr); $i++) {
        $p = $_AppPathArr[$i];
        if ($p) {
            $_UrlPath = preg_replace('/^\/'.$p.'\//', '/', $_UrlPath, 1);
        }
    }




//echo 1;
/*
 * return       => /qwe/qwe/asdf
 * querystring  => $_GET
 *获得uri的资源获取
 * */
function _detect_uri()
{
    if ( !isset($_SERVER['REQUEST_URI']) OR !isset($_SERVER['SCRIPT_NAME']))
    {
        return '';
    }
    $uri = $_SERVER['REQUEST_URI'];
    if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
    {
        $uri = substr($uri, strlen($_SERVER['SCRIPT_NAME']));           //如果是本文件
    }
    elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
    {
        $uri = substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
    }
//echo $uri;
//exit;
    // This section ensures that even on servers that require the URI to be in the query string (Nginx) a correct
    // URI is found, and also fixes the QUERY_STRING server var and $_GET array.
    if (strncmp($uri, '?/', 2) === 0)
    {
        $uri = substr($uri, 2);
    }
    $parts = preg_split('#\?#i', $uri, 2);
    $uri = $parts[0];
    if (isset($parts[1]))
    {
        $_SERVER['QUERY_STRING'] = $parts[1];
        parse_str($_SERVER['QUERY_STRING'], $_GET);
    }
    else
    {
        $_SERVER['QUERY_STRING'] = '';
        $_GET = array();
    }
    if ($uri == '/' || empty($uri))
    {
        return '/';
    }
    $uri = parse_url($uri, PHP_URL_PATH);
    // Do some final cleaning of the URI and return it
    return str_replace(array('//', '../'), '/', trim($uri, '/'));
}




$ms = _detect_uri();          //完成对访问资源的定位        => $_GET;

print_r($ms);
print_r($_GET);

exit;








//Note: 另一种方法
//PHP 常量 PHP_SAPI 具有和 php_sapi_name() 相同的值。
echo "重要函数 array_slice() ";
ECHO php_sapi_name();
EXIT;

print_r($_AppPathArr);
print_r($_UrlPath);
//echo $_AppPath.'<br>';
exit;

    $_UrlPath = preg_replace('/^\//', '', $_UrlPath, 1);
    $_AppPathArr = explode("/", $_UrlPath);
    $_AppPathArr_Count = count($_AppPathArr);
    $arr_url = array(
        'controller' => 'index',
        'method' => 'index',
        'parms' => array()
    );


    $arr_url['controller'] = $_AppPathArr[0];
    $arr_url['method'] = $_AppPathArr[1];

    if ($_AppPathArr_Count > 2 and $_AppPathArr_Count % 2 != 0) {
        die('参数错误');
    } else {
        for ($i = 2; $i < $_AppPathArr_Count; $i += 2) {
            $arr_temp_hash = array(strtolower($_AppPathArr[$i])=>$_AppPathArr[$i + 1]);
            $arr_url['parms'] = array_merge($arr_url['parms'], $arr_temp_hash);
        }
    }

    $module_name = $arr_url['controller'];
    $module_file = MODULE_DIR.$module_name.'.class.php';
    $method_name = $arr_url['method'];

if (file_exists($module_file)) {
    include $module_file;
    $obj_module = new $module_name();
    if (!method_exists($obj_module, $method_name)) {
        die("要调用的方法不存在");
    } else {
        if (is_callable(array($obj_module, $method_name))) {
            $obj_module -> $method_name($module_name, $arr_url['parms']);
            $obj_module -> printResult();
        }
    }
} else {
    die("定义的模块不存在");
}
?>

</body>
</html>
