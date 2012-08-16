<?php
  define('LOWERCASE',3);

   define('UPPERCASE',1);
   
   require_once "./lib/charset.php";

//модель выборки данных продавца
class Application_Models_Seller  extends Lib_DateBase
{	  
 	//--------------------------------------------------

   function detect_cyr_charset($str) {

      $charsets = Array(

         'k' => 0,

         'w' => 0,

         'd' => 0,

         'i' => 0,

         'm' => 0

      );

      for ( $i = 0, $length = strlen($str); $i < $length; $i++ ) {

         $char = ord($str[$i]);

      //non-russian characters

      if ($char < 128 || $char > 256) continue;


      //CP866

      if (($char > 159 && $char < 176) || ($char > 223 && $char < 242))

         $charsets['d']+=LOWERCASE;

      if (($char > 127 && $char < 160)) $charsets['d']+=UPPERCASE;


      //KOI8-R

      if (($char > 191 && $char < 223)) $charsets['k']+=LOWERCASE;

      if (($char > 222 && $char < 256)) $charsets['k']+=UPPERCASE;


      //WIN-1251

      if ($char > 223 && $char < 256) $charsets['w']+=LOWERCASE;

      if ($char > 191 && $char < 224) $charsets['w']+=UPPERCASE;


      //MAC

      if ($char > 221 && $char < 255) $charsets['m']+=LOWERCASE;

      if ($char > 127 && $char < 160) $charsets['m']+=UPPERCASE;


      //ISO-8859-5

      if ($char > 207 && $char < 240) $charsets['i']+=LOWERCASE;

      if ($char > 175 && $char < 208) $charsets['i']+=UPPERCASE;


   }

   arsort($charsets);

   return key($charsets);

}

	//--------------------------------------------------
	function delSelected($arr)
	{
		$sid = $_SESSION["uid"];
 		foreach ($arr as $key => $value)
		{
			$pid = $key;
			$result = parent::query("DELETE FROM products WHERE id=$pid and sid=$sid", null);
		}
		return 'was deleted';
	}
	
	//--------------------------------------------------
	function loadPrice()
	{ 
 		$f = file("uploads/".$_FILES["filename"]["name"]) or die("pipez");
		$fsize = count($f);
		$result = true;
		for ($i=0; $i<$fsize; $i++)
		{
			$prod = explode(';',$f[$i]);
			
			
			// var_dump(charset_x_win('юемпчел'));
			// $strtmp=iconv("ANSI", "utf-8", $f[$i]);
			//Проверяем в utf-8 кодировке вайл или нет
			if (!preg_match('//u', $f[$i])) { 
				$result = 'файл должен быть в utf-8 кодировке'; 
				return $result;
			}

			// var_dump($prod);
			// var_dump($f[$i]);
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
		if ($result) {$result = 'Файл успешно загружен';}
		else {$result = 'Ошибка записи файла в базу';}

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
		$sql = "SELECT id, art, name, price, count, ed FROM products WHERE sid=$uid";
		 
		$result = mysql_query($sql)  or die(mysql_error());
	
		while ($row = mysql_fetch_assoc($result))
		{		 
			$PriceItems[]=array(
				"id"=>$row['id'],
				"art"=>$row['art'],
				"name"=>$row['name'],
				"price"=>$row['price'],
				"count"=>$row['count'],
				"ed"=>$row['ed'],
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