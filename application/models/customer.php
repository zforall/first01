<?php
//модель выборки данных продавца
class Application_Models_Customer extends Lib_DateBase
{
    //--------------------------------------------------
    protected function  getCokieCart()// получить данные из куков назад в сессию
    {
        if(isset($_COOKIE))
        { // если куки существуют
            $_SESSION['cart']=unserialize(stripslashes($_COOKIE['cart'.$_SESSION['uid']])); //десериализует строку в массив
//            var_dump($_SESSION['cart']);
            return  true;
        }
        return  false;
    }

    //Получает данные из БД (цены) и вычисляет общую стоимость содержимого, а также количество
    //--------------------------------------------------
    public function  getCartData()
    {
        $res['cart_count']=0; //количество вещей в корзине
        $res['cart_price']=0; //общая стоимость

        if($this->getCokieCart() && $_SESSION['cart']) //если удалось получить данные из куков и они успешно десериализованы в $_SESSION['cart']
        {
            $total_price = 0;
            $total_count = 0;
            foreach ($_SESSION['cart'] as $id=>$count){ // пробегаем по содержимому, вычилсяя сумму и количество
                $sql = "SELECT p.price FROM products p WHERE id='{$id}'";
                $result = mysql_query($sql)  or die(mysql_error());
                if($row = mysql_fetch_assoc($result))
                {
                    $total_price+=$row['price']*$count;
                    $total_count+=$count;
                }
            }
            $res['cart_count']=$total_count;
            $res['cart_price']=$total_price;
        }
        return  $res;
    }

    // записывает в cokie текущее состояние корзины в сериализованном виде
    //--------------------------------------------------
    public function  setCartData()
    {
//        $tmp = SetCookie('gopa7', time(), time()+3600*24*365); //записывает сериализованную строку в куки, хранит 1 год
//        if ($tmp) var_dump('anus1'); else var_dump('kaka1');

        $cart_content = serialize($_SESSION['cart']); // сериализует  данные корзины из сессии в строку
        // var_dump($cart_content);
        $tmp = SetCookie('cart'.$_SESSION['uid'], $cart_content, time()+3600*24*365); //записывает сериализованную строку в куки, хранит 1 год
        return $tmp;
//         $tmp=unserialize(stripslashes($_COOKIE['cart'.$_SESSION['uid']])); //десериализует строку в массив

//         var_dump($tmp);

    }

    function addToCart($id, $count=1)// доавляет в корзину товар
    {
        // var_dump($_SESSION['cart']);
        $_SESSION['cart'][$id] = $_SESSION['cart'][$id]+$count;
        return true;
    }

    //Список контрагентов
    //--------------------------------------------------
    function getLeftList($uid)
    {
        if (!isset($uid)) return NULL;

        $sql = "SELECT id, name FROM users WHERE id IN (SELECT uid2 FROM relations WHERE uid1=$uid)";

        // $result = mysql_query($sql)  or die(mysql_error());
        $result = parent::query($sql) or die(mysql_error());

        $LeftItems = null;

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
        // $sql = "SELECT id, art, name, price, count FROM products WHERE sid=0";

        // $result = mysql_query($sql)  or die(mysql_error());
        $result = parent::query($sql);// or die(mysql_error());

        $PriceItems = null;

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
    function getOrders($a, $b)
    {

        if ($b<0) {
            $sql = "SELECT orders.id, orders.cid, orders.sid, orders.number, orders.date, orders.summ, status.name as thestatus, users.name as thename FROM orders left join status on status.id=orders.status_id left join users on users.id=orders.sid WHERE cid=$a";
        } else {
            $sql = "SELECT orders.id, orders.cid, orders.sid, orders.number, orders.date, orders.summ, status.name as thestatus, users.name as thename FROM orders left join status on status.id=orders.status_id left join users on users.id=orders.sid WHERE cid=$a and sid=$b";
        }

        $result = parent::query($sql);

        $OrdersItems = null;

        while ($row = mysql_fetch_assoc($result))
        {
            $OrdersItems[]=array(
                "id"=>$row['id'],
                "name"=>$row['thename'],
                "number"=>$row['number'],
                "date"=> strftime('%d %b %Y', $row['date']),
                "summ"=>$row['summ'],
                "status"=>$row['thestatus'],
            );
        }

        return $OrdersItems;

    }

    //--------------------------------------------------
    /* 	function getOrders($a, $b)
       {

           // var_dump($a);
           // var_dump($b);
           // var_dump($c);

           if ($b<0) { //выводим журнал без фильтра для покупателя
               $sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$a";
           // } else
           // if ($a<0) { //выводим журнал без фильтра для продавца
               // $sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE sid=$b";
           } else {
               $sql = "SELECT id, cid, sid, number, date, summ, status_id FROM orders WHERE cid=$a and sid=$b";
           }
           // var_dump($sql);
           $result = mysql_query($sql)  or die(mysql_error());
           while ($row = mysql_fetch_assoc($result))
           {
               // if ($b<0 or $c==4) { //журнал для покупателя
                   $uid=$row['sid'];
               // } else if ($a<0 or $c==3) {
                   // $uid=$row['cid'];
               // }
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
    */
}
/*
  Автор: zva
*/
?>