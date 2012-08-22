<div id="middle">
		<div id="sideRightManager">
			<strong>Право</strong><br>
			<div id="info">
			<?
				// var_dump($ContentItems);
				$tmp = $ContentItems[$_SESSION["uk"]];
				// var_dump($tmp);
				if ($tmp==null) $tmp = $LeftItems[$_SESSION["uk"]];
				// var_dump($tmp1);
				$info_view = "<form action=''>";

				$login = $tmp['login'];
				$info_view .= "<h1>login</h1>";
				$info_view .= "<input type='text' name='thelogin' value=$login>";
				
				$name = $tmp['name'];
				$info_view .= "<h1>name</h1>";
				$info_view .= "<input type='text' name='thename' value=\"$name\" >";

				// $password = $tmp['password'];
				$info_view .= "<h1>password</h1>";
				$info_view .= "<input type='password' name='thepassword' >";

				$inn = $tmp['inn'];
				$info_view .= "<h1>inn</h1>";
				$info_view .= "<input type='text' name='inn' value=$inn >";
				
				$email = $tmp['email'];
				$info_view .= "<h1>email</h1>";
				$info_view .= "<input type='text' name='email' value=$email >";

				$id = $tmp['id'];
				$info_view .= "<input type=hidden name='id' value=$id >";

				
				$info_view .= "<input type='submit' name='update' value=Обновить ><br>";
				$info_view .= "<input type='submit' name='newsell' value='Новый продавец' ><br>";
				$info_view .= "<input type='submit' name='newcust' value='Новый покупатель' ><br>";

				$info_view .= "</form>";
				echo  $info_view;
				
				echo "<h1>$message</h1>";
			?>
			</div>
		</div><!-- sideRightManager -->

		<div id="ManagerContent">
			<strong>Содержание</strong><br>
			<?
            $table_orders = "<form method=POST><table id='myTable' class='tablesorter'>
						<thead>
						<tr>
							<th>№_</th>
							<th>Контрагент</th>
							<th>Выбрать</th>
						</tr>
						</thead>
						<tbody>";
                        $i=1;


//						$table_orders="<table bgcolor='#E6DEEA' border='1' class='table_orders'><tr><th>№</th><th>Контрагент</th><th>Выбрать</th></tr>";
//						$i=1;
						foreach($ContentItems as $item) {
							if ($i%2==0) $bgcolor="#F2F2F2"; else $bgcolor="lightgray";
							$table_orders.="<tr bgcolor=$bgcolor>";
							$table_orders.="<td>".$i++."</td>";
							$table_orders.="<td><a href='?uk=".$item['id']."'>".$item['name']."</a></td>";
							// var_dump($item['checked']);
							$id=$item['id'];
							if ($item['checked']==1) $table_orders.="<td>"."<INPUT TYPE='checkbox' CHECKED name=upd[$id] value=$id>"."</td>";
							else $table_orders.="<td>"."<INPUT TYPE='checkbox' name=upd[$id] value=$id>"."</td>";
							// if ($item['checked']==1) $table_orders.="<td>"."<INPUT TYPE='checkbox' CHECKED name='del_".$item['id']."'>"."</td>";
							// else $table_orders.="<td>"."<INPUT TYPE='checkbox' name='del_".$item['id']."'>"."</td>";
							$table_orders.="</tr>";	
						}
						$table_orders.="</tbody></table>";
						$table_orders.="<input type='submit' value='Обновить'></form>";
						echo $table_orders;

			?>
		</div><!-- ManagerContent -->

		<div id="sideLeftManagerOne">
			<strong>Категории</strong><br>
			<?
				echo "<a href=?r=3>Продавцы</a><br>";
				echo "<a href=?r=4>Покупатели</a><br>";
				echo "<a href=?r=0>Все</a><br>";
			?>

		</div><!-- .sidebar#sideLeft -->
		<div id="sideLeftManagerTwo">
			<strong>Контрагенты</strong><br>
			<?
			// var_dump($LeftItems);

			if (count($LeftItems)>0) {
				foreach($LeftItems as $item){
					$tmp = $item['name'];
					$tmp1 = $item['id'];
					echo "<a href=?u=$tmp1&uk=$tmp1>$tmp</a><br>";
				}
			}			
			// echo "<a href=?u=-1>Все</a><br>";
			?>

		</div><!-- .sidebar#sideLeft -->

</div>