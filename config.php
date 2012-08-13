<?php
//Error_Reporting(E_ALL & ~E_NOTICE);//не выводить предупреждения
 function __autoload ($class_name) //автоматическая загрузка кслассов
 {
    $path=str_replace("_", "/", strtolower($class_name));//разбивает имя класска получая из него путь

    if (file_exists($path.".php")) {
   
     include_once($path.".php");//подключает php файл по полученному пути	
	}
	else{

	header("HTTP/1.0 404 Not Found");
	echo "К сожалению такой страницы не существует. [".PATH_SITE.$path.".php ]";
	exit;
	}
 }
 define('PATH_SITE', $_SERVER['DOCUMENT_ROOT']); 		//сервер
 require_once "./setting_sql.php"; //файл настроек
 
 
 
function put($filename,$content,$mode = 'w+')
{
    if (!$handle = fopen($filename, $mode)) {
        return false;
    }

    if (fwrite($handle, $content) === false) {
			fclose($handle);
		return false;
    }

		fclose($handle);
	return true;
}

function loger($text, $mode = 'a')
{	

	$filename = "log_".date("Y_m_d").".txt";
	$string = date("d.m.Y H:i:s")." => $text"."\n";
	put($filename, $string, $mode);
	return true;
}