<?php
    error_reporting(0);  
    // echo "我是人";
    header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');

$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");

if($db->connect_error) {
		echo "连接失败".$db->connect_error;
} else {
		// echo "连接成功";
}
$team_ID = $_GET["team_ID"] ? $_GET["team_ID"] : "1875";
$sql="select * from Reagent where From_Team_ID={$team_ID}";
if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}
$teamIndex=0;
$arr = array();
$str = "[";
while ($row=$result->fetch_assoc()) {
    $teamIndex=$teamIndex+1;
	$oneJsonData = json_encode($row);
    if(!$oneJsonData){
        continue;
    }
	array_push($arr , $oneJsonData);
	$str = $str.$oneJsonData.",";
}

$sss = substr($str , 0 , -1);
echo $sss."]";


// $sql = "INSERT INTO Reagent (CAS, From_Team_ID , Quantity) VALUES (1234, '1875' , 'good')";
//         if($db->query($sql) === TRUE) {
//             echo '{"status":"ok" , "message":"add操作成功"}';
//         } else {
//             echo '{"status":"error" , "errorInfo":"'.$db->error.'"}';
//         }


?>
