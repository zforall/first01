<?php
$menu=getMenu();
$usermenu=getUserMenu();
$smal_cart=getSmalCart();
$category_list=Lib_Category::getInstance()->getCategoryList_UL(0);

function getMenu(){
	return Lib_Menu::getInstance()->getMenu();
}
function getUserMenu(){
	return Lib_Menu::getInstance()->getUserMenu();
}
function getSmalCart(){
	return Lib_SmalCart::getInstance()->getCartData();
}
