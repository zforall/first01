<?
require_once "./config.php";

//подключаем страницу каталога
if($_REQUEST['url']=="catalog.php"){

	if(isset($_REQUEST['page'])){
	 $page=$_REQUEST['page']; 
	 $category_id=$_REQUEST['category_id'];
	}

	require_once "./section/".$_REQUEST['url'];
}
else
require_once "./section/".$_REQUEST['url'];

?>