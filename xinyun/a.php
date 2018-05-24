<?php
$dsn = 'mysql:host=qdm205422490.my3w.com'.';port=3306'.';dbname=qdm205422490_db';
$pdo = new PDO($dsn, 'qdm205422490', '11224441',array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //attr_errmode  errmode_exception
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);  //attr_default_fetch_mode   fetch_assoc
$pdo->beginTransaction();
try{
    $sql4 = 'SELECT name,img,cid FROM manhua_list';  //课程简介
    $stm4 = $pdo->prepare($sql4);
    $stm4->execute(array());
    $row4 = $stm4->fetchAll(PDO::FETCH_ASSOC);
    
    
    $data = ['cknr'=>$row4,];
    echo json_encode($data);
    $pdo->commit();
}  catch (PDOException $e){
    echo $e->getMessage();
    $pdo->rollBack();
}