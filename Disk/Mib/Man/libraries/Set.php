<?php
/**
 *
 * $S = new Set();      //集成众多的单例模式
 */
class Set implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * Key-value array of arbitrary data
     * @var array
     */
    public $data = array();

    /**
     * Constructor
     * @param array $items Pre-populate set with this key-value array
     */
    public function __construct($items = array())
    {
        $this->replace($items);
        $this->singleton('db', function ($c) {
            return new Db();
        });
        $this->singleton('mdb', function ($c) {
            return new Mdb();
        });
        $this->singleton('apc', function ($c) {
            return new Apc();
        });
        $this->singleton('logmon', function ($c) {
            return new Logmon();
        });
        $this->singleton('mcache', function ($c) {
            define('MEMCACHE_HOST', '127.0.0.1');
            define('MEMCACHE_PORT', 11211);
            define('MEMCACHE_EXPIRATION', 0);
            define('MEMCACHE_PREFIX', 'licai');
            define('MEMCACHE_COMPRESSION', FALSE);
            return new Mcache();
        });

    }

    /**
     * Normalize data key
     *
     * Used to transform data key into the necessary
     * key format for this set. Used in subclasses
     * like \Slim\Http\Headers.
     *
     * @param  string $key The data key
     * @return mixed       The transformed/normalized data key
     */
    protected function normalizeKey($key)
    {
        return $key;
    }

    /**
     * Set data key to value
     * @param string $key   The data key
     * @param mixed  $value The data value
     */
    public function set($key, $value)
    {
        $this->data[$this->normalizeKey($key)] = $value;
    }

    /**
     * Get data value with key
     * @param  string $key     The data key
     * @param  mixed  $default The value to return if data key does not exist
     * @return mixed           The data value, or the default value
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            $isInvokable = is_object($this->data[$this->normalizeKey($key)]) && method_exists($this->data[$this->normalizeKey($key)], '__invoke');

            return $isInvokable ? $this->data[$this->normalizeKey($key)]($this) : $this->data[$this->normalizeKey($key)];
        }

        return $default;
    }

    /**
     * Add data to set
     * @param array $items Key-value array of data to append to this set
     */
    public function replace($items)
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value); // Ensure keys are normalized
        }
    }

    /**
     * Fetch set data
     * @return array This set's key-value data array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Fetch set data keys
     * @return array This set's key-value data array keys
     */
    public function keys()
    {
        return array_keys($this->data);
    }

    /**
     * Does this set contain a key?
     * @param  string  $key The data key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($this->normalizeKey($key), $this->data);
    }

    /**
     * Remove value with key from this set
     * @param  string $key The data key
     */
    public function remove($key)
    {
        unset($this->data[$this->normalizeKey($key)]);
    }

    /**
     * Property Overloading
     */

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    public function __isset($key)
    {
        return $this->has($key);
    }

    public function __unset($key)
    {
        return $this->remove($key);
    }

    /**
     * Clear all values
     */
    public function clear()
    {
        $this->data = array();
    }

    /**
     * Array Access
     */

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Countable
     */

    public function count()
    {
        return count($this->data);
    }

    /**
     * IteratorAggregate
     */

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Ensure a value or object will remain globally unique
     * @param  string  $key   The value or object name
     * @param  Closure        The closure that defines the object
     * @return mixed
     */
    public function singleton($key, $value)
    {

        $this->set($key, function ($c) use ($value) {
            static $object;
            if (null === $object) {
                $object = $value($c);
            }
            return $object;
        });
    }

    /**
     * Protect closure from being directly invoked
     * @param  Closure $callable A closure to keep from being invoked and evaluated
     * @return Closure
     */
    public function protect(Closure $callable)
    {
        return function () use ($callable) {
            return $callable;
        };
    }

    //--------------------------------------------------------------------------------


    //函数群

    /*
    +----------------------------------------------------------
    * 获得时间戳
    +----------------------------------------------------------
    * 参数:无
    +----------------------------------------------------------
    */
    public static function T(){
        list($usec, $sec) = explode(" ",microtime());
        $num = ((float)$usec + (float)$sec);
        return $num;
    }

    public static function U($str){
        if (empty($str)) return array();
        $arr = unserialize($str);
        $arr = !empty($arr)?$arr:array();
        return $arr;
    }

    /*
    +----------------------------------------------------------
    * 字符转化为数组
    +----------------------------------------------------------
    * 参数:$str 需要转化的字符串 $flit 是否排重 $bl 分割字符
    +----------------------------------------------------------
    */
    public static function getarr($str,$flit='0',$bl = "\r\n"){
        $arr = array();
        if(empty($str)) return $arr;
        //================================================
        $arr_ = explode($bl,$str);
        if($flit) $arr_ = array_unique($arr_);
        foreach($arr_ as $key=>$value){
            if(!empty($value)) $arr[] = trim($value);
        }
        return $arr;
    }

    /*
    +----------------------------------------------------------
    * 数组转化为数组
    +----------------------------------------------------------
    * 参数:$arr 需要转化的数组 $flit 是否排重 $bl 分割字符
    +----------------------------------------------------------
    */
    public static function getstr($arr,$flit='0',$bl = "\r\n"){
        if(empty($arr)) return '';
        //================================================
        foreach($arr as $key=>$value){
            if(!empty($value)) $arr_[] = trim($value);
        }
        if(!empty($arr_)){
            if($flit) $arr_ = array_unique($arr_);
            $str = implode($bl,$arr_);
        }else{
            $str = '';
        }
        return $str;
    }

    /**
    +----------------------------------------------------------
     * // 保存文件
    +----------------------------------------------------------
     * 参数:filename 路径文件名 / text:内容
    +----------------------------------------------------------
     */
    public static function Fs($fileName, $text) {
        if( ! $fileName ) return false;
        if( $fp = @fopen( $fileName, "wb" ) ) {
            if( @fwrite( $fp, $text ) ) {
                fclose($fp);
                return true;
            }else {
                fclose($fp);
                return false;
            }
        }
        return false;
    }

    /**
    +----------------------------------------------------------
     * // 读取文件
    +----------------------------------------------------------
     * 参数:filename 路径文件名
    +----------------------------------------------------------
     */
    public static function Fr($filename){
        if( is_file( $filename ) ){
            $cn = file_get_contents( $filename );
            return $cn;
        }
    }


    /**
    +----------------------------------------------------------
     * // 魔术转义
    +----------------------------------------------------------
     * 参数:string 需要转义的内容   反函数 stripslashes
    +----------------------------------------------------------
     */
    public static function saddslashes($string) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = saddslashes($val);
            }
        } else {
            $string = addslashes($string);
        }
        return $string;
    }

    /**
    +----------------------------------------------------------
     * // html实体转义
    +----------------------------------------------------------
     * 参数:string 需要转义的内容   反函数 htmldecode
    +----------------------------------------------------------
     */
    public static function shtmlspecialchars($string) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = shtmlspecialchars($val);
            }
        } else {
            $string = htmlspecialchars(strip_sql($string), ENT_QUOTES);
        }
        return $string;
    }


    /**
    +----------------------------------------------------------
     * // 内容截取
    +----------------------------------------------------------
     * 参数
    +----------------------------------------------------------
     */
    public static function cut($startstr="",$endstr="",$str){
        if(empty($startstr) || empty($endstr))return false;
        $outstr="";
        if(!empty($str) && strpos($str,$startstr)!==false && strpos($str,$endstr)!==false){
            $startpos	= strpos($str,$startstr);
            $str		= substr($str,($startpos+strlen($startstr)),strlen($str));
            $endpos		= strpos($str,$endstr);
            $outstr		= substr($str,0,$endpos);
        }
        return trim($outstr);
    }



    /**
    +----------------------------------------------------------
     * //判断字符串是否存在
    +----------------------------------------------------------
     */
    public static function strexists($haystack, $needle) {
        return !(strpos($haystack, $needle) === FALSE);
    }
    //--------------------------------------------------------------------------------



    //函数缓存写入和读取,先不要用
//    //=============================================================
//    //读取缓存
//    function Cr($file, $dir = '') {
//        $cachefile = SET_CACHE_PATH . 'data/' . ($dir ? $dir . '/' : '') . $file . '.ca';
//        if (!is_file($cachefile)) {
//            return array();
//        }
//        return include $cachefile;
//    }
//
//    //写入缓存
//    function Cw($file, $array, $dir = '') {
//        //------------------------------------------
//        //不存在->创建
//        $_path = SET_CACHE_PATH .'data/'.($dir ? $dir . '/' : '');
//        !is_dir($_path) && mkdir($_path, 0777);
//        //------------------------------------------
//        $cachefile = $_path . $file . '.ca';
//        $array = "<?php\nreturn " . var_export($array, true) . ";\n? >";
//        $strlen = @file_put_contents($cachefile, $array);
//        @chmod($cachefile, 0777);
//        return $strlen;
//    }
//
//    //删除缓存
//    function Cd($file, $dir = '') {
//        $cachefile = RHCACHE .'data/'. ($dir ? $dir . '/' : '') . $file;
//        return @unlink($cachefile);
//    }













}
