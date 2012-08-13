<?php
//любой контролер будет наследоваться от базового класса
class Lib_BaseController 
{
    private $member; 
		
    function isAuth()
	{	     
		//если пришли данные логин и пароль, создаем модель проверки авторизации и передаем в нее данные.
		if($_REQUEST['login']||$_REQUEST['pass']){		
			$model=new Application_Models_Auth;
			$resultValid=$model->ValidData($_REQUEST['login'],$_REQUEST['pass']);
			//полученный результат проверки записываем в переменные для вывода в публичной части сайта
			// $this->unVisibleForm=$resultValid['unVisibleForm'];
			// $this->userName=$resultValid['login'];
			// $this->msg=$resultValid['msg'];
			// $this->login=$resultValid['login'];
			// $this->pass=$resultValid['pass'];
			// $_SESSION['uid']=$resultValid['id'];//id пользователя текущей сессии
			// $_SESSION["filtr"]=0;//состояние фильтра по контрагентам первоначально 0, то-есть 'все' !!! надо чтобы брался из сессии
			// $_SESSION["tab"]=1;//состояние контента 1-журнал, 2-прайс, 3-заявка
			
			// if($_REQUEST['location']) header('Location: '.$_REQUEST['location']);
			
		}
		else 
			if($_SESSION["Auth"])$this->unVisibleForm=true;	//Если пользователь уже авторизован, не будем выводить ему форму авторизации
		
		//если пользователь послал запрос о выходе из кабинета, сбрасываем флаги авторизации
		if($_REQUEST['out']=="1"){
			$_SESSION["Auth"]=false;
			$_SESSION["User"]="";
			$_SESSION["role"]="";
			$this->unVisibleForm=false;
			header('Location: /');
		}
    }


	function __set($name,$val)
	 {	     
		$this->member[$name] = $val;
     }

     function __get($name) 
	 {
		  return $this->member;	
     }  		 

     function Get($name) 
	 {
		  return $this->member[$name];	
     }  		 
 }
 /*
*/
?>