<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
    error_reporting(0);

    // GET person_ID  type  name  teamID
    // add : name ID gender age levels accountNumber IGEMPassword identity
    $person_ID = $_GET["person_ID"] ? $_GET["person_ID"] : "1234";
    $type = $_GET["type"] ? $_GET["type"] : "update";

    //$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");

    //if($db->connect_error) {
      //      echo "连接失败".$db->connect_error;
    //} else {
            // echo "连接成功";
    //}
$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");

    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
             //echo "连接成功";
    }

    if($type == "update") {
        //利用这些ID(13865)可以从Person表里查到所有Member
        // [{"ID":"13865","Name":"Douglas Densmore","Gender":null,"Age":null,"Levels":"2","Account_Number":"densmore","IGEM_Password":null,"Identity":"Primary PI"}]
        $name = $_GET["name"] ? $_GET["name"] : "newName";
        $sql = "UPDATE Person SET Name='{$name}' WHERE ID='{$person_ID}'";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"update操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    } else if ($type == "delete") {
	if(!$db) {
            $db=new mysqli("localhost","root","sjtuigem2016","IGEM");
        }
        $userId = $_GET["userId"] ? $_GET["userId"] : "userId";
        $sql = "DELETE FROM Join_Team WHERE Person_ID = '{$userId}'";
        if($db->query($sql) === TRUE) {
            
            $sql = "DELETE FROM Person WHERE ID = '{$userId}'";
            if($db->query($sql) === TRUE){
                echo '{"status":"ok" , "message":"delete操作成功"}';
            } else {
                echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
            }
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    } else if ($type == "add") {
        $name = $_GET["name"] ? $_GET["name"] : "name";
        $ID = $_GET["ID"] ? $_GET["ID"] : "ID";
        $gender = $_GET["gender"] ? $_GET["gender"] : "gender";
        $age = $_GET["age"] ? $_GET["age"] : "age";
        $levels = $_GET["levels"] ? $_GET["levels"] : "levels";
        $accountNumber = $_GET["accountNumber"] ? $_GET["accountNumber"] : "accountNumber";
        $IGEMPassword = $_GET["IGEMPassword"] ? $_GET["IGEMPassword"] : "IGEMPassword";
        $identity = $_GET["identity"] ? $_GET["identity"] : "identity";
        $teamID = $_GET["team_ID"] ? $_GET["team_ID"] : "team_ID";

        if(!$db) {
            $db=new mysqli("localhost","root","sjtuigem2016","IGEM");
        }
        //var_dump($db);
        // $sql = "INSERT INTO Join_Team (Team_ID, Person_ID) VALUES ('{$teamID}', '{$person_ID}')";
        $sql = "INSERT INTO Person (ID, Name , Gender , Age , Levels , Account_Number , IGEM_Password , Identity) VALUES ('{$ID}', '{$name}', '{$gender}', '{$age}', '{$levels}', '{$accountNumber}', '{$IGEMPassword}', '{$identity}')";
        if($db->query($sql) === TRUE) {
           // $sql = "INSERT INTO Person (ID, Name , Gender , Age , Levels , Account_Number , IGEM_Password , Identity) VALUES ('{$ID}', '{$name}', '{$gender}', '{$age}', '{$levels}', '{$accountNumber}', '{$IGEMPassword}', '{$identity}')";
            $sql = "INSERT INTO Join_Team (Team_ID, Person_ID) VALUES ('{$teamID}', '{$ID}')";
            if($db->query($sql) === TRUE) {
                echo '{"status":"ok" , "message":"add操作成功"}';
            } else {
                echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
            }
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    }
?>
