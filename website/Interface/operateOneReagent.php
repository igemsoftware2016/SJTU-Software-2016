<?php
    error_reporting(0);  
    // echo "我是人";
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:GET');

    $db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");
    $type = $_GET["type"] ? $_GET["type"] : "update";

    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            // echo "连接成功";
    }

    if($type == "update") {
        $CAS = $_GET["CAS"] ? $_GET["CAS"] : "CAS";
        $No_ = $_GET["No_"] ? $_GET["No_"] : "41";
        $From_Team_ID = $_GET["From_Team_ID"] ? $_GET["From_Team_ID"] : "From_Team_ID";
        $Quantity = $_GET["Quantity"] ? $_GET["Quantity"] : "wo shi shuju  zhende ";
        $Remaing_Available = $_GET["Remaing_Available"] ? $_GET["Remaing_Available"] : "wo shi ren ";
        $Expiration_Time = $_GET["Expiration_Time"] ? $_GET["Expiration_Time"] : "Expiration_Time";
        $sql = "UPDATE Reagent SET CAS='{$CAS}' , Quantity='{$Quantity}' , Remaining_Available='{$Remaing_Available}' , Expiration_Time='{$Expiration_Time}' WHERE No_={$No_}";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"update操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    } else if ($type == "delete") {
        $No_ = $_GET["No_"] ? $_GET["No_"] : "No_";
        $sql = "DELETE FROM Reagent WHERE No_ = '{$No_}'";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"delete操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    } else if ($type == "add") {
        $CAS = $_GET["CAS"] ? $_GET["CAS"] : "CAS";
        $From_Team_ID = $_GET["From_Team_ID"] ? $_GET["From_Team_ID"] : "From_Team_ID";
        $Quantity = $_GET["Quantity"] ? $_GET["Quantity"] : "Quantity";
        $Remaing_Available = $_GET["Remaing_Available"] ? $_GET["Remaing_Available"] : "Remaing_Available";
        $Expiration_Time = $_GET["Expiration_Time"] ? $_GET["Expiration_Time"] : "Expiration_Time";
        $sql = "INSERT INTO Reagent (CAS, From_Team_ID , Quantity , Remaining_Available , Expiration_Time) VALUES ('{$CAS}', '{$From_Team_ID}' , '{$Quantity}' , '{$Remaing_Available}' , '{$Expiration_Time}')";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"add操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    }

?>
