<?php
$_SESSION["Auth"] or die("К сожалению такой страницы не существует. [".__FILE__."]");

class Application_Controllers_Enter extends Lib_BaseController
  {
	 
     function __construct()
	 {
		//если пришли данные логин и пароль, создаем модель проверки авторизации и передаем в нее данные.
/* 		if($_REQUEST['login']||$_REQUEST['pass']){		
			$model=new Application_Models_Auth;
			$resultValid=$model->ValidData($_REQUEST['login'],$_REQUEST['pass']);
			//полученный результат проверки записываем в переменные для вывода в публичной части сайта
			$this->unVisibleForm=$resultValid['unVisibleForm'];
			$this->userName=$resultValid['login'];
			$this->msg=$resultValid['msg'];
			$this->login=$resultValid['login'];
			$this->pass=$resultValid['pass'];
			// $_SESSION['uid']=$resultValid['id'];//id пользователя текущей сессии
			// $_SESSION["filtr"]=0;//состояние фильтра по контрагентам первоначально 0, то-есть 'все' !!! надо чтобы брался из сессии
			// $_SESSION["tab"]=1;//состояние контента 1-журнал, 2-прайс, 3-заявка
			
			// if($_REQUEST['location']) header('Location: '.$_REQUEST['location']);
			
		}
		else 
			if($_SESSION["Auth"])$this->unVisibleForm=true;	//Если пользователь уже авторизован, не будем выводить ему форму авторизации
 */		
		//если пользователь послал запрос о выходе из кабинета, сбрасываем флаги авторизации
		// if($_REQUEST['out']=="1"){
			// $_SESSION["Auth"]=false;
			// $_SESSION["User"]="";
			// $_SESSION["role"]="";
			// $this->unVisibleForm=false;
			// header('Location: /');
		// }
//         $tmp = SetCookie('gopa7', time(), time()+3600*24*365); //записывает сериализованную строку в куки, хранит 1 год
//         if ($tmp) var_dump('anus'); else var_dump('kaka');

         switch ($_SESSION["role"])
		{
			 case (1) : { header('Location: /admin'); break;}
			 case (2) : { header('Location: /manager'); break;}
			 case (3) : { header('Location: /seller'); break;}
			 case (4) : { header('Location: /customer'); break;}
//			 case (4) : { require_once "./customer1.php"; break;}
		}

         /* 		$model=new Application_Models_Enter;

           $Items = $model->getLeftList($_SESSION["uid"]);
           $this->LeftItems=$Items;

          if (isset($_REQUEST["u"])) $_SESSION["filtr"]=$_REQUEST["u"];
          switch ($_SESSION["role"])
          {
              case 3 : {  //продавец
                  $Items1 = $model->getPrice($_SESSION["uid"]);
                  $Items2 = $model->getOrders($_SESSION["filtr"], $_SESSION["uid"], $_SESSION["role"]);
                  break;
              }
              case 4 : {  //покупатель
                  $Items1 = $model->getPrice($_SESSION["filtr"]);
                  $Items2 = $model->getOrders($_SESSION["uid"], $_SESSION["filtr"], $_SESSION["role"]);
                  break;
              }
          }
          $this->PriceItems=$Items1;
          $this->OrdersItems=$Items2;

          switch ($_REQUEST['r']) {
              case 1 : $_SESSION["tab"]=1; break;
              case 2 : $_SESSION["tab"]=2; break;
              case 3 : $_SESSION["tab"]=3; break;
          }

          if($_REQUEST['in-cart-product-id']) {// если нажата кнопка купить
              $cart=new Application_Models_Cart;
              $cart->addToCart($_REQUEST['in-cart-product-id']);
              Lib_SmalCart::getInstance()->setCartData();
              header('Location: /enter');
          }*/
		
		// var_dump($_REQUEST['r']);
		
	 }
  }
  /*
*/
?>