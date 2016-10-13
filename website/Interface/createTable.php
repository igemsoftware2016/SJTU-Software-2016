<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
error_reporting(0);
$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");

if($db->connect_error) {
		echo "连接失败".$db->connect_error;
} else {
		// echo "连接成功";
}

$sql="create table Task (NO int(6) unsigned auto_increment primary key , Issue varchar(30) not null , StartTime varchar(15) not null , EndTime varchar(15) , Participants varchar(100) , Status int(4) unsigned not null , Tag varchar(20))";
if ($db->query($sql) === TRUE)
{
    //echo "创建表成功";
} else {
    echo "创建表失败:".$db->error;
}

$sql = "insert into Task (Issue , StartTime , EndTime , Participants , Status , Tag) values ('issue' , 'starttime' , 'endtime' , 'participants' , 28 , 'tag')";

if($db->query($sql) === TRUE) {
    //echo "插入数据成功";
} else {
    echo "插入数据失败: ".$db->error;
}
?>
