<?

if($id=Lib_Category::getInstance()->addCategory($_POST))
	$response=array("msg"=>"Создана категория № $id","status"=>true);
else
	$response=array("msg"=>"Не удалось создать категорию!","status"=>false);	
echo json_encode($response);