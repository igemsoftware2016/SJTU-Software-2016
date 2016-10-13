<?php
    // 上传文件
    // var_dump($_FILES["upload_file"]);

    // $ftp_server = "115.159.215.213";
    // $ftp_user_name = "ubuntu";
    // $ftp_user_pass = "sjtuigem2016";
    // $conn_id = ftp_connect($ftp_server) or die("couldn't connect to $ftp_server");
    // $file = $_FILES["upload_file"]["tmp_name"];
    // $remote_file = "./packages/xxx.jpg";
    // $login_result = ftp_login($conn_id , $ftp_user_name , $ftp_user_pass);
    // echo "开始打印结果";
    // ftp_pasv($conn_id, true);
    // if($res = ftp_put($conn_id , $remote_file , $file , FTP_BINARY)) {
    //     echo "文件上传成功";
    // } else {
    //     echo "上传失败".$res;
    // }
    // var_dump($login_result);
    // ftp_close($conn_id);
    

    // 修改数据
    error_reporting(0);
    header("content-Type: text/html; charset=UTF8");
    $db=new mysqli("115.159.215.213:3306","root","sjtuigem2016","IGEM");

    if($db->connect_error) {
            echo "连接失败".$db->connect_error;
    } else {
            echo "连接成功<br>";
    }
    $db->query("SET NAMES utf8");
    $sql = "UPDATE Teamfile_Manager SET Avatar='touxiang' WHERE Team_ID='1234'";
    // $res = mysqli_query($con,"UPDATE Areas SET Avatar=36 WHERE Team_ID='1234'");
    // $res = mysqli_query($db , $sql);
    // var_dump($res);

    if($db->query($sql) === TRUE) {
        echo "更新成功";
    } else {
        echo "更新失败:".$db->error;
    }
    

?>