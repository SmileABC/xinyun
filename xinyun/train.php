<?php
include_once 'db.php';
$dsn = 'mysql:host='.db_host.';port='.db_port.';dbname='.db_database;
$pdo = new PDO($dsn, db_user, db_pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //attr_errmode  errmode_exception
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);  //attr_default_fetch_mode   fetch_assoc
$pdo->beginTransaction();
try{
    $sql = 'SELECT bannerimg FROM banner_list where type=2';  //banner
    $stm = $pdo->prepare($sql);
    $stm->execute(array());
    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    
    $sql2 = 'SELECT * FROM onlinetrain_list';
    $stm2 = $pdo->prepare($sql2);
    $stm2->execute(array());
    $row2 = $stm2->fetchAll(PDO::FETCH_ASSOC);
    
    $data = array();
    $data['banner'] = $row;
    $data['onlinelist'] = $row2;
    echo json_encode($data);
    $pdo->commit();
}  catch (PDOException $e){
    echo $e->getMessage();
    $pdo->rollBack();
}