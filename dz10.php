<?php

/* dz10.php
 * 
  Задание dz9.php (mysqli) переделать с помощью DbSimple, 
  все запросы к БД должны выводиться отладочным механизмом через FirePHP и видны в консоли Firebug
  
 */
 
//error_reporting(E_ALL);

$debug=0;


$project_root=$_SERVER['DOCUMENT_ROOT'];


require_once $project_root.'/dbsimple/lib/config.php';
require_once $project_root.'/dbsimple/lib/DbSimple/Generic.php';

require_once $project_root.'/FirePHPCore/FirePHP.class.php';

$firePHP = FirePHP::getInstance(true);

$firePHP -> setEnabled(true);


if (0) {
    
    
    var_dump(getenv('IP'));
    var_dump(getenv('C9_USER'));
    
}


$smarty_dir=$project_root.'/smarty/';

//$smarty_dir='/home/ubuntu/workspace/workspace/smarty/';

// put full path to Smarty.class.php
require($smarty_dir.'libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;



$smarty->template_dir = $smarty_dir.'templates';
$smarty->compile_dir = $smarty_dir.'templates_c';
$smarty->cache_dir = $smarty_dir.'cache';
$smarty->config_dir = $smarty_dir.'configs';

header('Content-type: text/html; charset=utf-8');


$current_php_script='dz10';


$seller_name="";
$checkedPrivate='checked';
$checkedCompany='';
$post_edit=0;
$email='';
$checked_allow_mails='';
$phone=$title=$description='';
$selected='selected=""';
$location_id='641780';
$price='0';
$amount_ads=0;
/*$db_user='dz9';
$db_name='dz9';
$db_server='localhost'; */

    $db_user='k6162353';
    $db_name='c9';
    $db_server='0.0.0.0';
    $db_pass='';

$mysql_last_id='';


/*$conn = mysql_connect(
$db_server, $db_user,$db_pass)
or die("Невозможно установить соединение: ". mysql_error()); */

$db = DbSimple_Generic::connect('mysqli://' . $db_user . ':' . $db_pass . '@'. $db_server. '/'. $db_name);

$db->setErrorHandler('databaseErrorHandler');
$db->setLogger('myLogger');

function databaseErrorHandler($message, $info)
{
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; 
    print_r($info); 
    echo "</pre>";
    exit();
}


function myLogger($db, $sql, $caller)
{
    global $firePHP;
    global $result;


    if (isset($caller['file'])) {
    
    $firePHP->group("at ".@$caller['file'].' line '.@$caller['line']);
    }
    
    $firePHP->log($sql);
    
    
    if (isset($caller['file'])) {
        
        $firePHP->groupEnd();
    }
    
}
    
    
    






/*


mysql_select_db($db_name);
mysql_query('SET NAMES utf8');


$query='select * from cities order by id ASC';

$result_query = mysql_query($query) or die('Запрос не удался');

while ($result = mysql_fetch_assoc($result_query)) {
    
    $cities[$result['city']]=$result['id'];
}

*/

$result= $db->select('select * from cities order by id ASC');


foreach ($result as $value)  {
    
    $cities[$value['city']]=$value['id'];
    
}

$firePHP->log($cities);
//var_dump($cities);





$tube_station_id='';

/* МЕТРО $tube_stations  */

/*

$query='select * from tube_stations order by tube_station ASC';

$result_query = mysql_query($query) or die('Запрос не удался');

while ($result = mysql_fetch_assoc($result_query)) {
$tube_stations[$result['tube_station']]=$result['id'];
}

*/

$result= $db->select('select * from tube_stations order by tube_station ASC');

foreach ($result as $value)  {
    
    $tube_stations[$value['tube_station']]=$value['id'];
    
}

//var_dump($tube_stations);

$firePHP->log($tube_stations,'tube_stations');

$category_id='';

/*

$query='select * from categories order by id ASC';
$result_query = mysql_query($query) or die('Запрос не удался');
while ($result = mysql_fetch_assoc($result_query)) {

$subquery='select * from subcategories where category='.$result['id'].' order by subcategory';
$result_subquery = mysql_query($subquery) or die('Запрос не удался');


    while ($result2 = mysql_fetch_assoc($result_subquery)) {

    $subcategory[$result2['subcategory']]=$result2['id'];

    }

$categories[$result['category']]=$subcategory;

//обнуляем
mysql_free_result($result_subquery);
$subcategory=array();


}  */

$result= $db->select('select * from categories order by id ASC');


foreach ($result as $value)  {
    
    $result2= $db->select('select * from subcategories where category='.$value['id'].' order by subcategory');
    //var_dump($value['id']);
    
    //var_dump($result2);
    
    foreach ($result2 as $value2)  {
        
        $subcategory[$value2['subcategory']]=$value2['id'];
        
    }
    //var_dump($subcategory);
    
    $categories[$value['category']]=$subcategory;
    $subcategory=array();
    

} 

//var_dump($categories);
//$firePHP -> log($categories,'$categories');





/*
через бд
*/

// Получаем объявления из бд

/*

$query='select * from ads order by id ASC';

$result_query = mysql_query($query) or die('Запрос из ads не удался');

if ($result = mysql_fetch_assoc($result_query)) {
    
$temp_array[]=$result;

while ($result = mysql_fetch_assoc($result_query)) {
    $temp_array[]=$result;
    }
}

else {

$temp_array=array();

        } */
        
if ($result= $db->select('select * from ads order by id ASC')) {
    
    $temp_array=$result;
    }

else {

$temp_array=array();

        }
    
$firePHP -> log($temp_array,'ads $temp_array');    
//var_dump($temp_array);
        

        
        

if (isset($_POST['form'])) {
    if ($_POST['form']=="Записать изменения") {
// сохранить элемент

// записать изменение в базу

if (isset($_POST['allow_mails'])) {
            
        $allow_mails=$_POST['allow_mails'];
        }
        
        else {
            
            $allow_mails='0';
            
        }

        //Изменили значение
        
        $db->query('UPDATE ads SET '.
        'title=?, price=?, user_name=? , 
        email=?, tel=?, descr=?,
        id_city=? , id_tube_station=? , id_subcategory=? ,
        private=?, send_to_email=? WHERE id=?',
        $_POST['title'], $_POST['price'], $_POST['seller_name'],
        $_POST['email'], $_POST['phone'], $_POST['description'],
        $_POST['location_id'], $_POST['metro_id'], $_POST['category_id'],
        $_POST['private'], $allow_mails, $_GET['id']);
        
        //$result_query = mysql_query($query) or die('Изменение не удалось');
        
        // обновляем в temp_array
        
        $row=$db->selectRow('select * from ads where ads.id=?',$_GET["id"]);
        
        if ($debug) {
        echo '<p>В изменении значения</p>';
        echo '<b>$row=</b>';
        var_dump($row);
        
        }

//$result_query = mysql_query($query) or die('Получение измененного элемента не удалось');        
        

foreach ($temp_array as $key => $value) {
        
        if ($temp_array[$key]['id']==$_GET["id"]) {
            
            $temp_array[$key]=$row;
            
        }
    }
       
        
        
$_POST=null;
header('Location:/'.$current_php_script.'.php');
}
    if ($_POST['form']=="Назад") {
$_POST=null;
unset($_GET);
header('Location:/'.$current_php_script.'.php');
}
}

// если гет заполнен, значит запросили удаление или просмотр
if (isset($_GET["id"])) {
    if (isset($_GET["del"])) {

$db->query('delete from ads where ads.id=?',$_GET["id"]);



//$result_query = mysql_query($query) or die('Удаление выбранного элемента не удалось');        
        

foreach ($temp_array as $key => $value) {
    
    
        if ($temp_array[$key]['id']==$_GET["id"]) {
            
            unset($temp_array[$key]);
            
        }
    }
   

unset($_GET["id"]);
header('Location:/'.$current_php_script.'.php');


  

}


    if (isset($_GET["edit"])) {
        
        $id=$_GET['id'];
        $post_edit=1;
        
        foreach ($temp_array as $value) {
            
            
        if ($value['id']==$id) {
           
        if ($value['private']=='1') {
            
            $checkedPrivate = 'checked';
            $checkedCompany = '';
        }
        
        else {
            
                $checkedPrivate = '';
            $checkedCompany = 'checked';
            
        }
        
        $seller_name = $value['user_name'];
        $email= $value['email'];
        
        if ($value['send_to_email']=='0' or $value['send_to_email']=='' ) {
            
            $checked_allow_mails = '';
        }
        
        else {
            
            $checked_allow_mails = 'checked';
            
        }
        
 
        $phone=$value['tel'];
        
        $location_id=$value['id_city'];
        $tube_station_id=$value['id_tube_station'];
        $category_id=$value['id_subcategory'];
        $title=$value['title'];
        $description=$value['descr'];
        $price=$value['price'];
        }
        
        }

}
}
// если заполнен пост

    elseif (count($_POST)) {
if (isset($_POST['main_form'])) {
if ($_POST['main_form']=='Добавить') {
        
   
        // allow_mails приходит от формы только тогда, когда установлен checkbox
        // а так вообще нет этой переменной, если он не установлен.
        if (isset($_POST['allow_mails'])) {
            
        $allow_mails=$_POST['allow_mails'];
        }
        
        else {
            
            $allow_mails='';
            
        }

        //вставили значение
        
/*        $query='INSERT into ads '.
        '(title, price, user_name, email, tel, descr, id_city, '.
        'id_tube_station, id_subcategory, private, send_to_email) '.
        'VALUES ("'.$_POST['title'].'", "'.$_POST['price'].'", "'.$_POST['seller_name'].'", "'
        .$_POST['email'].'", "'.$_POST['phone'].'", "'.$_POST['description'].'", "'
        .$_POST['location_id'].'", "'.$_POST['metro_id'].'", "'.$_POST['category_id'].'", "'
        .$_POST['private'].'", "'.$allow_mails.'" );';   */
        
        $mysql_last_id=$db->query('INSERT into ads '.
        '(title, price, user_name, email, tel, descr, id_city, '.
        'id_tube_station, id_subcategory, private, send_to_email) '.
        'VALUES (?, ?, ?,   ?, ?, ?,    ?, ?, ?,   ?, ? )' ,
        $_POST['title'], $_POST['price'], $_POST['seller_name'],
        $_POST['email'], $_POST['phone'], $_POST['description'], 
        $_POST['location_id'], $_POST['metro_id'], $_POST['category_id'], 
        $_POST['private'], $allow_mails);
        
        //$result_query = mysql_query($query) or die('Вставка в ads не удалась');
        
        //var_dump($db);
        
        
        // добавляем к temp_array вставленное значение, для мгновенного отображения
        
        if ($debug) {
        
        echo '<p><b>$mysql_last_id=</b>';
        var_dump($mysql_last_id);
        echo '</p>';
        
        }
        
        //$mysql_last_id=mysql_insert_id();
        $row=$db->selectRow('SELECT * from ads WHERE id=?',$mysql_last_id);
        
        if ($debug) {
        
        echo '<b>$row=</b>';
        var_dump($row);
        
        }
        
        //$result_query = mysql_query($query) or die('Запрос из ads последнего объявления не удался');
        $temp_array[]= $row; 
        
        if ($debug) {
        
        echo '<b>ads $temp_array=</b>';
        var_dump($temp_array);
        
        }

        
        
   

}
}

}

// без этого кода объявления не отображаются

if (isset($temp_array)) {
        

      $amount_ads=count($temp_array); 

} 




$smarty->assign('checkedPrivate',$checkedPrivate);
$smarty->assign('checkedCompany',$checkedCompany);
$smarty->assign('seller_name',$seller_name);
$smarty->assign('email',$email);
$smarty->assign('checked_allow_mails',$checked_allow_mails);
$smarty->assign('phone',$phone);
$smarty->assign('selected',$selected);
$smarty->assign('cities', $cities);
$smarty->assign('location_id',$location_id);
$smarty->assign('tube_stations',$tube_stations);
$smarty->assign('tube_station_id',$tube_station_id);
$smarty->assign('categories',$categories);
$smarty->assign('category_id',$category_id);
$smarty->assign('title',$title);
$smarty->assign('description',$description);
$smarty->assign('price',$price);
$smarty->assign('post_edit',$post_edit);
$smarty->assign('amount_ads',$amount_ads);
$smarty->assign('temp_array',$temp_array);
$smarty->assign('current_php_script',$current_php_script);



$smarty->display($current_php_script.'.tpl');

/*
if (!is_bool($result_query)) {
mysql_free_result($result_query);
}
mysql_close($conn);

*/

?>

