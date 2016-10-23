<?php
    error_reporting(0);
	
    header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
    $Task_ID = $_GET["Task_ID"] ? $_GET["Task_ID"] : "Task_ID";
    $type = $_GET["type"] ? $_GET["type"] : "update";

    $issue = $_GET["issue"] ? $_GET["issue"] : "issue";
    $startTime = $_GET["startTime"] ? $_GET["startTime"] : "startTime";
    $endTime = $_GET["endTime"] ? $_GET["endTime"] : "endTime";
    $participants = $_GET["participants"] ? $_GET["participants"] : "participants";
    $status = $_GET["status"] ? $_GET["status"] : "status";
    $tag = $_GET["tag"] ? $_GET["tag"] : "tag";

    $db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");

    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            // echo "连接成功";
    }

    if($type == "update") {
        $sql = "UPDATE Tasks SET Issue='{$issue}' , Start_time='{$startTime}' , End_time='{$endTime}' , Participants='{$participants}' , Task_Status='{$status}' , Tag='{$tag}' WHERE Task_ID='{$Task_ID}'";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"update操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    } else if ($type == "delete") {
        $sql = "DELETE FROM Tasks WHERE Task_ID = '{$Task_ID}'";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"delete操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    } else if ($type == "add") {
        $description = $_GET["description"] ? $_GET["description"] : "description";
        $From_Team_ID = $_GET["team_ID"] ? $_GET["team_ID"] : "team_ID";
	//echo "我是时间".$startTime;
        $sql = "INSERT INTO Tasks (From_Team_ID, Issue , Start_time , End_time , Participants , Task_Status , Tag , Discription) VALUES ('{$From_Team_ID}', '{$issue}' , '{$startTime}' , '{$endTime}' , '{$participants}' , '{$status}' , '{$tag}' , '{$description}')";
        if($db->query($sql) === TRUE) {
            echo '{"status":"ok" , "message":"add操作成功"}';
        } else {
            echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
        }
    }
?>
