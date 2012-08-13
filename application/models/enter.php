<?php
//модель выборки данных
 class Application_Models_Enter  {	  

	// function getLeftList($uid)
	// {
		// if (!isset($uid)) return NULL;
		// $sql = "SELECT id, name FROM users WHERE id IN (SELECT uid2 FROM relations WHERE uid1=$uid)";
		// $result = mysql_query($sql)  or die(mysql_error());
	
		 // while ($row = mysql_fetch_assoc($result))
		
	// }
	
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
	function getTwo($a, $b, $c)
	{ 
		 // if (!isset($сid1)) return NULL;
				var_dump($a);
				var_dump($b);
				var_dump($c);
				return null;
	}
	
	
	function getOrders($a, $b, $c)
	{ 
		 // if (!isset($сid1)) return NULL;
				// var_dump($a);
				// var_dump($b);
				// var_dump($c);
		 // if ($sid==0) { //выводим журнал без фильтра для покупателя
			// $sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$сid";
		 // } else if ($cid==0) { //выводим журнал без фильтра для продавца
			// $sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE sid=$sid";
		 // } else { //журнал с фильтром для всех
			// $sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$сid and sid=$sid";
		 // }

			// var_dump($sid);
		 if ($b<0) { //выводим журнал без фильтра для покупателя
			// var_dump($sid);
			$sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$a";
		 } else
		 
			 // var_dump($cid1);
		 if ($a<0) { //выводим журнал без фильтра для продавца
			 // var_dump($cid1);
			$sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE sid=$b";
		 } else {
		 
		 // if (($b>0)and($a>0)) { //журнал с фильтром для всех
			$sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$a and sid=$b";
		 }
		 

				// return null;
		 
		 $result = mysql_query($sql)  or die(mysql_error());
		 while ($row = mysql_fetch_assoc($result))
		 {
			// var_dump($cid);
		 
			if ($b<0 or $c==4) { //журнал для покупателя
				$uid=$row['sid'];
			} else if ($a<0 or $c==3) {
				$uid=$row['cid'];
			}
			$sql1 = "SELECT name FROM users WHERE id=$uid";
			// var_dump($sql1);

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
