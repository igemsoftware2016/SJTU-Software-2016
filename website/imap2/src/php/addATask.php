<?php
    // error_reporting(0);
    echo "我是人";
    echo "我是人";
    $teamID = $_GET["team_ID"] ? $_GET["team_ID"] : "1875";
    $issue = $_GET["issue"] ? $_GET["issue"] : "woshiIssue";
    $startTime = $_GET["startTime"] ? $_GET["startTime"] : "1992-04-12";
    $endTime = $_GET["endTime"] ? $_GET["endTime"] : "1993-07-23";
    $participants = $_GET["participants"] ? $_GET["participants"] : "woshiParticipants";
    $discription = $_GET["discription"] ? $_GET["discription"] : "woshiDiscription";
    $tag = $_GET["tag"] ? $_GET["tag"] : "woshiTag";
    $db=new mysqli("115.159.215.213:3306","root","sjtuigem2016","IGEM");
    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            // echo "连接成功";
    }



    // $sql = "INSERT INTO Tasks (Task_ID , From_Team_ID, Issue, Start_time , End_time , Participants , Task_Status , tag) VALUES (11 , {$teamID}, '{$issue}', {$startTime} , {$endTime} , '$participants' , 28 , '{$tag}')";
    $sql = "INSERT INTO Tasks (From_Team_ID, Issue, Start_time , End_time , Participants , tag , Discription) VALUES ({$teamID}, '{$issue}', {$startTime} , {$endTime} , '$participants' , '{$tag}' , '{$discription}')";

    if ($db->query($sql) === TRUE) {
        echo "新记录插入成功";
    } else {
        echo "Error: " . $db->error;
    }

    $db->close();
?>