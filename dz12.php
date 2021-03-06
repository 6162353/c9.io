<?php

$project_root = $_SERVER['DOCUMENT_ROOT'];

$site_dir = '';

$smarty_dir = $project_root . $site_dir . '/smarty/';

require_once $project_root . $site_dir . '/dbsimple/lib/config.php';
require_once $project_root . $site_dir . '/dbsimple/lib/DbSimple/Generic.php';

require_once $project_root . $site_dir . '/FirePHPCore/FirePHP.class.php';

require_once 'Ad.class.php';
require_once 'functions.php';

$firePHP = FirePHP::getInstance(true);

$firePHP->setEnabled(true);



// put full path to Smarty.class.php
require($smarty_dir . 'libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;



$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

header('Content-type: text/html; charset=utf-8');


$current_php_script = 'dz12';

$values_for_form = array('title' => '', 'price' => '0',
        'seller_name' => '', 'email' => '', 'phone' => '',
        'description' => '', 'location_id' => '641780', 'metro_id' => '',
        'category_id' => '', 'private' => '', 'allow_mails' => '',
    'checkedPrivate' => 'checked', 'checkedCompany' => '',
    'post_edit' => '0');


$seller_name = "";
$checkedPrivate = 'checked';
$checkedCompany = '';
$post_edit = 0;
$email = '';
$checked_allow_mails = '';
$phone = $title = $description = '';
$selected = 'selected=""';
$location_id = '641780';
$price = '0';


$amount_ads = 0;


    $db_user='k6162353';
    $db_name='c9';
    $db_server='0.0.0.0';
    $db_pass='';

$db = DbSimple_Generic::connect('mysqli://' . $db_user . ':' . $db_pass . '@' . $db_server . '/' . $db_name);
$db->setErrorHandler('databaseErrorHandler');
$db->setLogger('myLogger');

/*ГОРОД */

$result = $db->select('select * from cities order by id ASC');


foreach ($result as $value) {

    $cities[$value['city']] = $value['id'];
}

$firePHP->log($cities, '$cities');


$tube_station_id = '';

/* МЕТРО $tube_stations  */

$result = $db->select('select * from tube_stations order by tube_station ASC');

foreach ($result as $value) {

    $tube_stations[$value['tube_station']] = $value['id'];
}


$firePHP->log($tube_stations, '$tube_stations');



$category_id = '';

$result = $db->select('select * from categories order by id ASC');
$firePHP->log($result, 'categories $result');

foreach ($result as $value) {

    $result2 = $db->select('select * from subcategories where category=' . $value['id'] . ' order by subcategory');
    $firePHP->log($result2, 'subcategories $result2');

    foreach ($result2 as $value2) {

        $subcategory[$value2['subcategory']] = $value2['id'];
    }


    $categories[$value['category']] = $subcategory;
    $subcategory = array();
}

$firePHP->log($categories, '$categories');


// если гет заполнен, значит запросили изменение (в ходе просмотра) и удаление




$main = AdsStore::instance();
$main->getAllAdsFromDb();
$main->writeOutAll();




    if ($_POST['form'] == "Сохранить объявление") {
// сохранить элемент
// записать изменение в базу


        //$temp_array = $Ads1->change_ad($db, $_POST, $_GET["id"]);

        //$firePHP->log($temp_array, 'ads $temp_array');

        $main->change_Ad($_GET['id']);

        $_POST = null;
        header('Location:' . $site_dir . '/' . $current_php_script . '.php');
    }
    
    if ($_POST['form'] == "Назад") {
        $_POST = null;
        unset($_GET);
        header('Location:' . $site_dir . '/' . $current_php_script . '.php');
    }





if (isset($_GET["id"])) {
    
    if (isset($_GET["del"])) {

        $main->delete_ad($_GET["id"]);


        //$firePHP->log($temp_array, 'ads $temp_array');


        unset($_GET["id"]);
        header('Location:' . $site_dir . '/' . $current_php_script . '.php');
    }
    
    if (isset($_GET["edit"])) {

        
        $main->writeOutOne($_GET['id']);
        //$post_edit = 1;
        
        //$ad->edit($_GET['id']);
        
        
    }
    
    
}

elseif (count($_POST)) {
    if (isset($_POST['main_form'])) {
        if ($_POST['main_form'] == 'Добавить') {
            
        $ad=new BasicAd($_POST);

    
        $ad->save();
        //var_dump($ad);
        }
        
        
       
     }
    $main->getAllAdsFromDb(); 
    $main->writeOutAll(); 
     
}


$smarty->assign('checkedPrivate', $values_for_form['checkedPrivate']);
$smarty->assign('checkedCompany', $values_for_form['checkedCompany']);
$smarty->assign('seller_name', $values_for_form['seller_name']);
$smarty->assign('email', $values_for_form['email']);
$smarty->assign('checked_allow_mails', $values_for_form['allow_mails']);
$smarty->assign('phone', $values_for_form['phone']);
$smarty->assign('selected', $selected);
$smarty->assign('cities', $cities);
$smarty->assign('location_id', $values_for_form['location_id']);
$smarty->assign('tube_stations', $tube_stations);
$smarty->assign('tube_station_id', $values_for_form['tube_station_id']);
$smarty->assign('categories', $categories);
$smarty->assign('category_id', $values_for_form['category_id']);
$smarty->assign('title', $values_for_form['title']);
$smarty->assign('description', $values_for_form['description']);
$smarty->assign('price', $values_for_form['price']);
$smarty->assign('post_edit', $values_for_form['post_edit']);
$smarty->assign('amount_ads', $amount_ads);
$smarty->assign('temp_array', $temp_array);
$smarty->assign('current_php_script', $current_php_script);
$smarty->assign('site_dir', $site_dir);


$smarty->display('oop.tpl');

//var_dump($_POST);

?>