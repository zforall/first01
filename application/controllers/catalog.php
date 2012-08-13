<?php
//контролер обрабатывает данные каталога
  class Application_Controllers_Catalog extends Lib_BaseController
  {
     function __construct()
	 {	
		 if($_REQUEST['in-cart-product-id']) // если нажата кнопка купить
			{
				$cart=new Application_Models_Cart;
				$cart->addToCart($_REQUEST['in-cart-product-id']);
				Lib_SmalCart::getInstance()->setCartData();
				header('Location: /catalog');
				exit;
			}
	
			$page=1;//показать первую страницу выбранного раздела
			$step=3;//сколько выводить на странице объектов	
			$product_sub_category=1;	
			
			if(isset($_REQUEST['p'])){ //запрашиваемая страница
				$page=$_REQUEST['p'];
			}
		
			$model=new Application_Models_Catalog; // модель каталога
			
			//получаем список вложенных категорий, для вывода всех продуктов, на страницах текущей категории.
			$model->category_id=Lib_Category::getInstance()->getCategoryList($_REQUEST['category_id']);
			$model->category_id[]=$_REQUEST['category_id'];// в конец списка, добавляем корневую текущую категорию
			
			$Items =$model->getPageList($page,$step);//передаем номер требуемой страницы, и количество выводимых объектов
		
			$this->pager=$Items['pagination'];
			unset($Items['pagination']);

			$this->TiteCategory=$model->current_category["title"];//наименование текущей категории
			$this->Items=$Items;//список продуктов выводимых в этой категории
		
	}
  }