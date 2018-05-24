<?php
    
$xsid = $_POST['xsid'];
$page =  $_POST['page'];
$page1 = $_POST['page1'];
$page2 = $_POST['page2'];
$page3 = $_POST['page3'];
$page4 = $_POST['page4'];
$page5 = $_POST['page5'];
include_once 'db.php';
$dsn = 'mysql:host='.db_host.';port='.db_port.';dbname='.db_database;
$pdo = new PDO($dsn, db_user, db_pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //attr_errmode  errmode_exception
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);  //attr_default_fetch_mode   fetch_assoc
$pdo->beginTransaction();
try{
    $data = array();
    if($xsid==6){
        $sql1 = 'SELECT * FROM kecheng_list where xsid=1 limit '.($page1*3).',3';
        $sql2 = 'SELECT * FROM kecheng_list where xsid=2 limit '.($page2*3).',3';
        $sql3 = 'SELECT * FROM kecheng_list where xsid=3 limit '.($page3*3).',3';
        $sql4 = 'SELECT * FROM kecheng_list where xsid=4 limit '.($page4*3).',3';
        $sql5 = 'SELECT * FROM kecheng_list where xsid=5 limit '.($page5*3).',3';
        
        $stm1 = $pdo->prepare($sql1);
        $stm1->execute(array());
        $row1 = $stm1->fetchAll(PDO::FETCH_ASSOC);
        
        $stm2 = $pdo->prepare($sql2);
        $stm2->execute(array());
        $row2 = $stm2->fetchAll(PDO::FETCH_ASSOC);
        
        $stm3 = $pdo->prepare($sql3);
        $stm3->execute(array());
        $row3 = $stm3->fetchAll(PDO::FETCH_ASSOC);
        
        $stm4 = $pdo->prepare($sql4);
        $stm4->execute(array());
        $row4 = $stm4->fetchAll(PDO::FETCH_ASSOC);
        
        $stm5 = $pdo->prepare($sql5);
        $stm5->execute(array());
        $row5 = $stm5->fetchAll(PDO::FETCH_ASSOC);
        
        $data['kc1'] = $row1;
        $data['kc2'] = $row2;
        $data['kc3'] = $row3;
        $data['kc4'] = $row4;
        $data['kc5'] = $row5;
    }else{
        $sql = 'SELECT * FROM kecheng_list where xsid='. $xsid .' limit '.($page*3).',3';
        $stm = $pdo->prepare($sql);
        $stm->execute(array());
        $row = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data['kc'] = $row;
    }
//    $stm = $pdo->prepare($sql);
//    $stm->execute(array());
//    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
    
   
    echo json_encode($data);
    $pdo->commit();
}  catch (PDOException $e){
    echo $e->getMessage();
    $pdo->rollBack();
}