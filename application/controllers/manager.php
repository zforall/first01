<?
$_SESSION["Auth"] or die("К сожалению такой страницы не существует. [".__FILE__."]");

class Application_Controllers_Manager extends Lib_BaseController
{

	// --------------------------------------------------
	// Сравнивает текущее состояния отношений с тем что пришло с формы
	function Diff($arr_list, $arr_checked)
	{
		$flag = false;
		foreach ($arr_list as $key => $value)
		{
			$id = $value['id'];
			
			if (in_array($id, $arr_checked))	$arr_list[$key]['upd']=1;
			else	$arr_list[$key]['upd']=0;
			
			if ($arr_list[$key]['checked']!=$arr_list[$key]['upd']) $flag=true;
		}
		
		$this->ContentItems = $arr_list;

		return $flag;
	}


    function __construct()
	{
		
		$model = new Application_Models_Manager;
 
		if (isset($_REQUEST["r"])) $_SESSION["mr"]=$_REQUEST["r"];
		if (isset($_REQUEST["u"])) $_SESSION["u"]=$_REQUEST["u"];
		if (isset($_REQUEST["uk"])) $_SESSION["uk"]=$_REQUEST["uk"];
		if (isset($_REQUEST["update"]))
			$tmp = $model->UpdateKontr($_REQUEST["id"],$_REQUEST["thelogin"],$_REQUEST["thename"],$_REQUEST["thepassword"],$_REQUEST["inn"],$_REQUEST["email"]);
		if ($tmp) $this->message = "Элемент обновлен";
		if (isset($_REQUEST["newsell"]))
			$tmp = $model->NewKontr(3 ,$_REQUEST["thelogin"],$_REQUEST["thename"],$_REQUEST["thepassword"],$_REQUEST["inn"],$_REQUEST["email"]);
		if (isset($_REQUEST["newcust"]))
			$tmp = $model->NewKontr(4 ,$_REQUEST["thelogin"],$_REQUEST["thename"],$_REQUEST["thepassword"],$_REQUEST["inn"],$_REQUEST["email"]);
		// var_dump($_SESSION["uk"]);
		// else $this->message = "Элемент не обновлен";
		
		$this->LeftItems = $model->GetData($_SESSION["mr"]);
		$this->ContentItems = $model->GetRel($_SESSION["u"]);
		$ts = $model->GetRel($_SESSION["u"]);
		
		if (isset($_REQUEST["upd"])) $diff = $this->Diff($ts, $_REQUEST["upd"]);
		if ($diff) {
			$model->UpdateRel($_SESSION["u"], $this->Get["ContentItems"]);
			$this->ContentItems = $model->GetRel($_SESSION["u"]);
		}

		// $_SESSION["kontr"] = $this->Get["ContentItems"][$_SESSION['uk']];

	}

}
?>