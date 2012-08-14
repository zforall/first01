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
 						$table_orders = "<table id='myTable' class='tablesorter'>
						<thead>
						<tr>
							<th>№_</th>
							<th>Номер</th>
							<th>Дата</th>
							<th>Контрагент</th>
							<th>Сумма</th>
							<th>Статус</th>
							<th>Выбрать</th>
						</tr>
						</thead>
						<tbody>";
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
						$table_orders.="</tbody></table>";

						echo $table_orders;
					break;
					}
				}
				case 2 : {
					if (count($PriceItems)>0) {
 						$table_price = "<table id='myTable' class='tablesorter'>
						<thead>
						<tr>
							<th>№_</th>
							<th>Наименование</th>
							<th>Стоимость</th>
							<th>Количество</th>
							<th>Единица</th>
							<th>Выбрать</th>
						</tr>
						</thead>
						<tbody>";

						$i=1;
						foreach($PriceItems as $item) {
							if ($i%2==0) $bgcolor="#F2F2F2"; else $bgcolor="lightgray";
							$table_price.="<tr bgcolor=$bgcolor>";
							$table_price.="<td>".$i++."</td>";
							// $table_price.="<td><a href='/enter?in-cart-product-id=".$item['id']."'>".$item['name']."</a></td>";
							$table_price.="<td>".$item['name']."</td>";
							$table_price.="<td>".$item['price']." руб. </td>";
							$table_price.="<td><input type='text' style='text-align:center' size=3 name='item_".$item['id']."' value='".$item['count']."' /></td>";
							$table_price.="<td>"."ед"."</td>";
							$table_price.="<td>"."<INPUT TYPE='checkbox'  name='del_".$item['id']."'>"."</td>";
							$table_price.="</tr>";	
						}
						$table_price.="</tbody></table>";
						echo $table_price;
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
