class CacheMoney {
	
	public $file = 'class.stored.php';
	public $class = 'Stored';
	public $age = 3;
	public $force = true;
	public $queries;

	function __construct($params,$queries=null){
	
		if(isset($params['file'])){
			$this->file = $params['file'];
		}
		
		if(isset($params['age'])){
			$this->age = $params['age'];
		}
		
		if(isset($params['class'])){
			$this->class = $params['class'];
		}
		
		if(isset($params['force'])){
			$this->force = $params['force'];
		}
		
		if(isset($queries)){
			$this->queries = $queries;
		}
		
		if(!empty($queries)){
			$this->checkAndGo();
		}
	
	}
	
	public function setQueries($queries){
		
		if(!empty){
			$this->queries = $queries;
			return true;
		} else {
			return false;
		}
				
	}
	
	public function checkAndGo(){
				
		if($this->force==false){
			
			if($this->isExpired()==false){ //cache is not expired
				return false;
			} else { //cache is expired
				$this->buildCache();
				return true;	
			}
			
		} else{ //force cache rebuild
			$this->buildCache();
			return true;
		}
		
	}
	
	public function buildCache(){
		
		$arr=$this->queries;
				
		foreach($arr as $key => $value){
			$vars .= 'public static $'.$key.' = \''.serialize($value).'\';
			';			
		}
						
		$body='
		<?php
					
		Class '.$this->class.'{
		
			public static $hashedoutcrazydate = \''.date(DATE_RFC822).'\';
			public static $hashedoutmaxage = \''.$this->age.'\';
			'.$vars.'
			
			public static function getDate(){
				return self::$hashedoutcrazydate;
			}
			
			public static function isExpired($time_limit){
			
				if(empty($time_limit)) { $time_limit = self::$hashedoutcrazymaxage}
				
				$last_modified = strtotime(self::getDate());
		
				if(time()-$last_modified > $time_limit){
				    return true;
				} else {
					return false;
				}
				
			}
		
		}
					
		?>';
		
		file_put_contents($this->file, $body);
	
	}
	
	public function isExpired(){
		
		$days_old=$this->age;
		
		$time_limit = $days_old*24*60*60;
		
		require_once $this->file;
				
		$last_modified = strtotime(call_user_func(array($this->class, 'getDate')));
		
		if(time()-$last_modified > $time_limit){
		    //$this->buildCache();
		    return true;
		}
		else {
			return false;
		}
	}

}