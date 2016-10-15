<?php
    // error_reporting(0);  
    // echo "我是人";
    header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Methods:GET');

    $db=new mysqli("localhost","root","sjtuigem2016","IGEM");
    

    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            // echo "连接成功";
    }

    $PN = $_GET["PN"] ? $_GET["PN"] : "PN";
    $Art_No = $_GET["Art_No"] ? $_GET["Art_No"] : "Art_No";
    $No_ = $_GET["No_"] ? $_GET["No_"] : "No_";
    $CAS = $_GET["CAS"] ? $_GET["CAS"] : "CAS";
    $Quantity = $_GET["Quantity"] ? $_GET["Quantity"] : "Quantity";
    $Location = $_GET["Location"] ? $_GET["Location"] : "Location";
    $Size = $_GET["Size"] ? $_GET["Size"] : "Size";
    $ExpirationTime = $_GET["ExpirationTime"] ? $_GET["ExpirationTime"] : "ExpirationTime";
    $RemainingAviilable = $_GET["RemainingAviilable"] ? $_GET["RemainingAviilable"] : "RemainingAviilable";
    $Tag = $_GET["Tag"] ? $_GET["Tag"] : "Tag";


    $sql = "UPDATE Reagent_use_record SET PN='{$PN}' , Art_No={$Art_No} , Location='{$Location}' , Size={$Size} , Tag='{$Tag}' WHERE From_Team_ID={$From_Team_ID} and CAS={$CAS}";
    if($db->query($sql) === TRUE) {
        // echo '{"status":"ok" , "message":"update操作成功"}';
        $sql = "UPDATE Reagent SET Remaining_Available='{$RemainingAviilable}' , Expiration_Time={$ExpirationTime} , WHERE No_={$No_}";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"update操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    } else {
        echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
    }
   
?>
