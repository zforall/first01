<?php
 class Application_Models_Cart  extends Lib_DateBase
  {	  
	//--------------------------------------------------
	  function GetNumber(){// генерирует номер для нового заказа
		return mt_rand(1,10000);
		// return "123456";
	  }

	//--------------------------------------------------
	  function GetSid(){// возвращает ид продавца
//		return mt_rand(3,4);
		return $_SESSION["filtr"];
	  }
	  
	//--------------------------------------------------
	  function saveCartToBD(){// записывает корзину в базу
		if (!isset($_SESSION['cart'])){return false;};
		
		$summ = $this->getTotalSumm();
		$date = mktime(); //текущая дата в UNIX формате
		$number = $this->GetNumber();
		 $cid = $_SESSION["uid"];
//		$cid = 6;
		$sid = $this->GetSid();
		//формируем массив параметров SQL запроса
		$array=array(
			"cid"=>$cid, 
			"sid"=>$sid,
			"number"=>$number,
			"date"=>$date,
			"summ"=>$summ,
			"status_id"=>1
		);
		// var_dump($array);
		
		
		parent::build_query("INSERT INTO `orders` SET",$array); // отдаем на обработку  родительской функции build_query, выполняем запрос
		$id=parent::insert_id(); //узнаем номер id под которым заказ добавлен в базу

		//записываем в базу все позиции заказа
		$item_position = new Application_Models_Product();
		//добавляем в массив корзины третий параметр  цены товара, для сохранения в заказ
		// это нужно для того чтобы в последствии вывести детальную информацию о заказе. 
		//Если оставить только id то информация может оказаться не верной, так как цены меняютмя.
		//неск запросов подряд не оптимально - переделать, засунуть в один запрос
		foreach($_SESSION['cart'] as $product_id=>$count){
			$price=$item_position->getProductPrice($product_id);
			//формируем массив параметров SQL запроса
			$array=array(
				"order_id"=>$id, 
				"prod_id"=>$product_id,
				"price"=>$price,
				"count"=>$count
			);
			parent::build_query("INSERT INTO `ordersprod` SET",$array); // отдаем на обработку  родительской функции build_query, выполняем запрос

		}

		if($id) $this->clearCart();// если заказ успешно записан, то отчищаем корзину
		return $id; // возвращаем номер заказа
	  }	  

	//--------------------------------------------------
	function addToCart($id, $count=1)// доавляет в корзину товар
	{
			var_dump($_SESSION['cart']);
		$_SESSION['cart'][$id]=$_SESSION['cart'][$id]+$count;		
		return true;
	}	  
	  
	//--------------------------------------------------
	  function getListItemId() // возвращает список id продуктов из корзины
	  {	  	  		 
		if (!empty($_SESSION['cart'])){
			$listId=array_keys($_SESSION['cart']);
			return $listId;	
		}
		return false;	
	  }	  
	  
	//--------------------------------------------------
	  function getTotalSumm() // возвращает иготовую сумму корзины
	  {	  	  		 
		$array_product_id=$this->getListItemId(); // получаем списо id 
		$item_position = new Application_Models_Product();// создаем модель для работы с продуктами		
		
		foreach($array_product_id as $id){
			$product_positions[]=$item_position->getProduct($id);// получаем информацию о каждом продукте
		}
        $total_summ = 0;
		foreach($product_positions as $product)
		{
			$total_summ+=$_SESSION['cart'][$product['id']]*$product['price'];// расчитываем сумму
		}
			
		return $total_summ;
	  }
	  
	// отчищает корзину
	//--------------------------------------------------
	function clearCart(){
//		var_dump('gopa3');
		unset($_SESSION['cart']);
	}

	  
	  // обновляет содержимое корзины
	//--------------------------------------------------
	  function refreshCart($array_product_id){ // получает ассоциативный массив id=>count
		foreach($array_product_id as $Item_Id => $new_count){
				var_dump('gopa4');
			if($new_count<=0){
				unset($_SESSION['cart'][$Item_Id]); // если количесво меньше нуля, то удаляем запись
			}
			else
				$_SESSION['cart'][$Item_Id]=$new_count; // присваиваем новое количество			
			
		}
		
	  }
	  
	  // проверка корзины на заполненность
	//--------------------------------------------------
	 function isEmptyCart(){ 
    if($_SESSION['cart']) return true; 
    else return false;
    }
	
	//--------------------------------------------------
	function getOrderProdacts($oid)
	{ 
		 if (!isset($oid)) return NULL;
		 $sql = "SELECT prod_id, price, count FROM ordersprod WHERE order_id=$oid";
			// var_dump($sql);
		 
		 $result = mysql_query($sql)  or die(mysql_error());
	
		 while ($row = mysql_fetch_assoc($result))
		 {		 
			$OrderProds[$row['prod_id']]=array(
				"price"=>$row['price'],
				"count"=>$row['count'],
			);
		  }
		 return $OrderProds; 

	}
	

		// возвращает html код корзины
	//--------------------------------------------------
	  function printCart($order_id)
	  {	  	  
		$array_product_id=array();
		$product_positions=array();
		if ($order_id==0) {$array_product_id=$this->getListItemId();} // получает список id
		else {
			$array_product=$this->getOrderProdacts($order_id);
			if (!isset($array_product)) return null;
			$array_product_id=array_keys($array_product);
		}
		// var_dump($this->getOrderProdacts($order_id));

		
		$item_position = new Application_Models_Product();	// создаем модель для работы с продуктами	
		if (!empty($array_product_id))
		foreach($array_product_id as $id){
			$product_positions[$id]=$item_position->getProduct($id); // заполняем массив информацией о каждом продукте
			if ($order_id==0) { //если это текущий заказ
				$product_positions[$id]['count'] = $_SESSION['cart'][$id];
			}
			else { //смотрим заказ из журнала
				$product_positions[$id]['price'] = $array_product[$id]['price'];
				$product_positions[$id]['count'] = $array_product[$id]['count'];
			}
		}	

	  // формируем интерфейс для работы с корзиной
			$table_cart="<table bgcolor='#E6DEEA' border='1' class='table_cart'><tr><th>№</th><th>Наименование</th><th>Стоимость</th><th>Количество</th><th>Сумма</th><th>Удалить</th></tr>";
			$i=1;
          $total_summ = 0;
			foreach($product_positions as $product)
			{
				// var_dump($product);echo"<br>";
				if ($i%2==0) $bgcolor="#F2F2F2"; else $bgcolor="lightgray";
				$table_cart.="<tr bgcolor=$bgcolor>";
				$table_cart.="<td>".$i++."</td>";
				$table_cart.="<td>".$product['name']."</td>";
				$table_cart.="<td>".$product['price']." руб. </td>";
				$table_cart.="<td><input type='text' style='text-align:center' size=3 name='item_".$product['id']."' value='".$product['count']."' /></td>";
				$table_cart.="<td>".$product['count']*$product['price']." руб. </td>";
				$table_cart.="<td>"."<INPUT TYPE='checkbox'  name='del_".$product['id']."'>"."</td>";
				$table_cart.="</tr>";	
				$total_summ+=$product['count']*$product['price'];
			}
			$table_cart.="<tr><td colspan='3'></td><td>К оплате: </td><td><strong> <span style='color: #7F0037'>".$total_summ." руб. </span></strong></td><td></td></tr></table>";
		
		return $table_cart;
	  }	  
  } 
  
  
  /* 
	  function printCart()
	  {	  	  
		$array_product_id=array();
		$product_positions=array();
		
		$array_product_id=$this->getListItemId(); // получает список id
		
	
		$item_position = new Application_Models_Product();	// создаем модель для работы с продуктами	
		if (!empty($array_product_id))
		foreach($array_product_id as $id){
			$product_positions[]=$item_position->getProduct($id); // заполняем массив информацией о каждом продукте
		}	
	  // формируем интерфейс для работы с корзиной
			$table_cart="<table bgcolor='#E6DEEA' border='1' class='table_cart'><tr><th>№</th><th>Наименование</th><th>Стоимость</th><th>Количество</th><th>Сумма</th><th>Удалить</th></tr>";
			$i=1;
			foreach($product_positions as $product)
			{
				if ($i%2==0) $bgcolor="#F2F2F2"; else $bgcolor="lightgray";
				$table_cart.="<tr bgcolor=$bgcolor>";
				$table_cart.="<td>".$i++."</td>";
				$table_cart.="<td>".$product['name']."</td>";
				$table_cart.="<td>".$product['price']." руб. </td>";
				$table_cart.="<td><input type='text' style='text-align:center' size=3 name='item_".$product['id']."' value='".$_SESSION['cart'][$product['id']]."' /></td>";
				$table_cart.="<td>".$_SESSION['cart'][$product['id']]*$product['price']." руб. </td>";
				$table_cart.="<td>"."<INPUT TYPE='checkbox'  name='del_".$product['id']."'>"."</td>";
				$table_cart.="</tr>";	
				$total_summ+=$_SESSION['cart'][$product['id']]*$product['price'];
			}
			$table_cart.="<tr><td colspan='3'></td><td>К оплате: </td><td><strong> <span style='color: #7F0037'>".$total_summ." руб. </span></strong></td><td></td></tr></table>";
		
		return $table_cart;
	  }	  

  */