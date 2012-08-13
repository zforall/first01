<?php
//модель авторизации
 class Application_Models_Auth extends Lib_DateBase
  {	  
	//проверка данных авторизации и установка данных сессии
	  function ValidData($login,$pass)
	  {

	    $sql = parent::query("SELECT * FROM `users` WHERE login='%s' and password='%s'",$login,md5($pass));
	    if( parent::num_rows($sql))
		    { 
			$row=parent::fetch_assoc($sql);
			$_SESSION["Auth"]=true;  
			$_SESSION["uid"]=$row["id"];//id пользователя текущей сессии
			$_SESSION["User"]=$login;  
			$_SESSION["role"]=$row["role_id"];  
			
			$_SESSION["filtr"]=-1;//состояние фильтра по контрагентам первоначально -1, то-есть 'все' !!! надо чтобы брался из сессии
			$_SESSION["tab"]=1;//состояние контента 1-журнал, 2-прайс, 3-заявка
			
			
			} 
		else $_SESSION["Auth"]=false;  

		if (!$_SESSION["Auth"]){
			$msg="<em><span style='color:red'>Данные введены не верно!</span></em>";
		}	
		else {
			$msg="<em><span style='color:green'>Вы верно ввели данные!</span></em>";
			$unVisibleForm=true;
		}
		
		$result=array("unVisibleForm"=>$unVisibleForm,
						"userName"=>$login,
						"msg"=>$msg,
						"login"=>$login,
						"pass"=>$pass,
						"id"=>$_SESSION["id"],);
		return $result;
		
	  }
  } 
  /*
*/