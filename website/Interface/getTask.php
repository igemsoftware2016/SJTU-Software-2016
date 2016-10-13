<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:GET');
error_reporting(0);

$teamID = $_GET["team_ID"] ? $_GET["team_ID"] : "1875";

$db=new mysqli("127.0.0.1","root","sjtuigem2016","IGEM");

if($db->connect_error) {
		echo "连接失败".$db->connect_error;
} else {
		// echo "连接成功";
}



$sql="select * from Tasks where From_Team_ID={$teamID}";
if (!$result=$db->query($sql))
{
    die("There was an error running the query [".$db->error."]");
}
$teamIndex=0;
$arr = array();
$str = "[";
while ($row=$result->fetch_assoc()) {
    $teamIndex=$teamIndex+1;
	if(!$row["Task_Status"] || $row["Task_Status"]=="" || $row["Task_Status"]=="null") {
		$row["Task_Status"] = "1";
		// echo "我是人";
	}
	$oneJsonData = json_encode($row);
	if(!$oneJsonData){
        continue;
    }
	array_push($arr , $oneJsonData);
	$str = $str.$oneJsonData.",";
}

$sss = substr($str , 0 , -1);
if($teamIndex == 0){
	$sss = "[";
}
echo $sss."]";
?>
