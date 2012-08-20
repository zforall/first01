<?php
 class Lib_Application extends Lib_DateBase //класс маршрутизатор, подбирает нужный контролер для обработки данных
 {
    public $route='index';
	
	public function __construct()
	{
		if($_GET['route']!="favicon.ico")
		$this->getRoute();
	}
	
	private function getRoute() //получить маршрут .htaccess формирует ссылку таким образом, что в параметры гет запроса попадает требуемый маршрут
    {
	   $route=$this->route;
	   if (empty($_GET['route']))
       {
         $route = 'index';
	   }
         else
	   {
	  // print_r($_GET['route']);
            $route = $_GET['route'];				
			$rt=explode('/', $route);
			$route=$rt[(count($rt)-1)]; //product/monitor перенаправляем только на monitor
			//проверим не к продукту ли из каталога пытается обратиться пользователь
			//если до /monitor есть /product/
			//то будем искать полученный в каталоге id продукта по запрашиваемой ссылке
		//	echo 	$route;
		
			if(isset($rt[(count($rt)-2)])){		
				$sql = "SELECT  c.url as category_url, p.url as product_url, p.id  FROM product p LEFT JOIN category c ON c.id=p.cat_id WHERE p.url like '$route'";
				$result = parent::query($sql);
							
				if($obj = parent::fetch_object($result)){			
					if($rt[(count($rt)-2)]==$obj->category_url){			
						 $sql = "SELECT  p.id  FROM product p WHERE p.url like '%s'";
						 $result = parent::query($sql,$route);
						
					
						 if($row = parent::fetch_object($result))
						 {
							 $_REQUEST['id']=$row->id;
							 $route="product";
						 }					
					}
				}
			}
			else{
				$sql = "SELECT  c.url as category_url, c.id FROM category c WHERE c.url like '%s'";
				$result = parent::query($sql,$route);
				if($obj = parent::fetch_object($result)){
					$_REQUEST['category_id']=$obj->id;
					$route="catalog";
				}
			}
	   }
	    $this->route=$route;
		return $route;
    }

    private function getController()//получить контролер
	{       
       $route=$this->route;
	   if($route!="admin"){
	   $path_contr = 'application/controllers/';
       $controller= $path_contr. $route . '.php';
	   }
	
       return $controller;
    }
	 
	public function getView()//получить представление для контролера
	{
       $route=$this->route;
	   if($route!="admin"){
	   $path_view = 'application/views/' ;
       $view = $path_view . $route . '.php';
	   }

       return $view;
    }
	 
	public function Run()// запуск процесса обработки данных
	{ 
		session_start(); //открываем сессию
		
		
		//если это авторизация - проверяем данные устанавливаем переменные сессии
		if($_REQUEST['login']||$_REQUEST['pass']){		
			$model=new Application_Models_Auth;
			$resultValid=$model->ValidData($_REQUEST['login'],$_REQUEST['pass']);
			
		}

		
		
		if($_REQUEST['out']=="1"){
			$_SESSION["Auth"]=false;
			$_SESSION["User"]="";
			$_SESSION["role"]="";
			// $this->unVisibleForm=false;
			header('Location: /');
		}
		
		
	   $controller=$this->getController();//получаем контролер
	   $cl=explode('.', $controller);
	   
	   $cl=$cl[0]; //отбрасываем расширение, получаем только путь до контролера
    
	    $name_contr=str_replace("/", "_", $cl);//заменяем в пути слеши на подчеркивания, таким образом получая название класса
//	    var_dump($name_contr);
        $contr=new $name_contr;//создаем экземпляр класса контролера


	   
       $member=$contr->member;//получаем переменные контролера
	   
	   return $member;
	   
	
	}

}
 
 /*
*/
?>