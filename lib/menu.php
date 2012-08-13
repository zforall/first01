<?php
//класс меню, возвращает html код для меню. 
//Экземпляр класса может быть вызван лишь один раз.
//Реализован патерн Singleton
  class Lib_Menu
  {
	// public $MenuItem = array("Главная"=>"/", "Каталог"=>"/catalog", "Обратная связь"=>"/feedback","Вход"=>"/enter");     
	// public $MenuItem = array("Главная"=>"/", "Вход"=>"/enter");     
	public $MenuItem;     
	// public $UserMenuItem = array("ЖУРНАЛ"=>"/enter?r=1", "ПРАЙС"=>"/enter?r=2");     
	public $UserMenuItem;     
   
	protected static $instance; //(экземпляр объекта) Защищаем от создания через new Singleton

	//--------------------------------------------------
	private function __construct() 
	{
		switch ($_SESSION["role"]) {
			case 2 : {
				$this->MenuItem = array("Главная"=>"/", "Вход"=>"/enter");
				$this->UserMenuItem = array("ЖУРНАЛ"=>"/manager?r=1", "ПРАЙС"=>"/manager?r=2");
				break;
			}
			case 3 : {
				$this->MenuItem = array("Главная"=>"/", "Вход"=>"/enter");
				$this->UserMenuItem = array("ЖУРНАЛ"=>"/seller?r=1", "ПРАЙС"=>"/seller?r=2");
				break;
			}
			case 4 : {
				$this->MenuItem = array("Главная"=>"/", "Вход"=>"/enter");
				$this->UserMenuItem = array("ЖУРНАЛ"=>"/customer?r=1", "ПРАЙС"=>"/customer?r=2");
				break;
			}
		}
	}	

	//--------------------------------------------------
	public static function getInstance() {//Возвращает единственный экземпляр класса
		if (!is_object(self::$instance)) self::$instance = new self;
		return self::$instance;
    }
	 
	//--------------------------------------------------
	public function  getMenu()
	{	
		$print="<ul>";
		if ($this->MenuItem == null ) return "";
		foreach($this->MenuItem as $name=>$item ){
	    if ($name=="Вход" && $_SESSION["User"]!=""){
				$print.='<li><a href="/enter">'.$_SESSION["User"].'</a> [ <a href="/enter?out=1"><span style="font-size:10px">выйти</span></a> ]</li>';
			}			
		else $print.='<li><a href="'.$item.'">'.$name.'</a></li>';
	   }
	   $print.="</ul>";	
	   return  $print;		 
	 }

	//--------------------------------------------------
	public function  getUserMenu()
	{
		$print="<ul>";
		if ($this->MenuItem == null ) return "";
		
		foreach($this->UserMenuItem as $name=>$item ){
			$print.='<li><a href="'.$item.'">'.$name.'</a></li>';
		}
		$print.="</ul>";	
		return  $print;		 
	}
}
/*
*/
?>