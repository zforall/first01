<?php
//модель выборки данных продавца
class Application_Models_Customer extends Lib_DateBase
{	  
	
	//--------------------------------------------------
	function getLeftList($uid)
	{ 
		if (!isset($uid)) return NULL;
		
		$sql = "SELECT id, name FROM users WHERE id IN (SELECT uid2 FROM relations WHERE uid1=$uid)";
		
		// $result = mysql_query($sql)  or die(mysql_error());
		$result = parent::query($sql) or die(mysql_error());
	
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
		// $sql = "SELECT id, art, name, price, count FROM products WHERE sid=0";

		// $result = mysql_query($sql)  or die(mysql_error());
		$result = parent::query($sql);// or die(mysql_error());
		if(!$result) return null;
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
	function getOrders($a, $b)
	{ 
	
		if ($b<0) {
			$sql = "SELECT orders.id, orders.cid, orders.sid, orders.number, orders.date, orders.summ, status.name as thestatus, users.name as thename FROM orders left join status on status.id=orders.status_id left join users on users.id=orders.sid WHERE cid=$a";
		} else {
			$sql = "SELECT orders.id, orders.cid, orders.sid, orders.number, orders.date, orders.summ, status.name as thestatus, users.name as thename FROM orders left join status on status.id=orders.status_id left join users on users.id=orders.sid WHERE cid=$a and sid=$b";
		}
		
		$result = parent::query($sql) or die(mysql_error());
		
		while ($row = mysql_fetch_assoc($result))
		{
			$OrdersItems[]=array(
				"id"=>$row['id'],
				"name"=>$row['thename'],
				"number"=>$row['number'],
				"date"=>$row['date'],
				"summ"=>$row['summ'],
				"status"=>$row['thestatus'],
			);
		}
		
		return $OrdersItems; 

	}
	
	//--------------------------------------------------
/* 	function getOrders($a, $b)
	{ 
	
		// var_dump($a);
		// var_dump($b);
		// var_dump($c);
	
		if ($b<0) { //выводим журнал без фильтра для покупателя
			$sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$a";
		// } else
		// if ($a<0) { //выводим журнал без фильтра для продавца
			// $sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE sid=$b";
		} else {
			$sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$a and sid=$b";
		}
		// var_dump($sql);
		$result = mysql_query($sql)  or die(mysql_error());
		while ($row = mysql_fetch_assoc($result))
		{
			// if ($b<0 or $c==4) { //журнал для покупателя
				$uid=$row['sid'];
			// } else if ($a<0 or $c==3) {
				// $uid=$row['cid'];
			// }
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
 */
} 
  /*
  Автор: zva
*/
 ?>