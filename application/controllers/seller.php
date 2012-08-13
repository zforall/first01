<?
$_SESSION["Auth"] or die("К сожалению такой страницы не существует. [".__FILE__."]");

class Application_Controllers_Seller extends Lib_BaseController
{
	 
    function __construct()
	{

		$model = new Application_Models_Seller;

		$Items = $model->getLeftList($_SESSION["uid"]);	
		$this->LeftItems=$Items;
		 
		if (isset($_REQUEST["u"])) $_SESSION["filtr"]=$_REQUEST["u"];

		$Items1 = $model->getPrice($_SESSION["uid"]);
		$Items2 = $model->getOrders($_SESSION["filtr"], $_SESSION["uid"], $_SESSION["role"]);	

		$this->PriceItems = $Items1;
		$this->OrdersItems = $Items2;

		switch ($_REQUEST['r']) {
			case 1 : $_SESSION["tab"]=1; break;
			case 2 : $_SESSION["tab"]=2; break;
			case 3 : $_SESSION["tab"]=3; break;
		}


		if(isset($_FILES["filename"]))
		{
						var_dump($_FILES["filename"]);

			// if($_FILES["filename"]["size"] > 1024*3*1024)
		   // {
			 // echo ("Размер файла превышает три мегабайта");
			 // exit;
		   // }
		   
		   // Проверяем загружен ли файл
			if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
			{
				var_dump($_FILES["filename"]);

			 // Если файл загружен успешно, перемещаем его
			 // из временной директории в конечную
			move_uploaded_file($_FILES["filename"]["tmp_name"], "uploads/".$_FILES["filename"]["name"]);
			} else {
			  loger("error_file_loading ".$_FILES["filename"]["error"]);
			}
			$model->loadPrice();
		}

	}

}

?>