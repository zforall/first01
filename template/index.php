<?
//==================подключаем шаблон сайта===========//	
// Вывод шапки
error_reporting(E_ALL);
// error_reporting(0);
require_once "header.php";
// Вывод контента
	
	  
 $view=$router->getView();
 
 include ($view); 
// Вывод подвала
require_once "footer.php";
?>