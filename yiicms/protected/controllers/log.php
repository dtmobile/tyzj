<?php
ini_set('date.timezone','Asia/Shanghai');
class log
{

	private static $log_filename = 'd:\localization.log';
	public $log_handle;
	private static $_instance;
	
	//private标记的构造方法
	private function __construct()
	{
		$this->log_handle = fopen(self::$log_filename, 'a');
	}
	 
	//创建__clone方法防止对象被复制克隆
	public function __clone(){
		trigger_error('Clone is not allow!',E_USER_ERROR);
	}
	 
	//单例方法,用于访问实例的公共的静态方法
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
		self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function warning($message)
	{
	    fwrite(log::getInstance()->log_handle, "\n".date('Y-m-d H:i:s',time()).':'.'[DEBUG]:'.$message);
	}
}