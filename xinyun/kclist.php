<?php
include_once 'db.php';
$page = $_GET['page'];
$kctype = $_GET['kctype'];
//if($page){
//}else{
//    $page = 0;
//    SELECT * FROM kecheng_list where kctype=1 LIMIT 0,5;
//}
$dsn = 'mysql:host='.db_host.';port='.db_port.';dbname='.db_database;
$pdo = new PDO($dsn, db_user, db_pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //attr_errmode  errmode_exception
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);  //attr_default_fetch_mode   fetch_assoc
$pdo->beginTransaction();
try{
    $p = intval($page*5);
    if($kctype!=0){
        $sql = 'SELECT * FROM kecheng_list where kctype='.$kctype.' LIMIT '.$p.',5';
    }else{
        $sql = 'SELECT * FROM kecheng_list LIMIT '.$p.',5';
    }
    $sql2 = 'SELECT * FROM kctype_list';
    $stm = $pdo->prepare($sql);
    $stm->execute(array());
    $stm2 = $pdo->prepare($sql2);
    $stm2->execute(array());
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    $row2 = $stm2->fetchAll(PDO::FETCH_ASSOC);
    
    $data = array();
    $data['kctype'] = $row2;
    $data['kclist'] = $row;
    echo json_encode($data);
    $pdo->commit();
}  catch (PDOException $e){
    echo $e->getMessage();
    $pdo->rollBack();
}