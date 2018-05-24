<?php
include_once 'db.php';
$id = 1;
$dsn = 'mysql:host='.db_host.';port='.db_port.';dbname='.db_database;
$pdo = new PDO($dsn, db_user, db_pwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   //attr_errmode  errmode_exception
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);  //attr_default_fetch_mode   fetch_assoc
$pdo->beginTransaction();
try{
//    $sql = 'SELECT * FROM kecheng_list where id='.$id;  //课程简介
//    $sql2 = 'SELECT * FROM kcitem_list where id='.$id;  //课程内容
//    $sql2 = 'SELECT * FROM  where id='.$id;  //课程内容
//    $stm = $pdo->prepare($sql);
//    $stm->execute(array());
//    $stm2 = $pdo->prepare($sql2);
//    $stm2->execute(array());
//    $row = $stm->fetch(PDO::FETCH_ASSOC);
//    $row2 = $stm2->fetch(PDO::FETCH_ASSOC);
//    $data = ['kcxinxi'=>$row2,'kcneirong'=>$row];
    $sql3 = "select `kecheng_list`.`id` AS `id`,`kecheng_list`.`kcname` AS `kcname`,`kecheng_list`.`kcimg` AS `kcimg`,`kecheng_list`.`kcjianjie` AS `kcjianjie`,`kecheng_list`.`kcprice` AS `kcprice`,`kecheng_list`.`kcnumber` AS `kcnumber`,`kecheng_list`.`kcoldprice` AS `kcoldprice`,`kcitem_list`.`kcid` AS `kcid`,`kcitem_list`.`videourl` AS `videourl`,`kcitem_list`.`teacherid` AS `teacherid`,`kcitem_list`.`kcjieshao` AS `kcjieshao`,`kcitem_list`.`suitablecrowd` AS `suitablecrowd`,`teacher_list`.`name` AS `name`,`teacher_list`.`sex` AS `sex`,`teacher_list`.`introduction` AS `introduction`,`teacher_list`.`img` AS `img`,`teacher_list`.`shouid` AS `shouid`,`teacher_list`.`age` AS `age`,`becareful_list`.`item` AS `item` from (((`kecheng_list` join `kcitem_list` on((`kcitem_list`.`kcid` = `kecheng_list`.`id`))) join `teacher_list` on((`teacher_list`.`id` = `kcitem_list`.`teacherid`))) join `becareful_list` on((`becareful_list`.`kcid` = `kcitem_list`.`kcid`)))"
            . " WHERE `kecheng_list`.`id`=".$id;
    $stm = $pdo->prepare($sql3);
    $stm->execute(array());
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    
    $sql4 = 'SELECT `item` FROM becareful_list where kcid='.$id;  //课程简介
    $stm4 = $pdo->prepare($sql4);
    $stm4->execute(array());
    $row4 = $stm4->fetchAll(PDO::FETCH_ASSOC);
    
    $sql5 = 'select `comment_list`.`pltime` AS `pltime`,`comment_list`.`plcontent` AS `plcontent`,`comment_list`.`plrid` AS `plrid`,`comment_list`.`plgrade` AS `plgrade`,`comment_list`.`plid` AS `plid`,`user_list`.`username` AS `username`,`user_list`.`headimg` AS `headimg` from (`comment_list` join `user_list` on((`user_list`.`id` = `comment_list`.`plrid`))) WHERE comment_list.kcid='.$id;$stm5 = $pdo->prepare($sql5); 
    $stm5 = $pdo->prepare($sql5);
    $stm5->execute(array());
    $row5 = $stm5->fetchAll(PDO::FETCH_ASSOC);
    
    
//    $sql5 = 'SELECT `item` FROM becareful_list where kcid='.$id;  //课程简介
//    $stm5 = $pdo->prepare($sql4);
//    $stm5->execute(array());
//    $row5 = $stm4->fetch(PDO::FETCH_ASSOC);
    
//    $data = ['cknr'=>$row,'beacreful'=>$row4,'comment'=>$row5];
    $data = array();
    $data['cknr'] = $row;
    $data['beacreful'] = $row4;
    $data['comment'] = $row5;
    echo json_encode($data);
    $pdo->commit();
}  catch (PDOException $e){
    echo $e->getMessage();
    $pdo->rollBack();
}