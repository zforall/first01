<?
$_SESSION["Auth"] or die("К сожалению такой страницы не существует. [".__FILE__."]");

class Application_Controllers_Seller extends Lib_BaseController
{
	 
    function __construct()
	{
		$status = ''; //диагностические сообщения в строку статуса
		
		//ошибки при загрузке файла
		$upload_errors = array( 
			UPLOAD_ERR_OK        => "No errors.", 
			UPLOAD_ERR_INI_SIZE    => "Larger than upload_max_filesize.", 
			UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.", 
			UPLOAD_ERR_PARTIAL    => "Partial upload.", 
			UPLOAD_ERR_NO_FILE        => "No file.", 
			UPLOAD_ERR_NO_TMP_DIR    => "No temporary directory.", 
			UPLOAD_ERR_CANT_WRITE    => "Can't write to disk.", 
			UPLOAD_ERR_EXTENSION     => "File upload stopped by extension.", 
			UPLOAD_ERR_EMPTY        => "File is empty." // add this to avoid an offset 
		); 

		$model = new Application_Models_Seller;

		if (isset($_REQUEST["r"])) $_SESSION["tab"]=$_REQUEST["r"];
		else $_SESSION["tab"]=1;
		 
		if (isset($_REQUEST["u"])) $_SESSION["filtr"]=$_REQUEST["u"];

		if (isset($_REQUEST['del'])) $status .= $model->delSelected($_REQUEST['del']);;

		$this->LeftItems   = $model->getLeftList($_SESSION["uid"]);	
		$this->PriceItems  = $model->getPrice($_SESSION["uid"]);
		$this->OrdersItems = $model->getOrders($_SESSION["filtr"], $_SESSION["uid"], $_SESSION["role"]);	

		if(isset($_FILES["filename"]))
		{
		   // Проверяем загружен ли файл
			if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
			{
				// Если файл загружен успешно, перемещаем его
				// из временной директории в конечную
				move_uploaded_file($_FILES["filename"]["tmp_name"], "uploads/".$_FILES["filename"]["name"]);
				$status .= $model->loadPrice();
			} else {
			  loger("error_file_loading ".$upload_errors[$_FILES["filename"]["error"]]);
			}
		}
		
		$this->Status = $status;

	}

}

?>