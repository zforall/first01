<?php

$_SESSION["Auth"] or die("К сожалению такой страницы не существует. [".__FILE__."]");

class Application_Controllers_Customer extends Lib_BaseController
{

     function __construct()
	 {

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
             $model->addToCart($_REQUEST['in-cart-product-id']);
             $model->setCartData();
             header('Location: /customer');
         }

         $this->smal_cart = $model->getCartData();

     }
}

?>
