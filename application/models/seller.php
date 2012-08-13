<?php
//модель выборки данных продавца
class Application_Models_Seller  extends Lib_DateBase
{	  

	//--------------------------------------------------
	function loadPrice()
	{ 
 		$f = file("uploads/".$_FILES["filename"]["name"]) or die("pipez");
		$fsize = count($f);
		$result = true;
		for ($i=0; $i<$fsize; $i++)
		{
			$prod = explode(";",$f[$i]);

			if (count($prod)<4) continue; // если она пустая (глюки), пропускаем

			//Если есть уже с таким артикулом то обновляем
			$theuid = $_SESSION["uid"];
			$sql = "SELECT * FROM products WHERE sid='$theuid' and art='$prod[0]'";
			$result = parent::query($sql);
			if ($result!=false) //такой уже есть в базе - пытаемся обновить
			{
				$sql = "UPDATE products SET name='$prod[1]', price='$prod[2]', count='$prod[3]' WHERE sid='$theuid' and art='$prod[0]'";
				$result = parent::query($sql);
			} else 
			{
				$sql = "INSERT INTO products (sid, art, name, price, count) VALUES ('$theuid', '$prod[0]', '$prod[1]', '$prod[2]', '$prod[3]')";
				$result = parent::query($sql);
			}
			
		}

		return $result;
	}
	
	//--------------------------------------------------
	function getLeftList($uid)
	{ 
		if (!isset($uid)) return NULL;
		$sql = "SELECT id, name FROM users WHERE id IN (SELECT uid2 FROM relations WHERE uid1=$uid)";
		$result = mysql_query($sql)  or die(mysql_error());
	
		while ($row = mysql_fetch_assoc($result))
		{		 
			$LeftItems[]=array(
				"id"=>$row['id'],
				"name"=>$row['name'],
			);
		}
		return $LeftItems; 
	}
	
	//--------------------------------------------------
	function getPrice($uid)
	{ 
		if (!isset($uid)) return NULL;
		$sql = "SELECT id, art, name, price, count FROM products WHERE sid=$uid";
		 
		$result = mysql_query($sql)  or die(mysql_error());
	
		while ($row = mysql_fetch_assoc($result))
		{		 
			$PriceItems[]=array(
				"id"=>$row['id'],
				"art"=>$row['art'],
				"name"=>$row['name'],
				"price"=>$row['price'],
				"count"=>$row['count'],
			);
		}
		return $PriceItems; 

	}

	//--------------------------------------------------
	// function getTwo($a, $b, $c)
	// { 
		 // if (!isset($сid1)) return NULL;
				// var_dump($a);
				// var_dump($b);
				// var_dump($c);
				// return null;
	// }
	
	
	//--------------------------------------------------
	function getOrders($a, $b, $c)
	{ 
		if ($b<0) { //выводим журнал без фильтра для покупателя
			$sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$a";
		} else
		if ($a<0) { //выводим журнал без фильтра для продавца
			$sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE sid=$b";
		} else {
			$sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$a and sid=$b";
		}
		 
		$result = mysql_query($sql)  or die(mysql_error());
		while ($row = mysql_fetch_assoc($result))
		{
			if ($b<0 or $c==4) { //журнал для покупателя
				$uid=$row['sid'];
			} else if ($a<0 or $c==3) {
				$uid=$row['cid'];
			}
			$sql1 = "SELECT name FROM users WHERE id=$uid";

			$result1 = mysql_query($sql1)  or die(mysql_error());
			$row1 = mysql_fetch_assoc($result1);
			
			$status_id=$row['status_id'];
			$sql2 = "SELECT name FROM status WHERE id=$status_id";
			$result2 = mysql_query($sql2)  or die(mysql_error());
			$row2 = mysql_fetch_assoc($result2);

			$OrdersItems[]=array(
				"id"=>$row['id'],
				"name"=>$row1['name'],
				"number"=>$row['number'],
				"date"=>$row['date'],
				"summ"=>$row['summ'],
				"status"=>$row2['name'],
			);
		}
		
		return $OrdersItems; 

	}

} 
  /*
  Автор: zva
*/
 ?>