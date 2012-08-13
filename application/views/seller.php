	<div class="menu">
		<?=$usermenu?>
	</div>	

	<div id="middle">

		<div id="sideLeft">
		<?if($_SESSION["role"]==2):?>
			<strong>Менеджер</strong><br>
			<?
			if (count($LeftItems)>0) {
				foreach($LeftItems as $item){
					$tmp = $item['name'];
					$tmp1 = $item['id'];
					echo "<a href=?u=$tmp1>$tmp</a><br>";
				}
			}			
			echo "<a href=?u=-1>Все</a><br>";
			?>

		<?else:?>
			<strong>Фильтр по контрагентам</strong><br>
			<?
			if (count($LeftItems)>0) {
				foreach($LeftItems as $item){
					$tmp = $item['name'];
					$tmp1 = $item['id'];
					echo "<a href=?u=$tmp1>$tmp</a><br>";
				}
			}			
			echo "<a href=?u=-1>Все</a><br>";
			?>

		<?endif;?>

		</div><!-- .sidebar#sideLeft -->

		<div id="content1">
		<strong>Раб облость</strong>
			<?
			switch ($_SESSION['tab']){
				case 1 : { //журнал
					if (count($OrdersItems)>0) {

						$table_orders="<table bgcolor='#E6DEEA' border='1' class='table_orders'><tr><th>№</th><th>Номер</th><th>Дата</th><th>Контрагент</th><th>Сумма</th><th>Статус</th><th>Выбрать</th></tr>";
						$i=1;
						foreach($OrdersItems as $item) {
							if ($i%2==0) $bgcolor="#F2F2F2"; else $bgcolor="lightgray";
							$table_orders.="<tr bgcolor=$bgcolor>";
							$table_orders.="<td>".$i++."</td>";
							$table_orders.="<td><a href='/cart?oid=".$item['id']."'>".$item['number']."</a></td>";
													
							$table_orders.="<td>".$item['date']."</td>";
							$table_orders.="<td>".$item['name']."</td>";
							$table_orders.="<td>".$item['summ']."</td>";
							$table_orders.="<td>".$item['status']."</td>";
							$table_orders.="<td>"."<INPUT TYPE='checkbox'  name='del_".$item['id']."'>"."</td>";
							$table_orders.="</tr>";	
						}
						$table_orders.="</table>";
						echo $table_orders;
					break;
					}
				}
				case 2 : {
					if (count($PriceItems)>0) {

						$table_cart="<table bgcolor='#E6DEEA' border='1' class='table_cart'><tr><th>№</th><th>Наименование</th><th>Стоимость</th><th>Количество</th><th>Выбрать</th></tr>";
						$i=1;
						foreach($PriceItems as $item) {
							if ($i%2==0) $bgcolor="#F2F2F2"; else $bgcolor="lightgray";
							$table_cart.="<tr bgcolor=$bgcolor>";
							$table_cart.="<td>".$i++."</td>";
							// $table_cart.="<td>".$item['name']."</td>";
							$table_cart.="<td><a href='/enter?in-cart-product-id=".$item['id']."'>".$item['name']."</a></td>";
													

							$table_cart.="<td>".$item['price']." руб. </td>";
							$table_cart.="<td><input type='text' style='text-align:center' size=3 name='item_".$item['id']."' value='".$item['count']."' /></td>";
							// $table_cart.="<td>".$_SESSION['cart'][$product['id']]*$product['price']." руб. </td>";
							$table_cart.="<td>"."<INPUT TYPE='checkbox'  name='del_".$item['id']."'>"."</td>";
							$table_cart.="</tr>";	
							// $total_summ+=$_SESSION['cart'][$product['id']]*$product['price'];
							// $total_summ=1000;
						}
						// $table_cart.="<tr><td colspan='3'></td><td>К оплате: </td><td><strong> <span style='color: #7F0037'>".$total_summ." руб. </span></strong></td></tr></table>";
						$table_cart.="</table>";
						echo $table_cart;
					}
					break;
				}//прайс
				case 3 : {break;}//заявка
			}
			?>	
		</div><!-- #content-->


		<div id="sideRight">
			<strong>Загрузка прайса</strong>
			<br>
			<form action="" method="post" enctype="multipart/form-data">
			<input type=hidden name="MAX_FILE_SIZE" value=5000 />
			<input type="file" name="filename"><br> 
			<input type="submit" value="Загрузить"><br>
			</form>
		</div><!-- .sidebar#sideRight -->

	</div><!-- #middle-->
