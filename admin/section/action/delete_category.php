<?
if($id=Lib_Category::getInstance()->delCategory($_POST['id']))
	$response=array("msg"=>"Удалена категория № {$_POST['id']}","status"=>true);
else
	$response=array("msg"=>"Не удалось удалить категорию!","status"=>false);	
echo json_encode($response);