<?php
    //error_reporting(0);

header('Access-Control-Allow-Origin:*');     
    header('Access-Control-Allow-Methods:GET');    
    $From_Team_ID = $_GET["From_Team_ID"] ? $_GET["From_Team_ID"] : "1875";

    // 连接数据库
    $db=new mysqli("localhost","root","sjtuigem2016","IGEM");
    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            // echo "连接成功";
    }

	//$index111 = 0;

    $CAS = $_GET["CAS"] ? $_GET["CAS"] : "CAS";
    $Quantity = $_GET["Quantity"] ? $_GET["Quantity"] : "Quantity";
    $Expiration_Time = $_GET["Expiration_Time"] ? $_GET["Expiration_Time"] : "Expiration_Time";
    $Reamaining_Available = $_GET["Reamaining_Available"] ? $_GET["Reamaining_Available"] : "Reamaining_Available";
    $sql = "INSERT INTO Reagent (CAS, Quantity, Expiration_Time , Remaining_Available , From_Team_ID) VALUES ('{$CAS}', '{$Quantity}', '{$Expiration_Time}' , '{$Reamaining_Available}' , '{$From_Team_ID}')";
     if ($db->query($sql) === TRUE) {
        //$index111++;
	//echo "新记录插入成功";
    } else {
        echo "Error: " . $db->error;
    }

    $PN = $_GET["PN"] ? $_GET["PN"] : "PN"; 
    $Art_No = $_GET["Art_No"] ? $_GET["Art_No"] : "Art_No";
    $Location = $_GET["Location"] ? $_GET["Location"] : "Location";
    $Size = $_GET["Size"] ? $_GET["Size"] : "Size";
    $Tag = $_GET["Tag"] ? $_GET["Tag"] : "Tag";
    $sql = "INSERT INTO Reagent_use_record (PN, Art_No, Location , Size , Tag , From_Team_ID , CAS) VALUES ('{$PN}', '{$Art_No}', '{$Location}' , '{$Size}' , '{$Tag}' , '{$From_Team_ID}' , '{$CAS}')";

    if ($db->query($sql) === TRUE) {
        //$index111++;
	echo '{"status":"ok"}';	
//echo "新记录插入成功";
    } else {
        echo "Error: " . $db->error;
    }
	//if($index111 == 2) {
	//	echo '{"status":"ok"};
	//}
    $db->close();
?>
