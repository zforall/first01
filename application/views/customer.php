<div class="menu">
    <?=$usermenu?>
</div>

<div id="middle">

    <div id="sideLeft">
        <strong>Фильтр по контрагентам</strong><br>
        <?
        echo '<ul>';
        if (count($LeftItems)>0) {
            foreach($LeftItems as $item){
                $tmp = $item['name'];
                $tmp1 = $item['id'];
                echo "<li type='none'><a href=?u=$tmp1>$tmp</a></li>";
            }
        }
        echo "<li><a href=?u=-1>Все</a></li>";
        echo "<li><h1><a href=#>Go</a></h1></li>";
        echo '</ul>';
        ?>
    </div><!-- .sidebar#sideLeft -->

    <div id="content1">
        <strong>Раб облость</strong>
        <?
        switch ($_SESSION['tab'])
        {
            case 1 : { //журнал
            if (count($OrdersItems)>0)
            {
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
//                    $table_orders.="<tr bgcolor=$bgcolor>";
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

                $table_price = "<form method=POST><table id='myTable' class='tablesorter'>
						<thead>
						<tr>
							<th>№_</th>
							<th>Артикул</th>
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
                    $id = $item['id'];
                    if ($i%2==0) $bgcolor="#F2F2F2"; else $bgcolor="lightgray";
                    $table_price.="<tr bgcolor=$bgcolor>";
                    $table_price.="<td>".$i++."</td>";
                    // $table_price.="<td><a href='/enter?in-cart-product-id=".$item['id']."'>".$item['name']."</a></td>";
                    $table_price.="<td>".$item['art']."</td>";
//                    $table_price.="<td>".$item['name']."</td>";
                    $table_price.="<td><a href='/customer?in-cart-product-id=".$item['id']."'>".$item['name']."</a></td>";
                    $table_price.="<td>".$item['price']." руб. </td>";
                    // $table_price.="<td><input type='text' style='text-align:center' size=3 name='item_".$item['id']."' value='".$item['count']."' /></td>";
                    $table_price.="<td><input type='text' style='text-align:center' size=3 value='".$item['count']."' /></td>";
                    $table_price.="<td>".$item['ed']."</td>";
                    $table_price.="<td><INPUT TYPE='checkbox'  name=add[$id] value=$id></td>";
                    $table_price.="</tr>";
                }
                $table_price.="</tbody></table>";
//                $table_price.="<input type='submit' name='add' value='Добавить'>";
                $table_price.="</form>";
                echo $table_price;
            }
            break;
            }//прайс
        }
        ?>
    </div><!-- #content-->


    <div id="sideRight">
        <strong>Текущая заявка</strong>
        <div class="smalcart">
            <strong>Товаров в корзине:</strong>	<?=$smal_cart['cart_count']?> шт.
            <br/>
            <strong>На сумму:</strong>	<?=$smal_cart['cart_price']?> руб.
            <br/>
            <a href='/cart?z=1'>Оформить заказ</a>
        </div>
    </div><!-- .sidebar#sideRight -->

</div><!-- #middle-->
