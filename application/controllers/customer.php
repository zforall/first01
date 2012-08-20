<?php

$_SESSION["Auth"] or die("К сожалению такой страницы не существует. [".__FILE__."]");

class Application_Controllers_Customer extends Lib_BaseController
{

     function __construct()
	 {
//         $tmp = SetCookie('gopa7', time(), time()+3600*24*365); //записывает сериализованную строку в куки, хранит 1 год
//         if ($tmp) var_dump('anus'); else var_dump('kaka');

         $model=new Application_Models_Customer;

         if (isset($_REQUEST["u"])) $_SESSION["filtr"] = $_REQUEST["u"];

         $this->LeftItems   = $model->getLeftList($_SESSION["uid"]);
         $this->PriceItems  = $model->getPrice($_SESSION["filtr"]);
         $this->OrdersItems = $model->getOrders($_SESSION["uid"], $_SESSION["filtr"]);

         switch ($_REQUEST['r']) {
             case 1 : $_SESSION["tab"]=1; break;
             case 2 : $_SESSION["tab"]=2; break;
             case 3 : $_SESSION["tab"]=3; break;
         }

         if($_REQUEST['in-cart-product-id']) {// если нажата кнопка купить
//             echo('<br>');var_dump($_REQUEST['in-cart-product-id']);echo('<br>');
             $model->addToCart($_REQUEST['in-cart-product-id']);
             $model->setCartData();
             header('Location: /customer');
//             var_dump($model->getCartData());
         }
//        $this->smal_cart=Lib_SmalCart::getInstance()->getCartData();
         $this->smal_cart = $model->getCartData();
//         var_dump($this->Get('smal_cart'));

     }

}

?>