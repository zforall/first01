<?
$_SESSION["Auth"] or die("К сожалению такой страницы не существует. [".__FILE__."]");

class Application_Controllers_Customer extends Lib_BaseController
{

	//--------------------------------------------------
    function __construct()
	{
		$model=new Application_Models_Customer;
		
		$Items = $model->getLeftList($_SESSION["uid"]);	
		 
		if (isset($_REQUEST["u"])) $_SESSION["filtr"] = $_REQUEST["u"];
		
		$Items1 = $model->getPrice($_SESSION["filtr"]);
		
		$Items2 = $model->getOrders($_SESSION["uid"], $_SESSION["filtr"]);	

		$this->LeftItems = $Items;
		$this->PriceItems = $Items1;
		$this->OrdersItems = $Items2;

		switch ($_REQUEST['r']) {
			case 1 : $_SESSION["tab"]=1; break;
			case 2 : $_SESSION["tab"]=2; break;
			case 3 : $_SESSION["tab"]=3; break;
		} 

	}

}

?>