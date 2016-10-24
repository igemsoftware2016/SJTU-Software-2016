<?php
    // 通过get方式获取team_Name 和 team_ID
    // $team_Name = "bostonu";
    // $team_ID = "1234";
    $team_Name = $_GET["teamName"] ? $_GET["teamName"] : "aachen";
    $team_ID = $_GET["teamID"] ? $_GET["teamID"] : "1234";
    // echo $team_Name;

    $ftp_server = "115.159.215.213";
    $ftp_user_name = "ubuntu";
    $ftp_user_pass = "sjtuigem2016";
    $conn_id = ftp_connect($ftp_server) or die("couldn't connect to $ftp_server");
    $file = $_FILES["upload_file"]["tmp_name"];
    
    $file_type = substr(strrchr($_FILES["upload_file"]["name"], '.'), 1);
    $remote_file = "./Team_Data/".$team_Name."/".$team_Name."HeadImg.".$file_type;
    $login_result = ftp_login($conn_id , $ftp_user_name , $ftp_user_pass);

    ftp_pasv($conn_id, true);

    $res = ftp_put($conn_id , $remote_file , $file , FTP_BINARY);

    if($res) {
        $remote_file = substr($remote_file,1);
        $remote_file = "ftp://115.159.215.213".$remote_file;

        header("content-Type: text/html; charset=UTF8");
        $db=new mysqli("115.159.215.213:3306","root","sjtuigem2016","IGEM");

        if($db->connect_error) {
                echo "连接失败".$db->connect_error;
        } else {
                // echo "连接成功<br>";
        }
        $db->query("SET NAMES utf8");
        $sql = "UPDATE Teamfile_Manager SET Avatar='{$remote_file}' WHERE Team_ID='{$team_ID}'";

        if($db->query($sql) === TRUE) {
            echo "{'status':'ok' , 'path':'{$remote_file}'}";
        } else {
            echo "{'status':'error' , 'errorInfo':'{$db->error}'}";
        }
    } else {
        echo "头像上传失败".$res;
    }
    ftp_close($conn_id);
?>