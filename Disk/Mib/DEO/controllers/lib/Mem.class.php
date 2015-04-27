<?php
class Mem {

	/*
		//示例
		include "./M/controllers/lib/Mem.class.php";
		$mems = NEW Mem();
		//=============================================
		$mems->get('keys2');						//获取
		$mems->set('keys2','40',1500);				//设置
		$mems->add('keys2','4--03235',1500);		//新增[已经有了会出错,还没有的就正常]
		$mems->replace('keys2','4--03235',1500);	//替换
		$mems->inc('keys2',1);						//数值 +1
		$mems->des('keys2',2);						//数值 -1
		$mems->del('keys');							//删除
		$mems->clear();								//清除所有
		$mems->close();								//关闭
	*/

	public	$group = ''; 
	private $mmc = NULL;
	private $ver = 0;

	public function __construct($memConfig = array()) {
		$this->mmc = new Memcache;
		if(empty($memConfig)) {
			$memConfig['MEM_SERVER'] = array(array('127.0.0.1', 11211));
			$memConfig['MEM_GROUP'] = 'tag';
		}

		//实现addServer功能
		foreach($memConfig['MEM_SERVER'] as $config) {
			/*
			*先将$memConfig['MEM_SERVER']中的服务器信息遍历出来，服务器信息在配置文件中设置，
			属于array('127.0.0.1', 11211)、	array('127.0.0.2', 11211)....
			*这种类型，然后调用call_user_func_array()函数，该函数的作用,举一个例子说明：
			*当array('127.0.0.1', 11211)时，即call_user_func_array(array($this->mmc, 'addServer'), $config);时是理解为
			*$this->mmc->addServer('127.0.0.1',11211),因为call_user_func_array函数也可以调用类内部的方法的,$config中的元素，对应
			*成为addServer方法的参数
			*/
			call_user_func_array(array($this->mmc, 'addServer'), $config);         
		}
		$this->group = $memConfig['MEM_GROUP'];
		$this->ver = intval( $this->mmc->get($this->group.'_ver') );
    }
 
	//获得memcache的版本信息
	public function version(){
		return $this->mmc->getVersion();
	}

	//读取缓存
	public function get($key) {
		return $this->mmc->get($this->group.'_'.$this->ver.'_'.$key);
	}

	//设置缓存
	public function set($key,$value,$expire = 1800) {
		return $this->mmc->set($this->group.'_'.$this->ver.'_'.$key, $value, 0,$expire);
	}

	//添加缓存
	public function add($key, $value, $expire = 1800) {
		if(!$this->get($key)){
			return $this->mmc->add($this->group.'_'.$this->ver.'_'.$key, $value,0,$expire);
		}else{
			echo "设置失败，该键值被已被注册";
			return false;
		}
	}

	//替换缓存
	public function replace($key, $value, $expire = 1800){
		return $this->mmc->replace($this->group.'_'.$this->ver."_".$key,0, $value);
	}

	//自增1
	public function inc($key, $value = 1) {
		return $this->mmc->increment($this->group.'_'.$this->ver.'_'.$key, $value);
	}

	//自减1
	public function des($key, $value = 1) {
		return $this->mmc->decrement($this->group.'_'.$this->ver.'_'.$key, $value);
	}

	//删除
	public function del($key) {
		return $this->mmc->delete($this->group.'_'.$this->ver.'_'.$key);
	}

	//全部清空
	public function clear() {
		$this->ver = $this->ver + 1;
		return  $this->mmc->set($this->group.'_ver', $this->ver); 
	}

	//关闭缓存
	public function close() {
		return $this->mmc->close();
	}

}
?>