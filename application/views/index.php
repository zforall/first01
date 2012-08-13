				<?if(!$_SESSION["Auth"]):?>
					<div id='sidebar'>
					<div class='login'>
					<h1>Вход в личный кабинет</h1>
					<?echo $msg;?>
					<form action="/enter" method="POST">
					Логин: &nbsp;<input type="text" name="login" value="<?=$login?>" /><br />
					Пароль: <input type="password" name="pass" value="<?=$pass?>" /><br />
					<input type="submit" value="Вход" />
					</form>
				</div>
				</div>
				<?endif;?>
				
		<div id="middle	">
			Добро пожаловать на сайт где осуществляется взаимодействие между покупателями и продавцами
		</div><!-- #content-->

