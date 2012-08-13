<h2>Заявка</h2>

<?if($empty_cart):?>

		<form action="/cart" method="post">
			<?//var_dump($big_cart)?>
			<?=$big_cart;?>
			<input type="submit" name="refresh" value="Пересчитать"  style="margin-left:10px; margin-top:10px;" />
		</form>	

		<form action="/cart" method="post" style="margin-left:600px;">
			<input type="submit" name="to_order" value="Оформить заказ" style=" height:30px; padding: 0px 20px;" />
		</form>

<?else:?>
Заявка пуста!
<?endif;?>