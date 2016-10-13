<?php
    error_reporting(0);

    // GET person_ID  type  name  teamID
    // add : name ID gender age levels accountNumber IGEMPassword identity
    $person_ID = $_GET["person_ID"] ? $_GET["person_ID"] : "1234";
    $type = $_GET["type"] ? $_GET["type"] : "update";

    $db=new mysqli("115.159.215.213:3306","root","sjtuigem2016","IGEM");

    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            // echo "连接成功";
    }

    if($type == "update") {
        updateOneMember();
    } else if ($type == "delete") {
        deleteOneMember();
    } else if ($type == "add") {
        addOneMember();
    }

    // 更新person信息
    function updateOneMember()
    {
        //利用这些ID(13865)可以从Person表里查到所有Member
        // [{"ID":"13865","Name":"Douglas Densmore","Gender":null,"Age":null,"Levels":"2","Account_Number":"densmore","IGEM_Password":null,"Identity":"Primary PI"}]
        $name = $_GET["name"] ? $_GET["name"] : "newName";
        $sql = "UPDATE Person SET Name='{$name}' WHERE Person_ID='{$person_ID}'";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"update操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    }

    // 删除某一个person
    function deleteOneMember()
    {
        $sql = "DELETE FROM Person WHERE Person_ID = '{$person_ID}'";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"delete操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    }



    // 增加一个person
    function addOneMember()
    {
        $name = $_GET["name"] ? $_GET["name"] : "name";
        $ID = $_GET["ID"] ? $_GET["ID"] : "ID";
        $gender = $_GET["gender"] ? $_GET["gender"] : "gender";
        $age = $_GET["age"] ? $_GET["age"] : "age";
        $levels = $_GET["levels"] ? $_GET["levels"] : "levels";
        $accountNumber = $_GET["accountNumber"] ? $_GET["accountNumber"] : "accountNumber";
        $IGEMPassword = $_GET["IGEMPassword"] ? $_GET["IGEMPassword"] : "IGEMPassword";
        $identity = $_GET["identity"] ? $_GET["identity"] : "identity";

        $sql = "INSERT INTO Join_Team (Team_ID, Person_ID) VALUES ('{$teamID}', '{$person_ID}')";
        if($db->query($sql) === TRUE) {
            $sql = "INSERT INTO Person (ID, Name , Gender , Age , Levels , Account_Number , IGEM_Password , Identity) VALUES ('{$ID}', '{$name}', '{$gender}', '{$age}', '{$levels}', '{$accountNumber}', '{$IGEMPassword}', '{$identity}')";
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